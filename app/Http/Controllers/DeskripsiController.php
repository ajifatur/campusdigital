<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Deskripsi;
use App\User;

class DeskripsiController extends Controller
{
    /**
     * Menampilkan deskripsi
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
                // Data deskripsi
                $deskripsi = Deskripsi::first();
                
                // View
                return view('deskripsi/admin/index', [
                    'deskripsi' => $deskripsi,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Mengupdate deskripsi
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'deskripsi' => 'required',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Upload gambar dari quill
            $html = quill_image_upload($request->deskripsi, 'assets/images/konten-deskripsi/');

            // Mengupdate data
            $deskripsi = Deskripsi::first();
            $deskripsi->deskripsi = htmlentities($html);
            $deskripsi->save();
        }

        // Redirect
		return redirect('/admin/konten-web/deskripsi')->with(['message' => 'Berhasil mengupdate deskripsi.']);
    }
}
