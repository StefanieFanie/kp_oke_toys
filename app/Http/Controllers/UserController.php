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
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'phone_number'=>'required|unique:users',
            'password'=>'required',
            'role'=>'required|in:owner,kasir',
            'photo'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
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
        $query->where('is_deleted', false);

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
            $ownerCount = User::where('role', 'owner')->where('is_deleted', false)->count();
            if ($ownerCount <= 1) {
                return redirect()->back()->with('error', 'Tidak dapat mengubah peran. Setidaknya harus ada satu user dengan peran owner.')->withInput();
            }
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'phone_number' => 'required|unique:users,phone_number,'.$id,
            'role' => 'required|in:owner,kasir',
            'password' => 'nullable|min:6',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            $data->is_deleted = true;
            $data->save();
        }
        return redirect(route('user'))->with('success', 'User berhasil dihapus');
    }
}
