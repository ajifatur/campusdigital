<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Course;
use App\CourseChapter;
use App\User;

class CourseController extends Controller
{
    /**
     * Menampilkan data chapter
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
                // Data chapter
                $chapter = CourseChapter::all();
    			
                // View
                return view('e-course/admin/index', [
                    'chapter' => $chapter,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
        elseif(Auth::user()->is_admin == 0){
			// User belum membayar
            if(Auth::user()->status == 0) return redirect('/member/pemberitahuan');
            
            // Data chapter
            $chapter = CourseChapter::all();
            // foreach($chapter as $key=>$data){
            //     $courses = Course::where('id_cc','=',$data->id_cc)->orderBy('course_nomor','asc')->get();
            //     $chapter[$key]->courses = $courses;
            // }
    			
            // View
            return view('e-course/member/index', [
                'chapter' => $chapter,
            ]);
        }
    }

    /**
     * Menginput voucher
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function voucher(Request $request)
    {
		// Mengecek kecocokan voucher
		$data = CourseChapter::where('id_cc','=',$request->id)->where('voucher','=',$request->voucher)->first();
		
		if(!$data){
			// Redirect
			return redirect('/member/e-course')->with(['message' => 'Tidak berhasil menggunakan voucher.', 'id_cc' => $request->id]);
		}
		else{
			// Simpan ke session
			$request->session()->put('id_cc', $data->id_cc);
			
			// Redirect
			return redirect('/member/e-course/chapter/'.$data->chapter_nomor);
		}
    }

    /**
     * Menampilkan form tambah chapter
     *
     * @return \Illuminate\Http\Response
     */
    public function createChapter()
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
        	// Exist chapters
        	$array = array();
            $exist_chapter = CourseChapter::orderBy('chapter_nomor','asc')->get();
            if(count($exist_chapter) > 0){
	            foreach($exist_chapter as $data){
	            	array_push($array, $data->chapter_nomor);
	            }
	        }

            // View
            return view('e-course/admin/create-chapter', ['array' => $array]);
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Menambah chapter
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeChapter(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
        	'chapter_nomor' => 'required',
            'judul' => 'required|max:255',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{		
            // Upload gambar
            $image_name = $request->gambar != '' ? upload_file_content($request->gambar, "assets/images/chapter/") : '';
			
            // Menambah data
            $chapter = new CourseChapter;
            $chapter->chapter_nomor = $request->chapter_nomor;
            $chapter->chapter_judul = $request->judul;
            $chapter->chapter_icon = $image_name;
            $chapter->voucher = $request->voucher != '' ? $request->voucher : '';
            $chapter->save();
        }

        // Redirect
        return redirect('/admin/e-course')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan detail chapter
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function detailChapter($id)
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
                // Data chapter
                $chapter = CourseChapter::where('chapter_nomor','=',$id)->first();

                if(!$chapter){
                    abort(404);
                }

                // Data e-course
                $video = Course::where('id_cc','=',$chapter->id_cc)->orderBy('course_nomor','asc')->get();

                // View
                return view('e-course/admin/detail-chapter', [
                    'chapter' => $chapter,
                    'video' => $video,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
        elseif(Auth::user()->is_admin == 0){
			// User belum membayar
            if(Auth::user()->status == 0) return redirect('/member/pemberitahuan');

            // Data chapter
            $chapter = CourseChapter::where('chapter_nomor','=',$id)->first();

            if(!$chapter){
                abort(404);
            }
			
			// Belum memasukkan voucher
			if(session()->get('id_cc') != $chapter->id_cc && $chapter->voucher != ''){
				// Redirect
				return redirect('/member/e-course')->with(['message' => 'Anda harus memasukkan voucher terlebih dahulu', 'id_cc' => $chapter->id_cc]);
			}

            // Data e-course
            $video = Course::where('id_cc','=',$chapter->id_cc)->orderBy('course_nomor','asc')->get();

            // View
            return view('e-course/member/videos', [
                'chapter' => $chapter,
                'video' => $video,
            ]);
        }
    }

    /**
     * Menampilkan form edit chapter
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function editChapter($id)
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
        	// Data chapter
        	$chapter = CourseChapter::find($id);

            if(!$chapter){
                abort(404);
            }

        	// Exist chapters
        	$array = array();
            $exist_chapter = CourseChapter::where('id_cc','!=',$id)->orderBy('chapter_nomor','asc')->get();
            if(count($exist_chapter) > 0){
	            foreach($exist_chapter as $data){
	            	array_push($array, $data->chapter_nomor);
	            }
	        }

            // View
            return view('e-course/admin/edit-chapter', [
            	'chapter' => $chapter,
            	'array' => $array,
            ]);
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Mengupdate chapter
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateChapter(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'chapter_nomor' => 'required',
            'judul' => 'required|max:255',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{		
            // Upload gambar
            $image_name = $request->gambar != '' ? upload_file_content($request->gambar, "assets/images/chapter/") : '';
			
            // Mengupdate data
            $chapter = CourseChapter::find($request->id);
            $chapter->chapter_nomor = $request->chapter_nomor;
            $chapter->chapter_judul = $request->judul;
            $chapter->chapter_icon = $request->gambar != '' ? $image_name : $chapter->chapter_icon;
            $chapter->voucher = $request->voucher != '' ? $request->voucher : $chapter->voucher;
            $chapter->save();
        }

        // Redirect
        return redirect('/admin/e-course')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus chapter
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteChapter(Request $request)
    {
    	// Menghapus data
        $chapter = CourseChapter::find($request->id);
        $chapter->delete();

        // Redirect
        return redirect('/admin/e-course')->with(['message' => 'Berhasil menghapus data.']);
    }

    /**
     * Menampilkan form tambah video
     *
     * * int $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
        	// Data chapter
        	$chapter = CourseChapter::where('chapter_nomor','=',$id)->first();

            if(!$chapter){
                abort(404);
            }

        	// Exist videos
        	$array = array();
            $exist_video = Course::where('id_cc','=',$chapter->id_cc)->orderBy('course_nomor','asc')->get();
            if(count($exist_video) > 0){
	            foreach($exist_video as $data){
	            	array_push($array, $data->course_nomor);
	            }
	        }

            // View
            return view('e-course/admin/create', [
                'chapter' => $chapter,
                'array' => $array
            ]);
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Menambah video
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'chapter' => 'required',
        	'course_nomor' => 'required',
            'judul' => 'required|max:255',
            'caption' => 'required',
            'kode_youtube' => 'required',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{				
			// Upload gambar
            $image_name = $request->thumbnail != '' ? upload_file_content($request->thumbnail, "assets/images/course/") : '';

            // Chapter
            $chapter = CourseChapter::find($request->chapter);
            
            // Menambah data
            $course = new Course;
            $course->id_cc = $request->chapter;
            $course->course_nomor = $request->course_nomor;
            $course->course_judul = $request->judul;
            $course->course_gambar = $image_name;
            $course->course_caption = $request->caption;
            $course->course_youtube = $request->kode_youtube;
            $course->course_at = date('Y-m-d H:i:s');
            $course->save();
        }

        // Redirect
        return redirect('/admin/e-course/chapter/'.$chapter->chapter_nomor)->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form detail video
     *
     * * int $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
                // Data course
                $course = Course::join('course_chapter','course.id_cc','=','course_chapter.id_cc')->find($id);

                if(!$course){
                    abort(404);
                }

                // Data semua course
                $all_courses = Course::join('course_chapter','course.id_cc','=','course_chapter.id_cc')->where('course.id_cc','=',$course->id_cc)->orderBy('course_chapter.chapter_nomor','asc')->orderBy('course_nomor','asc')->get();
                if(count($all_courses)>0){
                    foreach($all_courses as $key=>$data){
                        if($data->id_course == $course->id_course){
                            $current_key = $key;
                            // Video sebelumnya dan selanjutnya
                            $prev = isset($all_courses[$key-1]) ? Course::find($all_courses[$key-1]->id_course) : Course::find(0);
                            $next = isset($all_courses[$key+1]) ? Course::find($all_courses[$key+1]->id_course) : Course::find(0);
                        }
                    }
                }

                // View
                return view('e-course/admin/detail', [
                    'course' => $course,
                    'all_courses' => $all_courses,
                    'prev' => $prev,
                    'next' => $next,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
        elseif(Auth::user()->is_admin == 0){
			// User belum membayar
            if(Auth::user()->status == 0) return redirect('/member/pemberitahuan');

            // Data course
            $course = Course::join('course_chapter','course.id_cc','=','course_chapter.id_cc')->find($id);

            if(!$course){
                abort(404);
            }
			
			// Belum memasukkan voucher
			if(session()->get('id_cc') != $course->id_cc && $course->voucher != ''){
				// Redirect
				return redirect('/member/e-course')->with(['message' => 'Anda harus memasukkan voucher terlebih dahulu', 'id_cc' => $course->id_cc]);
			}

            // Data semua course
            $all_courses = Course::join('course_chapter','course.id_cc','=','course_chapter.id_cc')->where('course.id_cc','=',$course->id_cc)->orderBy('course_chapter.chapter_nomor','asc')->orderBy('course_nomor','asc')->get();
            if(count($all_courses)>0){
                foreach($all_courses as $key=>$data){
                    if($data->id_course == $course->id_course){
                        $current_key = $key;
                        // Video sebelumnya dan selanjutnya
                        $prev = isset($all_courses[$key-1]) ? Course::find($all_courses[$key-1]->id_course) : Course::find(0);
                        $next = isset($all_courses[$key+1]) ? Course::find($all_courses[$key+1]->id_course) : Course::find(0);
                    }
                }
            }

            // View
            return view('e-course/member/detail', [
                'course' => $course,
                'all_courses' => $all_courses,
                'prev' => $prev,
                'next' => $next,
            ]);
        }
    }

    /**
     * Menampilkan form edit video
     *
     * * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
        	// Data course
        	$course = Course::find($id);

            if(!$course){
                abort(404);
            }

        	// Exist videos
        	$array = array();
            $exist_video = Course::where('id_course','!=',$id)->where('id_cc','=',$course->id_cc)->orderBy('course_nomor','asc')->get();
            if(count($exist_video) > 0){
	            foreach($exist_video as $data){
	            	array_push($array, $data->course_nomor);
	            }
	        }

            // View
            return view('e-course/admin/edit', [
                'course' => $course,
                'array' => $array
            ]);
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Mengupdate video
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'chapter' => 'required',
            'course_nomor' => 'required',
            'judul' => 'required|max:255',
            'caption' => 'required',
            'kode_youtube' => 'required',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{				
			// Upload gambar
            $image_name = $request->thumbnail != '' ? upload_file_content($request->thumbnail, "assets/images/course/") : '';

            // Chapter
            $chapter = CourseChapter::find($request->chapter);
            
            // Mengupdate data
            $course = Course::find($request->id);
            $course->id_cc = $request->chapter;
            $course->course_nomor = $request->course_nomor;
            $course->course_judul = $request->judul;
            $course->course_gambar = $request->thumbnail != '' ? $image_name : $course->course_gambar;
            $course->course_caption = $request->caption;
            $course->course_youtube = $request->kode_youtube;
            $course->save();
        }

        // Redirect
        return redirect('/admin/e-course/chapter/'.$chapter->chapter_nomor)->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus video
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
    	// Menghapus data
        $course = Course::join('course_chapter','course.id_cc','=','course_chapter.id_cc')->find($request->id);
        $course->delete();

        // Redirect
        return redirect('/admin/e-course/chapter/'.$course->chapter_nomor)->with(['message' => 'Berhasil menghapus data.']);
    }
}
