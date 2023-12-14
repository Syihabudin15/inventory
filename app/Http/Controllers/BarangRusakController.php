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
            $findBrg = BarangModel::findOrFail($validate['barang_id']);
            $brgMasuk = collect(TransaksiBarangModel::where("status", "=", "MASUK")->where("supplier_id", "=", $validate['supplier_id'])->where("barang_id", "=", $validate['barang_id'])->get());
            $totalMasuk = 0;
            
            if(count($brgMasuk) == 0){
                return redirect('/barang-rusak')->with(['error' => 'Maaf!! Supplier ini tidak memiliki barang masuk']);
            }else{
                foreach ($brgMasuk as $masuk) {
                    $totalMasuk += $masuk->quantity;
                }
            }
            
            if($findBrg->stock < $validate['quantity']){
                return redirect('/barang-rusak')->with(['error' => 'Maaf!! stok tidak memadai. '.'Stok '.$findBrg->name.': '.$findBrg->stock]);
            }elseif($totalMasuk < $validate['quantity']){
                return redirect('/barang-rusak')->with(['error' => 'Maaf!! kuantiti melebihi jumlah barang masuk dari supplier']);
            }
            
            $findBrg->stock = $findBrg->stock - (int)$validate['quantity'];
            $findBrg->save();

            TransaksiBarangModel::create($validate);
            return redirect('/barang-rusak')->with(['success' => 'Barang rusak berhasil diinput']);
        }catch(Exception $exception){
            // dd($exception);
            return redirect('/barang-rusak')->with(['error' => "Server Error"]);
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
            
            $brg->stock = ($brg->stock + $find->quantity) - $validate['quantity'];
            $find->quantity = $validate['quantity'];
            
            $find->save();
            $brg->save();
            return redirect('/barang-keluar')->with(['success' => "Update transaksi barang keluar berhasil"]);
        }catch(Exception $exception){
            dd($exception);
            return redirect('/barang-keluar')->with(['error' => "Server Error"]);
        }
    }

}
