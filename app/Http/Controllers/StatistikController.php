<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Stevebauman\Location\Facades\Location;
use App\Aktivitas;
use App\FileReader;
use App\Pelatihan;
use App\PelatihanMember;
use App\User;
use App\Visitor;

class StatistikController extends Controller
{
    /**
     * Menampilkan statistik umum
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function umum(Request $request)
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
                $tanggal1 = $request->query('tanggal1') ?: date('d/m/Y');
                $tanggal2 = $request->query('tanggal2') ?: date('d/m/Y');

                // View
                return view('statistik/admin/umum', [
                    'tanggal1' => $tanggal1,
                    'tanggal2' => $tanggal2,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Menampilkan statistik pelatihan
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pelatihan(Request $request)
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
                // Data pelatihan
                $pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->orderBy('tanggal_pelatihan_from','desc')->get();

                // View
                return view('statistik/admin/pelatihan', [
                    'pelatihan' => $pelatihan,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Menampilkan statistik pelatihan member
     *
     * int $id_pelatihan
     * int $id_member
     * @return \Illuminate\Http\Response
     */
    public function pelatihanMember($id_pelatihan, $id_member)
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
                // Data pelatihan
                $pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->orderBy('tanggal_pelatihan_from','desc')->get();

                // Data member pelatihan
                $pelatihan_member = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan_member.id_user','=','users.id_user')->where('pelatihan_member.id_pelatihan','=',$id_pelatihan)->orderBy('nama_user','asc')->get();

                // Data user
                $member = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan_member.id_user','=','users.id_user')->where('pelatihan_member.id_pelatihan','=',$id_pelatihan)->where('pelatihan_member.id_user','=',$id_member)->firstOrFail();

                // View
                return view('statistik/admin/pelatihan', [
                    'pelatihan' => $pelatihan,
                    'pelatihan_member' => $pelatihan_member,
                    'member' => $member,
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
            $userUnder20 = User::where('is_admin','=',0)->where('status','=',1)->whereYear('tanggal_lahir','>=',(date('Y')-20))->count();
            // Data usia di antara 21 - 37
            $userBetween21_37 = User::where('is_admin','=',0)->where('status','=',1)->whereYear('tanggal_lahir','<=',(date('Y')-21))->whereYear('tanggal_lahir','>=',(date('Y')-37))->count();
            // Data usia di antara 38 - 50
            $userBetween38_50 = User::where('is_admin','=',0)->where('status','=',1)->whereYear('tanggal_lahir','<=',(date('Y')-38))->whereYear('tanggal_lahir','>=',(date('Y')-50))->count();
            // Data usia di atas 50
            $userAfter50 = User::where('is_admin','=',0)->where('status','=',1)->whereYear('tanggal_lahir','<',(date('Y')-50))->count();
            // Data total
            $userTotal = User::where('is_admin','=',0)->where('status','=',1)->count();
            
            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Sukses!',
                'data' => [
                    'data_num' => [$userUnder20, $userBetween21_37, $userBetween38_50, $userAfter50],
                    'total' => $userTotal,
                    'label' => ['< 20 Tahun', '21 - 37 Tahun', '38 - 50 Tahun', '> 50 Tahun'],
                    'colors' => ["#FF6384", "#63FF84", "#84FF63", "#8463FF"]
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
            $userL = User::where('is_admin','=',0)->where('status','=',1)->where('jenis_kelamin','=','L')->count();
            // Data gender perempuan
            $userP = User::where('is_admin','=',0)->where('status','=',1)->where('jenis_kelamin','=','P')->count();
            // Data total
            $userTotal = User::where('is_admin','=',0)->where('status','=',1)->count();
            
            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Sukses!',
                'data' => [
                    'data_num' => [$userL, $userP],
                    'total' => $userTotal,
                    'label' => ['Laki-Laki', 'Perempuan'],
                    'colors' => ["#FF6384", "#63FF84"]
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
     * Data lokasi
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dataLokasi(Request $request)
    {
        ini_set('max_execution_time', '300');

        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
            // Data total
            $visitorTotal = Visitor::join('users','visitor.id_user','=','users.id_user')->where('is_admin','=',0)->where('status','=',1)->whereNotIn('ip_address',['','127.0.0.1'])->whereDate('visit_at','>=',generate_date_format($request->query('tanggal1'), 'y-m-d'))->whereDate('visit_at','<=',generate_date_format($request->query('tanggal2'), 'y-m-d'))->get();

            // Get lokasi
            $visitorJakarta = $visitorJabar = $visitorJateng = $visitorJatim = $visitorLainnya = 0;
            if(count($visitorTotal)>0){
                foreach($visitorTotal as $visitor){
                    $location = Location::get($visitor->ip_address);
                    if($location){
                        if($location->regionName == 'Jakarta') $visitorJakarta++;
                        elseif($location->regionName == 'West Java') $visitorJabar++;
                        elseif($location->regionName == 'Central Java') $visitorJateng++;
                        elseif($location->regionName == 'East Java') $visitorJatim++;
                        else $visitorLainnya++;
                    }
                }
            }
            
            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Sukses!',
                'data' => [
                    'data_num' => [$visitorJakarta, $visitorJabar, $visitorJateng, $visitorJatim, $visitorLainnya],
                    'total' => count($visitorTotal),
                    'label' => ['Jakarta', 'Jawa Barat', 'Jawa Tengah', 'Jawa Timur', 'Lainnya'],
                    'colors' => ["#FF6384", "#63FF84", "#84FF63", "#8463FF", "#FDD100"]
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
     * Data kunjungan member
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dataKunjunganMember(Request $request)
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
            // Data total
            $userTotal = User::where('is_admin','=',0)->where('status','=',1)->get();

            $userLoginA = $userLoginB = $userLoginC = $userLoginD = 0;
            if(count($userTotal)>0){
                foreach($userTotal as $user){
                    if(count_visits($user->id_user, [generate_date_format($request->query('tanggal1'), 'y-m-d'), generate_date_format($request->query('tanggal2'), 'y-m-d')]) == 0) $userLoginA++;
                    elseif(count_visits($user->id_user, [generate_date_format($request->query('tanggal1'), 'y-m-d'), generate_date_format($request->query('tanggal2'), 'y-m-d')]) >= 1 && count_visits($user->id_user, [generate_date_format($request->query('tanggal1'), 'y-m-d'), generate_date_format($request->query('tanggal2'), 'y-m-d')]) <= 5) $userLoginB++;
                    elseif(count_visits($user->id_user, [generate_date_format($request->query('tanggal1'), 'y-m-d'), generate_date_format($request->query('tanggal2'), 'y-m-d')]) >= 6 && count_visits($user->id_user, [generate_date_format($request->query('tanggal1'), 'y-m-d'), generate_date_format($request->query('tanggal2'), 'y-m-d')]) <= 10) $userLoginC++;
                    elseif(count_visits($user->id_user, [generate_date_format($request->query('tanggal1'), 'y-m-d'), generate_date_format($request->query('tanggal2'), 'y-m-d')]) > 10) $userLoginD++;
                }
            }
            
            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Sukses!',
                'data' => [
                    'data_num' => [$userLoginA, $userLoginB, $userLoginC, $userLoginD],
                    'total' => count($userTotal),
                    'label' => ['Tidak Login', 'Login 1 - 5 kali', 'Login 6 - 10 kali', 'Login > 10 kali'],
                    'colors' => ["#FF6384", "#63FF84", "#84FF63", "#8463FF"]
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
     * Data pelatihan member
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dataPelatihanMember(Request $request)
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
            // Data total
            $userTotal = User::where('is_admin','=',0)->where('status','=',1)->get();

            $userPelatihan0 = $userPelatihan1 = $userPelatihan2 = $userPelatihan3 = $userPelatihan4 = $userPelatihanMore = 0;
            if(count($userTotal)>0){
                foreach($userTotal as $user){
                    if(count_pelatihan_member($user->id_user, [generate_date_format($request->query('tanggal1'), 'y-m-d'), generate_date_format($request->query('tanggal2'), 'y-m-d')]) == 0) $userPelatihan0++;
                    elseif(count_pelatihan_member($user->id_user, [generate_date_format($request->query('tanggal1'), 'y-m-d'), generate_date_format($request->query('tanggal2'), 'y-m-d')]) == 1) $userPelatihan1++;
                    elseif(count_pelatihan_member($user->id_user, [generate_date_format($request->query('tanggal1'), 'y-m-d'), generate_date_format($request->query('tanggal2'), 'y-m-d')]) == 2) $userPelatihan2++;
                    elseif(count_pelatihan_member($user->id_user, [generate_date_format($request->query('tanggal1'), 'y-m-d'), generate_date_format($request->query('tanggal2'), 'y-m-d')]) == 3) $userPelatihan3++;
                    elseif(count_pelatihan_member($user->id_user, [generate_date_format($request->query('tanggal1'), 'y-m-d'), generate_date_format($request->query('tanggal2'), 'y-m-d')]) == 4) $userPelatihan4++;
                    elseif(count_pelatihan_member($user->id_user, [generate_date_format($request->query('tanggal1'), 'y-m-d'), generate_date_format($request->query('tanggal2'), 'y-m-d')]) > 4) $userPelatihanMore++;
                }
            }
            
            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Sukses!',
                'data' => [
                    'data_num' => [$userPelatihan0, $userPelatihan1, $userPelatihan2, $userPelatihan3, $userPelatihan4, $userPelatihanMore],
                    'total' => count($userTotal),
                    'label' => ['Tidak Pernah Ikut', 'Ikut 1 kali', 'Ikut 2 kali', 'Ikut 3 kali', 'Ikut 4 kali', 'Ikut > 4'],
                    'colors' => ["#FF6384", "#63FF84", "#84FF63", "#8463FF", "#FDD100", "#F8B312"]
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
     * Data churn rate member
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dataChurnRateMember(Request $request)
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
            // Total
            $total = count_churn_rate(1) + count_churn_rate(2) + count_churn_rate(3);
            
            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Sukses!',
                'data' => [
                    'data_num' => [count_churn_rate(1), count_churn_rate(2), count_churn_rate(3)],
                    'total' => $total,
                    'label' => ['Tidak Login 1 bulan terakhir', 'Tidak Login 2 bulan terakhir', 'Tidak Login 3 bulan terakhir'],
                    'colors' => ["#FF6384", "#63FF84", "#84FF63"]
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
     * Data member pelatihan
     *
     * string $id
     * @return \Illuminate\Http\Response
     */
    public function dataMemberPelatihan($id)
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
            // Data member pelatihan
            $member = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan_member.id_user','=','users.id_user')->where('pelatihan_member.id_pelatihan','=',$id)->orderBy('nama_user','asc')->get();
            
            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Sukses!',
                'data' => $member
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
     * Data login member pelatihan
     *
     * string $id
     * @return \Illuminate\Http\Response
     */
    public function dataMemberPelatihanLogin($id)
    {
        ini_set('max_execution_time', '300');

        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
            // Data member pelatihan
            $member = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan_member.id_user','=','users.id_user')->find($id);
            
            if($member){
                // Array data
                $tanggal = [];
                $visit = [];
                $tanggal_awal = $member->tanggal_pelatihan_from;
                $tanggal_akhir = $member->tanggal_pelatihan_to;
                while(strtotime($tanggal_awal) < strtotime($tanggal_akhir)){
                    // Custom data
                    $count_visit = Visitor::where('id_user','=',$member->id_user)->whereDate('visit_at','=',$tanggal_awal)->count();

                    // Push first
                    array_push($tanggal, date('d/m/Y', strtotime($tanggal_awal)));
                    array_push($visit, $count_visit);

                    // Replace then
                    $tanggal_awal = date("Y-m-d", strtotime("+1 day", strtotime($tanggal_awal)));
                }

                // Response
                return response()->json([
                    'status' => 200,
                    'message' => 'Sukses!',
                    'data' => [
                        'tanggal' => $tanggal,
                        'visit' => $visit,
                    ]
                ]);
            }
            else{
                // Response
                return response()->json([
                    'status' => 404,
                    'message' => 'Not Found!',
                    'data' => [],
                ]);
            }
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
