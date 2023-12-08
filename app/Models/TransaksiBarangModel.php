<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiBarangModel extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    
    public function supplier(){
        return $this->belongsTo(SupplierModel::class);
    }
    public function barang(){
        return $this->belongsTo(BarangModel::class);
    }
    public function pengguna(){
        return $this->belongsTo(PenggunaModel::class);
    }
}
