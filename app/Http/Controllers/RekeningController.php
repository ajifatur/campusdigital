<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\DefaultRekening;
use App\Platform;
use App\Rekening;

class RekeningController extends Controller
{
    /**
     * Menampilkan data rekening
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_finance()){
                // Data rekening
                $rekening = Rekening::join('users','rekening.id_user','=','users.id_user')->join('platform','rekening.id_platform','=','platform.id_platform')->orderBy('id_rekening','desc')->get();

                // View
                return view('rekening/admin/index', [
                    'rekening' => $rekening,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
        elseif(Auth::user()->is_admin == 0){
            // User belum membayar
            if(Auth::user()->status == 0) return redirect('/member/pemberitahuan');
            
            // Data rekening
            $rekening = Rekening::where('id_user',Auth::user()->id_user)->join('platform','rekening.id_platform','=','platform.id_platform')->orderBy('id_rekening','desc')->get();

            // View
            return view('rekening/member/index', [
                'rekening' => $rekening,
            ]);
        }
    }

    /**
     * Menampilkan data default rekening
     *
     * @return \Illuminate\Http\Response
     */
    public function indexDefault()
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){
            // Data default rekening
            $default_rekening = DefaultRekening::join('platform','default_rekening.id_platform','=','platform.id_platform')->orderBy('tipe_platform','asc')->get();

            // View
            return view('rekening/admin/default-index', [
                'default_rekening' => $default_rekening,
            ]);
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Menampilkan form tambah rekening
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		// User belum membayar
		if(Auth::user()->status == 0) return redirect('/member/pemberitahuan');
			
		// Data platform bank
		$bank = Platform::where('tipe_platform','=',1)->orderBy('nama_platform','asc')->get();
		
		// Data platform fintech
		$fintech = Platform::where('tipe_platform','=',2)->orderBy('nama_platform','asc')->get();
		
        // View
        return view('rekening/member/create', [
			'bank' => $bank,	
			'fintech' => $fintech,	
		]);
    }

    /**
     * Menampilkan form tambah default rekening
     *
     * @return \Illuminate\Http\Response
     */
    public function createDefault()
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){
            // Data platform bank
            $bank = Platform::where('tipe_platform','=',1)->orderBy('nama_platform','asc')->get();
            
            // Data platform fintech
            $fintech = Platform::where('tipe_platform','=',2)->orderBy('nama_platform','asc')->get();
            
            // View
            return view('rekening/admin/default-create', [
                'bank' => $bank,    
                'fintech' => $fintech,  
            ]);
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Menambah rekening
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'platform' => 'required',
            'nomor' => 'required|numeric',
            'atas_nama' => 'required|max:255',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Menambah data
            $rekening = new Rekening;
            $rekening->id_user = Auth::user()->id_user;
            $rekening->id_platform = $request->platform;
            $rekening->nomor = $request->nomor;
            $rekening->atas_nama = $request->atas_nama;
            $rekening->save();
        }

        // Redirect
        return redirect('/member/rekening')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menambah default rekening
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeDefault(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'platform' => 'required',
            'nomor' => 'required|numeric',
            'atas_nama' => 'required|max:255',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Menambah data
            $rekening = new DefaultRekening;
            $rekening->id_platform = $request->platform;
            $rekening->nomor = $request->nomor;
            $rekening->atas_nama = $request->atas_nama;
            $rekening->save();
        }

        // Redirect
        return redirect('/admin/pengaturan/rekening')->with(['message2' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit rekening
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		// User belum membayar
		if(Auth::user()->status == 0) return redirect('/member/pemberitahuan');
			
		// Data platform bank
		$bank = Platform::where('tipe_platform','=',1)->orderBy('nama_platform','asc')->get();
		
		// Data platform fintech
		$fintech = Platform::where('tipe_platform','=',2)->orderBy('nama_platform','asc')->get();
		
    	// Data rekening
    	$rekening = Rekening::find($id);

        // View
        return view('rekening/member/edit', [
			'bank' => $bank,	
			'fintech' => $fintech,	
        	'rekening' => $rekening
        ]);
    }

    /**
     * Menampilkan form edit default rekening
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function editDefault($id)
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){
            // Data platform bank
            $bank = Platform::where('tipe_platform','=',1)->orderBy('nama_platform','asc')->get();
            
            // Data platform fintech
            $fintech = Platform::where('tipe_platform','=',2)->orderBy('nama_platform','asc')->get();
            
            // Data rekening
            $rekening = DefaultRekening::find($id);

            // View
            return view('rekening/admin/default-edit', [
                'bank' => $bank,    
                'fintech' => $fintech,  
                'rekening' => $rekening
            ]);
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Mengupdate rekening
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'platform' => 'required',
            'nomor' => 'required|numeric',
            'atas_nama' => 'required|max:255',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Mengupdate data
            $rekening = Rekening::find($request->id);
            $rekening->id_platform = $request->platform;
            $rekening->nomor = $request->nomor;
            $rekening->atas_nama = $request->atas_nama;
            $rekening->save();
        }

        // Redirect
        return redirect('/member/rekening')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Mengupdate default rekening
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateDefault(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'platform' => 'required',
            'nomor' => 'required|numeric',
            'atas_nama' => 'required|max:255',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Mengupdate data
            $rekening = DefaultRekening::find($request->id);
            $rekening->id_platform = $request->platform;
            $rekening->nomor = $request->nomor;
            $rekening->atas_nama = $request->atas_nama;
            $rekening->save();
        }

        // Redirect
        return redirect('/admin/pengaturan/rekening')->with(['message2' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus rekening
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
    	// Menghapus data
        $rekening = Rekening::find($request->id);
        $rekening->delete();

        // Redirect
        if(Auth::user()->is_admin == 1){
            return redirect('/admin/rekening')->with(['message' => 'Berhasil menghapus data.']);
        }
        elseif(Auth::user()->is_admin == 0){
            return redirect('/member/rekening')->with(['message' => 'Berhasil menghapus data.']);
        }
    }

    /**
     * Menghapus default rekening
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteDefault(Request $request)
    {
        // Menghapus data
        $rekening = DefaultRekening::find($request->id);
        $rekening->delete();

        // Redirect
        if(Auth::user()->is_admin == 1){
            return redirect('/admin/pengaturan/rekening')->with(['message' => 'Berhasil menghapus data.']);
        }
    }
}
