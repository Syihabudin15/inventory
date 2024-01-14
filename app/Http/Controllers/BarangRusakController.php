<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\SupplierModel;
use App\Models\TransaksiBarangModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangRusakController extends Controller
{
    //
    public function index() {
        $data = [];
        $page = (int)request("page") || 1;

        if(request('page') && (request("from") || request('to'))){
            if(request("from") && request('to')){
                $data = TransaksiBarangModel::where("status", "=", "RUSAK")->whereBetween("created_at", [request("from"), request("to")])->skip(ceil(($page-1)*5))->take(5)->get();
            }elseif(request("from") && !request('to')){
                $data = TransaksiBarangModel::where("status", "=", "RUSAK")->where("created_at", ">=" , request('from'))->skip(ceil(($page-1)*5))->take(5)->get();
            }elseif(request("to") && !request('from')){
                $data = TransaksiBarangModel::where("status", "=", "RUSAK")->where("created_at", "<=" , request('to'))->skip(ceil(($page-1)*5))->take(5)->get();
            }
        }elseif(request("page") && (!request("from") && !request('to'))){
            $data = TransaksiBarangModel::latest()->where("status", "=", "RUSAK")->skip(ceil(($page-1)*5))->take(5)->get();
        }elseif(!request('page') && (request('from') || request('to'))){
            if(request('from') && request('to')){
                $data = TransaksiBarangModel::where("status", "=", "RUSAK")->whereBetween("created_at", [request("from"), request("to")])->take(5)->get();
            }elseif(request('from') && !request('to')){
                $data = TransaksiBarangModel::where("status", "=", "RUSAK")->where("created_at", ">=", request('from'))->take(5)->get();
            }elseif(request('to') && !request('from')){
                $data = TransaksiBarangModel::where("status", "=", "RUSAK")->where("created_at", "<=", request('to'))->take(5)->get();
            }
        }else{
            $data = TransaksiBarangModel::latest()->where("status", "=", "RUSAK")->take(5)->get();
        }
        $barang = BarangModel::where("is_active", "=", true)->get();
        $supplier = SupplierModel::latest()->where("is_active", "=", true)->get();
        return view('BarangRusakView', [
            "heading" => "Barang Rusak",
            "data" => collect($data),
            "total" => count($data),
            "barang" => collect($barang),
            "supplier" => collect($supplier)
        ]);
    }

    public function create(Request $request){
        $validate = $request->validate([
            'barang_id' => ['required'],
            "supplier_id" => ['required'],
            "quantity" => ['required', "min:1"]
        ]);
        try{
            $validate['pengguna_id'] = Auth::user()->id;
            $validate['status'] = "RUSAK";
            $validate['refund_status'] = "PENDING";
            $findBrg = BarangModel::findOrFail($validate['barang_id']);

            $brgMasuk = TransaksiBarangModel::where("status", "=", "MASUK")->where("supplier_id", "=", $validate['supplier_id'])->where("barang_id", "=", $validate['barang_id'])->sum("quantity");
            $brgKeluar = TransaksiBarangModel::where("status", "=", "KELUAR")->where("supplier_id", "=", $validate['supplier_id'])->where("barang_id", "=", $validate['barang_id'])->sum("quantity");
            $brgRusak = TransaksiBarangModel::where("status", "=", "RUSAK")->where("supplier_id", "=", $validate['supplier_id'])->where("barang_id", "=", $validate['barang_id'])->sum("quantity");
            $totalMasuk = $brgMasuk - ($brgKeluar + $brgRusak);
            
            if($findBrg->stock < $validate['quantity']){
                return redirect('/barang-rusak')->with(['error' => 'Maaf!! stok tidak memadai. '.'Stok '.$findBrg->name.': '.$findBrg->stock]);
            }elseif($totalMasuk < $validate['quantity']){
                return redirect('/barang-rusak')->with(['error' => 'Maaf!! kuantiti melebihi jumlah stok barang dari supplier ini']);
            }
            
            $findBrg->stock = (int)$findBrg->stock - (int)$validate['quantity'];
            $findBrg->save();

            TransaksiBarangModel::create($validate);
            return redirect('/barang-rusak')->with(['success' => 'Barang rusak berhasil diinput']);
        }catch(Exception $exception){
            // dd($exception);
            return redirect('/barang-rusak')->with(['error' => "Server Error"]);
        }
    }

    public function updateRefund(Request $request){
        try{
            $find = TransaksiBarangModel::findOrFail($request['id']);
            $find->refund_status = "SUCCESS";
            TransaksiBarangModel::create([
                "barang_id" => $find->barang_id,
                "supplier_id" => $find->supplier_id,
                "pengguna_id" => Auth::user()->id,
                "status" => "MASUK",
                "refund_status" => "SUCCESS",
                "quantity" => $find->quantity
            ]);
            $findBrg = BarangModel::findOrFail($find->barang_id);
            $findBrg->stock = (int)$findBrg->stock + $find->quantity;
            
            $findBrg->save();
            $find->save();
            return redirect('/barang-rusak')->with(['success' => 'Status refund berhasil di update']);
        }catch(Exception $exception){
            return redirect('/barang-rusak')->with(['error' => $exception->getMessage()]);
        }
    }

    public function update(Request $request){
        try{
            $validate = $request->validate([
                "id" => ['required'],
                "barang_id" => ['required'],
                "supplier_id" => ['required'],
                "quantity" => ['required', 'min:1']
            ]);
            $find = TransaksiBarangModel::findOrFail($validate['id']);
            $brg = BarangModel::findOrFail($find->barang_id);
            $brgMasuk = collect(TransaksiBarangModel::where("status", "=", "RUSAK")->where("supplier_id", "=", $validate['supplier_id'])->where("barang_id", "=", $validate['barang_id']));
            $totalMasuk = 0;
            if($find->quantity == $validate['quantity']){
                return redirect('/barang-rusak')->with(['error' => "Mohon masukan kuantiti yang berbeda"]);
            }elseif(($brg->stock + $find->quantity) < $validate['quantity']){
                return redirect('/barang-rusak')->with(['error' => 'Maaf!! stok tidak memadai. '.'Stok '.$brg->name.': '.$brg->stock]);
            }
            
            foreach ($brgMasuk as $masuk) {
                $totalMasuk += $masuk->quantity;
            }
            
            if($totalMasuk < $validate['quantity']){
                return redirect('/barang-rusak')->with(['error' => 'Maaf!! kuantiti melebihi jumlah barang masuk dari supplier']);
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
