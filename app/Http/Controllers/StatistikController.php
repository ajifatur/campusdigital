<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Stevebauman\Location\Facades\Location;
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

    /* Statistik API */

    /**
     * Data usia
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dataUsia(Request $request)
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
            // Data usia di bawah 20
            $userUnder20 = User::where('is_admin','=',0)->whereYear('tanggal_lahir','>=',(date('Y')-20))->count();
            // Data usia di antara 21 - 37
            $userBetween21_37 = User::where('is_admin','=',0)->whereYear('tanggal_lahir','<=',(date('Y')-21))->whereYear('tanggal_lahir','>=',(date('Y')-37))->count();
            // Data usia di antara 38 - 50
            $userBetween38_50 = User::where('is_admin','=',0)->whereYear('tanggal_lahir','<=',(date('Y')-38))->whereYear('tanggal_lahir','>=',(date('Y')-50))->count();
            // Data usia di atas 50
            $userAfter50 = User::where('is_admin','=',0)->whereYear('tanggal_lahir','<',(date('Y')-50))->count();
            // Data total
            $userTotal = User::where('is_admin','=',0)->count();
            
            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Sukses!',
                'data' => [
                    'data_num' => [$userUnder20, $userBetween21_37, $userBetween38_50, $userAfter50],
                    'data_pcg' => [
                        round(($userUnder20 / $userTotal) * 100, 2),
                        round(($userBetween21_37 / $userTotal) * 100, 2),
                        round(($userBetween38_50 / $userTotal) * 100, 2),
                        round(($userAfter50 / $userTotal) * 100, 2),
                    ],
                    'total' => $userTotal,
                    'label' => ['< 20', '21 - 37', '38 - 50', '> 50']
                ],
            ]);
        }
        else{
            // Response
            return response()->json([
                'status' => 403,
                'message' => 'Forbidden!',
                'data' => [],
            ]);
        }
    }

    /**
     * Data gender
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dataGender(Request $request)
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
            // Data gender laki-laki
            $userL = User::where('is_admin','=',0)->where('jenis_kelamin','=','L')->count();
            // Data gender perempuan
            $userP = User::where('is_admin','=',0)->where('jenis_kelamin','=','P')->count();
            // Data total
            $userTotal = User::where('is_admin','=',0)->count();
            
            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Sukses!',
                'data' => [
                    'data_num' => [$userL, $userP],
                    'data_pcg' => [
                        round(($userL / $userTotal) * 100, 2),
                        round(($userP / $userTotal) * 100, 2)
                    ],
                    'total' => $userTotal,
                    'label' => ['Laki-Laki', 'Perempuan']
                ],
            ]);
        }
        else{
            // Response
            return response()->json([
                'status' => 403,
                'message' => 'Forbidden!',
                'data' => [],
            ]);
        }
    }
}
