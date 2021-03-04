<?php

namespace App\Http\Controllers;

use Auth;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\FilePath;
use App\Files;
use App\FileDetail;
use App\FileReader;
use App\FileThumbnail;
use App\Folder;
use App\FolderIcon;
use App\KategoriMateri;
use App\User;

use App\Files2;
use App\Folder2;
use App\FolderKategori;

class FileController extends Controller
{
    /**
     * Menampilkan data folder dan file
     *
	 * string $category
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $category)
    {
		// Kategori
		$kategori = FolderKategori::where('slug_kategori','=',$category)->first();

		if(!$kategori){
			abort(404);
		}

        // Jika role admin
        if(Auth::user()->is_admin == 1){
			// Get direktori value
        	$dir = $request->query('dir');

			// Jika direktori == null
			if($dir == null){
				// Get direktori default
				$directory = Folder2::find(1);
				// Get folder dalam direktori
				$folders = Folder2::where('folder_parent','=',$directory->id_folder)->where('folder_kategori','=',$kategori->id_fk)->orderBy('folder_up','desc')->get();
				// Get file dalam direktori
				$files = Files2::where('id_folder','=',$directory->id_folder)->where('file_kategori','=',$kategori->id_fk)->orderBy('file_nama','asc')->get();
				// Redirect
				return redirect('/admin/file-manager/'.generate_permalink($kategori->folder_kategori).'?dir=/');
			}
			// Jika direktori != null
			else{
				// Jika direktori == '/'
				if($dir == '/')
					$directory = Folder2::where('folder_dir','=',$dir)->first();
				// Jika direktori != '/'
				else
					$directory = Folder2::where('folder_dir','=',$dir)->where('folder_kategori','=',$kategori->id_fk)->first();
				
				// Jika direktori tidak ditemukan, akan redirect ke direktori default
				if(!$directory){
					// Get direktori default
					$directory = Folder2::find(1);
					// Get folder dalam direktori
					$folders = Folder2::where('folder_parent','=',$directory->id_folder)->where('folder_kategori','=',$kategori->id_fk)->orderBy('folder_up','desc')->get();
					// Get file dalam direktori
					$files = Files2::where('id_folder','=',$directory->id_folder)->where('file_kategori','=',$kategori->id_fk)->orderBy('file_nama','asc')->get();
					// Redirect
					return redirect('/admin/file-manager/'.generate_permalink($kategori->folder_kategori).'?dir=/');
				}
				// Jika direktori ditemukan
				else{
					// Get folder dalam direktori
					$folders = Folder2::where('folder_parent','=',$directory->id_folder)->where('folder_kategori','=',$kategori->id_fk)->orderBy('folder_up','desc')->get();
					// Get file dalam direktori
					$files = Files2::where('id_folder','=',$directory->id_folder)->where('file_kategori','=',$kategori->id_fk)->orderBy('file_nama','asc')->get();

				}
			}

			// Breadcrumb
			$breadcrumb = [$directory];
			$d = $directory;
			while($d->folder_parent != 0){
				$d = Folder2::find($d->folder_parent);
				array_push($breadcrumb, $d);
			}
			
			// Folder icon
			$folder_icon = FolderIcon::all();
			
			// File Thumbnail
			$file_thumbnail = FileThumbnail::all();
			
			// Folder tersedia
			$available_folders = Folder2::where('folder_kategori','=',$kategori->id_fk)->orWhere('folder_kategori','=',0)->orderBy('folder_parent','asc')->orderBy('folder_nama','asc')->get();
			
            return view('file/admin/index', [
				'available_folders' => $available_folders,
				'directory' => $directory,
				'file_thumbnail' => $file_thumbnail,
				'folder_icon' => $folder_icon,
                'folders' => $folders,
				'files' => $files,
				'kategori' => $kategori,
				'breadcrumb' => array_reverse($breadcrumb),
            ]);
        }
        elseif(Auth::user()->is_admin == 0){
			// User belum membayar
			if(Auth::user()->status == 0) return redirect('/member/pemberitahuan');
			
			// Get direktori value
        	$dir = $request->query('dir');

			// Jika direktori == null
			if($dir == null){
				// Get direktori default
				$directory = Folder2::find(1);
				// Get folder dalam direktori
				$folders = Folder2::where('folder_parent','=',$directory->id_folder)->where('folder_kategori','=',$kategori->id_fk)->orderBy('folder_up','desc')->get();
				// Get file dalam direktori
				$files = Files2::join('folder2','file2.id_folder','=','folder2.id_folder')->where('file2.id_folder','=',$directory->id_folder)->where('file_kategori','=',$kategori->id_fk)->orderBy('id_file','asc')->get();
				// Redirect
				return redirect('/member/file-manager/'.generate_permalink($kategori->folder_kategori).'?dir=/');
			}
			// Jika direktori != null
			else{
				// Jika direktori == '/'
				if($dir == '/')
					$directory = Folder2::where('folder_dir','=',$dir)->first();
				// Jika direktori != '/'
				else
					$directory = Folder2::where('folder_dir','=',$dir)->where('folder_kategori','=',$kategori->id_fk)->first();
				
				// Jika direktori tidak ditemukan, akan redirect ke direktori default
				if(!$directory){
					// Get direktori default
					$directory = Folder2::find(1);
					// Get folder dalam direktori
					$folders = Folder2::where('folder_parent','=',$directory->id_folder)->where('folder_kategori','=',$kategori->id_fk)->orderBy('folder_up','desc')->get();
					// Get file dalam direktori
					$files = Files2::join('folder2','file2.id_folder','=','folder2.id_folder')->where('file2.id_folder','=',$directory->id_folder)->where('file_kategori','=',$kategori->id_fk)->orderBy('id_file','asc')->get();
					// Redirect
					return redirect('/member/file-manager/'.generate_permalink($kategori->folder_kategori).'?dir=/');
				}
				// Jika direktori ditemukan
				else{
					// Get folder dalam direktori
					$folders = Folder2::where('folder_parent','=',$directory->id_folder)->where('folder_kategori','=',$kategori->id_fk)->orderBy('folder_up','desc')->get();
					// Get file dalam direktori
					$files = Files2::join('folder2','file2.id_folder','=','folder2.id_folder')->where('file2.id_folder','=',$directory->id_folder)->where('file_kategori','=',$kategori->id_fk)->orderBy('id_file','asc')->get();

				}
			}

			// Breadcrumb
			$breadcrumb = [$directory];
			$d = $directory;
			while($d->folder_parent != 0){
				$d = Folder2::find($d->folder_parent);
				array_push($breadcrumb, $d);
			}
			
            return view('file/member/index', [
				'directory' => $directory,
                'folders' => $folders,
				'files' => $files,
				'kategori' => $kategori,
				'breadcrumb' => array_reverse($breadcrumb),
            ]);
        }
	}

    /**
     * Menambah file
     *
	 * string $category
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $category)
    {
		// Kategori
		$kategori = FolderKategori::where('slug_kategori','=',$category)->first();

		if(!$kategori){
			abort(404);
		}

        // Jika role admin
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
				// Get direktori value
				$dir = $request->query('dir');

				// Jika direktori == null
				if($dir == null){
					// Get direktori default
					$directory = Folder2::find(1);
					// Redirect
					return redirect('/admin/file-manager/'.generate_permalink($kategori->folder_kategori).'/create?dir=/');
				}
				// Jika direktori != null
				else{
					// Jika direktori == '/'
					if($dir == '/')
						$directory = Folder2::where('folder_dir','=',$dir)->first();
					// Jika direktori != '/'
					else
						$directory = Folder2::where('folder_dir','=',$dir)->where('folder_kategori','=',$kategori->id_fk)->first();
					
					// Jika direktori tidak ditemukan, akan redirect ke direktori default
					if(!$directory){
						// Get direktori default
						$directory = Folder2::find(1);
						// Redirect
						return redirect('/admin/file-manager/'.generate_permalink($kategori->folder_kategori).'/create?dir=/');
					}
				}
				
				// View
				if($kategori->id_fk == 1){
					return view('file/admin/create-video', [
						'directory' => $directory,
						'kategori' => $kategori
					]);
				}
				elseif($kategori->id_fk == 2){
					return view('file/admin/create-script', [
						'directory' => $directory,
						'kategori' => $kategori
					]);
				}
				elseif($kategori->id_fk == 3){
					return view('file/admin/create-tools', [
						'directory' => $directory,
						'kategori' => $kategori
					]);
				}
				elseif($kategori->id_fk > 3){
					return view('file/admin/create-ebook', [
						'directory' => $directory,
						'kategori' => $kategori
					]);
				}
			}
            else{
                // View
                return view('error/forbidden');
            }
        }
    }
	
    /**
     * Menyimpan file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		// Kategori
		$kategori = FolderKategori::find($request->file_kategori);

        // Validasi
        $validator = Validator::make($request->all(), [
            'file_nama' => 'required|max:255',
            'file_konten' => 'required',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{				
			// Upload gambar
            $image_name = $request->thumbnail != '' ? upload_file_content($request->thumbnail, "assets/images/file-thumbnail/") : '';

			// Menyimpan thumbnail jika ada gambar yang diupload
			if($image_name != ''){
				$file_thumbnail = new FileThumbnail;
				$file_thumbnail->file_thumbnail = $image_name;
				$file_thumbnail->uploaded_at = date('Y-m-d H:i:s');
				$file_thumbnail->save();
			}
            
            // Menambah data
            $file = new Files2;
            $file->id_folder = $request->folder_parent;
            $file->id_user = Auth::user()->id_user;
            $file->file_nama = $request->file_nama;
            $file->file_kategori = $request->file_kategori;
            $file->file_deskripsi = $request->file_deskripsi != '' ? $request->file_deskripsi : '';
            $file->file_konten = $request->file_konten;
            $file->file_keterangan = $request->file_kategori == 1 ? htmlentities($request->file_keterangan) : '';
            $file->file_thumbnail = $image_name;
            $file->file_at = date('Y-m-d H:i:s');
            $file->file_up = date('Y-m-d H:i:s');
            $file->save();

			// Direktori
			$directory = Folder2::find($file->id_folder);
        }

		// Redirect
		return redirect('/admin/file-manager/'.generate_permalink($kategori->folder_kategori).'?dir='.$directory->folder_dir)->with(['message' => 'Berhasil menambah file.']);
	}

    /**
     * Menampilkan detail file
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
		// Get data file
		$file = Files2::join('users','file2.id_user','=','users.id_user')->join('folder2','file2.id_folder','=','folder2.id_folder')->find($id);

		if(!$file){
			abort(404);
		}

		// Kategori
		$kategori = FolderKategori::find($file->file_kategori);

		// Direktori
		$directory = Folder2::find($file->id_folder);

		// Breadcrumb
		$breadcrumb = [$directory];
		$d = $directory;
		while($d->folder_parent != 0){
			$d = Folder2::find($d->folder_parent);
			array_push($breadcrumb, $d);
		}

		// Jika role admin
		if(Auth::user()->is_admin == 1){
			// Kategori video
			if($file->file_kategori == 1){
				// Video dalam folder ini
				$all_files = Files2::where('id_folder','=',$file->id_folder)->where('file_kategori','=',$file->file_kategori)->get();

				return view('file/admin/detail-video', [
					'file' => $file,
					'directory' => $directory,
					'kategori' => $kategori,
					'all_files' => $all_files,
					'breadcrumb' => array_reverse($breadcrumb),
				]);
			}
			// Kategori script
			elseif($file->file_kategori == 2){
				return view('file/admin/detail-script', [
					'file' => $file,
					'directory' => $directory,
					'kategori' => $kategori,
					'breadcrumb' => array_reverse($breadcrumb),
				]);
			}
			// Kategori tools
			elseif($file->file_kategori == 3){
				return redirect('/admin/file-manager/'.generate_permalink($kategori->folder_kategori).'?dir=/');
			}
			// Kategori e-book
			elseif($file->file_kategori > 3){
				// File Detail
				$file_detail = FileDetail::where('id_file','=',$file->file_konten)->orderBy('nama_fd','asc')->get();

				return view('file/admin/detail-ebook', [
					'file' => $file,
					'file_detail' => $file_detail,
					'directory' => $directory,
					'kategori' => $kategori,
					'breadcrumb' => array_reverse($breadcrumb),
				]);
			}
		}
		// Jika role member
		elseif(Auth::user()->is_admin == 0){
			// Belum memasukkan voucher
			if(session()->get('id_folder') != $file->id_folder && $file->folder_voucher != ''){
				// Redirect
				return redirect('/member/file-manager/'.generate_permalink($kategori->folder_kategori).'?dir=/')->with(['message' => 'Anda harus memasukkan voucher terlebih dahulu', 'id_folder' => $file->id_folder]);
			}

			// Kategori video
			if($file->file_kategori == 1){
				// Video dalam folder ini
				$all_files = Files2::where('id_folder','=',$file->id_folder)->where('file_kategori','=',$file->file_kategori)->get();

				return view('file/member/detail-video', [
					'file' => $file,
					'directory' => $directory,
					'kategori' => $kategori,
					'all_files' => $all_files,
					'breadcrumb' => array_reverse($breadcrumb),
				]);
			}
			// Kategori script
			elseif($file->file_kategori == 2){
				return view('file/member/detail-script', [
					'file' => $file,
					'directory' => $directory,
					'kategori' => $kategori,
					'breadcrumb' => array_reverse($breadcrumb),
				]);
			}
			// Kategori tools
			elseif($file->file_kategori == 3){
				return redirect('/member/file-manager/'.generate_permalink($kategori->folder_kategori).'?dir=/');
			}
			// Kategori e-book
			elseif($file->file_kategori > 3){
				// File Detail
				$file_detail = FileDetail::where('id_file','=',$file->file_konten)->orderBy('nama_fd','asc')->get();

				return view('file/member/detail-ebook', [
					'file' => $file,
					'file_detail' => $file_detail,
					'directory' => $directory,
					'kategori' => $kategori,
					'breadcrumb' => array_reverse($breadcrumb),
				]);
			}
		}
	}

    /**
     * Mengedit file
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Jika role admin
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor()){
				// Get data file
				$file = Files2::join('users','file2.id_user','=','users.id_user')->find($id);

				if(!$file){
					abort(404);
				}

				// Kategori
				$kategori = FolderKategori::find($file->file_kategori);

				// Direktori
				$directory = Folder2::find($file->id_folder);

				// Jika role admin
				if(Auth::user()->is_admin == 1){
					// Kategori video
					if($file->file_kategori == 1){
						return view('file/admin/edit-video', [
							'file' => $file,
							'directory' => $directory,
							'kategori' => $kategori,
						]);
					}
					// Kategori script
					elseif($file->file_kategori == 2){
						return view('file/admin/edit-script', [
							'file' => $file,
							'directory' => $directory,
							'kategori' => $kategori,
						]);
					}
				}
			}
            else{
                // View
                return view('error/forbidden');
            }
        }
	}
	
    /**
     * Mengupdate file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
		// Kategori
		$kategori = FolderKategori::find($request->file_kategori);

        // Validasi
        $validator = Validator::make($request->all(), [
            'file_nama' => 'required|max:255',
            'file_konten' => 'required',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{            
            // Mengupdate data
            $file = Files2::find($request->id);
            $file->file_nama = $request->file_nama;
            $file->file_deskripsi = $request->file_deskripsi != '' ? $request->file_deskripsi : '';
            $file->file_konten = $request->file_konten;
            $file->file_keterangan = $request->file_kategori == 1 ? htmlentities($request->file_keterangan) : '';
            $file->file_up = date('Y-m-d H:i:s');
            $file->save();

			// Direktori
			$directory = Folder2::find($file->id_folder);
        }

		// Redirect
		return redirect('/admin/file-manager/'.generate_permalink($kategori->folder_kategori).'?dir='.$directory->folder_dir)->with(['message' => 'Berhasil mengupdate file.']);
	}
	
    /**
     * Mencari folder dan file
     *
	 * string $category
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function search2(Request $request, $category)
    {
		// Kategori
		$kategori = FolderKategori::where('slug_kategori','=',$category)->first();

		if(!$kategori){
			abort(404);
		}

		if($request->search != ''){
			// Folder
			$folders = Folder2::where('folder_nama','like','%'.$request->search.'%')->where('folder_kategori','=',$kategori->id_fk)->get();
			if(count($folders)>0){
				foreach($folders as $key=>$folder){
					$folders[$key]->count_files = count_files($folder->id_folder, $folder->folder_kategori);
					$folders[$key]->count_folders = count_folders($folder->id_folder, $folder->folder_kategori);
				}
			}

			// File
			$files = Files2::where('file_nama','like','%'.$request->search.'%')->where('file_kategori','=',$kategori->id_fk)->get();
			if(count($files)>0){
				foreach($files as $key=>$file){
					// $files[$key]->count = count_pages($file->url);
				}
			}
		}
		else{
			// Folder
			$folders = Folder2::where('folder_kategori','=',$kategori->id_fk)->get();
			if(count($folders)>0){
				foreach($folders as $key=>$folder){
					$folders[$key]->count_files = count_files($folder->id_folder, $folder->folder_kategori);
					$folders[$key]->count_folders = count_folders($folder->id_folder, $folder->folder_kategori);
				}
			}

			// File
			$files = Files2::where('file_kategori','=',$kategori->id_fk)->get();
			if(count($files)>0){
				foreach($files as $key=>$file){
					// $files[$key]->count = count_pages($file->url);
				}
			}
		}
		
		echo json_encode([
			'folders' => $folders,
			'files' => $files,
		]);
	}

    /**
     * Mengupdate nama file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function rename(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_file' => 'required|max:255',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Nama file
            $file = Files2::find($request->id_file);
            $nama_file = $request->nama_file;
            $i = 1;
            while(count_existing_file2($file->id_folder, $file->file_kategori, $nama_file, $request->id_file) > 0){
                $nama_file = rename_file($request->nama_file, $i);
                $i++;
            }

            // Mengupdate data
            $file->file_nama = $nama_file;
            $file->file_up = date('Y-m-d H:i:s');
            $file->save();
			
			// Get data folder
			$folder = Folder2::find($file->id_folder);

			// Kategori
			$kategori = FolderKategori::find($file->file_kategori);
        }

        // Redirect
        return redirect('/admin/file-manager/'.generate_permalink($kategori->folder_kategori).'?dir='.$folder->folder_dir)->with(['message' => 'Berhasil mengupdate nama file.']);
    }

    /**
     * Menghapus file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Menghapus data
        $file = Files2::find($request->id);
		
		// Menghapus file detail
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
			
		// Get data direktori
		$directory = Folder2::find($file->id_folder);

		// Kategori file
		$kategori = FolderKategori::find($file->file_kategori);

        // Redirect
		return redirect('/admin/file-manager/'.generate_permalink($kategori->folder_kategori).'?dir='.$directory->folder_dir)->with(['message' => 'Berhasil menghapus file.']);
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
		$image_name = upload_file_content($request->src_image, "assets/images/file-thumbnail/");
		
		// Simpan data File Thumbnail
		$file_thumbnail = new FileThumbnail;
		$file_thumbnail->file_thumbnail = $image_name;
		$file_thumbnail->uploaded_at = date('Y-m-d H:i:s');
		$file_thumbnail->save();
		
		// Get data File
		$file = Files2::find($request->id_file);
		$file->file_thumbnail = $image_name;
		$file->file_up = date('Y-m-d H:i:s');
		$file->save();

		// Get directory folder
		$dir = Folder2::find($file->id_folder);

		// Kategori
		$kategori = FolderKategori::find($file->file_kategori);

		// Redirect
		return redirect('/admin/file-manager/'.generate_permalink($kategori->folder_kategori).'?dir='.$dir->folder_dir)->with(['message' => 'Berhasil mengganti thumbnail.']);
    }

    /**
     * Memilih thumbnail
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function chooseThumbnail(Request $request)
    {		
		// Get data File Thumbnail
		$file_thumbnail = FileThumbnail::find($request->id_ft);
		
		// Get data file
		$file = Files2::find($request->id_file_2);
		$file->file_thumbnail = $file_thumbnail != null ? $file_thumbnail->file_thumbnail : '';
		$file->file_up = date('Y-m-d H:i:s');
		$file->save();

		// Get directory folder
		$dir = Folder2::find($file->id_folder);

		// Kategori
		$kategori = FolderKategori::find($file->file_kategori);

		// Redirect
		return redirect('/admin/file-manager/'.generate_permalink($kategori->folder_kategori).'?dir='.$dir->folder_dir)->with(['message' => 'Berhasil mengganti thumbnail.']);
    }
	
    /**
     * Mengupload file PDF
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadPDF(Request $request)
    {
		// Get data
		$file_name = $request->name;

		// Save files
		$data = $request->code;
		list($type, $data) = explode(';', $data);
		list(, $data)      = explode(',', $data);
		$data = base64_decode($data);
		
		$number = $request->key + 1;
		$number = add_zero($number);
		$file_detail_name = $file_name.'-'.$number.'.jpg';
		if(file_put_contents('assets/uploads/'.$file_detail_name, $data)){
			$file_detail = new FileDetail;
			$file_detail->id_file = $file_name;
			$file_detail->nama_fd = $file_detail_name;
			$file_detail->save();
		}
	}
	
    /**
     * Mengupload tools
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadTools(Request $request)
    {
        // Nama file
        $file_name = explode('.'.mime_to_ext($_FILES["datafile"]["type"])[0], $_FILES["datafile"]["name"])[0];
        // Nama file temp
        $file_temp = $_FILES["datafile"]["tmp_name"];
        // Tipe file
        $file_type = $_FILES["datafile"]["type"];
        // Ukuran file
        $file_size = $_FILES["datafile"]["size"];

        // Nama file
        $nama_file = generate_permalink($file_name);
        $i = 1;
        while(in_array($nama_file.'.'.mime_to_ext($file_type)[0], generate_file('assets/tools'))){
            $nama_file = rename_permalink(generate_permalink($file_name), $i);
            $i++;
        }
        
        // Upload file ke folder
        if (move_uploaded_file($file_temp, 'assets/tools/'.$nama_file.'.'.mime_to_ext($file_type)[0])){
			echo $nama_file.'.'.mime_to_ext($file_type)[0];
        }
	}

    /**
     * Menginput voucher
     *
	 * string $category
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function inputVoucher(Request $request, $category)
    {
		// Kategori
		$kategori = FolderKategori::where('slug_kategori','=',$category)->first();

		if(!$kategori){
			abort(404);
		}

		// Mengecek kecocokan voucher
		$data = Folder2::where('id_folder','=',$request->id)->where('folder_voucher','=',$request->voucher)->first();
		
		if(!$data){
			// Redirect
			return redirect('/member/file-manager/'.generate_permalink($kategori->folder_kategori).'?dir='.$request->dir)->with(['message' => 'Tidak berhasil menggunakan voucher.', 'id_folder' => $request->id]);
		}
		else{
			// Simpan ke session
			$request->session()->put('id_folder', $data->id_folder);
			
			// Redirect
			return redirect('/member/file-manager/'.generate_permalink($kategori->folder_kategori).'?dir='.$data->folder_dir);
		}
    }

    /**
     * Redirect file e-book
     *
	 * int $id
     * @return \Illuminate\Http\Response
     */
    public function redirectEbook($id)
    {
	}
}
