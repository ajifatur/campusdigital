<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Platform;

class PlatformController extends Controller
{
    /**
     * Menampilkan data platform
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){
            // Data platform
            $platform = Platform::orderBy('tipe_platform','asc')->orderBy('nama_platform','asc')->get();

            // View
            return view('platform/admin/index', [
                'platform' => $platform,
            ]);
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Menampilkan form tambah platform
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){
            // View
            return view('platform/admin/create');
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Menambah platform
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_platform' => 'required|max:255',
            'tipe_platform' => 'required',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{			
            // Menambah data
            $platform = new Platform;
            $platform->nama_platform = $request->nama_platform;
            $platform->tipe_platform = $request->tipe_platform;
            $platform->save();
        }

        // Redirect
        return redirect('/admin/pengaturan/platform')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit platform
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){
        	// Data platform
        	$platform = Platform::find($id);

            // View
            return view('platform/admin/edit', [
            	'platform' => $platform
            ]);
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Mengupdate platform
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_platform' => 'required|max:255',
            'tipe_platform' => 'required',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Menambah data
            $platform = Platform::find($request->id);
            $platform->nama_platform = $request->nama_platform;
            $platform->tipe_platform = $request->tipe_platform;
            $platform->save();
        }

        // Redirect
        return redirect('/admin/pengaturan/platform')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus platform
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
    	// Menghapus data
        $platform = Platform::find($request->id);
        $platform->delete();

        // Redirect
        return redirect('/admin/pengaturan/platform')->with(['message' => 'Berhasil menghapus data.']);
    }
}
