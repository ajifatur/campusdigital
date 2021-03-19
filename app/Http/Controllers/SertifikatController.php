<?php

namespace App\Http\Controllers;

use Auth;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Pelatihan;
use App\PelatihanMember;
use App\Signature;
use App\User;

class SertifikatController extends Controller
{
    /**
     * Menampilkan data sertifikat trainer
     *
     * @return \Illuminate\Http\Response
     */
    public function indexTrainer()
    {
		if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
                // Data Sertifikat
                $sertifikat = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->get();
				
                // View
                return view('e-sertifikat/admin/index-trainer', [
                    'sertifikat' => $sertifikat,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
		}
		elseif(Auth::user()->is_admin == 0){
			// Data Sertifikat
			$sertifikat = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->where('users.id_user','=',Auth::user()->id_user)->get();
			
			// View
			return view('e-sertifikat/member/index-trainer', [
				'sertifikat' => $sertifikat,
			]);
		}
    }
	
    /**
     * Menampilkan data sertifikat peserta
     *
     * @return \Illuminate\Http\Response
     */
    public function indexParticipant()
    {
		if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
                // Data Sertifikat
                $sertifikat = PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->where('status_pelatihan','!=',0)->get();
                
                if(count($sertifikat)>0){
                    foreach($sertifikat as $key=>$data){
                        // Data pelatihan
                        $pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->find($data->id_pelatihan);
						if(!$pelatihan) $sertifikat->forget($key);
                        else $sertifikat[$key]->pelatihan = $pelatihan;
                    }
                }
                
                // View
                return view('e-sertifikat/admin/index-participant', [
                    'sertifikat' => $sertifikat,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
		}
		elseif(Auth::user()->is_admin == 0){
			// Data Sertifikat
			$sertifikat = PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->where('pelatihan_member.id_user','=',Auth::user()->id_user)->where('status_pelatihan','!=',0)->get();
			
			if(count($sertifikat)>0){
				foreach($sertifikat as $key=>$data){
					// Data pelatihan
					$pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->find($data->id_pelatihan);
					if(!$pelatihan) $sertifikat->forget($key);
					else $sertifikat[$key]->pelatihan = $pelatihan;
				}
			}
			
			// View
			return view('e-sertifikat/member/index-participant', [
				'sertifikat' => $sertifikat,
			]);
		}
    }
	
    /**
     * Menampilkan PDF Sertifikat Trainer
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function viewTrainer(Request $request, $id)
    {
        ini_set('max_execution_time', 300);

        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
                // Data Member
                $member = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->find($id);

                // Jika tidak ada
                if(!$member){
                    abort(404);
                }
            }
            else{
                // View
                return view('error/forbidden');
            }
		}
		elseif(Auth::user()->is_admin == 0){
			// Data Member
			$member = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->where('users.id_user','=',Auth::user()->id_user)->find($id);

			// Jika tidak ada
			if(!$member){
				abort(404);
			}
		}

		// Data pelatihan
		$pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->join('kategori_pelatihan','pelatihan.kategori_pelatihan','=','kategori_pelatihan.id_kp')->find($member->id_pelatihan);
		$pelatihan->materi_pelatihan = json_decode($pelatihan->materi_pelatihan, true);
		
		// Direktur
		$direktur = User::where('role','=',role_manajer())->first();
		
		// Dosen
		$dosen = User::where('role','=',role_mentor())->first();
		
		// Data signature direktur
		$signature_direktur = Signature::join('users','signature.id_user','=','users.id_user')->where('users.role','=',role_manajer())->first();
		
		// Data signature dosen
		$signature_dosen = Signature::join('users','signature.id_user','=','users.id_user')->where('users.role','=',role_mentor())->first();
		
		// Data signature trainer
		$signature_trainer = Signature::where('id_user','=',$pelatihan->trainer)->first();
		
		// Page
		$page = $request->query('page');
		if($page == null) return redirect('/admin/e-sertifikat/trainer/detail/'.$id.'?page=1');

		// View PDF
		$pdf = PDF::loadview('e-sertifikat/pdf/trainer/'.$page, [
			'member' => $member,
			'direktur' => $direktur,
			'dosen' => $dosen,
			'pelatihan' => $pelatihan,
			'signature_direktur' => $signature_direktur,
			'signature_dosen' => $signature_dosen,
			'signature_trainer' => $signature_trainer,
		]);
		$pdf->setPaper('A4', 'landscape');
		
        return $pdf->stream("Sertifikat Trainer Pelatihan.pdf");
    }
	
    /**
     * Menampilkan PDF Sertifikat Peserta
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function viewParticipant(Request $request, $id)
    {
        ini_set('max_execution_time', 300);

        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
                // Data Member
                $member = PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->where('status_pelatihan','!=',0)->find($id);

                // Jika tidak ada
                if(!$member){
                    abort(404);
                }
            }
            else{
                // View
                return view('error/forbidden');
            }
		}
		elseif(Auth::user()->is_admin == 0){
			// Data Member
			$member = PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->where('pelatihan_member.id_user','=',Auth::user()->id_user)->where('status_pelatihan','!=',0)->find($id);

			// Jika tidak ada
			if(!$member){
				abort(404);
			}
		}

		// Data pelatihan
		$pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->join('kategori_pelatihan','pelatihan.kategori_pelatihan','=','kategori_pelatihan.id_kp')->find($member->id_pelatihan);
		$pelatihan->materi_pelatihan = json_decode($pelatihan->materi_pelatihan, true);
		
		// Direktur
		$direktur = User::where('role','=',role_manajer())->first();
		
		// Dosen
		$dosen = User::where('role','=',role_mentor())->first();
		
		// Data signature direktur
		$signature_direktur = Signature::join('users','signature.id_user','=','users.id_user')->where('users.role','=',role_manajer())->first();
		
		// Data signature dosen
		$signature_dosen = Signature::join('users','signature.id_user','=','users.id_user')->where('users.role','=',role_mentor())->first();
		
		// Data signature trainer
		$signature_trainer = Signature::where('id_user','=',$pelatihan->trainer)->first();
		
		// Page
		$page = $request->query('page');
		// if($page != 1 || $page != 2 || $page != 'all') return redirect('/admin/e-sertifikat/peserta/detail/'.$id.'?page=all');

		// View PDF
		$pdf = PDF::loadview('e-sertifikat/pdf/peserta/'.$page, [
			'member' => $member,
			'direktur' => $direktur,
			'dosen' => $dosen,
			'pelatihan' => $pelatihan,
			'signature_direktur' => $signature_direktur,
			'signature_dosen' => $signature_dosen,
			'signature_trainer' => $signature_trainer,
		]);
		$pdf->setPaper('A4', 'landscape');
		
        return $pdf->stream("Sertifikat Peserta Pelatihan.pdf");
    }
	
    /**
     * Menampilkan ID Card Member
     *
     * @return \Illuminate\Http\Response
     */
    public function idcard()
    {
        ini_set('max_execution_time', 300);
		
		if(Auth::user()->is_admin == 0){
			// Data Member
			$member = User::join('role','users.role','=','role.id_role')->find(Auth::user()->id_user);

			// Jika tidak ada
			if(!$member){
				abort(404);
			}
		}

		// View PDF
		$pdf = PDF::loadview('id-card', [
			'member' => $member,
		]);
		//$pdf->setPaper('A4', 'landscape');
		
        return $pdf->stream("ID Card.pdf");
    }
	
    /**
     * Cek Sertifikat Peserta
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function checkParticipant($id)
    {
        ini_set('max_execution_time', 300);

		// Data Member
		$member = PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->where('status_pelatihan','!=',0)->find($id);

		// Jika tidak ada
		if(!$member){
			abort(404);
		}

		// Data pelatihan
		$pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->join('kategori_pelatihan','pelatihan.kategori_pelatihan','=','kategori_pelatihan.id_kp')->find($member->id_pelatihan);
		$pelatihan->materi_pelatihan = json_decode($pelatihan->materi_pelatihan, true);
		
		// Direktur
		$direktur = User::where('role','=',role_manajer())->first();
		
		// Dosen
		$dosen = User::where('role','=',role_mentor())->first();
		
		// Data signature direktur
		$signature_direktur = Signature::join('users','signature.id_user','=','users.id_user')->where('users.role','=',role_manajer())->first();
		
		// Data signature dosen
		$signature_dosen = Signature::join('users','signature.id_user','=','users.id_user')->where('users.role','=',role_mentor())->first();
		
		// Data signature trainer
		$signature_trainer = Signature::where('id_user','=',$pelatihan->trainer)->first();
		
		// Page
		// $page = $request->query('page');
		// if($page != 1 || $page != 2 || $page != 'all') return redirect('/admin/e-sertifikat/peserta/detail/'.$id.'?page=all');

		// View PDF
		$pdf = PDF::loadview('e-sertifikat/pdf/peserta/all', [
			'member' => $member,
			'direktur' => $direktur,
			'dosen' => $dosen,
			'pelatihan' => $pelatihan,
			'signature_direktur' => $signature_direktur,
			'signature_dosen' => $signature_dosen,
			'signature_trainer' => $signature_trainer,
		]);
		$pdf->setPaper('A4', 'landscape');
		
        return $pdf->stream("Sertifikat Peserta Pelatihan.pdf");
    }
}
