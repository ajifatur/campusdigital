<?php

namespace App\Http\Controllers;

use Auth;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Tool;
use App\ToolThumbnail;
use App\Toolbox;
use App\ToolboxIcon;
use App\User;

class ToolController extends Controller
{
    /**
     * Menampilkan data tools
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // View
        if(Auth::user()->is_admin == 1){
			// Toolbox
        	$dir = $request->query('dir');
			if($dir == null){
				$directory = Toolbox::find(1);
				$toolboxes = Toolbox::where('toolbox_parent','=',$directory->id_toolbox)->orderBy('modified_at','desc')->get();
				$tools = Tool::where('id_toolbox','=',$directory->id_toolbox)->orderBy('nama_tool','asc')->get();
				return redirect('/admin/tools?dir=/');
			}
			else{
                $directory = Toolbox::where('dir_toolbox','=',$dir)->first();
                
				if(!$directory){
					$directory = Toolbox::find(1);
					$toolboxes = Toolbox::where('toolbox_parent','=',$directory->id_toolbox)->orderBy('modified_at','desc')->get();
					$tools = Tool::where('id_toolbox','=',$directory->id_toolbox)->orderBy('nama_tool','asc')->get();
					return redirect('/admin/tools?dir=/');
				}
			
				// Data toolbox dan tool
				$toolboxes = Toolbox::where('toolbox_parent','=',$directory->id_toolbox)->orderBy('modified_at','desc')->get();
				$tools = Tool::where('id_toolbox','=',$directory->id_toolbox)->orderBy('nama_tool','asc')->get();
			}
			
			// Toolbox icon
			$toolbox_icon = ToolboxIcon::all();
			
			// Tool Thumbnail
			$tool_thumbnail = ToolThumbnail::all();
			
			// Toolbox tersedia
			$available_toolbox = Toolbox::orderBy('toolbox_parent','asc')->orderBy('nama_toolbox','asc')->get();
			
            return view('tool/admin/index', [
				'available_toolbox' => $available_toolbox,
				'directory' => $directory,
				'tool_thumbnail' => $tool_thumbnail,
				'toolbox_icon' => $toolbox_icon,
                'toolboxes' => $toolboxes,
				'tools' => $tools,
            ]);
        }
        elseif(Auth::user()->is_admin == 0){
			// User belum membayar
			if(Auth::user()->status == 0) return redirect('/member/pemberitahuan');
			
			// Go to folder
        	$dir = $request->query('dir');
			if($dir == null){
				$directory = Toolbox::find(1);
				$toolboxes = Toolbox::where('toolbox_parent','=',$directory->id_toolbox)->orderBy('modified_at','desc')->get();
				$tools = Tool::where('id_toolbox','=',$directory->id_toolbox)->orderBy('nama_tool','asc')->get();
				return redirect('/member/tools?dir=/');
			}
			else{
                $directory = Toolbox::where('dir_toolbox','=',$dir)->first();
                
				if(!$directory){
					$directory = Toolbox::find(1);
					$toolboxes = Toolbox::where('toolbox_parent','=',$directory->id_toolbox)->orderBy('modified_at','desc')->get();
					$tools = Tool::where('id_toolbox','=',$directory->id_toolbox)->orderBy('nama_tool','asc')->get();
					return redirect('/member/tools?dir=/');
				}
			
				// Data toolbox dan tool
				$toolboxes = Toolbox::where('toolbox_parent','=',$directory->id_toolbox)->orderBy('modified_at','desc')->get();
				$tools = Tool::where('id_toolbox','=',$directory->id_toolbox)->orderBy('nama_tool','asc')->get();
			}
			
            return view('tool/member/index', [
				'directory' => $directory,
                'toolboxes' => $toolboxes,
				'tools' => $tools,
            ]);
        }
	}
	
    /**
     * Mencari tool
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
		if($request->search != ''){
			// Toolbox
			$toolboxes = Toolbox::where('nama_toolbox','like','%'.$request->search.'%')->where('dir_toolbox','!=','/')->get();
			if(count($toolboxes)>0){
				foreach($toolboxes as $key=>$toolbox){
					$toolboxes[$key]->count = count_tools($toolbox->id_toolbox);
				}
			}

			// Tools
			$tools = Tool::where('nama_tool','like','%'.$request->search.'%')->get();
			if(count($tools)>0){
				foreach($tools as $key=>$tool){
                    $tool->nama_tool = $tool->nama_tool.'.'.mime_to_ext($tool->tipe_tool)[0];
					$tools[$key]->count = generate_size($tool->ukuran_tool);
				}
			}
		}
		else{
			// Toolbox
			$toolboxes = Toolbox::where('dir_toolbox','!=','/')->get();
			if(count($toolboxes)>0){
				foreach($toolboxes as $key=>$toolbox){
					$toolboxes[$key]->count = count_tools($toolbox->id_toolbox);
				}
			}

			// Tools
			$tools = Tool::all();
			if(count($tools)>0){
				foreach($tools as $key=>$tool){
                    $tool->nama_tool = $tool->nama_tool.'.'.mime_to_ext($tool->tipe_tool)[0];
					$tools[$key]->count = generate_size($tool->ukuran_tool);
				}
			}
		}
		
		echo json_encode([
			'folders' => $toolboxes,
			'files' => $tools,
		]);
	}

    /**
     * Menampilkan form upload tools
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function uploadForm(Request $request)
    {
        // View
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
				// Go to toolbox
				$dir = $request->query('dir');
				if($dir == null){
					$directory = Toolbox::find(1);
					return redirect('/admin/tools/upload?dir=/');
				}
				else{
                    $directory = Toolbox::where('dir_toolbox','=',$dir)->first();
                    
					if(!$directory){
						$directory = Toolbox::find(1);
						return redirect('/admin/tools/upload?dir=/');
					}
				}
				
	            return view('tool/admin/upload', [
					'directory' => $directory,
				]);
            }
            else{
                // View
                return view('error/forbidden');
            }
        }
    }
	
    /**
     * Mengupload tools
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {        
        // baca nama file
        $fileName = $_FILES["datafile"]["name"];
        // baca file temporary upload
        $fileTemp = $_FILES["datafile"]["tmp_name"];
        // baca tipe file
        $fileType = $_FILES["datafile"]["type"];
        // baca filesize
        $fileSize = $_FILES["datafile"]["size"];

        // Nama tool
        $nama_tool = generate_file_name($request->nama_tool);
        $i = 1;
        while(count_existing_tool($request->id_toolbox, $nama_tool, null) > 0){
            $nama_tool = rename_file(generate_file_name($request->nama_tool), $i);
            $i++;
        }
        
        // proses upload file ke folder
        if (move_uploaded_file($fileTemp, 'assets/tools/'.$nama_tool.'.'.mime_to_ext($fileType)[0])){
            // echo "Upload $nama_tool selesai";

            // Save data
            $tool = new Tool;
            $tool->id_toolbox = $request->id_toolbox;
            $tool->nama_tool = $nama_tool;
            $tool->thumbnail_tool = '';
            $tool->ukuran_tool = $fileSize;
            $tool->tipe_tool = $fileType;
            $tool->uploaded_at = date('Y-m-d H:i:s');
            $tool->save();
    
            // Update modified_at di toolbox
            $toolbox = Toolbox::find($request->id_toolbox);
            $toolbox->modified_at = $tool->uploaded_at;
            $toolbox->save();
        }
	}

    /**
     * Mengupdate tools
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_tool' => 'required|max:255',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Nama tools
            $tool = Tool::find($request->id_tool);
            $nama_tool_old = $tool->nama_tool;
            $nama_tool = generate_file_name($request->nama_tool);
            $i = 1;
            while(count_existing_tool($tool->id_toolbox, $nama_tool, $request->id_tool) > 0){
                $nama_tool = rename_file(generate_file_name($request->nama_tool), $i);
                $i++;
            }

            // Mengupdate data
            $tool->nama_tool = $nama_tool;
            $tool->save();

            // Mengganti nama tool
            if($nama_tool_old != $nama_tool) Storage::move('assets/tools/'.$nama_tool_old.'.'.mime_to_ext($tool->tipe_tool)[0], 'assets/tools/'.$nama_tool.'.'.mime_to_ext($tool->tipe_tool)[0]);
			
			// Get data toolbox
			$toolbox = Toolbox::find($tool->id_toolbox);
        }

        // Redirect
        return redirect('/admin/tools?dir='.$toolbox->dir_toolbox)->with(['message' => 'Berhasil mengupdate file.']);
    }

    /**
     * Upload thumbnail
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadThumbnail(Request $request)
    {
		// Upload gambar
		$image_name = upload_file_content($request->src_image, "assets/images/tool/");
		
		// Simpan data Tool Thumbnail
		$tool_thumbnail = new ToolThumbnail;
		$tool_thumbnail->tool_thumbnail = $image_name;
		$tool_thumbnail->uploaded_at = date('Y-m-d H:i:s');
		$tool_thumbnail->save();
		
		// Get data tool
		$tool = Tool::find($request->id_tool);
		$tool->thumbnail_tool = $image_name;
		$tool->save();

		// Get directory toolbox
		$dir = Toolbox::find($tool->id_toolbox);

		// Redirect
		return redirect('/admin/tools?dir='.$dir->dir_toolbox)->with(['message' => 'Berhasil mengganti thumbnail.']);
    }

    /**
     * Choose thumbnail
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function chooseThumbnail(Request $request)
    {		
		// Get data Tool Thumbnail
		$tool_thumbnail = ToolThumbnail::find($request->id_tt);
		
		// Get data tool
		$tool = Tool::find($request->id_tool_2);
		$tool->thumbnail_tool = $tool_thumbnail != null ? $tool_thumbnail->tool_thumbnail : '';
		$tool->save();

		// Get directory toolbox
		$dir = Toolbox::find($tool->id_toolbox);

		// Redirect
		return redirect('/admin/tools?dir='.$dir->dir_toolbox)->with(['message' => 'Berhasil mengganti thumbnail.']);
    }

    /**
     * Menghapus tool
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Menghapus data
        $tool = Tool::find($request->id);
        File::delete('assets/tools/'.$tool->nama_tool.'.'.mime_to_ext($tool->tipe_tool)[0]);
        $tool->delete();
			
		// Get data toolbox
		$toolbox = Toolbox::find($tool->id_toolbox);

        // Redirect
		return redirect('/admin/tools?dir='.$toolbox->dir_toolbox)->with(['message' => 'Berhasil menghapus file.']);
    }
}
