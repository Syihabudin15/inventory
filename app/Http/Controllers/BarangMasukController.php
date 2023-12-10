<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\SupplierModel;
use App\Models\TransaksiBarangModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    //
    public function index() {
        $data = [];
        $page = (int)request("page") || 1;

        if(request('page') && (request("from") || request('to'))){
            if(request("from") && request('to')){
                $data = TransaksiBarangModel::where("status", "=", "MASUK")->whereBetween("created_at", [request("from"), request("to")])->skip(ceil(($page-1)*5))->take(5)->get();
            }elseif(request("from") && !request('to')){
                $data = TransaksiBarangModel::where("status", "=", "MASUK")->where("created_at", ">=" , request('from'))->skip(ceil(($page-1)*5))->take(5)->get();
            }elseif(request("to") && !request('from')){
                $data = TransaksiBarangModel::where("status", "=", "MASUK")->where("created_at", "<=" , request('to'))->skip(ceil(($page-1)*5))->take(5)->get();
            }
        }elseif(request("page") && (!request("from") && !request('to'))){
            $data = TransaksiBarangModel::latest()->where("status", "=", "MASUK")->skip(ceil(($page-1)*5))->take(5)->get();
        }elseif(!request('page') && (request('from') || request('to'))){
            if(request('from') && request('to')){
                $data = TransaksiBarangModel::where("status", "=", "MASUK")->whereBetween("created_at", [request("from"), request("to")])->take(5)->get();
            }elseif(request('from') && !request('to')){
                $data = TransaksiBarangModel::where("status", "=", "MASUK")->where("created_at", ">=", request('from'))->take(5)->get();
            }elseif(request('to') && !request('from')){
                $data = TransaksiBarangModel::where("status", "=", "MASUK")->where("created_at", "<=", request('to'))->take(5)->get();
            }
        }else{
            $data = TransaksiBarangModel::latest()->where("status", "=", "MASUK")->take(5)->get();
        }
        $barang = BarangModel::where("is_active", "=", true)->get();
        $supplier = SupplierModel::latest()->where("is_active", "=", true)->get();
        return view('BarangMasukView', [
            "heading" => "Barang Masuk",
            "data" => collect($data),
            "total" => count($data),
            "barang" => collect($barang),
            "supplier" => collect($supplier)
        ]);
    }

    public function create(Request $request){
        $validate = $request->validate([
            'barang_id' => ['required'],
            'supplier_id' => ['required'],
            "quantity" => ['required', "min:1"]
        ]);
        try{
            $validate['pengguna_id'] = 1;
            $validate['status'] = "MASUK";
            $findBrg = BarangModel::findOrFail($validate['barang_id']);
            $findBrg->stock = $findBrg->stock + (int)$validate['quantity'];
            $findBrg->save();

            TransaksiBarangModel::create($validate);
            return redirect('BarangMasukView')->with(['success' => 'Barang masuk berhasil diinput']);
        }catch(Exception $exception){
            dd($exception);
            return redirect('BarangMasukView')->with(['error' => "Server Error"]);
        }
    }

    public function update(Request $request){

    }
}
