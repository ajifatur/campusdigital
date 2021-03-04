<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Mitra;
use App\User;

class MitraController extends Controller
{
    /**
     * Menampilkan data mitra
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){
                // Data mitra
                $mitra = Mitra::all();
                
                // View
                return view('mitra/admin/index', [
                    'mitra' => $mitra,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Menampilkan form tambah mitra
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){
                // View
                return view('mitra/admin/create');
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Menambah mitra
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_mitra' => 'required|max:255',
            'gambar' => 'required'
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{			
            // Upload gambar
            $image_name = $request->gambar != '' ? upload_file_content($request->gambar, "assets/images/mitra/") : '';

            // Menambah data
            $mitra = new Mitra;
            $mitra->nama_mitra = $request->nama_mitra;
            $mitra->logo_mitra = $image_name;
            $mitra->save();
        }

        // Redirect
        return redirect('/admin/konten-web/mitra')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit mitra
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){
                // Data mitra
                $mitra = Mitra::find($id);

                if(!$mitra){
                    abort(404);
                }

                // View
                return view('mitra/admin/edit', [
                    'mitra' => $mitra
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Mengupdate mitra
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_mitra' => 'required|max:255',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{			
            // Upload gambar
            $image_name = $request->gambar != '' ? upload_file_content($request->gambar, "assets/images/mitra/") : '';

            // Menambah data
            $mitra = Mitra::find($request->id);
            $mitra->nama_mitra = $request->nama_mitra;
            $mitra->logo_mitra = $request->gambar != '' ? $image_name : $mitra->logo_mitra;
            $mitra->save();
        }

        // Redirect
        return redirect('/admin/konten-web/mitra')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus mitra
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
    	// Menghapus data
        $mitra = Mitra::find($request->id);
        $mitra->delete();

        // Redirect
        return redirect('/admin/konten-web/mitra')->with(['message' => 'Berhasil menghapus data.']);
    }
}
