<?php

namespace App\Http\Controllers;

use App\Models\SupplierModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index() {
        $data = [];
        $page = (int)request("page") || 1;

        if(request("page")){
            $data = SupplierModel::latest()->where("is_active", "=", true)->skip(ceil(($page-1)*5))->take(5)->get();
        }elseif(request("search")){
            if(request("page")){
                $data = SupplierModel::latest()->where("is_active", "=", true)->where("company_name", "LIKE", "%" . request("search") . "%")->skip(ceil(($page-1)*5))->take(5)->get();
            }else{
                $data = SupplierModel::latest()->where("is_active", "=", true)->where("company_name", "LIKE", "%" . request("search") . "%")->take(5)->get();
            }
        }else{
            $data = SupplierModel::latest()->where("is_active", "=", true)->take(5)->get();
        }
        return view("SupplierView", [
            "heading" => "Supplier",
            "data" => collect($data),
            "total" => count($data)
        ]);
    }

    public function create(Request $request){
        $validate = $request->validate([
            "company_name" => ['required', 'min:5'],
            "address" => ['required', 'min: 5'],
            "sub_district" => ['required', 'min: 5'],
            "city" => ['required', 'min:5'],
            "zip_code" => ['required', 'min: 5'],
            "country" => ['required', 'min: 4'],
            "no_telepon" => ['required', 'min:10'],
        ]);
        
        try{
            if($request['email']){
                $validate['email'] = (string)$request['email'];
            }
            $find = SupplierModel::where('company_name', '=', $validate['company_name'])->first();

            if($find && $find->is_active === 0){
                $find->is_active = true;
                $find->save();
                return redirect('/supplier')->with(['success' => "Pembuatan supplier berhasil"]);
            }elseif($find && $find->is_active === 1){
                return redirect('/supplier')->with(['error' => "Data supplier sudah tersedia!"]);
            }else{
                $validate['is_active'] = true;

                SupplierModel::create($validate);
                return redirect('/supplier')->with(['success' => "Pembuatan supplier berhasil"]);
            }
        }catch(Exception $exception){
            dd($exception);
            return redirect('/supplier')->with(['error' => "Server Error!"]);
        }
    }

    public function update(Request $request){
        try{
            $find = SupplierModel::findOrFail($request->id);
            $find->company_name = $request->company_name ? $request->company_name : $find->company_name;
            $find->address = $request->address ? $request->address : $find->address;
            $find->sub_district = $request->sub_district ? $request->sub_district : $find->sub_district;
            $find->city = $request->city ? $request->city : $find->city;
            $find->zip_code = $request->zip_code ? $request->zip_code : $find->zip_code;
            $find->country = $request->country ? $request->country : $find->country;
            $find->email = $request->email ? $request->email : $find->email;
            $find->no_telepon = $request->no_telepon ? $request->no_telepon : $find->no_telepon;
            $find->save();
            return redirect("/supplier")->with(['info' => "Update supplier berhasil"]);
        }catch(Exception $exception){
            return redirect("/supplier")->with(['error' => "Server Error!"]);
        }
    }

    public function delete(Request $request){
        $find = SupplierModel::findOrFail($request->id);
        $find->is_active = false;
        $find->save();

        return redirect("/supplier")->with(['success' => "Hapus supplier berhasil"]);
    }
}
