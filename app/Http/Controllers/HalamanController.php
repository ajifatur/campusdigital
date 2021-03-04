<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Halaman;
use App\User;

class HalamanController extends Controller
{
    /**
     * Menampilkan data halaman
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
                // Data halaman
                $halaman = Halaman::orderBy('halaman_at','desc')->get();
    			
                // View
                return view('halaman/admin/index', [
                    'halaman' => $halaman,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Menampilkan form tambah halaman
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
            // View
            return view('halaman/admin/create');
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Menambah halaman
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'judul_halaman' => 'required|max:255',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{	
            // Upload gambar dari quill
            $html = quill_image_upload($request->konten, 'assets/images/konten-halaman/');

            // Permalink
            $permalink = generate_permalink($request->judul_halaman);
            $i = 1;
            while(count_existing_data('halaman', 'halaman_permalink', $permalink, null) > 0){
                $permalink = rename_permalink(generate_permalink($request->judul_halaman), $i);
                $i++;
            }

            // Menambah data
            $halaman = new Halaman;
            $halaman->halaman_title = $request->judul_halaman;
            $halaman->halaman_permalink = $permalink;
            $halaman->konten = htmlentities($html);
            $halaman->halaman_at = date('Y-m-d H:i:s');
            $halaman->save();
        }

        // Redirect
        return redirect('/admin/halaman')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan halaman
     *
     * string $permalink
     * @return \Illuminate\Http\Response
     */
    public function page($permalink)
    {
        // Data halaman
        $halaman = Halaman::where('halaman_permalink','=',$permalink)->first();

        if(!$halaman){
            abort(404);
        }

        // View
        return view('halaman/guest/page', [
            'halaman' => $halaman,
        ]);
    }

    /**
     * Menampilkan form edit halaman
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
        	// Data halaman
        	$halaman = Halaman::find($id);

            if(!$halaman){
                abort(404);
            }

            // View
            return view('halaman/admin/edit', [
            	'halaman' => $halaman
            ]);
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Mengupdate halaman
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'judul_halaman' => 'required|max:255',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Upload gambar dari quill
            $html = quill_image_upload($request->konten, 'assets/images/konten-halaman/');

            // Permalink
            $permalink = generate_permalink($request->judul_halaman);
            $i = 1;
            while(count_existing_data('halaman', 'halaman_permalink', $permalink, $request->id) > 0){
                $permalink = rename_permalink(generate_permalink($request->judul_halaman), $i);
                $i++;
            }

            // Mengupdate data
            $halaman = Halaman::find($request->id);
            $halaman->halaman_title = $request->judul_halaman;
            $halaman->halaman_permalink = $permalink;
            $halaman->konten = htmlentities($html);
            $halaman->save();
        }

        // Redirect
        return redirect('/admin/halaman/edit/'.$request->id)->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus halaman
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
    	// Menghapus data
        $halaman = Halaman::find($request->id);
        $halaman->delete();

        // Redirect
        return redirect('/admin/halaman')->with(['message' => 'Berhasil menghapus data.']);
    }
}
