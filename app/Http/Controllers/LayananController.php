<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Layanan;
use App\User;

class LayananController extends Controller
{
    /**
     * Menampilkan data layanan
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){
                // Data layanan
                $layanan = Layanan::all();
                
                // View
                return view('layanan/admin/index', [
                    'layanan' => $layanan,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Menampilkan form tambah layanan
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        ini_set('max_execution_time', 300);
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){    
                // Icons
                $icons = json_fa();
                
                // View
                return view('layanan/admin/create', ['icons' => $icons]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Menambah layanan
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'layanan' => 'required',
            'caption' => 'required',
            'icon' => 'required',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Menambah data
            $layanan = new Layanan;
            $layanan->layanan = $request->layanan;
            $layanan->layanan_caption = $request->caption;
            $layanan->layanan_icon = $request->icon;
            $layanan->save();
        }

        // Redirect
		return redirect('/admin/konten-web/layanan')->with(['message' => 'Berhasil menambah layanan.']);
    }

    /**
     * Menampilkan form edit layanan
     *
     * * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        ini_set('max_execution_time', 300);
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){   
                // Layanan
                $layanan = Layanan::find($id);

                if(!$layanan){
                    abort(404);
                }
                
                // Icons
                $icons = json_fa();
                
                // View
                return view('layanan/admin/edit', [
                    'layanan' => $layanan,
                    'icons' => $icons
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Mengupdate layanan
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'layanan' => 'required',
            'caption' => 'required',
            'icon' => 'required',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Mengupdate data
            $layanan = Layanan::find($request->id);
            $layanan->layanan = $request->layanan;
            $layanan->layanan_caption = $request->caption;
            $layanan->layanan_icon = $request->icon;
            $layanan->save();
        }

        // Redirect
		return redirect('/admin/konten-web/layanan')->with(['message' => 'Berhasil mengupdate layanan.']);
    }

    /**
     * Menghapus layanan
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
    	// Menghapus data
        $layanan = Layanan::find($request->id);
        $layanan->delete();

        // Redirect
        return redirect('/admin/konten-web/layanan')->with(['message' => 'Berhasil menghapus data.']);
    }
}
