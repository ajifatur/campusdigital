<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Blog;
use App\Course;
use App\Files;
use App\Halaman;
use App\KategoriArtikel;
use App\KategoriMateri;
use App\Komisi;
use App\PelatihanMember;
use App\Setting;
use App\User;
use App\Withdrawal;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {  
        View::composer('*', function($view){
            // Halaman
            $halaman = Halaman::all();

            // Kategori Artikel
            $kategori_artikel = KategoriArtikel::all();

            if(Auth::check()){
                // Kategori Materi
                $kategori_materi = KategoriMateri::all();
						
				// Get default referral code
				$setting = Setting::where('setting_key','=','default_referral_code')->first();
                $default_ref = User::find($setting->setting_value);
				
                if(Auth::user()->is_admin == 1){
                    // Komisi yang belum diverifikasi
                    $komisi = Komisi::join('users','komisi.id_user','=','users.id_user')->where('komisi_status','=',0)->where('komisi_proof','!=','')->get();
                    $komisi_total = count($komisi);

                    // Withdrawal yang belum dikirimkan komisi
                    $withdrawal = Withdrawal::where('withdrawal_status','=',0)->get();
					$withdrawal_total = count($withdrawal);

                    // Pelatihan Member yang belum diverifikasi
                    $pelatihan_member = PelatihanMember::where('fee_status','=',0)->get();
					$pelatihan_member_total = count($pelatihan_member);

                    // Total
                    $total = $komisi_total + $withdrawal_total + $pelatihan_member_total;

                    // Send variable
                    view()->share('global_komisi', $komisi);
                    view()->share('global_komisi_total', $komisi_total);
                    view()->share('global_withdrawal', $withdrawal);
                    view()->share('global_withdrawal_total', $withdrawal_total);
                    view()->share('global_pelatihan_member', $pelatihan_member);
                    view()->share('global_pelatihan_member_total', $pelatihan_member_total);
					view()->share('global_total', $total);
                }
				elseif(Auth::user()->is_admin == 0){
					// Artikel hari ini
					$artikel = Blog::whereDate('blog_at',date('Y-m-d'))->get();
					$artikel_total = count($artikel);
					
					// File hari ini
					$array_file = array();
					$file_total = 0;
					foreach($kategori_materi as $data){
						$file = Files::where('jenis_file','=',$data->id_km)->whereDate('uploaded_at',date('Y-m-d'))->get();
						array_push($array_file, array('kategori'=>$data->kategori, 'total'=>count($file)));
						$file_total += count($file);
					}
					
					// E-Course hari ini
					$e_course = Course::whereDate('course_at',date('Y-m-d'))->get();
					$e_course_total = count($e_course);

                    // Total
                    $total = $artikel_total + $file_total + $e_course_total;

                    // Send variable
                    view()->share('global_artikel_total', $artikel_total);
                    view()->share('global_array_file', $array_file);
                    view()->share('global_e_course_total', $e_course_total);
					view()->share('global_total', $total);
				}
				
				// Send variable
				view()->share('kategori_materi', $kategori_materi);
				view()->share('global_default_ref', $default_ref);
            }
            view()->share('global_halaman', $halaman);
            view()->share('global_kategori_artikel', $kategori_artikel);
        });
    }
}
