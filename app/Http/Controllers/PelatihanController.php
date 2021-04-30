<?php

namespace App\Http\Controllers;

use Auth;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Mail\TrainingPaymentMail;
use App\DefaultRekening;
use App\KategoriPelatihan;
use App\Pelatihan;
use App\PelatihanMember;
use App\PelatihanThumbnail;
use App\User;

class PelatihanController extends Controller
{
    /**
     * Menampilkan data pelatihan
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor() || Auth::user()->role == role_finance()){
                // Data pelatihan
                $pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->orderBy('tanggal_pelatihan_from','desc')->get();
                
                // Menghitung peserta pelatihan
                if(count($pelatihan)>0){
                    foreach($pelatihan as $key=>$data){
                        $jumlah_peserta = PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->where('id_pelatihan','=',$data->id_pelatihan)->get();
                        $pelatihan[$key]->jumlah_peserta = count($jumlah_peserta);
                    }
                }
                
                // View
                return view('pelatihan/admin/index', [
                    'pelatihan' => $pelatihan,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
        elseif(Auth::user()->is_admin == 0){
			if(Auth::user()->role == role_trainer()){
				// Data pelatihan yang dia traineri
				$pelatihan_sendiri = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->where('trainer','=',Auth::user()->id_user)->orderBy('tanggal_pelatihan_from','desc')->get();
				
				// Menghitung peserta pelatihan
				if(count($pelatihan_sendiri)>0){
					foreach($pelatihan_sendiri as $key=>$data){
						$jumlah_peserta = PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->where('id_pelatihan','=',$data->id_pelatihan)->get();
						$pelatihan_sendiri[$key]->jumlah_peserta = count($jumlah_peserta);
					}
				}
				
				// Data pelatihan (kecuali yang dia traineri)
				$pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->where('trainer','!=',Auth::user()->id_user)->whereDate('tanggal_pelatihan_to','>=',date('Y-m-d'))->orderBy('tanggal_pelatihan_from','desc')->get();
			}
			elseif(Auth::user()->role == role_member()){
				// Data pelatihan
				$pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->whereDate('tanggal_pelatihan_to','>=',date('Y-m-d'))->orderBy('tanggal_pelatihan_from','desc')->get();
				
				$pelatihan_sendiri = null;
			}
			
            // View
            return view('pelatihan/member/index', [
                'pelatihan' => $pelatihan,
                'pelatihan_sendiri' => $pelatihan_sendiri,
            ]);
        }
    }

    /**
     * Menampilkan form tambah pelatihan
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
            // Kategori
            $kategori = KategoriPelatihan::all();

            // Mentor
            $mentor = User::where('role','=',role_trainer())->orderBy('nama_user','asc')->get();

            // View
            return view('pelatihan/admin/create', [
                'kategori' => $kategori,
                'mentor' => $mentor,
            ]);
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Menambah pelatihan
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_pelatihan' => 'required|max:255',
            'kategori' => 'required',
            'trainer' => 'required',
            'tanggal_pelatihan' => 'required',
            'tanggal_sertifikat' => 'required',
            'fee_member' => 'required',
            'fee_umum' => 'required',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
			// Upload gambar
            $image_name = $request->thumbnail != '' ? upload_file_content($request->thumbnail, "assets/images/pelatihan/") : '';

			// Generate nomor pelatihan
			$check = Pelatihan::where('kategori_pelatihan','=',$request->kategori)->whereYear('tanggal_pelatihan_from','=',date('Y', strtotime(generate_date_range('explode', $request->tanggal_pelatihan)['from'])))->latest('tanggal_pelatihan_from')->first();
			$nomor_pelatihan = generate_nomor_pelatihan($check, generate_kategori_pelatihan($request->kategori), date('Y', strtotime(generate_date_range('explode', $request->tanggal_pelatihan)['from'])));
			
            // Upload gambar dari quill
            $html = quill_image_upload($request->deskripsi, 'assets/images/konten-pelatihan/');
			
			// Materi
			$array = array();
			$kode_unit = $request->get('kode_unit');
			$judul_unit = $request->get('judul_unit');
			$durasi = $request->get('durasi');
			foreach($kode_unit as $key=>$kode){
				array_push($array, ['kode' => $kode, 'judul' => $judul_unit[$key], 'durasi' => $durasi[$key]]);
			}
			
            // Menambah data
            $pelatihan = new Pelatihan;
            $pelatihan->nama_pelatihan = $request->nama_pelatihan;
            $pelatihan->kategori_pelatihan = $request->kategori;
            $pelatihan->tempat_pelatihan = $request->tempat_pelatihan != '' ? $request->tempat_pelatihan : '';
            $pelatihan->tanggal_pelatihan_from = generate_date_range('explode', $request->tanggal_pelatihan)['from'];
            $pelatihan->tanggal_pelatihan_to = generate_date_range('explode', $request->tanggal_pelatihan)['to'];
            $pelatihan->tanggal_sertifikat_from = generate_date_range('explode', $request->tanggal_sertifikat)['from'];
            $pelatihan->tanggal_sertifikat_to = generate_date_range('explode', $request->tanggal_sertifikat)['to'];
            $pelatihan->thumbnail_pelatihan = $image_name;
            $pelatihan->nomor_pelatihan = $nomor_pelatihan;
            $pelatihan->deskripsi_pelatihan = htmlentities($html);
            $pelatihan->trainer = $request->trainer;
            $pelatihan->kode_trainer = str_replace('/', '.', $nomor_pelatihan).'.T';
            $pelatihan->fee_member = str_replace('.', '', $request->fee_member);
            $pelatihan->fee_non_member = str_replace('.', '', $request->fee_umum);
			$pelatihan->materi_pelatihan = json_encode($array);
			$pelatihan->total_jam_pelatihan = array_sum($durasi);
            $pelatihan->save();
        }

        // Redirect
        return redirect('/admin/pelatihan')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Daftar Pelatihan
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
		// Data pelatihan
		$pelatihan = Pelatihan::find($request->id);
		
        // Mengupload file
        $file = $request->file('foto');
		if($file != null){
			$filename = time().".".$file->getClientOriginalExtension();
			$file->move('assets/images/fee-pelatihan', $filename);
		}
		else{
			$filename = '';
		}
		
		// Member yang sudah ada
		$members = PelatihanMember::where('id_pelatihan','=',$request->id)->get();
		
		// Menambah data
		$pelatihan_member = new PelatihanMember;
		$pelatihan_member->id_user = Auth::user()->id_user;
		$pelatihan_member->id_pelatihan = $request->id;
		$pelatihan_member->kode_sertifikat = generate_nomor_sertifikat($members, $pelatihan);
		$pelatihan_member->status_pelatihan = 0;
		$pelatihan_member->fee = $request->fee;
		$pelatihan_member->fee_bukti = $filename;
		$pelatihan_member->fee_status = $request->fee > 0 ? 0 : 1;
		$pelatihan_member->inv_pelatihan = $request->inv_pelatihan;
		$pelatihan_member->pm_at = date('Y-m-d H:i:s');
		$pelatihan_member->save();
		
		$pm = PelatihanMember::where('pm_at','=',$pelatihan_member->pm_at)->first();
		
		// Send Mail Notification
		if($request->fee > 0){
		 	// $receivers = ["ajifatur2@gmail.com", "dwinurkholisoh1@gmail.com", "randyrahmanhussen@gmail.com", "farisfanani.id@gmail.com"];
            $receivers = get_penerima_notifikasi();
		 	foreach($receivers as $receiver){
		 		Mail::to($receiver)->send(new TrainingPaymentMail($pm->id_pm, Auth::user()->id_user));
		 	}
		}

        // Redirect
        return redirect('/member/pelatihan/detail/'.$request->id)->with(['message' => 'Berhasil mendaftar pelatihan.']);
    }

    /**
     * Menampilkan form detail pelatihan
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
    	// Data pelatihan
    	$pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->find($id);
		
		if(!$pelatihan){
			abort(404);
        }
        
        // Get data default rekening
        $default_rekening = DefaultRekening::join('platform','default_rekening.id_platform','=','platform.id_platform')->orderBy('tipe_platform','asc')->get();
		
		if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor() || Auth::user()->role == role_finance()){
                // View
                return view('pelatihan/admin/detail', [
                    'pelatihan' => $pelatihan,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
		}
		else{
			// Cek pelatihan member
			$cek_pelatihan = PelatihanMember::where('id_pelatihan','=',$pelatihan->id_pelatihan)->where('id_user','=',Auth::user()->id_user)->first();
			
			// Cek total pelatihan member
			$cek_total = PelatihanMember::where('id_user','=',Auth::user()->id_user)->get();
			
			// Generate invoice
			$invoice = generate_invoice(Auth::user()->id_user, 'PEM').'.'.(count($cek_total)+1);
			
			// View
			return view('pelatihan/member/detail', [
				'default_rekening' => $default_rekening,
				'pelatihan' => $pelatihan,
				'cek_pelatihan' => $cek_pelatihan,
				'cek_total' => $cek_total,
				'invoice' => $invoice,
			]);
		}
    }

    /**
     * Menampilkan daftar peserta
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function participant($id)
    {
    	// Data pelatihan
    	$pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->find($id);
		
		if(!$pelatihan){
			abort(404);
		}
		
		if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
                // Data pelatihan member
                $pelatihan_member = PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->where('id_pelatihan','=',$pelatihan->id_pelatihan)->orderBy('pm_at','desc')->get();
                
                // View
                return view('pelatihan/admin/participant', [
                    'pelatihan' => $pelatihan,
                    'pelatihan_member' => $pelatihan_member,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
		}
		elseif(Auth::user()->is_admin == 0){
			if(Auth::user()->role == role_member()){
				abort(404);
			}
			
			// Data pelatihan member
			$pelatihan_member = PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->where('id_pelatihan','=',$pelatihan->id_pelatihan)->orderBy('pm_at','desc')->get();
			
			// View
			return view('pelatihan/member/participant', [
				'pelatihan' => $pelatihan,
				'pelatihan_member' => $pelatihan_member,
			]);
		}
    }

    /**
     * Menampilkan form edit pelatihan
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
            // Data pelatihan
            $pelatihan = Pelatihan::find($id);

            if(!$pelatihan){
                abort(404);
            }
			
			$pelatihan->materi_pelatihan = json_decode($pelatihan->materi_pelatihan, true);
            
            // Mentor
            $mentor = User::where('role','=',role_trainer())->orderBy('nama_user','asc')->get();

            // View
            return view('pelatihan/admin/edit', [
                'pelatihan' => $pelatihan,
                'mentor' => $mentor,
            ]);
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Mengupdate pelatihan
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_pelatihan' => 'required|max:255',
            'trainer' => 'required|max:255',
            'tanggal_pelatihan' => 'required',
            'tanggal_sertifikat' => 'required',
            'fee_member' => 'required',
            'fee_umum' => 'required',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{			
			// Upload gambar
            $image_name = $request->thumbnail != '' ? upload_file_content($request->thumbnail, "assets/images/pelatihan/") : '';

            // Upload gambar dari quill
            $html = quill_image_upload($request->deskripsi, 'assets/images/konten-pelatihan/');
			
			// Materi
			$array = array();
			$kode_unit = $request->get('kode_unit');
			$judul_unit = $request->get('judul_unit');
			$durasi = $request->get('durasi');
			foreach($kode_unit as $key=>$kode){
				array_push($array, ['kode' => $kode, 'judul' => $judul_unit[$key], 'durasi' => $durasi[$key]]);
			}
			
            // Mengupdate data
            $pelatihan = Pelatihan::find($request->id);
            $pelatihan->nama_pelatihan = $request->nama_pelatihan;
            $pelatihan->trainer = $request->trainer;
            $pelatihan->tempat_pelatihan = $request->tempat_pelatihan != '' ? $request->tempat_pelatihan : '';
            $pelatihan->tanggal_pelatihan_from = generate_date_range('explode', $request->tanggal_pelatihan)['from'];
            $pelatihan->tanggal_pelatihan_to = generate_date_range('explode', $request->tanggal_pelatihan)['to'];
            $pelatihan->tanggal_sertifikat_from = generate_date_range('explode', $request->tanggal_sertifikat)['from'];
            $pelatihan->tanggal_sertifikat_to = generate_date_range('explode', $request->tanggal_sertifikat)['to'];
            $pelatihan->deskripsi_pelatihan = htmlentities($html);
            $pelatihan->thumbnail_pelatihan = $image_name != '' ? $image_name : $pelatihan->thumbnail_pelatihan;
            $pelatihan->fee_member = str_replace('.', '', $request->fee_member);
            $pelatihan->fee_non_member = str_replace('.', '', $request->fee_umum);
			$pelatihan->materi_pelatihan = json_encode($array);
			$pelatihan->total_jam_pelatihan = array_sum($durasi);
            $pelatihan->save();
        }

        // Redirect
        return redirect('/admin/pelatihan')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Update status peserta
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
    	// Update status peserta
        $pelatihan_member = PelatihanMember::find($request->id);
		$pelatihan_member->status_pelatihan = $request->status;
		$pelatihan_member->save();
		
		echo 'Berhasil mengupdate status peserta!';

        // Redirect
        // return redirect('/member/pelatihan/peserta/'.$pelatihan_member->id_pelatihan)->with(['message' => 'Berhasil mengupdate status peserta.']);
    }

    /**
     * Menghapus pelatihan
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
    	// Menghapus data
        $pelatihan = Pelatihan::find($request->id);
        $pelatihan->delete();

        // Redirect
        return redirect('/admin/pelatihan')->with(['message' => 'Berhasil menghapus data.']);
    }

    /**
     * Menduplikat pelatihan
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function duplicate(Request $request)
    {
    	// Mengambil data
        $getpelatihan = Pelatihan::find($request->id);

        if($getpelatihan){
            // Menduplikat data
            $pelatihan = new Pelatihan;
            $pelatihan->nama_pelatihan = $getpelatihan->nama_pelatihan;
            $pelatihan->kategori_pelatihan = $getpelatihan->kategori_pelatihan;
            $pelatihan->tempat_pelatihan = $getpelatihan->tempat_pelatihan;
            $pelatihan->tanggal_pelatihan_from = $getpelatihan->tanggal_pelatihan_from;
            $pelatihan->tanggal_pelatihan_to = $getpelatihan->tanggal_pelatihan_to;
            $pelatihan->tanggal_sertifikat_from = $getpelatihan->tanggal_sertifikat_from;
            $pelatihan->tanggal_sertifikat_to = $getpelatihan->tanggal_sertifikat_to;
            $pelatihan->thumbnail_pelatihan = $getpelatihan->thumbnail_pelatihan;
            $pelatihan->nomor_pelatihan = $getpelatihan->nomor_pelatihan;
            $pelatihan->deskripsi_pelatihan = $getpelatihan->deskripsi_pelatihan;
            $pelatihan->trainer = $getpelatihan->trainer;
            $pelatihan->kode_trainer = $getpelatihan->kode_trainer;
            $pelatihan->fee_member = $getpelatihan->fee_member;
            $pelatihan->fee_non_member = $getpelatihan->fee_non_member;
            $pelatihan->materi_pelatihan = $getpelatihan->materi_pelatihan;
            $pelatihan->total_jam_pelatihan = $getpelatihan->total_jam_pelatihan;
            $pelatihan->save();
        }

        // Redirect
        return redirect('/admin/pelatihan')->with(['message' => 'Berhasil menduplikat data.']);
    }
	
    /**
     * Menampilkan data transaksi pelatihan
     *
     * @return \Illuminate\Http\Response
     */
    public function transaction()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_finance()){
                // Data pelatihan member
                $pelatihan_member = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan_member.id_user','=','users.id_user')->orderBy('pm_at','desc')->get();
                
                // View
                return view('pelatihan/admin/transaction', [
                    'pelatihan_member' => $pelatihan_member,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
        elseif(Auth::user()->is_admin == 0){
            // Data pelatihan member
            $pelatihan_member = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan_member.id_user','=','users.id_user')->where('pelatihan_member.id_user','=',Auth::user()->id_user)->orderBy('pm_at','desc')->get();
            
            // View
            return view('pelatihan/member/transaction', [
                'pelatihan_member' => $pelatihan_member,
            ]);
        }
    }

    /**
     * Verifikasi pembayaran aktivasi
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        // Mengupdate data pelatihan
        $pelatihan_member = PelatihanMember::find($request->id);
        $pelatihan_member->fee_status = 1;
        $pelatihan_member->save();

        // Redirect
        return redirect('/admin/transaksi/pelatihan')->with(['message' => 'Berhasil memverifikasi pembayaran.']);
    }
}
