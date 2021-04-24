<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Blog;
use App\KategoriArtikel;
use App\Komentar;
use App\Tag;
use App\User;

class BlogController extends Controller
{
    /**
     * Menampilkan data artikel
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
                // Data artikel
                $blog = Blog::join('users','blog.author','=','users.id_user')->orderBy('blog_at','desc')->get();
    			
                // View
                return view('artikel/admin/index', [
                    'blog' => $blog,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Menampilkan form tambah artikel
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
            // Kategori
            $kategori = KategoriArtikel::orderBy('id_ka','desc')->get();

            // View
            return view('artikel/admin/create', [
                'kategori' => $kategori,
            ]);
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Menambah artikel
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'judul_artikel' => 'required|max:255',
            'kategori' => 'required',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{					
			// Upload gambar
            $image_name = $request->gambar != '' ? upload_file_content($request->gambar, "assets/images/blog/") : '';

            // Upload gambar dari quill
            $html = quill_image_upload($request->konten, 'assets/images/konten-blog/');

            // Permalink
            $permalink = generate_permalink($request->judul_artikel);
            $i = 1;
            while(count_existing_data('blog', 'blog_permalink', $permalink, null) > 0){
                $permalink = rename_permalink(generate_permalink($request->judul_artikel), $i);
                $i++;
            }

            // Tag
            $array_id = [];
            $tags = explode(",", $request->get('tag'));
            foreach($tags as $key=>$tag){
                $tag_data = Tag::where('tag','=',$tag)->first();
                if(!$tag_data){
                    $slug = generate_permalink($tag);
                    $j = 1;
                    while(count_existing_data('tag', 'slug', $slug, null) > 0){
                        $slug = rename_permalink(generate_permalink($tag), $j);
                        $j++;
                    }

                    // Tambah tag baru
                    $new_tag = new Tag;
                    $new_tag->tag = $tag;
                    $new_tag->slug = $slug;
                    $new_tag->save();

                    // Get tag baru
                    $data_new_tag = Tag::latest('id_tag')->first();
                    array_push($array_id, $data_new_tag->id_tag);
                }
                else{
                    array_push($array_id, $tag_data->id_tag);
                }
            }

            // Menambah data
            $blog = new Blog;
            $blog->blog_title = $request->judul_artikel;
            $blog->blog_permalink = $permalink;
            $blog->blog_gambar = $image_name;
            $blog->blog_kategori = $request->kategori;
            $blog->blog_tag = implode(",", $array_id);
            $blog->konten = htmlentities($html);
            $blog->author = Auth::user()->id_user;
            $blog->kontributor = $request->kontributor != '' ? $request->kontributor : '';
            $blog->kontributor_slug = $request->kontributor != '' ? generate_permalink($request->kontributor) : '';
            $blog->blog_at = date('Y-m-d H:i:s');
            $blog->save();
        }

        // Redirect
        return redirect('/admin/artikel')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit artikel
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
        	// Data artikel
        	$blog = Blog::find($id);

            if(!$blog){
                abort(404);
            }

            // Tag
            if($blog->blog_tag != ''){
                $tags = explode(",", $blog->blog_tag);
                foreach($tags as $key=>$value){
                    $data_tag = Tag::find($value);
                    $tags[$key] = $data_tag->tag;
                }
                $blog->blog_tag = implode(",", $tags);
            }

            // Kategori
            $kategori = KategoriArtikel::orderBy('id_ka','desc')->get();

            // View
            return view('artikel/admin/edit', [
            	'blog' => $blog,
            	'kategori' => $kategori,
            ]);
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Mengupdate artikel
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'judul_artikel' => 'required|max:255',
            'kategori' => 'required',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{			
			// Upload gambar
            $image_name = $request->gambar != '' ? upload_file_content($request->gambar, "assets/images/blog/") : '';

            // Upload gambar dari quill
            $html = quill_image_upload($request->konten, 'assets/images/konten-blog/');

            // Permalink
            $permalink = generate_permalink($request->judul_artikel);
            $i = 1;
            while(count_existing_data('blog', 'blog_permalink', $permalink, $request->id) > 0){
                $permalink = rename_permalink(generate_permalink($request->judul_artikel), $i);
                $i++;
            }

            // Tag
            $array_id = [];
            $tags = explode(",", $request->get('tag'));
            foreach($tags as $key=>$tag){
                $tag_data = Tag::where('tag','=',$tag)->first();
                if(!$tag_data){
                    $slug = generate_permalink($tag);
                    $j = 1;
                    while(count_existing_data('tag', 'slug', $slug, null) > 0){
                        $slug = rename_permalink(generate_permalink($tag), $j);
                        $j++;
                    }

                    // Tambah tag baru
                    $new_tag = new Tag;
                    $new_tag->tag = $tag;
                    $new_tag->slug = $slug;
                    $new_tag->save();

                    // Get tag baru
                    $data_new_tag = Tag::latest('id_tag')->first();
                    array_push($array_id, $data_new_tag->id_tag);
                }
                else{
                    array_push($array_id, $tag_data->id_tag);
                }
            }

            // Mengupdate data
            $blog = Blog::find($request->id);
            $blog->blog_title = $request->judul_artikel;
            $blog->blog_permalink = $permalink;
            $blog->blog_gambar = $request->gambar != '' ? $image_name : $blog->blog_gambar;
            $blog->blog_kategori = $request->kategori;
            $blog->blog_tag = implode(",", $array_id);
            $blog->konten = htmlentities($html);
            $blog->kontributor = $request->kontributor != '' ? $request->kontributor : '';
            $blog->kontributor_slug = $request->kontributor != '' ? generate_permalink($request->kontributor) : '';
            $blog->save();
        }

        // Redirect
        return redirect('/admin/artikel/edit/'.$request->id)->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus artikel
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
    	// Menghapus data
        $blog = Blog::find($request->id);
        $blog->delete();

        // Redirect
        return redirect('/admin/artikel')->with(['message' => 'Berhasil menghapus data.']);
    }

    /**
     * Menampilkan semua artikel
     *
     * @return \Illuminate\Http\Response
     */
    public function posts()
    {
        // Data artikel
        $blogs = Blog::join('users','blog.author','=','users.id_user')->orderBy('blog_at','desc')->paginate(9);

        // View
        return view('artikel/guest/blogs', [
            'blogs' => $blogs
        ]);
    }

    /**
     * Menampilkan artikel berdasarkan kategori
     *
     * string $category
     * @return \Illuminate\Http\Response
     */
    public function categories($category)
    {
        // Data kategori
        $kategori = KategoriArtikel::where('slug','=',$category)->first();

        if(!$kategori){
            return redirect('/artikel');
        }
        
        // Data artikel
        $blogs = Blog::join('users','blog.author','=','users.id_user')->where('blog_kategori','=',$kategori->id_ka)->orderBy('blog_at','desc')->paginate(9);

        // View
        return view('artikel/guest/kategori', [
            'blogs' => $blogs,
            'kategori' => $kategori,
        ]);
    }

    /**
     * Menampilkan artikel berdasarkan tag
     *
     * string $tag
     * @return \Illuminate\Http\Response
     */
    public function tags($tag)
    {
        // Data tag
        $tag = Tag::where('slug','=',$tag)->first();

        if(!$tag){
            return redirect('/artikel');
        }

        // Data artikel
        $blogs = Blog::join('users','blog.author','=','users.id_user')->orderBy('blog_at','desc')->get();

        // Tag filter
        $ids = array();
        foreach($blogs as $key=>$blog){
            if($blog->blog_tag != ''){
                $explode = explode(',', $blog->blog_tag);
                if(in_array($tag->id_tag, $explode)){
                    array_push($ids, $blog->id_blog);
                }
            }
        }

        // Data artikel setelah di filter
        $blogs = Blog::join('users','blog.author','=','users.id_user')->whereIn('id_blog',$ids)->orderBy('blog_at','desc')->paginate(9);

        // View
        return view('artikel/guest/tag', [
            'blogs' => $blogs,
            'tag' => $tag,
        ]);
    }

    /**
     * Menampilkan artikel berdasarkan pencarian
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {        
        // Data artikel
        $blogs = Blog::join('users','blog.author','=','users.id_user')->join('kategori_artikel','blog.blog_kategori','=','kategori_artikel.id_ka')->where('blog_title','like','%'.$request->keyword.'%')->orWhere('konten','like','%'.$request->keyword.'%')->orWhere('kategori','like','%'.$request->keyword.'%')->orderBy('blog_at','desc')->paginate(9);

        // View
        return view('artikel/guest/search', [
            'blogs' => $blogs,
            'keyword' => $request->keyword,
        ]);
    }

    /**
     * Menampilkan konten
     *
     * string $permalink
     * @return \Illuminate\Http\Response
     */
    public function post($permalink)
    {
        // Data artikel
        $blog = Blog::join('users','blog.author','=','users.id_user')->where('blog_permalink','=',$permalink)->first();

        if(!$blog){
            abort(404);
        }

        // Tag artikel
        $blog_tags = array();
        if($blog->blog_tag != ''){
            $explode = explode(",", $blog->blog_tag);
            foreach($explode as $id){
                $tag = Tag::find($id);
                array_push($blog_tags, $tag);
            }
        }

        // Komentar
        $blog_komentar = Komentar::join('users','komentar.id_user','=','users.id_user')->where('id_artikel','=',$blog->id_blog)->where('komentar_parent','=',0)->orderBy('komentar_at','desc')->get();

        // Kategori
        $kategori = KategoriArtikel::orderBy('id_ka','desc')->get();

        // Tag
        $tag = Tag::limit(10)->get();

        // Artikel terbaru
        $recents = Blog::join('users','blog.author','=','users.id_user')->orderBy('blog_at','desc')->limit(6)->get();

        // View
        return view('artikel/guest/post', [
            'blog' => $blog,
            'blog_tags' => $blog_tags,
            'blog_komentar' => $blog_komentar,
            'kategori' => $kategori,
            'recents' => $recents,
            'tag' => $tag,
        ]);
    }

    /**
     * Mengirim komentar
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function comment(Request $request)
    {
        // Mengirim komentar
        $komentar = new Komentar;
        $komentar->id_user = Auth::user()->id_user;
        $komentar->id_artikel = $request->id_artikel;
        $komentar->komentar = $request->komentar;
        $komentar->komentar_parent = $request->komentar_parent;
        $komentar->komentar_at = date('Y-m-d H:i:s');
        $komentar->save();

        // Data artikel
        $blog = Blog::find($request->id_artikel);

        // Redirect
        return redirect('/artikel/'.$blog->blog_permalink);
    }

    /**
     * Menghapus komentar
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteComment(Request $request)
    {
        // Get komentar
        $komentar = Komentar::find($request->id_komentar);

        // Mencari dan menghapus anak komentar
        $children = Komentar::where('komentar_parent','=',$komentar->id_komentar)->get();
        if(count($children)>0){
            foreach($children as $data){
                $child = Komentar::find($data->id_komentar);
                $child->delete();
            }
        }

        // Menghapus komentar
        $komentar->delete();

        // Data artikel
        $blog = Blog::find($komentar->id_artikel);

        // Redirect
        return redirect('/artikel/'.$blog->blog_permalink);
    }

    /**
     * Menampilkan artikel berdasarkan author
     *
     * string $author
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function postsByAuthor(Request $request, $author)
    {
        // Get user
        $user = User::where('username','=',$author)->first();

        // Data artikel
        $blogs = Blog::join('users','blog.author','=','users.id_user')->where('author','=',$user->id_user)->where('kontributor','=','')->orWhere('kontributor','=',null)->orderBy('blog_at','desc')->paginate(9);

        // View
        return view('artikel/guest/posts-by-author', [
            'user' => $user,
            'blogs' => $blogs,
        ]);
    }

    /**
     * Menampilkan artikel berdasarkan kontributor
     *
     * string $contributor
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function postsByContributor(Request $request, $contributor)
    {
        // Data artikel
        $blogs = Blog::join('users','blog.author','=','users.id_user')->where('kontributor_slug','=',$contributor)->orderBy('blog_at','desc')->paginate(9);

        // Data kontributor
        $kontributor = (count($blogs)>0) ? $blogs[0]->kontributor : $contributor;

        // View
        return view('artikel/guest/posts-by-contributor', [
            'kontributor' => $kontributor,
            'blogs' => $blogs,
        ]);
    }
}
