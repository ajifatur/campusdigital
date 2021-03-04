<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Mentor;
use App\User;

class MentorController extends Controller
{
    /**
     * Menampilkan data mentor
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){
				// Data mentor
				$mentor = Mentor::all();

				// View
				return view('mentor/admin/index', [
					'mentor' => $mentor,
				]);
        	}
            else{
                // View
                return view('error/forbidden');
            }
		}
    }

    /**
     * Menampilkan form tambah mentor
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){
                // View
                return view('mentor/admin/create');
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Menambah mentor
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_mentor' => 'required|max:255',
            'bidang_mentor' => 'required|max:255',
            'gambar' => 'required',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{			
            // Upload gambar
            $image_name = $request->gambar != '' ? upload_file_content($request->gambar, "assets/images/mentor/") : '';

            // Menambah data
            $mentor = new Mentor;
            $mentor->nama_mentor = $request->nama_mentor;
            $mentor->bidang_mentor = $request->bidang_mentor;
            $mentor->foto_mentor = $image_name;
            $mentor->save();
        }

        // Redirect
        return redirect('/admin/konten-web/mentor')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit mentor
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){
                // Data mentor
                $mentor = Mentor::find($id);

                if(!$mentor){
                    abort(404);
                }

                // View
                return view('mentor/admin/edit', [
                    'mentor' => $mentor
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Mengupdate mentor
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_mentor' => 'required|max:255',
            'bidang_mentor' => 'required|max:255',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{			
            // Upload gambar
            $image_name = $request->gambar != '' ? upload_file_content($request->gambar, "assets/images/mentor/") : '';

            // Menambah data
            $mentor = Mentor::find($request->id);
            $mentor->nama_mentor = $request->nama_mentor;
            $mentor->bidang_mentor = $request->bidang_mentor;
            $mentor->foto_mentor = $request->gambar != '' ? $image_name : $mentor->foto_mentor;
            $mentor->save();
        }

        // Redirect
        return redirect('/admin/konten-web/mentor')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus mentor
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
    	// Menghapus data
        $mentor = Mentor::find($request->id);
        $mentor->delete();

        // Redirect
        return redirect('/admin/konten-web/mentor')->with(['message' => 'Berhasil menghapus data.']);
    }
}
