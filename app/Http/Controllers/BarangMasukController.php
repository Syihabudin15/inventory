<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    //
    public function index() {
        return view('BarangMasukView', [
            "heading" => "Barang Masuk"
        ]);
    }
}
