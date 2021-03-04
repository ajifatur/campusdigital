<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Testimoni;
use App\User;

class TestimoniController extends Controller
{
    /**
     * Menampilkan data testimoni
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){
                // Data testimoni
                $testimoni = Testimoni::all();
                
                // View
                return view('testimoni/admin/index', [
                    'testimoni' => $testimoni,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Menampilkan form tambah testimoni
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){
                // View
                return view('testimoni/admin/create');
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Menambah testimoni
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_klien' => 'required|max:255',
            'profesi_klien' => 'required|max:255',
            'testimoni' => 'required'
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{			
            // Upload gambar
            $image_name = $request->gambar != '' ? upload_file_content($request->gambar, "assets/images/testimoni/") : '';

            // Menambah data
            $testimoni = new Testimoni;
            $testimoni->klien = $request->nama_klien;
            $testimoni->foto_klien = $image_name;
            $testimoni->profesi_klien = $request->profesi_klien;
            $testimoni->testimoni = $request->testimoni;
            $testimoni->save();
        }

        // Redirect
        return redirect('/admin/konten-web/testimoni')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit testimoni
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){
                // Data testimoni
                $testimoni = Testimoni::find($id);

                if(!$testimoni){
                    abort(404);
                }

                // View
                return view('testimoni/admin/edit', [
                    'testimoni' => $testimoni
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Mengupdate testimoni
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_klien' => 'required|max:255',
            'profesi_klien' => 'required|max:255',
            'testimoni' => 'required'
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{			
            // Upload gambar
            $image_name = $request->gambar != '' ? upload_file_content($request->gambar, "assets/images/testimoni/") : '';

            // Mengupdate data
            $testimoni = Testimoni::find($request->id);
            $testimoni->klien = $request->nama_klien;
            $testimoni->foto_klien = $request->gambar != '' ? $image_name : $testimoni->foto_klien;
            $testimoni->profesi_klien = $request->profesi_klien;
            $testimoni->testimoni = $request->testimoni;
            $testimoni->save();
        }

        // Redirect
        return redirect('/admin/konten-web/testimoni')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus testimoni
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
    	// Menghapus data
        $testimoni = Testimoni::find($request->id);
        $testimoni->delete();

        // Redirect
        return redirect('/admin/konten-web/testimoni')->with(['message' => 'Berhasil menghapus data.']);
    }
}
