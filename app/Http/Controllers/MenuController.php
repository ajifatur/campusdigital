<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Menu;
use App\User;

class MenuController extends Controller
{
    /**
     * Menampilkan data menu
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer()){
                // Data menu
                $menu = Menu::first();
                $menu->menu = json_decode($menu->menu, true);
                $menu->menu = $menu->menu[0];
                
                // View
                return view('menu/admin/index', [
                    'menu' => $menu,
                ]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }

    /**
     * Menambah menu
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_menu' => 'required',
            'url' => 'required',
            'warna_tulisan' => 'required',
            'warna_background' => 'required',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Array data baru
            $push = [
                'id' => time(),
                'name' => $request->nama_menu,
                'url' => $request->url,
                'color' => $request->warna_tulisan,
                'bgcolor' => $request->warna_background,
                'children' => array()
            ];

            // Menambah data
            $menu = Menu::first();
            $menu->menu = json_decode($menu->menu, true);
            $array = $menu->menu[0];
            array_push($array, $push);
            $menu->menu = json_encode(array($array));
            $menu->save();
        }

        // Redirect
		return redirect('/admin/menu')->with(['message' => 'Berhasil menambah menu.']);
    }

    /**
     * Mengurutkan menu
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        // Mengupdate data
        $menu = Menu::first();
        $menu->menu = $request->json;
        $menu->save();

        // Redirect
		return redirect('/admin/menu')->with(['message_sort' => 'Berhasil mengurutkan menu.']);
    }

    /**
     * Mengupdate menu
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_menu_2' => 'required',
            'url_2' => 'required',
            'warna_tulisan_2' => 'required',
            'warna_background_2' => 'required',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Get data
            $menu = Menu::first();
            $menu->menu = json_decode($menu->menu, true);
            $array = $menu->menu[0];

            // Mengambil menu berdasarkan id
            foreach($array as $key=>$value){
                // Mencari menu dari array level 1
                if($value['id'] == $request->id){
                    $array[$key]['name'] = $request->nama_menu_2;
                    $array[$key]['url'] = $request->url_2;
                    $array[$key]['color'] = $request->warna_tulisan_2;
                    $array[$key]['bgcolor'] = $request->warna_background_2;
                }
                else{
                    // Mencari menu dari array level 2
                    if(count(array_filter($value['children'])) > 0){
                        foreach($value['children'][0] as $key2=>$children){
                            if($children['id'] == $request->id){
                                $array[$key]['children'][0][$key2]['name'] = $request->nama_menu_2;
                                $array[$key]['children'][0][$key2]['url'] = $request->url_2;
                                $array[$key]['children'][0][$key2]['color'] = $request->warna_tulisan_2;
                                $array[$key]['children'][0][$key2]['bgcolor'] = $request->warna_background_2;
                            }
                        }
                    }
                }
            }

            // Mengupdate data
            $menu->menu = json_encode(array($array));
            $menu->save();
        }

        // Redirect
		return redirect('/admin/menu')->with(['message_sort' => 'Berhasil mengupdate menu.']);
    }

    /**
     * Menghapus menu
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Get data
        $menu = Menu::first();
        $menu->menu = json_decode($menu->menu, true);
        $array = $menu->menu[0];

        // Mengambil menu berdasarkan id
        foreach($array as $key=>$value){
            if($value['id'] == $request->id) unset($array[$key]);
        }

        // Mengupdate data
        $menu->menu = json_encode(array($array));
        $menu->save();

        // Redirect
		return redirect('/admin/menu')->with(['message_sort' => 'Berhasil menghapus menu.']);
    }
}
