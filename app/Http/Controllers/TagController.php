<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Tag;
use App\User;

class TagController extends Controller
{
    /**
     * Menampilkan data tag
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
                // Data tag
                $tag = Tag::all();
                
                // View
                return view('tag/admin/index', [
                    'tag' => $tag,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Menampilkan form tambah tag
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){ 
                // View
                return view('tag/admin/create');
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Menambah tag artikel
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'tag' => 'required'
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Permalink
            $permalink = generate_permalink($request->tag);
            $i = 1;
            while(count_existing_category('tag', 'slug', $permalink, 'id_tag', null) > 0){
                $permalink = rename_permalink(generate_permalink($request->tag), $i);
                $i++;
            }

            // Menambah data
            $tag = new Tag;
            $tag->tag = $request->tag;
            $tag->slug = $permalink;
            $tag->save();
        }

        // Redirect
		return redirect('/admin/artikel/tag')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit tag
     *
     * * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){ 
                // Tag
                $tag = Tag::find($id);

                if(!$tag){
                    abort(404);
                }
                
                // View
                return view('tag/admin/edit', [
                    'tag' => $tag,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Mengupdate tag artikel
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'tag' => 'required'
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Permalink
            $permalink = generate_permalink($request->tag);
            $i = 1;
            while(count_existing_category('tag', 'slug', $permalink, 'id_tag', $request->id) > 0){
                $permalink = rename_permalink(generate_permalink($request->tag), $i);
                $i++;
            }

            // Mengupdate data
            $tag = Tag::find($request->id);
            $tag->tag = $request->tag;
            $tag->slug = $permalink;
            $tag->save();
        }

        // Redirect
		return redirect('/admin/artikel/tag')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus tag artikel
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
    	// Menghapus data
        $tag = Tag::find($request->id);
        $tag->delete();

        // Redirect
        return redirect('/admin/artikel/tag')->with(['message' => 'Berhasil menghapus data.']);
    }
}
