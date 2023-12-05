<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BarangRusakController extends Controller
{
    //
    public function index() {
        return view('BarangRusakView', [
            "heading" => "Barang Rusak"
        ]);
    }
}
