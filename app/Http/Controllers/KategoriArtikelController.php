<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\KategoriArtikel;
use App\User;

class KategoriArtikelController extends Controller
{
    /**
     * Menampilkan data kategori artikel
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
                // Data kategori
                $kategori = KategoriArtikel::all();
                
                // View
                return view('kategori-artikel/admin/index', [
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
     * Menampilkan form tambah kategori artikel
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){ 
                // View
                return view('kategori-artikel/admin/create');
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Menambah kategori artikel
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'kategori' => 'required'
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Permalink
            $permalink = generate_permalink($request->kategori);
            $i = 1;
            while(count_existing_category('kategori_artikel', 'slug', $permalink, 'id_ka', null) > 0){
                $permalink = rename_permalink(generate_permalink($request->kategori), $i);
                $i++;
            }

            // Menambah data
            $kategori = new KategoriArtikel;
            $kategori->kategori = $request->kategori;
            $kategori->slug = $permalink;
            $kategori->save();
        }

        // Redirect
		return redirect('/admin/artikel/kategori')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit kategori artikel
     *
     * * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){ 
                // Kategori
                $kategori = KategoriArtikel::find($id);

                if(!$kategori){
                    abort(404);
                }
                
                // View
                return view('kategori-artikel/admin/edit', [
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
     * Mengupdate kategori artikel
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'kategori' => 'required'
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Permalink
            $permalink = generate_permalink($request->kategori);
            $i = 1;
            while(count_existing_category('kategori_artikel', 'slug', $permalink, 'id_ka', $request->id) > 0){
                $permalink = rename_permalink(generate_permalink($request->kategori), $i);
                $i++;
            }

            // Mengupdate data
            $kategori = KategoriArtikel::find($request->id);
            $kategori->kategori = $request->kategori;
            $kategori->slug = $permalink;
            $kategori->save();
        }

        // Redirect
		return redirect('/admin/artikel/kategori')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus kategori artikel
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
    	// Menghapus data
        $kategori = KategoriArtikel::find($request->id);
        $kategori->delete();

        // Redirect
        return redirect('/admin/artikel/kategori')->with(['message' => 'Berhasil menghapus data.']);
    }
}
