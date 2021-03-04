<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Rak;
use App\Script;
use App\User;

class ScriptController extends Controller
{
    /**
     * Menampilkan rak
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Data rak
        $rak = Rak::all();

        // View
        if(Auth::user()->is_admin == 1){
			return view('script/admin/index', [
				'rak' => $rak,
			]);
        }
        elseif(Auth::user()->is_admin == 0){
			return view('script/member/index', [
				'rak' => $rak,
			]);
        }
    }

    /**
     * Menampilkan form tambah rak
     *
     * @return \Illuminate\Http\Response
     */
    public function createRak()
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
            // View
            return view('script/admin/create-rak');
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Menambah rak
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeRak(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'rak' => 'required|max:255',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{		
            // Upload gambar
            $image_name = $request->gambar != '' ? upload_file_content($request->gambar, "assets/images/rak/") : '';
			
            // Menambah data
            $rak = new Rak;
            $rak->rak = $request->rak;
            $rak->rak_icon = $image_name;
            $rak->save();
        }

        // Redirect
        return redirect('/admin/script')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan detail rak
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function detailRak($id)
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
                // Data rak
                $rak = Rak::find($id);

                if(!$rak){
                    abort(404);
                }

                // Data script
                $script = Script::where('id_rak','=',$rak->id_rak)->get();

                // View
                return view('script/admin/detail-rak', [
                    'rak' => $rak,
                    'script' => $script,
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

            // Data rak
            $rak = Rak::find($id);

            if(!$rak){
                abort(404);
            }

            // Data script
            $script = Script::where('id_rak','=',$rak->id_rak)->get();

            // View
            return view('script/member/scripts', [
                'rak' => $rak,
                'script' => $script,
            ]);
        }
    }

    /**
     * Menampilkan form edit rak
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function editRak($id)
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
        	// Data rak
        	$rak = Rak::find($id);

            if(!$rak){
                abort(404);
            }

            // View
            return view('script/admin/edit-rak', [
            	'rak' => $rak,
            ]);
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Mengupdate rak
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateRak(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'rak' => 'required|max:255',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{		
            // Upload gambar
            $image_name = $request->gambar != '' ? upload_file_content($request->gambar, "assets/images/rak/") : '';
			
            // Mengupdate data
            $rak = Rak::find($request->id);
            $rak->rak = $request->rak;
            $rak->rak_icon = $request->gambar != '' ? $image_name : $rak->rak_icon;
            $rak->save();
        }

        // Redirect
        return redirect('/admin/script')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus rak
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteRak(Request $request)
    {
        // Menghapus rak
        $rak = Rak::find($request->id);
        $rak->delete();

        // Menghapus script
        $script = Script::where('id_rak','=',$rak->id_rak)->get();
        if(count($script)>0){
            foreach($script as $data){
                $data_script = Script::find($data->id_script);
                $data_script->delete();
            }
        }

        // Redirect
		return redirect('/admin/script')->with(['message' => 'Berhasil menghapus data.']);
    }

    /**
     * Menampilkan form tambah script
     *
     * * int $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
        	// Data rak
        	$rak = Rak::find($id);

            if(!$rak){
                abort(404);
            }

            // View
            return view('script/admin/create', [
                'rak' => $rak,
            ]);
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Menambah script
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'judul' => 'required|max:255',
            'script' => 'required',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Mengupdate data
            $script = new Script;
            $script->id_rak = $request->id_rak;
            $script->script_title = $request->judul;
            $script->script = htmlentities($request->script);
            $script->save();
        }

        // Redirect
		return redirect('/admin/script/rak/'.$script->id_rak)->with(['message' => 'Berhasil menambah script.']);
    }

    /**
     * Menampilkan detail script
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        if(Auth::user()->is_admin == 1){
            // Data script
            $script = Script::find($id);

            if(!$script){
                abort(404);
            }

            // Data rak
            $rak = Rak::find($script->id_rak);

            // View
            return view('script/admin/detail', [
                'rak' => $rak,
                'script' => $script,
            ]);
        }
        elseif(Auth::user()->is_admin == 0){
			// User belum membayar
            if(Auth::user()->status == 0) return redirect('/member/pemberitahuan');
            // Data script
            $script = Script::find($id);

            if(!$script){
                abort(404);
            }

            // Data rak
            $rak = Rak::find($script->id_rak);

            // View
            return view('script/member/detail', [
                'rak' => $rak,
                'script' => $script,
            ]);
        }
    }

    /**
     * Menampilkan form edit script
     *
     * * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
        	// Data script
        	$script = Script::find($id);

            if(!$script){
                abort(404);
            }

            // Data rak
            $rak = Rak::find($script->id_rak);

            // View
            return view('script/admin/edit', [
                'rak' => $rak,
                'script' => $script,
            ]);
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Mengupdate script
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'judul' => 'required|max:255',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Mengupdate data
            $script = Script::find($request->id);
            $script->script_title = $request->judul;
            $script->script = htmlentities($request->script);
            $script->save();
        }

        // Redirect
		return redirect('/admin/script/rak/'.$script->id_rak)->with(['message' => 'Berhasil mengupdate script.']);
    }

    /**
     * Menghapus script
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Menghapus data
        $script = Script::find($request->id);
        $script->delete();

        // Data rak
        $rak = Rak::find($script->id_rak);

        // Redirect
		return redirect('/admin/script/rak/'.$rak->id_rak)->with(['message' => 'Berhasil menghapus script.']);
    }
}