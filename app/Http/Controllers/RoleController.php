<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Komisi;
use App\Role;
use App\User;

class RoleController extends Controller
{
    /**
     * Menampilkan data role
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == role_it()){
            // Data role
            $role = Role::orderBy('is_admin','desc')->orderBy('id_role','asc')->get();
			
            // View
            return view('role/admin/index', [
                'role' => $role,
            ]);
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Menampilkan form tambah role
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role == role_it()){
            // View
            return view('role/admin/create');
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Menambah role
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_role' => 'required|max:32',
            'sebagai_admin' => 'required',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{			
            // Menambah data
            $role = new Role;
            $role->nama_role = $request->nama_role;
            $role->is_admin = $request->sebagai_admin;
            $role->role_at = date('Y-m-d H:i:s');
            $role->save();
        }

        // Redirect
        return redirect('/admin/pengaturan/role')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit role
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->role == role_it()){
        	// Data role
        	$role = Role::find($id);

            // View
            return view('role/admin/edit', [
            	'role' => $role
            ]);
        }
        else{
            // View
            return view('error/forbidden');
        }
    }

    /**
     * Mengupdate role
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_role' => 'required|max:32',
            // 'sebagai_admin' => 'required',
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{			
            // Mengupdate data
            $role = Role::find($request->id);
            $role->nama_role = $request->nama_role;
            // $role->is_admin = $request->sebagai_admin;
            $role->save();
        }

        // Redirect
        return redirect('/admin/pengaturan/role')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus role
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
    	// Menghapus data
        $role = Role::find($request->id);
        $role->delete();

        // Redirect
        return redirect('/admin/pengaturan/role')->with(['message' => 'Berhasil menghapus data.']);
    }
}
