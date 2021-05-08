<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Aktivitas;
use App\FileReader;
use App\User;
use App\Visitor;

class StatistikController extends Controller
{
    /**
     * Menampilkan data statistik
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){    			
                // View
                return view('statistik/admin/index', [
                    //
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Menampilkan data visitor
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function visitor(Request $request)
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it()){
				// Get tanggal
				$tanggal = $request->query('tanggal') != null ? $request->query('tanggal') : date('d/m/Y');
				//$bulan = $request->query('bulan') != null ? $request->query('bulan') <= 12 ? $request->query('bulan') : date('n') : date('n');
				
                // Data visitor
                if($request->query('filter') == 'admin'){
                    $visitor = Visitor::join('users','visitor.id_user','=','users.id_user')->where('is_admin','=',1)->whereDate('visit_at','=',generate_date_format($tanggal,'y-m-d'))->orderBy('visit_at','desc')->get();
                }
                elseif($request->query('filter') == 'member'){
                    $visitor = Visitor::join('users','visitor.id_user','=','users.id_user')->where('is_admin','=',0)->whereDate('visit_at','=',generate_date_format($tanggal,'y-m-d'))->orderBy('visit_at','desc')->get();
                }
                else{
                    $visitor = Visitor::join('users','visitor.id_user','=','users.id_user')->whereDate('visit_at','=',generate_date_format($tanggal,'y-m-d'))->orderBy('visit_at','desc')->get();
                }
    			
                // View
                return view('statistik/admin/visitor', [
                    'tanggal' => $tanggal,
                    'filter' => $request->query('filter'),
                    'visitor' => $visitor,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Menampilkan data top visitor
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function topVisitor(Request $request)
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it()){
                // Data visitor
                if($request->query('filter') == 'admin'){
                    $visitor_group = Visitor::join('users','visitor.id_user','=','users.id_user')->where('is_admin','=',1)->groupBy('visitor.id_user')->orderBy('visit_at','desc')->get();
                }
                elseif($request->query('filter') == 'member'){
                    $visitor_group = Visitor::join('users','visitor.id_user','=','users.id_user')->where('is_admin','=',0)->groupBy('visitor.id_user')->orderBy('visit_at','desc')->get();
                }
                else{
                    $visitor_group = Visitor::join('users','visitor.id_user','=','users.id_user')->groupBy('visitor.id_user')->orderBy('visit_at','desc')->get();
                }
    			
                // View
                return view('statistik/admin/top-visitor', [
                    'filter' => $request->query('filter'),
                    'visitor_group' => $visitor_group,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Menampilkan data file reader
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fileReader(Request $request)
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it()){
                $file_reader = FileReader::join('users','file_reader.id_user','=','users.id_user')->join('file','file_reader.id_file','=','file.id_file')->join('kategori_materi','file.jenis_file','=','kategori_materi.id_km')->orderBy('read_at','desc')->get();
                $by_reader = FileReader::join('users','file_reader.id_user','=','users.id_user')->join('file','file_reader.id_file','=','file.id_file')->join('kategori_materi','file.jenis_file','=','kategori_materi.id_km')->groupBy('file_reader.id_user')->orderBy('read_at','desc')->get();
                $by_file = FileReader::join('users','file_reader.id_user','=','users.id_user')->join('file','file_reader.id_file','=','file.id_file')->join('kategori_materi','file.jenis_file','=','kategori_materi.id_km')->groupBy('file_reader.id_file')->orderBy('read_at','desc')->get();
    			
                // View
                return view('statistik/admin/file-reader', [
                    'file_reader' => $file_reader,
                    'by_reader' => $by_reader,
                    'by_file' => $by_file,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Menampilkan data aktivitas
     *
     * int $id
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function detailAktivitas(Request $request, $id)
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it()){
                // Get data user
                $user = User::find($id);

                if(!$user){
                    abort(404);
                }

                // Get data all aktivitas
                $all_aktivitas = Aktivitas::where('id_user','=',$id)->orderBy('aktivitas_at','desc')->get();

				// Login
				$login = $request->query('login') != null ? $request->query('login') : $all_aktivitas[0]->id_aktivitas;
				
				// Get data aktivitas
                $aktivitas = Aktivitas::where('id_user','=',$id)->where('id_aktivitas','=',$login)->first();
				$aktivitas->aktivitas = json_decode($aktivitas->aktivitas, true);

                // View
                return view('statistik/admin/detail-aktivitas', [
                    'user' => $user,
                    'all_aktivitas' => $all_aktivitas,
                    'aktivitas' => $aktivitas,
                    'login' => $login,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }
}
