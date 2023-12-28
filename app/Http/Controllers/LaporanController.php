<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\SupplierModel;
use App\Models\TransaksiBarangModel;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public $trans;
    public $startDate;
    public $endDate;
    public $range;
    
    public function index() {
        if(request('from') && request('to')){
            $this->trans = TransaksiBarangModel::whereBetween('created_at', [
                Carbon::parse(request('from'))->subDay(1),
                Carbon::parse(request('to'))->addDay(1)
                ])->get();
            $this->startDate = Carbon::parse(request('from'));
            $this->endDate = Carbon::parse(request('to'));
            
        }elseif(request('from') && !request('to')){
            $this->trans = TransaksiBarangModel::where('created_at', '>=', Carbon::parse(request('from'))->subDay(1))->get();
            $this->startDate = Carbon::parse(request('from'));
            $this->endDate = Carbon::now();
        }elseif(!request('from') && request('to')){
            $this->trans = TransaksiBarangModel::where('created_at', '<=', Carbon::parse(request('to'))->addDay(1))->get();
            $this->startDate = Carbon::now()->startOfMonth();
            $this->endDate = Carbon::parse(request('to'));
        }else{
            $this->trans = TransaksiBarangModel::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
            $this->startDate = Carbon::now()->startOfMonth();
            $this->endDate = Carbon::now();
        }
        $this->range = ceil(CarbonPeriod::create($this->startDate, $this->endDate)->count() / 4);
        $barang = BarangModel::where("is_active", "=", true)->whereColumn('stock', "<=", "min_stock")->get();
        $supply = SupplierModel::where("is_active", "=", true)->get();
        
        $result = [];
        foreach ($barang as $brg) {
            $cekTX = TransaksiBarangModel::where("status", "=", "MASUK")->where("barang_id", "=", $brg->id)->get();
            
            if(count($cekTX) > 0){
                foreach ($supply as $sup) {
                    $masuk = TransaksiBarangModel::where("status", "=", "MASUK")->where("barang_id", "=", $brg->id)->where("supplier_id", "=", $sup->id)->get();
                    $keluar = TransaksiBarangModel::where("status", "=", "KELUAR")->where("barang_id", "=", $brg->id)->where("supplier_id", "=", $sup->id)->get();
                    $rusak = TransaksiBarangModel::where("status", "=", "RUSAK")->where("barang_id", "=", $brg->id)->where("supplier_id", "=", $sup->id)->get();

                    if(count($masuk) > 0){
                        array_push($result, collect([
                            "product_code" => $brg->product_code,
                            "product_name" => $brg->name,
                            "supplier" => $sup->company_name,
                            "email" => $sup->email,
                            "no_telepon" => $sup->no_telepon,
                            "masuk" => $masuk->sum('quantity'),
                            "keluar" => count($keluar) != 0 ? $keluar->sum('quantity') : 0,
                            "rusak" => count($rusak) != 0 ? $rusak->sum('quantity') : 0,
                            "sisa_stock" => $masuk->sum('quantity') - ($keluar->sum('quantity') + $rusak->sum('quantity'))
                        ]));
                    }
                }
            }else{
                array_push($result, collect([
                    "product_code" => $brg->product_code,
                    "product_name" => $brg->name,
                    "supplier" => "-",
                    "email" => "-",
                    "no_telepon" => "-",
                    "masuk" => 0,
                    "keluar" => 0,
                    "rusak" => 0,
                    "sisa_stock" => 0
                ]));
            }
        }
        
        return view('LaporanView', [
            "heading" => "Laporan Bulanan",
            "data" => $this->trans,
            "re_stock" => collect($result)
        ]);
    }

    public function download(Request $request){
        $cekTransaksi = TransaksiBarangModel::count();
        if($cekTransaksi === 0){
            return redirect('/laporan')->with(['error' => "Tidak ada data untuk dicetak"]);
        }
        $start = '';
        $end = '';
        if($request['from'] && $request['to']){
            $start = Carbon::parse($request['from']);
            $end = Carbon::parse($request['to']);
            
        }elseif($request['from'] && !$request['to']){
            $start = Carbon::parse($request['from']);
            $end = Carbon::now();
        }elseif(!$request['from'] && $request['to']){
            $start = Carbon::now()->startOfMonth();
            $end = Carbon::parse($request['to']);
        }else{
            $start = Carbon::now()->startOfMonth();
            $end = Carbon::now();
        }
        $range = ceil(CarbonPeriod::create($start, $end)->count() / 7);
        $result = $this->createDetail($range, $start);

        
        $configPie = "{
            type: 'pie',
            data: {
                datasets: [
                    {
                    data: [". $result['masuk']['total'] .", ". $result['keluar']['total'] .", ". $result['rusak']['total'] ."],
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                    label: 'Dataset 1',
                    },
                ],
            },
        }";
        $configLine = "{
            type: 'line',
            data: {
                labels: ". json_encode($result["week"]) .",
                datasets: [
                    {
                        backgroundColor: 'rgba(78, 115, 223, 0.05)',
                        borderColor: 'rgba(78, 115, 223, 1)',
                        data: [".implode(",",$result["masuk"]["weekly"])."],
                        label: 'Masuk',
                        fill: false,
                        lineTension: 0.4,
                        borderWidth: 1,
                        pointBorderWidth: .1,
                        pointBorderColor: 'rgba(78, 115, 223, 1)',
                        pointBackgroundColor: 'rgba(78, 115, 223, 1)'
                    },
                    {
                        backgroundColor: '#1cc88a',
                        borderColor: '#1cc88a',
                        data: [".implode(",",$result["keluar"]["weekly"])."],
                        label: 'Keluar',
                        fill: false,
                        lineTension: 0.4,
                        borderWidth: 1,
                        pointBorderWidth: .1,
                        pointBorderColor: '#1cc88a',
                        pointBackgroundColor: '#1cc88a'
                    },
                    {
                        backgroundColor: '#36b9cc',
                        borderColor: '#36b9cc',
                        data: [".implode(",",$result["rusak"]["weekly"])."],
                        label: 'Rusak',
                        fill: false,
                        lineTension: 0.4,
                        borderWidth: 1,
                        pointBorderWidth: .1,
                        pointBorderColor: '#36b9cc',
                        pointBackgroundColor: '#36b9cc'
                    },
                ],
            },
            options: {
                legend: {
                    labels: {
                        fontSize: 5,
                        fontStyle: 'normal',
                        fontColor: '#404040',
                    }
                },
                scales: {
                    xAxes: [
                        {
                            ticks: {
                            autoSkip: false,
                            maxRotation: 0,
                            fontSize: 5
                            },
                        },
                    ],
                    yAxes: [
                        {
                            ticks: {
                            autoSkip: false,
                            maxRotation: 0,
                            fontSize: 5
                            },
                        },
                    ],
                },
            },
        }";

        $setFrom = '';
        $setTo = "";
        if(Carbon::parse($request['from'])->format('F') == Carbon::parse($request['to'])->format('F')){
            $setFrom = null;
            $setTo = null;
        }else{
            $setFrom = Carbon::parse($request['from'])->format('F');
            $setTo = Carbon::parse($request['to'])->format('F');
        }

        $restock = $this->createReStock();
        $barangs = BarangModel::where("is_active", "=", true)->get();

        $pdf = app('dompdf.wrapper');
        
        $options = $pdf->getOptions();
        $options->setIsRemoteEnabled(true);
        $pdf->loadView('pdf', [
            'heading' => "Data Test",
            "data" => [
                "barangs" => $barangs,
                "restock" => collect($restock),
                'heading' => "Data Test",
                "from" => $setFrom,
                "to" => $setTo,
                "pie" => "https://quickchart.io/chart?w=150&h=150&c=". urlencode($configPie),
                "line" => "https://quickchart.io/chart?w=280&h=200&c=". urlencode($configLine),
                "data" => collect($result)   
            ]
        ]);
        return $pdf->download("Laporan ".Carbon::now()->format('d-m-Y').".pdf");
        
        // return view('pdf', [
        //     "data" => [
        //         "barangs" => $barangs,
        //         "restock" => collect($restock),
        //         'heading' => "Data Test",
        //         "from" => $setFrom,
        //         "to" => $setTo,
        //         "pie" => "https://quickchart.io/chart?w=150&h=150&c=". urlencode($configPie),
        //         "line" => "https://quickchart.io/chart?w=280&h=200&c=". urlencode($configLine),
        //         "data" => collect($result)   
        //     ]
        // ]);
    }

    public function createDetail($range, $st){
        $data = [
            "week" => [],
            "masuk" => [
                "all" => [],
                "weekly" => [],
                "total" => 0
            ],
            "keluar" => [
                "all" => [],
                "weekly" => [],
                "total" => 0
            ],
            "rusak" => [
                "all" => [],
                "weekly" => [],
                "total" => 0
            ]
        ];
        $start = $st;
        $minggu = 1;
        if(Carbon::parse($start)->day >= 7){
            $minggu = 2;
        }elseif(Carbon::parse($start)->day >= 14){
            $minggu = 3;
        }elseif(Carbon::parse($start)->day >= 21 && Carbon::parse($start)->day <= 28){
            $minggu = 4;
        }else{
            $minggu = 1;
        }

        for ($i=1; $i <= $range; $i++) {
            $masuk = TransaksiBarangModel::where("status", "=", "MASUK")->whereBetween("created_at", [
                $start,
                Carbon::parse($start)->addDay(7)]);
            $keluar = TransaksiBarangModel::where("status", "=", "KelUAR")->whereBetween("created_at", [
                $start,
                Carbon::parse($start)->addDay(7)]);
            $rusak = TransaksiBarangModel::where("status", "=", "RUSAK")->whereBetween("created_at", [
                $start,
                Carbon::parse($start)->addDay(7)]);

            array_push($data["week"], "Minggu ".$minggu);
            if($minggu == 4){
                $minggu = 1;
            }else{
                $minggu +=1;
            }

            array_push($data["masuk"]["all"], $masuk->get());
            array_push($data["masuk"]["weekly"], $masuk->sum("quantity"));
            $data["masuk"]["total"] += $masuk->sum("quantity");

            array_push($data["keluar"]["all"], $keluar->get());
            array_push($data["keluar"]["weekly"], $keluar->sum("quantity"));
            $data["keluar"]["total"] += $keluar->sum("quantity");

            array_push($data["rusak"]["all"], $rusak->get());
            array_push($data["rusak"]["weekly"], $rusak->sum("quantity"));
            $data["rusak"]["total"] += $rusak->sum("quantity");

            $start->addDay(7);
        }
        $data["masuk"]["all"] = collect($data["masuk"]["all"])->flatten(1);
        $data["keluar"]["all"] = collect($data["keluar"]["all"])->flatten(1);
        $data["rusak"]["all"] = collect($data["rusak"]["all"])->flatten(1);
        
        return $data;
    }

    public function createReStock(){
        $barang = BarangModel::where("is_active", "=", true)->whereColumn('stock', "<=", "min_stock")->get();
        $supply = SupplierModel::where("is_active", "=", true)->get();
        $result = [];
        foreach ($barang as $brg) {
            $cekTX = TransaksiBarangModel::where("status", "=", "MASUK")->where("barang_id", "=", $brg->id)->get();
            
            if(count($cekTX) > 0){
                foreach ($supply as $sup) {
                    $masuk = TransaksiBarangModel::where("status", "=", "MASUK")->where("barang_id", "=", $brg->id)->where("supplier_id", "=", $sup->id)->get();
                    $keluar = TransaksiBarangModel::where("status", "=", "KELUAR")->where("barang_id", "=", $brg->id)->where("supplier_id", "=", $sup->id)->get();
                    $rusak = TransaksiBarangModel::where("status", "=", "RUSAK")->where("barang_id", "=", $brg->id)->where("supplier_id", "=", $sup->id)->get();

                    if(count($masuk) > 0){
                        array_push($result, collect([
                            "product_code" => $brg->product_code,
                            "product_name" => $brg->name,
                            "supplier" => $sup->company_name,
                            "email" => $sup->email,
                            "no_telepon" => $sup->no_telepon,
                            "masuk" => $masuk->sum('quantity'),
                            "keluar" => count($keluar) != 0 ? $keluar->sum('quantity') : 0,
                            "rusak" => count($rusak) != 0 ? $rusak->sum('quantity') : 0,
                            "sisa_stock" => $masuk->sum('quantity') - ($keluar->sum('quantity') + $rusak->sum('quantity'))
                        ]));
                    }
                }
            }else{
                array_push($result, collect([
                    "product_code" => $brg->product_code,
                    "product_name" => $brg->name,
                    "supplier" => "-",
                    "email" => "-",
                    "no_telepon" => "-",
                    "masuk" => 0,
                    "keluar" => 0,
                    "rusak" => 0,
                    "sisa_stock" => 0
                ]));
            }
        }
        return collect($result);
    }

}
