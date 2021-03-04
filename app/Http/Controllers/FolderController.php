<?php

namespace App\Http\Controllers;

use Auth;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\FileDetail;
use App\Files;
use App\Folder;
use App\FolderIcon;
use App\KategoriMateri;

use App\Files2;
use App\Folder2;
use App\FolderKategori;

class FolderController extends Controller
{
	/**
     * Menambah folder
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_folder' => 'required|max:255',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Nama folder
            $nama_folder = $request->nama_folder;
            $i = 1;
            while(count_existing_folder2($request->folder_parent, $request->folder_kategori, $nama_folder, null) > 0){
                $nama_folder = rename_folder($request->nama_folder, $i);
                $i++;
            }

			// Generate dir folder
			if($request->folder_parent == 1){
				$dir = "/".$nama_folder;
			}
			else{
				$folder_parent = Folder2::find($request->folder_parent);
				$dir = $folder_parent->folder_dir."/".$nama_folder;
			}
			
            // Menambah data
            $folder = new Folder2;
            $folder->id_user = Auth::user()->id_user;
            $folder->folder_nama = $nama_folder;
			$folder->folder_kategori = $request->folder_kategori;
			$folder->folder_dir = $dir;
			$folder->folder_parent = $request->folder_parent;
			$folder->folder_icon = '';
			$folder->folder_voucher = $request->voucher != '' ? $request->voucher : '';
			$folder->folder_at = date('Y-m-d H:i:s');
			$folder->folder_up = date('Y-m-d H:i:s');
            $folder->save();
			
			// Get data folder
            $current_folder = Folder2::find($request->folder_parent);
            
            // Kategori folder
            $kategori = FolderKategori::find($folder->folder_kategori);
        }

        // Redirect
        return redirect('/admin/file-manager/'.generate_permalink($kategori->folder_kategori).'?dir='.$current_folder->folder_dir)->with(['message' => 'Berhasil menambah folder.']);
    }

    /**
     * Memindah file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function move2(Request $request)
    {
		if($request->type == 'file'){
			$file = Files2::find($request->id);
			$file->id_folder = $request->destination;
			$file->save();
            
            // Kategori folder
            $kategori = FolderKategori::find($file->file_kategori);
			
			// Redirect
            return redirect('/admin/file-manager/'.generate_permalink($kategori->folder_kategori).'?dir=/')->with(['message' => 'Berhasil memindahkan file.']);
		}
    }
	
    /**
     * Mengupdate folder
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_folder2' => 'required|max:255',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Nama folder
            $folder = Folder2::find($request->id_folder);
            $nama_folder = $request->nama_folder2;
            $i = 1;
            while(count_existing_folder2($request->folder_parent, $request->folder_kategori, $nama_folder, $request->id_folder) > 0){
                $nama_folder = rename_folder($request->nama_folder, $i);
                $i++;
            }

			// Generate dir folder
			if($request->folder_parent == 1){
				$dir = "/".$nama_folder;
			}
			else{
				$folder_parent = Folder2::find($request->folder_parent);
				$dir = $folder_parent->folder_dir."/".$nama_folder;
			}
			
            // Mengupdate data
			$folder->folder_nama = $nama_folder;
			$folder->folder_dir = $dir;
			$folder->folder_voucher = $request->voucher2 != '' ? $request->voucher2 : '';
            $folder->save();
			
			// Get data folder
			$current_folder = Folder2::find($request->folder_parent);
            
            // Kategori materi
            $kategori = FolderKategori::find($folder->folder_kategori);
        }

        // Redirect
        return redirect('/admin/file-manager/'.generate_permalink($kategori->folder_kategori).'?dir='.$current_folder->folder_dir)->with(['message' => 'Berhasil mengupdate folder.']);
    }

    /**
     * Upload icon
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadIcon2(Request $request)
    {
		// Upload gambar
		$image_name = upload_file_content($request->src_image, "assets/images/icon/");
		
		// Simpan data Folder Icon
		$folder_icon = new FolderIcon;
		$folder_icon->folder_icon = $image_name;
		$folder_icon->uploaded_at = date('Y-m-d H:i:s');
		$folder_icon->save();
		
		// Get data folder
		$folder = Folder2::find($request->id_folder);
		$folder->folder_icon = $image_name;
		$folder->save();

		// Kategori folder
		$kategori = FolderKategori::find($folder->folder_kategori);

		// Redirect
		return redirect('/admin/file-manager/'.generate_permalink($kategori->folder_kategori).'?dir=/')->with(['message' => 'Berhasil mengganti icon.']);
    }

    /**
     * Choose icon
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function chooseIcon2(Request $request)
    {		
		// Get data Folder Icon
		$folder_icon = FolderIcon::find($request->id_fi);
		
		// Get data folder
		$folder = Folder2::find($request->id_folder_2);
		$folder->folder_icon = $folder_icon != null ? $folder_icon->folder_icon : '';
		$folder->save();

		// Kategori folder
		$kategori = FolderKategori::find($folder->folder_kategori);

		// Redirect
		return redirect('/admin/file-manager/'.generate_permalink($kategori->folder_kategori).'?dir=/')->with(['message' => 'Berhasil mengganti icon.']);
    }

    /**
     * Menghapus folder
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Get folder
        $folder = Folder2::find($request->id);

        // Get children folder
        $children = [];
        $child = Folder2::where('folder_parent','=',$folder->id_folder)->get();
        while(count($child) > 0){
            $ids = [];
            foreach($child as $c){
                $data = Folder2::find($c->id_folder);
                array_push($ids, $data->id_folder);
                array_push($children, $data);
            }
            $child = Folder2::whereIn('folder_parent',$ids)->get();
        }

        // Menghapus folder yang terpilih
        $folder->delete();

        // Menghapus children folder
        if(count($children) > 0){
            foreach($children as $child){
                $data = Folder2::find($child->id_folder);
                $data->delete();

                // Menghapus file
		        $files = Files2::where('id_folder','=',$child->id_folder)->get();
                if(count($files)>0){
                    foreach($files as $file){
                        if($file->file_kategori > 3){
                            $file_detail = FileDetail::where('id_file','=',$file->file_konten)->get();
                            if(count($file_detail) > 0){
                                foreach($file_detail as $data){
                                    $fd = FileDetail::find($data->id_fd);
                                    File::delete('assets/uploads/'.$fd->nama_fd);
                                    $fd->delete();
                                }
                            }
                            else{
                                File::delete('assets/uploads/'.$file->file_konten);
                            }
                        }
                        // Menghapus file tools
                        elseif($file->file_kategori == 3){
                            File::delete('assets/tools/'.$file->file_konten);
                        }
                        $file->delete();
                    }
                }
            }
        }
			
		// Get data current folder
		$current_folder = Folder2::find($folder->folder_parent);

		// Kategori folder
		$kategori = FolderKategori::find($folder->folder_kategori);

		// Redirect
		return redirect('/admin/file-manager/'.generate_permalink($kategori->folder_kategori).'?dir='.$current_folder->folder_dir)->with(['message' => 'Berhasil menghapus folder beserta isinya.']);
    }
}
