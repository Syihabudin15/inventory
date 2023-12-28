<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\SupplierModel;
use App\Models\TransaksiBarangModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangKeluarController extends Controller
{
    //
    public function index() {
        $data = [];
        $page = (int)request("page") || 1;

        if(request('page') && (request("from") || request('to'))){
            if(request("from") && request('to')){
                $data = TransaksiBarangModel::where("status", "=", "KELUAR")->whereBetween("created_at", [request("from"), request("to")])->skip(ceil(($page-1)*5))->take(5)->get();
            }elseif(request("from") && !request('to')){
                $data = TransaksiBarangModel::where("status", "=", "KELUAR")->where("created_at", ">=" , request('from'))->skip(ceil(($page-1)*5))->take(5)->get();
            }elseif(request("to") && !request('from')){
                $data = TransaksiBarangModel::where("status", "=", "KELUAR")->where("created_at", "<=" , request('to'))->skip(ceil(($page-1)*5))->take(5)->get();
            }
        }elseif(request("page") && (!request("from") && !request('to'))){
            $data = TransaksiBarangModel::latest()->where("status", "=", "KELUAR")->skip(ceil(($page-1)*5))->take(5)->get();
        }elseif(!request('page') && (request('from') || request('to'))){
            if(request('from') && request('to')){
                $data = TransaksiBarangModel::where("status", "=", "KELUAR")->whereBetween("created_at", [request("from"), request("to")])->take(5)->get();
            }elseif(request('from') && !request('to')){
                $data = TransaksiBarangModel::where("status", "=", "KELUAR")->where("created_at", ">=", request('from'))->take(5)->get();
            }elseif(request('to') && !request('from')){
                $data = TransaksiBarangModel::where("status", "=", "KELUAR")->where("created_at", "<=", request('to'))->take(5)->get();
            }
        }else{
            $data = TransaksiBarangModel::latest()->where("status", "=", "KELUAR")->take(5)->get();
        }
        $barang = BarangModel::where("is_active", "=", true)->get();
        $supplier = SupplierModel::latest()->where("is_active", "=", true)->get();
        return view('BarangKeluarView', [
            "heading" => "Barang Keluar",
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
            $validate['pengguna_id'] = Auth::user()->id;
            $validate['status'] = "KELUAR";

            $findBrg = BarangModel::findOrFail($validate['barang_id']);
            $findMasuk = TransaksiBarangModel::where("barang_id", "=", $findBrg->id)->where("supplier_id", "=", $validate['supplier_id'])
            ->where("status", "=", "MASUK")->sum("quantity");
            $findkeluar = TransaksiBarangModel::where("barang_id", "=", $findBrg->id)->where("supplier_id", "=", $validate['supplier_id'])
            ->where("status", "=", "KELUAR")->sum("quantity");
            $findRusak = TransaksiBarangModel::where("barang_id", "=", $findBrg->id)->where("supplier_id", "=", $validate['supplier_id'])
            ->where("status", "=", "RUSAK")->sum("quantity");
            $findTrx = $findMasuk - ($findRusak + $findkeluar);

            if($findBrg->stock < $validate['quantity']){
                return redirect('/barang-keluar')->with(['error' => 'Maaf!! stok tidak memadai. '.'Stok '.$findBrg->name.': '.$findBrg->stock]);
            }elseif($findTrx < $validate['quantity']){
                return redirect('/barang-keluar')->with(['error' => 'Maaf!! barang masuk dari supplier ini kurang dari jumlah barang keluar yang diinput']);
            }
            $findBrg->stock = (int)$findBrg->stock - (int)$validate['quantity'];
            $findBrg->save();

            TransaksiBarangModel::create($validate);
            return redirect('/barang-keluar')->with(['success' => 'Barang keluar berhasil diinput']);
        }catch(Exception $exception){
            dd($exception);
            return redirect('/barang-keluar')->with(['error' => "Server Error"]);
        }
    }

    public function update(Request $request){
        try{
            $validate = $request->validate([
                "id" => ['required'],
                "quantity" => ['required', 'min:1'],
                "supplier_id" => ['required']
            ]);

            $find = TransaksiBarangModel::findOrFail($validate['id']);
            $brg = BarangModel::findOrFail($find->barang_id);
            $findMasuk = TransaksiBarangModel::where("barang_id", "=", $brg->id)->where("supplier_id", "=", $validate['supplier_id'])
            ->where("status", "=", "MASUK")->sum("quantity")->get();
            $findKeluar = TransaksiBarangModel::where("barang_id", "=", $brg->id)->where("supplier_id", "=", $validate['supplier_id'])
            ->where("status", "=", "KELUAR")->sum("quantity")->get();
            $findRusak = TransaksiBarangModel::where("barang_id", "=", $brg->id)->where("supplier_id", "=", $validate['supplier_id'])
            ->where("status", "=", "RUSAK")->sum("quantity")->get();
            $findTrx = $findMasuk - ($findRusak + $findKeluar);

            if($find->quantity == $validate['quantity']){
                return redirect('/barang-keluar')->with(['error' => "Mohon masukan kuantiti yang berbeda"]);
            }elseif(($brg->stock + $find->quantity) < $validate['quantity']){
                return redirect('/barang-keluar')->with(['error' => 'Maaf!! stok tidak memadai. '.'Stok '.$brg->name.': '.$brg->stock]);
            }elseif($findTrx < $validate['quantity']){
                return redirect('/barang-keluar')->with(['error' => 'Maaf!! barang masuk dari supplier '.$findMasuk->supplier->company_name." kurang dari jumlah barang keluar yang diinput"]);
            }
            $brg->stock = (int)($brg->stock + $find->quantity) - (int)$validate['quantity'];
            $find->quantity = (int)$validate['quantity'];
            
            $find->save();
            $brg->save();
            return redirect('/barang-keluar')->with(['success' => "Update transaksi barang keluar berhasil"]);
        }catch(Exception $exception){
            dd($exception);
            return redirect('/barang-keluar')->with(['error' => "Server Error"]);
        }
    }

}
