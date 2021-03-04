<?php

namespace App\Http\Controllers;

use Auth;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\ProfilePhoto;
use App\User;

class ProfilePhotoController extends Controller
{
    /**
     * Menampilkan data foto profil
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Data foto
        $photos = ProfilePhoto::orderBy('uploaded_at','desc')->get();
		
		// Set data foto
		foreach($photos as $key=>$photo){
			$check = User::where('foto','=',$photo->photo_name)->where('id_user','=',$photo->id_user)->first();
			$photos[$key]->status = (!$check) ? 0 : 1;
		}

        // View
        if(Auth::user()->role == 1){
            return view('photo/admin/index', [
                'photos' => $photos,
            ]);
        }
    }
    /**
     * Menghapus file foto
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Menghapus data
        $photo = ProfilePhoto::find($request->id);
        File::delete('assets/images/users/'.$photo->photo_name);
        $photo->delete();

        // Redirect
        return redirect('/admin/galeri')->with(['message' => 'Berhasil menghapus data.']);
    }
}
