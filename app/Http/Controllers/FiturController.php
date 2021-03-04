<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Fitur;
use App\User;

class FiturController extends Controller
{
    /**
     * Menampilkan data fitur
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
                // Data fitur
                $fitur = Fitur::all();
                
                // View
                return view('fitur/admin/index', [
                    'fitur' => $fitur,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Menampilkan form tambah fitur
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
                // View
                return view('fitur/admin/create');
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Menambah fitur
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_fitur' => 'required|max:255',
            'keterangan_fitur' => 'required',
            'url_fitur' => 'required',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{			
            // Upload gambar
            $image_name = $request->gambar != '' ? upload_file_content($request->gambar, "assets/images/fitur/") : '';

            // Menambah data
            $fitur = new Fitur;
            $fitur->nama_fitur = $request->nama_fitur;
            $fitur->keterangan_fitur = $request->keterangan_fitur;
            $fitur->url_fitur = $request->url_fitur;
            $fitur->icon_fitur = $image_name;
            $fitur->save();
        }

        // Redirect
        return redirect('/admin/konten-web/fitur')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit fitur
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
                // Data fitur
                $fitur = Fitur::find($id);

                if(!$fitur){
                    abort(404);
                }

                // View
                return view('fitur/admin/edit', [
                    'fitur' => $fitur
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Mengupdate fitur
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_fitur' => 'required|max:255',
            'keterangan_fitur' => 'required',
            'url_fitur' => 'required',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{			
            // Upload gambar
            $image_name = $request->gambar != '' ? upload_file_content($request->gambar, "assets/images/fitur/") : '';

            // Mengupdate data
            $fitur = Fitur::find($request->id);
            $fitur->nama_fitur = $request->nama_fitur;
            $fitur->keterangan_fitur = $request->keterangan_fitur;
            $fitur->url_fitur = $request->url_fitur;
            $fitur->icon_fitur = $request->gambar != '' ? $image_name : $fitur->icon_fitur;
            $fitur->save();
        }

        // Redirect
        return redirect('/admin/konten-web/fitur')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus fitur
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
    	// Menghapus data
        $fitur = Fitur::find($request->id);
        $fitur->delete();

        // Redirect
        return redirect('/admin/konten-web/fitur')->with(['message' => 'Berhasil menghapus data.']);
    }
}
