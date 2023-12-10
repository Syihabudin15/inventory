<?php

namespace App\Http\Controllers;

use App\Models\PenggunaModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    //
    public function index() {
        $data = [];
        $page = (int)request("page") || 1;

        if(request("page")){
            $data = PenggunaModel::latest()->where("is_active", "=", true)->skip(ceil(($page-1)*5))->take(5)->get();
        }elseif(request("search")){
            if(request("page")){
                $data = PenggunaModel::latest()->where("is_active", "=", true)->where("first_name", "LIKE", "%" . request("search") . "%")->orWhere("last_name", "LIKE", "%" . request("search") . "%")->skip(ceil(($page-1)*5))->take(5)->get();
            }else{
                $data = PenggunaModel::latest()->where("is_active", "=", true)->where("first_name", "LIKE", "%" . request("search") . "%")->orWhere("last_name", "LIKE", "%" . request("search") . "%")->take(5)->get();
            }
        }else{
            $data = PenggunaModel::latest()->where("is_active", "=", true)->take(5)->get();
        }
        return view("PenggunaView", [
            "heading" => "Pengguna",
            "data" => collect($data),
            "total" => count($data)
        ]);
    }
    public function create(Request $request){
        $validate = $request->validate([
            "first_name" => ['required', 'min:5'],
            "last_name" => ['required', 'min:5'],
            "username" => ['required', 'min:5'],
            "password" => ['required', 'min:5'],
            "role" => ['required', 'min:5'],
        ]);

        try{
            $find = PenggunaModel::where('first_name', '=', $validate['first_name'])->where('last_name', '=', $validate['last_name'])->first();
            if($find && $find->is_active === 0){
                $find->is_active = true;
                $find->save();
                return redirect('/pengguna')->with(['success' => "Pembuatan pengguna berhasil"]);
            }elseif($find && $find->is_active === 1){
                return redirect('/pengguna')->with(['error' => "Data pengguna sudah tersedia!"]);
            }else{
                $validate['is_active'] = true;
                $validate['password'] = Hash::make($validate['password']);
                PenggunaModel::create($validate);
                return redirect('/pengguna')->with(['success' => "Pembuatan pengguna berhasil"]);
            }
        }catch(Exception $exception){
            dd($exception);
            return redirect('/pengguna')->with(['error' => "Server Error"]);
        }
    }

    public function update(Request $request){
        try{
            $find = PenggunaModel::findOrFail($request->id);
            $find->first_name = $request->first_name ? $request->first_name : $find->first_name;
            $find->last_name = $request->last_name ? $request->last_name : $find->last_name;
            $find->username = $request->username ? $request->username : $find->username;
            $find->password = $request->password ? $request->password : $find->password;
            $find->role = $request->role ? $request->role : $find->role;

            $find->save();
            return redirect('/pengguna')->with(['success' => "Update data pengguna berhasil"]);
        }catch(Exception $exception){
            dd($exception);
            return redirect('/pengguna')->with(['error' => "Server Error"]);
        }
    }

    public function delete(Request $request){
        $find = PenggunaModel::findOrFail($request->id);
        $find->is_active = false;
        $find->save();

        return redirect('/pengguna')->with(['success' => "Hapus data barang berhasil"]);
    }
}
