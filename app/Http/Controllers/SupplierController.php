<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    function show() {
        $data = Supplier::orderBy('id', 'desc')->paginate(9);
        return view('supplier.supplier', ['supplier' => $data]);
    }

    public function cari(Request $request) {
        $query = Supplier::orderBy('id', 'desc');
        if ($request->filled('cari')) {
            $query->where('nama_supplier', 'like', '%' . $request->cari . '%');
        }
        $data = $query->paginate(9);
        return view('supplier.supplier', [
            'supplier' => $data,
            'cari' => $request->cari
        ]);
    }

    public function tambah() {
        return view('supplier.tambah-supplier');
    }

    function simpan(Request $request) {
        $nama_supplier = ucwords(strtolower($request->nama_supplier));
        $existingSupplier = Supplier::withTrashed()->where('nama_supplier', $nama_supplier)->first();
        if ($existingSupplier) {
            if ($existingSupplier->trashed()) {
                $existingSupplier->restore();
                $existingSupplier->update([
                    'nomor_telepon' => $request->nomor_telepon,
                    'email' => $request->email,
                    'alamat' => $request->alamat
                ]);
            } else {
                return redirect()->back()->with('error', 'Nama supplier sudah ada');
            }
        } else {
            $data['nama_supplier'] = ucwords(strtolower($request->nama_supplier));
            $data['nomor_telepon'] = $request->nomor_telepon;
            $data['email'] = $request->email;
            $data['alamat'] = $request->alamat;
            $supplier = Supplier::create($data);
        }
        return redirect(route('supplier'))->with('success', 'Data supplier berhasil ditambahkan.');
    }

    public function edit($id) {
        $data = Supplier::find($id);
        return view('supplier.edit-supplier', ['supplier' => $data]);
    }

    public function update(Request $request, $id) {
        $nama_supplier = ucwords(strtolower($request->nama_supplier));
        $supplier = Supplier::withTrashed()->where('nama_supplier', $nama_supplier)->first();
        if ($supplier) {
            if ($supplier->trashed()) {
                return redirect()->back()->with(
                    'error', 'Nama supplier ini pernah dihapus. Untuk memulihkannya bisa tambah supplier dengan nama yang sama'
                );
            }
        }
        $existingSupplier = Supplier::withTrashed()->where('nama_supplier', $nama_supplier)->where('id', '!=', $id)->first();
        if ($existingSupplier) {
            return redirect()->back()->with('error', 'Nama supplier sudah ada');
        }
        $supplier->update([
            $data['nama_supplier'] = ucwords(strtolower($request->nama_supplier)),
            $data['nomor_telepon'] = $request->nomor_telepon,
            $data['email'] = $request->email,
            $data['alamat'] = $request->alamat,
            Supplier::find($id)->update($data),
        ]);
        return redirect(route('supplier'))->with('success', 'Data supplier berhasil diperbarui.');
    }

    public function hapus($id) {
        $data_supplier = Supplier::find($id);
        $data_supplier->delete();
        return redirect(route('supplier'))->with('success', 'Data supplier berhasil dihapus.');
    }
}
