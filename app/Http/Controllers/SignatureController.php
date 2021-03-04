<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Signature;
use App\User;

class SignatureController extends Controller
{
    /**
     * Menampilkan form signature
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		if(Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
			// Data signature
			$signature = Signature::where('id_user','=',Auth::user()->id_user)->first();

			// View
			return view('signature/admin/index', [
				'signature' => $signature,
			]);
		}
		elseif(Auth::user()->role == role_trainer()){
			// Data signature
			$signature = Signature::where('id_user','=',Auth::user()->id_user)->first();

			// View
			return view('signature/member/index', [
				'signature' => $signature,
			]);
		}
		else{
			abort(404);
		}
    }

    /**
     * Mengupdate e-signature
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
		// Get data
		$signature = Signature::where('id_user','=',Auth::user()->id_user)->first();

		// Jika belum ada
		if(!$signature) $signature = new Signature;

		// Upload e-signature
		$image = $request->signature != '' ? $request->signature : $request->upload;
		list($type, $image) = explode(';', $image);
		list(, $image)      = explode(',', $image);
		$image = base64_decode($image);
		$image_name = time().'.png';
		if(file_put_contents('assets/images/signature/'.$image_name, $image) != false){
			// Simpan e-signature
			$signature->id_user = Auth::user()->id_user;
			$signature->signature = $image_name;
			$signature->signature_at = date('Y-m-d H:i:s');
			$signature->save();
		}

		// Redirect
		if(Auth::user()->is_admin == 1)
			return redirect('/admin/e-signature')->with(['message' => 'Berhasil menyimpan E-Signature.']);
		elseif(Auth::user()->is_admin == 0)
			return redirect('/member/e-signature')->with(['message' => 'Berhasil menyimpan E-Signature.']);
    }
}
