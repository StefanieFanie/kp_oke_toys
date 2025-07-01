<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    function tambah(){
        if (Auth::check()) {
            return view('user.tambah-user');
        }
        return redirect(route('login'))->with('error','anda harus login terlebih dahulu');
    }

    function simpan(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:users,name,NULL,id,deleted_at,NULL',
            'email'=>'required|email|unique:users,email,NULL,id,deleted_at,NULL',
            'phone_number'=>'required|unique:users,phone_number,NULL,id,deleted_at,NULL',
            'password'=>'required|min:6',
            'role'=>'required|in:owner,kasir',
            'photo'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.unique' => 'Nama sudah ada dalam database.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah ada dalam database.',
            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'phone_number.unique' => 'Nomor telepon sudah ada dalam database.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'role.required' => 'Peran wajib dipilih.',
            'role.in' => 'Peran yang dipilih tidak valid.',
            'photo.required' => 'Foto profil wajib diupload.',
            'photo.image' => 'Format foto tidak valid.',
            'photo.mimes' => 'Format foto tidak valid.',
            'photo.max' => 'Ukuran foto maksimal 2MB.'
        ]);
        
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone_number'] = $request->phone_number;
        $data['role'] = $request->role;
        $data['password'] = Hash::make($request->password);
        
        if ($request->hasFile('photo')) {
            $imageName = time().'.'.$request->photo->extension();  
            $request->photo->move(public_path('storage/profil'), $imageName);
            $data['photo'] = $imageName;
        }
        
        User::create($data);
        
        return redirect(route('user'))->with('success', 'User berhasil ditambahkan');
    }

    function show(Request $request){
        $query = User::query();
        if ($request->has('role') && !empty($request->role)) {
            $query->where('role', $request->role);
        }

        $data = $query->get();
        return view('user.user', ['user' => $data]);
    }

    public function edit($id){
        if (Auth::check()) {
            $data = User::find($id);
            return view('user.edit-user', ['user' => $data]);
        }
        return redirect(route('login'))->with('error', 'Anda harus login terlebih dahulu');
    }

    function update(Request $request, $id)
    {
        $user = User::find($id);
        if ($user->role === 'owner' && $request->role === 'kasir') {
            $ownerCount = User::where('role', 'owner')->count();
            if ($ownerCount <= 1) {
                return redirect()->back()->with('error', 'Tidak dapat mengubah peran. Setidaknya harus ada satu user dengan peran owner.')->withInput();
            }
        }

        $request->validate([
            'name' => 'required|unique:users,name,'.$id.',id,deleted_at,NULL',
            'email' => 'required|email|unique:users,email,'.$id.',id,deleted_at,NULL',
            'phone_number' => 'required|unique:users,phone_number,'.$id.',id,deleted_at,NULL',
            'role' => 'required|in:owner,kasir',
            'password' => 'nullable|min:6',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.unique' => 'Nama sudah ada dalam database.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah ada dalam database.',
            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'phone_number.unique' => 'Nomor telepon sudah ada dalam database.',
            'role.required' => 'Peran wajib dipilih.',
            'role.in' => 'Peran yang dipilih tidak valid.',
            'password.min' => 'Password minimal 6 karakter.',
            'photo.image' => 'Format foto tidak valid.',
            'photo.mimes' => 'Format foto tidak valid.',
            'photo.max' => 'Ukuran foto maksimal 2MB.'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
        ];

        if ($request->hasFile('photo')) {
            if ($user->photo && file_exists(public_path('storage/profil/'.$user->photo))) {
                unlink(public_path('storage/profil/'.$user->photo));
            }
            
            $imageName = time().'.'.$request->photo->extension();  
            $request->photo->move(public_path('storage/profil'), $imageName);
            $data['photo'] = $imageName;
        }

        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect(route('user'))->with('success', 'Profil berhasil diperbarui.');
    }

    public function hapus($id){
        $data = User::find($id);
        
        if ($data) {
            $data->delete();
        }
        return redirect(route('user'))->with('success', 'User berhasil dihapus');
    }
}
