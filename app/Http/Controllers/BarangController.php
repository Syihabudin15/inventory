<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use Exception;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index() {
        $data = [];
        $page = (int)request("page") || 1;

        if(request("page")){
            $data = BarangModel::where("is_active", "=", true)->skip(ceil(($page-1)*5))->take(5)->get();
        }elseif(request("search")){
            if(request("page")){
                $data = BarangModel::where("is_active", "=", true)->where("name", "LIKE", "%" . request("search") . "%")->skip(ceil(($page-1)*5))->take(5)->get();
            }else{
                $data = BarangModel::where("is_active", "=", true)->where("name", "LIKE", "%" . request("search") . "%")->take(5)->get();
            }
        }else{
            $data = BarangModel::where("is_active", "=", true)->take(5)->get();
        }
        return view("BarangView", [
            "heading" => "Barang",
            "data" => collect($data),
            "total" => count($data)
        ]);
    }

    public function create(Request $request){
        $validate = $request->validate([
            "name" => ['required', 'min:5'],
            "product_code" => ['required', 'min:5'],
        ]);

        try{
            $find = BarangModel::where('name', '=', $validate['name'])->first();
            if($find && $find->is_active === 0){
                $find->is_active = true;
                $find->save();
                return redirect('/barang')->with(['success' => "Pembuatan data barang berhasil"]);
            }elseif($find && $find->is_active === 1){
                return redirect('/barang')->with(['error' => "Data barang sudah tersedia!"]);
            }else{
                $validate['stock'] = 0;
                $validate['is_active'] = true;
                BarangModel::create($validate);
                return redirect('/barang')->with(['success' => "Pembuatan data barang berhasil"]);
            }
        }catch(Exception $exception){
            return redirect('/barang')->with(['error' => "Server Error"]);
        }
    }

    public function update(Request $request){
        try{
            $find = BarangModel::findOrFail($request->id);
            $find->name = $request->name ? $request->name : $find->name;
            $find->product_code = $request->product_code ? $request->product_code : $find->product_code;
            $find->save();
            return redirect('/barang')->with(['success' => "Update data barang berhasil"]);
        }catch(Exception $exception){
            dd($exception);
            return redirect('/barang')->with(['error' => "Server Error"]);
        }
    }

    public function delete(Request $request){
        $find = BarangModel::findOrFail($request->id);
        $find->is_active = false;
        $find->save();

        return redirect('/barang')->with(['success' => "Hapus data barang berhasil"]);
    }
}
