<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Cabang;
use App\User;

class CabangController extends Controller
{
    /**
     * Menampilkan data cabang
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){
				// Data cabang
				$cabang = Cabang::all();

				// View
				return view('cabang/admin/index', [
					'cabang' => $cabang,
				]);
        	}
            else{
                // View
                return view('error/forbidden');
            }
		}
    }

    /**
     * Menampilkan form tambah cabang
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){
                // View
                return view('cabang/admin/create');
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Menambah cabang
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_cabang' => 'required|max:255',
            'alamat_cabang' => 'required',
            'whatsapp_cabang' => 'required|numeric|max:255',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Menambah data
            $cabang = new Cabang;
            $cabang->nama_cabang = $request->nama_cabang;
            $cabang->alamat_cabang = $request->alamat_cabang;
            $cabang->whatsapp_cabang = $request->whatsapp_cabang;
            $cabang->instagram_cabang = $request->instagram_cabang != '' ? $request->instagram_cabang : '';
            $cabang->website_cabang = $request->website_cabang != '' ? $request->website_cabang : '';
            $cabang->cabang_at = date('Y-m-d H:i:s');
            $cabang->save();
        }

        // Redirect
        return redirect('/admin/konten-web/cabang')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit cabang
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){
                // Data cabang
                $cabang = Cabang::find($id);

                if(!$cabang){
                    abort(404);
                }

                // View
                return view('cabang/admin/edit', [
                    'cabang' => $cabang
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Mengupdate cabang
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_cabang' => 'required|max:255',
            'alamat_cabang' => 'required',
            'whatsapp_cabang' => 'required|numeric|max:255',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Mengupdate data
            $cabang = Cabang::find($request->id);
            $cabang->nama_cabang = $request->nama_cabang;
            $cabang->alamat_cabang = $request->alamat_cabang;
            $cabang->whatsapp_cabang = $request->whatsapp_cabang;
            $cabang->instagram_cabang = $request->instagram_cabang != '' ? $request->instagram_cabang : '';
            $cabang->website_cabang = $request->website_cabang != '' ? $request->website_cabang : '';
            $cabang->save();
        }

        // Redirect
        return redirect('/admin/konten-web/cabang')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus cabang
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
    	// Menghapus data
        $cabang = Cabang::find($request->id);
        $cabang->delete();

        // Redirect
        return redirect('/admin/konten-web/cabang')->with(['message' => 'Berhasil menghapus data.']);
    }
}
