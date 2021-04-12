<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterMail;
use App\Komisi;
use App\Mentor;
use App\Mitra;
use App\Setting;
use App\Slider;
use App\User;

class HomeController extends Controller
{		
    /**
     * Home Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function home(Request $request)
    {
		// Get data mentor
		$mentor = Mentor::all();
		
		// Get data mitra
		$mitra = Mitra::all();
		
		// Get data slider
		$slider = Slider::where('status_slider','=',1)->get();
		
        // Get referral
        $referral = $request->query('ref');
        if($referral == null){
        	$request->session()->put('ref', get_referral_code()->username);
        	return redirect('/?ref='.get_referral_code()->username);
        }
        else{
	        $user = User::where('username',$referral)->where('status','=',1)->first();
	        if(!$user){
	        	$request->session()->put('ref', get_referral_code()->username);
	        	return redirect('/?ref='.get_referral_code()->username);
	        }
	        else{
	        	$request->session()->put('ref', $referral);
	        }
	    }
        // End get referral

        return view('front/home', [
			'mentor' => $mentor,
			'mitra' => $mitra,
			'slider' => $slider,
		]);
    }	
	
    /**
     * Beasiswa Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function beasiswa(Request $request)
    {
        // Get referral
        $referral = $request->query('ref');
        if($referral == null){
        	$request->session()->put('ref', get_referral_code()->username);
        	return redirect('/beasiswa?ref='.get_referral_code()->username);
        }
        else{
	        $user = User::where('username',$referral)->where('status','=',1)->first();
	        if(!$user){
	        	$request->session()->put('ref', get_referral_code()->username);
	        	return redirect('/beasiswa?ref='.get_referral_code()->username);
	        }
	        else{
	        	$request->session()->put('ref', $referral);
	        }
	    }
        // End get referral

        return view('front/beasiswa');
    }	
	
    /**
     * Afiliasi Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function afiliasi(Request $request)
    {
        // Get referral
        $referral = $request->query('ref');
        if($referral == null){
        	$request->session()->put('ref', get_referral_code()->username);
        	return redirect('/afiliasi?ref='.get_referral_code()->username);
        }
        else{
	        $user = User::where('username',$referral)->where('status','=',1)->first();
	        if(!$user){
	        	$request->session()->put('ref', get_referral_code()->username);
	        	return redirect('/afiliasi?ref='.get_referral_code()->username);
	        }
	        else{
	        	$request->session()->put('ref', $referral);
	        }
	    }
        // End get referral

        return view('front/afiliasi');
    }
	
    /**
     * Tentang Kami Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function tentangKami(Request $request)
    {
        // Get referral
        $referral = $request->query('ref');
        if($referral == null){
        	$request->session()->put('ref', get_referral_code()->username);
        	return redirect('/tentang-kami?ref='.get_referral_code()->username);
        }
        else{
            $user = User::where('username',$referral)->where('status','=',1)->first();
	        if(!$user){
	        	$request->session()->put('ref', get_referral_code()->username);
	        	return redirect('/tentang-kami?ref='.get_referral_code()->username);
	        }
	        else{
	        	$request->session()->put('ref', $referral);
	        }
	    }
        // End get referral

        return view('front/tentang-kami');
    }
	
    /**
     * Verifikasi Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {		
		// Get user
		$user = User::where('email','=',$request->query('email'))->first();

        // Jika user tidak ditemukan
        if(!$user){
            // View
            return view('front/verify', [
                'user' => $user,
                'status' => 0,
            ]);
        }
        // Jika user ditemukan
        else{
            // Jika user belum terverifikasi
            if($user->email_verified == 0){
                // Update status verifikasi email
                $user->email_verified = 1;
                $user->save();
                
                // Get komisi
                $komisi = Komisi::where('id_user','=',$user->id_user)->first();
                
                // Send Mail
                // Mail::to($user->email)->send(new EmailVerificationMail($user->id_user));
                Mail::to($user->email)->send(new RegisterMail($user->id_user, $komisi->id_komisi));
                
                // Redirect
                return redirect('/member');
            }
            // Jika user sudah terverifikasi
            else{
                // View
                return view('front/verify', [
                    'user' => $user,
                    'status' => 1,
                ]);
            }
        }
    }	
}
