<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Role;
use App\Setting;
use App\User;

class SettingController extends Controller
{
    /**
     * Menampilkan form pengaturan (umum)
     *
     * @return \Illuminate\Http\Response
     */
    public function umum()
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){
            // Data pengaturan
            $settings = Setting::where('setting_category','=',1)->orderBy('id_setting','asc')->get();

            // View
            return view('pengaturan/admin/umum', [
                'settings' => $settings,
            ]);
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Menampilkan form pengaturan (tampilan)
     *
     * @return \Illuminate\Http\Response
     */
    public function tampilan()
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){
            // Data pengaturan
            $settings = Setting::where('setting_category','=',2)->orderBy('id_setting','asc')->get();

            // View
            return view('pengaturan/admin/tampilan', [
                'settings' => $settings,
            ]);
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Menampilkan form pengaturan (harga)
     *
     * @return \Illuminate\Http\Response
     */
    public function harga()
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){
            // Data pengaturan
            $settings = Setting::where('setting_category','=',3)->orderBy('setting_name','asc')->get();

            // View
            return view('pengaturan/admin/harga', [
                'settings' => $settings,
            ]);
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Menampilkan form pengaturan (e-sertifikat)
     *
     * @return \Illuminate\Http\Response
     */
    public function e_sertifikat()
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){
            // Data pengaturan
            $settings = Setting::where('setting_category','=',4)->orderBy('setting_name','asc')->get();

            // View
            return view('pengaturan/admin/e-sertifikat', [
                'settings' => $settings,
            ]);
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Menampilkan form pengaturan (e-mail)
     *
     * @return \Illuminate\Http\Response
     */
    public function e_mail()
    {
        if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){
            // Data pengaturan
            $settings = Setting::where('setting_category','=',5)->orderBy('setting_name','asc')->get();

            // View
            return view('pengaturan/admin/e-mail', [
                'settings' => $settings,
            ]);
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Mengupdate pengaturan
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $key_rules = array();
        $settings = $request->get('settings');
        foreach($settings as $key=>$value){
            $key_rules['settings.'.$key] = setting_rules($key);
        }

        // Validasi
        $validator = Validator::make($request->all(), $key_rules, validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Mengupdate
            foreach($settings as $key=>$value){
                // Get data
                $setting = Setting::where('setting_key',$key)->first();
                
                // Upload Image
                if($key == "icon" || $key == "logo"){
                    if($value != $setting->setting_value){
                        list($type, $value) = explode(';', $value);
                        list(, $value)      = explode(',', $value);
                        $value = base64_decode($value);
                        $mime = str_replace('data:', '', $type);
                        $file_name = time().'-'.$key.'.'.mime_to_ext($mime)[0];
                        file_put_contents("assets/images/logo/".$file_name, $value);
                        $value = $file_name;
                    }
                    else{
                        $value = $setting->setting_value;
                    }
                }

                // Update
            	$setting->setting_value = $setting->setting_category == 3 ? str_replace('.', '', $value) : $value;
            	$setting->save();
            }
        }

        // Redirect
        if($request->category == 1)
            return redirect('/admin/pengaturan/umum')->with(['message' => 'Berhasil mengupdate pengaturan.']);
        elseif($request->category == 2)
            return redirect('/admin/pengaturan/tampilan')->with(['message' => 'Berhasil mengupdate pengaturan.']);
        elseif($request->category == 3)
            return redirect('/admin/pengaturan/harga')->with(['message' => 'Berhasil mengupdate pengaturan.']);
        elseif($request->category == 4)
            return redirect('/admin/pengaturan/e-sertifikat')->with(['message' => 'Berhasil mengupdate pengaturan.']);
        elseif($request->category == 5)
            return redirect('/admin/pengaturan/e-mail')->with(['message' => 'Berhasil mengupdate pengaturan.']);
    }
}
