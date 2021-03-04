<?php

namespace App\Http\Controllers;

use Auth;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Tool;
use App\Toolbox;
use App\ToolboxIcon;

class ToolboxController extends Controller
{
	/**
     * Menambah toolbox
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_toolbox' => 'required|max:255',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Nama toolbox
            $nama_toolbox = $request->nama_toolbox;
            $i = 1;
            while(count_existing_toolbox($request->toolbox_parent, $nama_toolbox, null) > 0){
                $nama_toolbox = rename_toolbox($request->nama_toolbox, $i);
                $i++;
            }

			// Generate dir toolbox
			if($request->toolbox_parent == 1){
				$dir = "/".$nama_toolbox;
			}
			else{
				$toolbox_parent = Toolbox::find($request->toolbox_parent);
				$dir = $toolbox_parent->dir_toolbox."/".$nama_toolbox;
			}
			
            // Menambah data
            $toolbox = new Toolbox;
            $toolbox->nama_toolbox = $nama_toolbox;
			$toolbox->dir_toolbox = $dir;
			$toolbox->toolbox_parent = $request->toolbox_parent;
			$toolbox->toolbox_icon = '';
			$toolbox->modified_at = date('Y-m-d H:i:s');
			$toolbox->toolbox_at = date('Y-m-d H:i:s');
            $toolbox->save();
			
			// Get data toolbox
            $current_toolbox = Toolbox::find($request->toolbox_parent);
        }

        // Redirect
        return redirect('/admin/tools?dir='.$current_toolbox->dir_toolbox)->with(['message' => 'Berhasil menambah folder.']);
    }

    /**
     * Memindah tool
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function move(Request $request)
    {
        $tool = Tool::find($request->id);
        $tool->id_toolbox = $request->destination;
        $tool->save();
        
        // Redirect
        return redirect('/admin/tools?dir=/')->with(['message' => 'Berhasil memindahkan file.']);
    }
	
    /**
     * Mengupdate toolbox
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_toolbox2' => 'required|max:255',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Nama toolbox
            $toolbox = Toolbox::find($request->id_toolbox);
            $nama_toolbox = $request->nama_toolbox2;
            $i = 1;
            while(count_existing_toolbox($request->toolbox_parent, $nama_toolbox, $request->id_toolbox) > 0){
                $nama_toolbox = rename_folder($request->nama_toolbox2, $i);
                $i++;
            }

			// Generate dir toolbox
			if($request->toolbox_parent == 1){
				$dir = "/".$nama_toolbox;
			}
			else{
				$toolbox_parent = Toolbox::find($request->toolbox_parent);
				$dir = $toolbox_parent->dir_toolbox."/".$nama_toolbox;
			}
			
            // Mengupdate data
			$toolbox->nama_toolbox = $nama_toolbox;
			$toolbox->dir_toolbox = $dir;
			$toolbox->toolbox_parent = $request->toolbox_parent;
            $toolbox->save();
			
			// Get data toolbox
			$current_toolbox = Toolbox::find($request->toolbox_parent);
        }

        // Redirect
        return redirect('/admin/tools?dir='.$current_toolbox->dir_toolbox)->with(['message' => 'Berhasil mengupdate folder.']);
    }

    /**
     * Upload icon
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadIcon(Request $request)
    {
		// Upload gambar
		$image_name = upload_file_content($request->src_image, "assets/images/toolbox/");
		
		// Simpan data Toolbox Icon
		$toolbox_icon = new ToolboxIcon;
		$toolbox_icon->toolbox_icon = $image_name;
		$toolbox_icon->uploaded_at = date('Y-m-d H:i:s');
		$toolbox_icon->save();
		
		// Get data toolbox
		$toolbox = Toolbox::find($request->id_toolbox);
		$toolbox->toolbox_icon = $image_name;
		$toolbox->save();

		// Redirect
		return redirect('/admin/tools?dir=/')->with(['message' => 'Berhasil mengganti icon.']);
    }

    /**
     * Choose icon
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function chooseIcon(Request $request)
    {		
		// Get data Toolbox Icon
		$toolbox_icon = ToolboxIcon::find($request->id_ti);
		
		// Get data folder
		$toolbox = Toolbox::find($request->id_toolbox_2);
		$toolbox->toolbox_icon = $toolbox_icon != null ? $toolbox_icon->toolbox_icon : '';
		$toolbox->save();

		// Redirect
		return redirect('/admin/tools?dir=/')->with(['message' => 'Berhasil mengganti icon.']);
    }

    /**
     * Menghapus toolbox
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Get toolbox
        $toolbox = Toolbox::find($request->id);
        $toolbox->delete();
			
		// Get data current toolbox
		$current_toolbox = Toolbox::find($toolbox->toolbox_parent);
		
		// Get tools inside
		$tools = Tool::where('id_toolbox','=',$request->id)->get();
		if(count($tools)>0){
			foreach($tools as $tool){
				$data_tool = Tool::find($tool->id_tool);
				$data_tool->delete();
			}
		}
        
        // Redirect
        return redirect('/admin/tools?dir='.$current_toolbox->dir_toolbox)->with(['message' => 'Berhasil menghapus folder.']);
    }
}
