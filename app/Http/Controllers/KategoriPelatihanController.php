<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\KategoriPelatihan;
use App\User;

class KategoriPelatihanController extends Controller
{
    /**
     * Menampilkan data kategori pelatihan
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){
                // Data kategori
                $kategori = KategoriPelatihan::all();
                
                // View
                return view('kategori-pelatihan/admin/index', [
                    'kategori' => $kategori,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Menampilkan form tambah kategori pelatihan
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){ 
                // View
                return view('kategori-pelatihan/admin/create');
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Menambah kategori pelatihan
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'kategori' => 'required|unique:kategori_pelatihan',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Menambah data
            $kategori = new KategoriPelatihan;
            $kategori->kategori = $request->kategori;
            $kategori->save();
        }

        // Redirect
		return redirect('/admin/pengaturan/kategori-pelatihan')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit kategori pelatihan
     *
     * * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){ 
                // Kategori
                $kategori = KategoriPelatihan::find($id);

                if(!$kategori){
                    abort(404);
                }
                
                // View
                return view('kategori-pelatihan/admin/edit', [
                    'kategori' => $kategori,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Mengupdate kategori pelatihan
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'kategori' => [
                'required', Rule::unique('kategori_pelatihan')->ignore($request->id, 'id_kp')
            ],
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Mengupdate data
            $kategori = KategoriPelatihan::find($request->id);
            $kategori->kategori = $request->kategori;
            $kategori->save();
        }

        // Redirect
		return redirect('/admin/pengaturan/kategori-pelatihan')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus kategori materi
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
    	// Menghapus data
        $kategori = KategoriPelatihan::find($request->id);
        $kategori->delete();

        // Redirect
		return redirect('/admin/pengaturan/kategori-pelatihan')->with(['message' => 'Berhasil menghapus data.']);
    }
}
