<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class DiskonResellerController extends Controller
{
    protected $filePath = 'diskon_reseller.json';
    public function edit() {
        if (!Storage::exists($this->filePath)) {
            Storage::put(
                $this->filePath,
                json_encode(['diskon_reseller' => 0])
            );
        }
        $data = json_decode(Storage::get($this->filePath), true);
        $diskon_reseller = $data['diskon_reseller'] ?? 0;
        return view('edit-diskon-reseller', ['diskon_reseller' => $diskon_reseller]);
    }
    public function update(Request $request) {
        Storage::put($this->filePath, json_encode(['diskon_reseller' => $request->diskon_reseller]));
        return redirect()->back()->with('success', 'Diskon reseller berhasil diperbarui');
    }
}
