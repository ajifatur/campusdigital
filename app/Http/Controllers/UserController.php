<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Komisi;
use App\ProfilePhoto;
use App\Rekening;
use App\Role;
use App\User;
use App\Withdrawal;

class UserController extends Controller
{
    /**
     * Menampilkan data user
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get data user
        if($request->query('filter') == null){
            $users = User::join('role','users.role','=','role.id_role')->orderBy('register_at','desc')->get();
        }
        else{
            if($request->query('filter') == 'all')
                $users = User::join('role','users.role','=','role.id_role')->orderBy('register_at','desc')->get();
            elseif($request->query('filter') == 'admin')
                $users = User::join('role','users.role','=','role.id_role')->where('role.is_admin','=',1)->orderBy('register_at','desc')->get();
            elseif($request->query('filter') == 'member')
                $users = User::join('role','users.role','=','role.id_role')->where('role.is_admin','=',0)->orderBy('register_at','desc')->get();
            elseif($request->query('filter') == 'aktif')
                $users = User::join('role','users.role','=','role.id_role')->where('role.is_admin','=',0)->where('status','=',1)->orderBy('register_at','desc')->get();
            elseif($request->query('filter') == 'belum-aktif')
                $users = User::join('role','users.role','=','role.id_role')->where('role.is_admin','=',0)->where('status','=',0)->orderBy('register_at','desc')->get();
            else
                return redirect('/admin/user');

        }

        foreach($users as $key=>$user){
            $refer = User::where('reference','=',$user->username)->where('is_admin','=',0)->where('username','!=',$user->username)->get();
            $users[$key]->refer = count($refer);
        }

        // View
        return view('user/admin/index', [
            'users' => $users,
            'filter' => $request->query('filter')
        ]);
    }

    /**
     * Menambah data user
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get data role
        $role = Role::orderBy('is_admin','desc')->get();

        // View
        return view('user/admin/create', [
            'role' => $role,
        ]);
    }

    /**
     * Menyimpan data user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_user' => 'required|string|max:255',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'nomor_hp' => 'required',
            'username' => 'required|string|min:6|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Get data role
            $role = Role::find($request->role);

            // Menyimpan data
            $user = new User;
            $user->nama_user = $request->nama_user;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->tanggal_lahir = generate_date_format($request->tanggal_lahir, 'y-m-d');
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->nomor_hp = $request->nomor_hp;
            $user->reference = '';
            $user->foto = '';
            $user->role = $request->role;
            $user->is_admin = $role->is_admin;
            $user->last_visit = null;
            $user->saldo = 0;
            $user->status = 1;
            $user->register_at = date('Y-m-d H:i:s');
            $user->save();
        }

        // Redirect
        return redirect('/admin/user')->with(['message' => 'Berhasil menambah data.']);
    }
    
    /**
     * Menampilkan detail user
     * 
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        // Get data user
        $user = User::join('role','users.role','=','role.id_role')->find($id);

        if(!$user){
            abort(404);
        }

        // Sponsor
        $sponsor = User::where('username',$user->reference)->first();

        // Refer
        $refer = User::where('reference','=',$user->username)->get();

        // Refer Aktif
        $refer_aktif = User::where('reference','=',$user->username)->where('status','=',1)->get();
        
        // Galeri foto
        $photos = ProfilePhoto::where('id_user','=',$id)->get();

        // View
        if($user->is_admin == 1){
            return view('user/admin/detail-admin', [
                'user' => $user,
                'sponsor' => $sponsor,
                'refer' => $refer,
                'refer_aktif' => $refer_aktif,
                'photos' => $photos,
            ]);
        }
        elseif($user->is_admin == 0){
            return view('user/admin/detail-member', [
                'user' => $user,
                'sponsor' => $sponsor,
                'refer' => $refer,
                'refer_aktif' => $refer_aktif,
                'photos' => $photos,
            ]);
        }
    }
    
    /**
     * Menampilkan profil sendiri
     * 
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        // Get data user
        $user = User::find(Auth::user()->id_user);

        // Sponsor
        $sponsor = User::where('username',Auth::user()->reference)->first();

        // Refer
        $refer = User::where('reference',Auth::user()->username)->get();
        
        // Galeri foto
        $photos = ProfilePhoto::where('id_user','=',Auth::user()->id_user)->get();

        // View
        if(Auth::user()->is_admin == 1){
            return view('user/admin/profile-admin', [
                'user' => $user,
                'sponsor' => $sponsor,
                'refer' => $refer,
                'photos' => $photos,
            ]);
        }
    }
    
    /**
     * Menampilkan profil member
     * 
     * @return \Illuminate\Http\Response
     */
    public function memberProfile()
    {
		// User belum membayar
		if(Auth::user()->status == 0) return redirect('/member/pemberitahuan');
			
        // Get data user
        $user = User::find(Auth::user()->id_user);

        // Sponsor
        $sponsor = ($user->role == role_trainer()) ? User::where('username',Auth::user()->reference)->first() : null;

        // Refer
        $refer = User::where('reference',Auth::user()->username)->get();
        
        // Galeri foto
        $photos = ProfilePhoto::where('id_user','=',Auth::user()->id_user)->get();

        // View
        if(Auth::user()->is_admin == 0){            
            return view('user/member/profile', [
                'user' => $user,
                'sponsor' => $sponsor,
                'refer' => $refer,
                'photos' => $photos,
            ]);
        }
    }

    /**
     * Mengedit data user
     * 
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get data user
        $user = User::find($id);

        // Jika tidak ada user
        if(!$user){
            abort(404);
        }

        // Get data role
        $role = Role::orderBy('is_admin','desc')->get();

        // View
        return view('/user/admin/edit', [
            'role' => $role,
            'user' => $user,
        ]);
    }

    /**
     * Mengupdate data user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_user' => 'required|string|max:255',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'nomor_hp' => 'required',
            'username' => $request->username != '' ? ['required', 'string', 'min:6', 'max:255', Rule::unique('users')->ignore($request->id, 'id_user')] : '',
            'email' => [
                'required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($request->id, 'id_user')
            ],
            'password' => $request->password != '' ? 'required|string|min:6' : '',
            'role' => 'required',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Get data role
            $role = Role::find($request->role);

            // Menyimpan data
            $user = User::find($request->id);
            $user->nama_user = $request->nama_user;
            $user->tanggal_lahir = generate_date_format($request->tanggal_lahir, 'y-m-d');
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->nomor_hp = $request->nomor_hp;
            $user->email = $request->email;
            $user->username = $request->username != '' ? $request->username : $user->username;
            $user->password = $request->password != '' ? bcrypt($request->password) : $user->password;
            $user->role = $request->role;
            $user->is_admin = $role->is_admin;
            $user->save();
        }

        // Redirect
        return redirect('/admin/user')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Mengupdate data identitas profil user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'nomor_hp' => 'required',
            'username' => Auth::user()->is_admin == 1 ? ['required', 'string', 'min:6', 'max:255', Rule::unique('users')->ignore(Auth::user()->id_user, 'id_user')] : '',
            'email' => [
                'required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::user()->id_user, 'id_user')
            ],
            'password' => $request->password != '' ? 'required|string|min:6' : '',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Memilih data
            $user = User::find(Auth::user()->id_user);
            $user->nama_user = $request->nama_lengkap;
            $user->username = Auth::user()->is_admin == 1 ? $request->username : $user->username;
            $user->tanggal_lahir = $request->tanggal_lahir;
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->nomor_hp = $request->nomor_hp;
            $user->email = $request->email;
            $user->password = $request->password != '' ? bcrypt($request->password) : $user->password;
            $user->save();
        }

        // Redirect
        if(Auth::user()->is_admin == 1){
            return redirect('/admin/profil')->with(['updateProfile' => 'Berhasil mengupdate profil.']);
        }
        elseif(Auth::user()->is_admin == 0){
            return redirect('/member/profil')->with(['updateProfile' => 'Berhasil mengupdate profil.']);
        }
    }

    /**
     * Mengupdate foto profil
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePhoto(Request $request)
    {
        // Update foto profil
        $image_name = upload_file_content($request->src_image, "assets/images/users/");

        // Update data
        $user = $request->id != null || $request->id != '' ? User::find($request->id) : User::find(Auth::user()->id_user);
        $user->foto = $image_name;
        $user->save();
        
        // Tambah data foto profil
        $photo = new ProfilePhoto;
        $photo->id_user = $user->id_user;
        $photo->photo_name = $image_name;
        $photo->uploaded_at = date('Y-m-d H:i:s');
        $photo->save();

        // Redirect
        if(Auth::user()->is_admin == 1){
            if($user->id_user == Auth::user()->id_user)
                return redirect('/admin/profil')->with(['updatePhotoMessage' => 'Berhasil mengganti foto profil.']);
            else
                return redirect('/admin/user/detail/'.$user->id_user)->with(['updatePhotoMessage' => 'Berhasil mengganti foto profil.']);
        }
        elseif(Auth::user()->is_admin == 0){
            return redirect('/member/profil')->with(['updatePhotoMessage' => 'Berhasil mengganti foto profil.']);
        }
    }

    /**
     * Mengupdate foto profil (pilih)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function choosePhoto(Request $request)
    {
		// Get data photo profil
		$photo = ProfilePhoto::find($request->id_pp);
		
        // Update data
        $user = $request->id != null || $request->id != '' ? User::find($request->id) : User::find(Auth::user()->id_user);
        $user->foto = $photo->photo_name;
        $user->save();

        // Redirect
        if(Auth::user()->is_admin == 1){
            if($user->id_user == Auth::user()->id_user)
                return redirect('/admin/profil')->with(['updatePhotoMessage' => 'Berhasil mengganti foto profil.']);
            else
                return redirect('/admin/user/detail/'.$user->id_user)->with(['updatePhotoMessage' => 'Berhasil mengganti foto profil.']);
        }
        elseif(Auth::user()->is_admin == 0){
            return redirect('/member/profil')->with(['updatePhotoMessage' => 'Berhasil mengganti foto profil.']);
        }
    }
    
    /**
     * Export ke Excel
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        // Get data user
        if($request->query('filter') == null){
            $users = User::join('role','users.role','=','role.id_role')->get();
        }
        else{
            if($request->query('filter') == 'all')
                $users = User::join('role','users.role','=','role.id_role')->get();
            elseif($request->query('filter') == 'admin')
                $users = User::join('role','users.role','=','role.id_role')->where('role.is_admin','=',1)->get();
            elseif($request->query('filter') == 'member')
                $users = User::join('role','users.role','=','role.id_role')->where('role.is_admin','=',0)->get();
            elseif($request->query('filter') == 'aktif')
                $users = User::join('role','users.role','=','role.id_role')->where('role.is_admin','=',0)->where('status','=',1)->get();
            elseif($request->query('filter') == 'belum-aktif')
                $users = User::join('role','users.role','=','role.id_role')->where('role.is_admin','=',0)->where('status','=',0)->get();
            else
                $users = User::join('role','users.role','=','role.id_role')->get();

        }

        return Excel::download(new UserExport($users), 'Data User.xlsx');
    }
    
    /**
     * Menghapus user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Menghapus user
        $user = User::find($request->id);
        $user->delete();
		
		// Menghapus rekening
		$rekening = Rekening::where('id_user','=',$request->id)->first();
		if($rekening != null) $rekening->delete();
		
		// Menghapus komisi
		$komisi = Komisi::where('id_user','=',$request->id)->first();
		if($komisi != null) $komisi->delete();
		
		// Menghapus withdrawal
		$withdrawal = Withdrawal::where('id_user','=',$request->id)->first();
		if($withdrawal != null) $withdrawal->delete();

        // Redirect
        return redirect('/admin/user')->with(['message' => 'Berhasil menghapus data.']);
    }

    public function json()
    {
        $users = [];
        $user = User::get();
        
        foreach($user as $data){
             $add['id'] = $data->id_user;
             $add['nama'] = $data->nama_user;
             $add['username'] = $data->username;
             array_push($users,$add);
        }

        echo json_encode($users);
        
    }
}
