<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Exports\AbsensiExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Absensi;
use App\User;

class AbsensiController extends Controller
{
    /**
     * Menampilkan data absensi
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
				// Get tanggal
				$tanggal = $request->query('tanggal') != null ? $request->query('tanggal') : date('d/m/Y');
				
                // Get data absensi
                $absensi = Absensi::join('users','absensi.id_user','=','users.id_user')->whereDate('absensi_at','=',generate_date_format($tanggal,'y-m-d'))->groupBy('absensi.id_user')->orderBy('absensi_at','desc')->get();
                
                // View
                return view('absensi/admin/index2', [
                    'absensi' => $absensi,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }
    
    /**
     * Export ke Excel
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
				// Get tanggal
				$tanggal = $request->query('tanggal') != null ? $request->query('tanggal') : date('d/m/Y');
				
                // Get data absensi
                $absensi = Absensi::join('users','absensi.id_user','=','users.id_user')->whereDate('absensi_at','=',generate_date_format($tanggal,'y-m-d'))->groupBy('absensi.id_user')->orderBy('absensi_at','asc')->get();
                
       	 		return Excel::download(new AbsensiExport($absensi), 'Rekap Absensi '.generate_date_format($tanggal,'y-m-d').'.xlsx');
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }
}
