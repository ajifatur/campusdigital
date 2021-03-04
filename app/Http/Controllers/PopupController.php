<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Popup;
use App\User;

class PopupController extends Controller
{
    /**
     * Menampilkan data pop-up
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
			// Get data pop-up
			$popup = Popup::orderBy('popup_at','desc')->get();

			// View
			return view('pop-up/admin/index', [
				'popup' => $popup,
			]);
		}
        else{
            // View
            return view('error/forbidden');
        }
    }
	
    /**
     * Menambah pop-up
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
			// View
			return view('pop-up/admin/create');
		}
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Menyimpan pop-up
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'gambar' => $request->tipe == 1 ?'required' : '',
            'judul' => 'required',
            'tipe' => 'required',
            'video' => $request->tipe == 2 ? 'required' : '',
            'waktu_aktif' => 'required',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
			$filename = '';
			if($request->tipe == 1){
				// Mengupload gambar
				if($request->gambar_src != ''){
					$file = $request->file('gambar');
					$filename = time().".".$file->getClientOriginalExtension();
					$file->move('assets/images/pop-up', $filename);
				}
			}
			
            // Upload gambar dari quill
            $html = quill_image_upload($request->konten, 'assets/images/konten-pop-up/');
			
			// Waktu aktif
			$explode = explode(" - ", $request->waktu_aktif);
			$explode_from = explode("/", $explode[0]);
			$explode_to = explode("/", $explode[1]);
			$from = $explode_from[2]."-".$explode_from[1]."-".$explode_from[0];
			$to = $explode_to[2]."-".$explode_to[1]."-".$explode_to[0];
			
            // Menambah data
            $popup = new Popup;
            $popup->popup_judul = $request->judul;
            $popup->popup_gambar = $request->tipe == 1 ? $filename : $request->video;
            $popup->popup_konten = htmlentities($html);
            $popup->popup_from = $from;
            $popup->popup_to = $to;
            $popup->popup_at = date('Y-m-d H:i:s');
            $popup->save();
        }

        // Redirect
        return redirect('/admin/pop-up')->with(['message' => 'Berhasil menambah data.']);
    }
	
    /**
     * Melihat pop-up
     * 
	 * int $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
			// Get data
			$popup = Popup::find($id);

			if(!$popup){
				abort(404);
			}

			// View
			return view('pop-up/admin/detail', ['popup' => $popup]);
		}
		elseif(Auth::user()->is_admin == 0){
			// User belum membayar
            if(Auth::user()->status == 0) return redirect('/member/pemberitahuan');
            
			// Get data
			$popup = Popup::find($id);

			if(!$popup){
				abort(404);
			}

			// View
			return view('pop-up/member/detail', ['popup' => $popup]);
		}
        else{
            // View
            return view('error/forbidden');
        }
    }
	
    /**
     * Mengedit pop-up
     * 
	 * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
			// Get data
			$popup = Popup::find($id);

			if(!$popup){
				abort(404);
			}
			
			// From dan to
			$explode_from = explode("-", $popup->popup_from);
			$explode_to = explode("-", $popup->popup_to);
			$glue = $explode_from[2]."/".$explode_from[1]."/".$explode_from[0]." - ".$explode_to[2]."/".$explode_to[1]."/".$explode_to[0];

			// View
			return view('pop-up/admin/edit', ['popup' => $popup, 'glue' => $glue]);
		}
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Mengupdate pop-up
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'gambar' => $request->gambar_src == '' ? 'required' : '',
            'judul' => 'required',
            'tipe' => 'required',
            'video' => $request->tipe == 2 ? 'required' : '',
            'waktu_aktif' => 'required',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
			$filename = '';
			if($request->tipe == 1){
				// Mengupload gambar
				if($request->file('gambar') != null){
					$file = $request->file('gambar');
					$filename = time().".".$file->getClientOriginalExtension();
					$file->move('assets/images/pop-up', $filename);
				}
				else{
					$filename = $request->gambar_src;
				}
			}
			
            // Upload gambar dari quill
            $html = quill_image_upload($request->konten, 'assets/images/konten-pop-up/');
			
			// Waktu aktif
			$explode = explode(" - ", $request->waktu_aktif);
			$explode_from = explode("/", $explode[0]);
			$explode_to = explode("/", $explode[1]);
			$from = $explode_from[2]."-".$explode_from[1]."-".$explode_from[0];
			$to = $explode_to[2]."-".$explode_to[1]."-".$explode_to[0];
			
            // Mengupdate data
            $popup = Popup::find($request->id);
            $popup->popup_gambar = $request->tipe == 1 ? $filename : $request->video;
            $popup->popup_judul = $request->judul;
            $popup->popup_konten = htmlentities($html);
            $popup->popup_from = $from;
            $popup->popup_to = $to;
            $popup->save();
        }

        // Redirect
        return redirect('/admin/pop-up/edit/'.$request->id)->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus pop-up
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
		// Get data
		$popup = Popup::find($request->id);
		$popup->delete();

        // Redirect
        return redirect('/admin/pop-up')->with(['message' => 'Berhasil menghapus data.']);
	}
}
