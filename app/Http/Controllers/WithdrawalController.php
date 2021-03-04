<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Mail\VerificationMail;
use App\Komisi;
use App\Platform;
use App\Rekening;
use App\User;
use App\Withdrawal;

class WithdrawalController extends Controller
{
    /**
     * Menampilkan data withdrawal
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Jika role = admin
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_finance()){
                // Data withdrawal
                $withdrawal = Withdrawal::join('users','withdrawal.id_user','=','users.id_user')->join('rekening','withdrawal.id_rekening','=','rekening.id_rekening')->join('platform','rekening.id_platform','=','platform.id_platform')->orderBy('withdrawal_status','desc')->orderBy('withdrawal_at','desc')->get();

                // View
                return view('withdrawal/admin/index', [
                    'withdrawal' => $withdrawal,
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
            
			// Data withdrawal
			$withdrawal = Withdrawal::join('users','withdrawal.id_user','=','users.id_user')->join('rekening','withdrawal.id_rekening','=','rekening.id_rekening')->join('platform','rekening.id_platform','=','platform.id_platform')->where('withdrawal.id_user',Auth::user()->id_user)->orderBy('withdrawal_status','desc')->orderBy('withdrawal_at','desc')->get();

            // Data current withdrawal
            $current_withdrawal = Withdrawal::where('withdrawal_status','=',0)->latest('withdrawal_at')->first();

			// View
			return view('withdrawal/member/index', [
				'withdrawal' => $withdrawal,
                'current_withdrawal' => $current_withdrawal,
			]);
        }
    }

    /**
     * Mengirim withdrawal
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        // Mengupload foto
        $image_name = upload_file_content($request->src_image, "assets/images/withdrawal/");

        // Update data
        $withdrawal = Withdrawal::find($request->id_withdrawal);
        $withdrawal->withdrawal_status = 1;
        $withdrawal->withdrawal_success_at = date('Y-m-d H:i:s');
        $withdrawal->withdrawal_proof = $image_name;
        $withdrawal->save();
        
        // Update data user
        $user = User::find($withdrawal->id_user);
        $user->saldo -= $withdrawal->nominal;
        $user->save();

        // Redirect
        if(Auth::user()->is_admin == 1){
            return redirect('/admin/transaksi/withdrawal')->with(['message' => 'Berhasil mengirim komisi.']);
        }
    }
}
