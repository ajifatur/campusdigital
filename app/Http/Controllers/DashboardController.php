<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Blog;
use App\Course;
use App\DefaultRekening;
use App\Deskripsi;
use App\Files;
use App\Files2;
use App\FolderKategori;
use App\Fitur;
use App\KategoriMateri;
use App\Komisi;
use App\Pelatihan;
use App\Popup;
use App\Signature;
use App\User;
use App\Visitor;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard admin
     * 
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {		
		// Data Member Aktif
		$data_student_aktif = User::where('is_admin','=',0)->where('status','=',1)->count();
		// Data Member Belum Aktif
		$data_student_belum_aktif = User::where('is_admin','=',0)->where('status','=',0)->count();
		
		// New Array
		$array = [
			['data' => 'Member Aktif', 'total' => $data_student_aktif, 'url' => '/admin/user?filter=aktif'],
			['data' => 'Member Belum Aktif', 'total' => $data_student_belum_aktif, 'url' => '/admin/user?filter=belum-aktif'],
		];
		
		// Array Push Data Materi
		$kategori_materi = FolderKategori::where('id_fk','>=',4)->get();
		foreach($kategori_materi as $data){
			$file = Files2::where('file_kategori','=',$data->id_fk)->get();
			array_push($array, ['data' => 'Materi '.$data->folder_kategori, 'total' => count($file), 'url' => '/admin/file-manager/'.$data->slug_kategori]);
		}
		
		// Array Push Data Course, Data Artikel, Data Pelatihan
		$data_course = Files2::where('file_kategori','=',1)->count();
		$data_artikel = Blog::join('kategori_artikel','blog.blog_kategori','=','kategori_artikel.id_ka')->count();
		$data_pelatihan = Pelatihan::join('kategori_pelatihan','pelatihan.kategori_pelatihan','=','kategori_pelatihan.id_kp')->count();
		array_push($array, 
			['data' => 'Materi E-Course', 'total' => $data_course, 'url' => '/admin/file-manager/e-course'],
			['data' => 'Artikel', 'total' => $data_artikel, 'url' => '/admin/artikel'],
			['data' => 'Pelatihan', 'total' => $data_pelatihan, 'url' => '/admin/pelatihan'],
		);
		
		// View
	    return view('dashboard/admin/dashboard', [
			'array' => $array,
		]);
	}
	
    /**
     * Menampilkan dashboard member
     * 
     * @return \Illuminate\Http\Response
     */
    public function member()
    {
		// Get deskripsi
		$deskripsi = Deskripsi::first();

		// Get data fitur
		$fitur = Fitur::all();

        // Get data default rekening
        $default_rekening = DefaultRekening::join('platform','default_rekening.id_platform','=','platform.id_platform')->orderBy('tipe_platform','asc')->get();

        // Get data komisi
        $komisi = Komisi::where('id_user','=',Auth::user()->id_user)->first();
		
		// Get data pop-up
		$popup = Popup::whereDate('popup_from','<=',date('Y-m-d'))->whereDate('popup_to','>=',date('Y-m-d'))->orderBy('popup_to','asc')->get();

        // Get data signature
		$signature = Signature::where('id_user','=',Auth::user()->id_user)->first();
		
		if(Auth::user()->role == role_trainer()){
			// Data pelatihan (kecuali yang dia traineri)
			$pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->where('trainer','!=',Auth::user()->id_user)->whereDate('tanggal_pelatihan_from','>=',date('Y-m-d'))->orderBy('tanggal_pelatihan_from','desc')->get();
		}
		elseif(Auth::user()->role == role_member()){
			// Data pelatihan
			$pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->whereDate('tanggal_pelatihan_from','>=',date('Y-m-d'))->orderBy('tanggal_pelatihan_from','desc')->get();
		}

    	// View
	    return view('dashboard/member/dashboard', [
            'default_rekening' => $default_rekening,
            'deskripsi' => $deskripsi,
            'fitur' => $fitur,
            'komisi' => $komisi,
            'pelatihan' => $pelatihan,
            'popup' => $popup,
            'signature' => $signature,
        ]);
    }
	
    /**
     * Count visitor
     * 
     * @return \Illuminate\Http\Response
     */
    public function countVisitor()
    {
		// Get data last 7 days
		$array = array();
		for($i=7; $i>=0; $i--){
			$date = date('Y-m-d', strtotime('-'.$i.' days'));
			$visitor_all = Visitor::join('users','visitor.id_user','=','users.id_user')->whereDate('visit_at','=',$date)->groupBy('visitor.id_user')->get();
			$visitor_admin = Visitor::join('users','visitor.id_user','=','users.id_user')->where('is_admin','=',1)->whereDate('visit_at','=',$date)->groupBy('visitor.id_user')->get();
			$visitor_member = Visitor::join('users','visitor.id_user','=','users.id_user')->where('is_admin','=',0)->whereDate('visit_at','=',$date)->groupBy('visitor.id_user')->get();
			array_push($array, array(
				'date' => $date,
				'date_str' => date('d/m/y', strtotime($date)),
				'visitor_all' => count($visitor_all),
				'visitor_admin' => count($visitor_admin),
				'visitor_member' => count($visitor_member),
			));
		}
		echo json_encode($array);
    }
}
