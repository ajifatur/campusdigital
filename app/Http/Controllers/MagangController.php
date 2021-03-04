<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\MagangAbsensi;
use App\MagangMember;
use App\MagangSosialisasi;
use App\User;

class MagangController extends Controller
{
    /**
     * Menampilkan data member magang
     *
     * @return \Illuminate\Http\Response
     */
    public function member()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
                // Data member magang
				$member = MagangMember::join('kategori_lembaga','magang_member.satuan_pendidikan','=','kategori_lembaga.id_kl')->orderBy('mm_at','desc')->get();
    			
                // View
                return view('magang/admin/member', [
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
     * Menampilkan data absensi member magang
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function absensi(Request $request)
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
				// Get tanggal
				$tanggal = $request->query('tanggal') != null ? $request->query('tanggal') : date('d/m/Y');
				
                // Data absensi
				$absensi = MagangAbsensi::join('magang_member','magang_absensi.id_mm','=','magang_member.id_mm')->join('kategori_lembaga','magang_member.satuan_pendidikan','=','kategori_lembaga.id_kl')->whereDate('ma_at','=',generate_date_format($tanggal,'y-m-d'))->orderBy('ma_at','desc')->get();
    			
                // View
                return view('magang/admin/absensi', [
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
     * Menampilkan data sosialisasi
     *
     * @return \Illuminate\Http\Response
     */
    public function sosialisasi()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
                // Data sosialisasi
				$sosialisasi = MagangSosialisasi::join('kategori_lembaga','magang_sosialisasi.lembaga','=','kategori_lembaga.id_kl')->orderBy('ms_at','desc')->get();
    			
                // View
                return view('magang/admin/sosialisasi', [
                    'sosialisasi' => $sosialisasi,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }
}
