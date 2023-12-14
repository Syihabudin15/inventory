<?php

namespace App\Http\Controllers;

use App\Models\TransaksiBarangModel;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //
    public function index() {
        $date = Carbon::now();
        $monthlyMasuk = $this->createSumAndData("MASUK");
        $monthlyKeluar = $this->createSumAndData("KELUAR");
        $monthlyRusak = $this->createSumAndData("RUSAK");

        $yearlyMasuk = $this->createDataYearly("MASUK");
        $yearlyKeluar = $this->createDataYearly("KELUAR");
        $yearlyRusak = $this->createDataYearly("RUSAK");

        return view('DashboardView', [
            "heading" => "Dashboard",
            "currMonth" => $date->format("F"),
            "currYear" => $date->format("Y"),
            "data" => [
                "monthly" => [
                    "masuk" => $monthlyMasuk,
                    "keluar" => $monthlyKeluar,
                    "rusak" => $monthlyRusak
                ],
                "yearly" => [
                    "masuk" => $yearlyMasuk,
                    "keluar" => $yearlyKeluar,
                    "rusak" => $yearlyRusak
                ]
            ]
        ]);
    }

    public function createSumAndData($status){
        $temp = TransaksiBarangModel::whereMonth("created_at", Carbon::now()->month)->where("status", "=", $status);
        $resultData = $temp->get();
        $resultSum = $temp->sum('quantity');
        return [
            "data" => $resultData,
            "total" => $resultSum
        ];
    }

    public function createDataYearly($status){
        $data = [];
        $total = 0;
        for ($i=1; $i <= 12; $i++) { 
            $temp = TransaksiBarangModel::whereYear("created_at", "=", Carbon::now()->year)->whereMonth("created_at", $i)->where("status", "=", $status)->sum('quantity');
            array_push($data, $temp);
            $total += $temp;
        }
        return [
            "data" => $data,
            "total" => $total
        ];
    }
}
