<?php

namespace App\Http\Controllers;
use App\Models\Kategori;

use Illuminate\Http\Request;

class KategoriController extends Controller
{
    function show(){
        $data=Kategori::all();

        return view('kategori.kategori',['kategori'=>$data]);
    }

}
