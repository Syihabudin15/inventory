<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <title>Laporan Bulanan</title>
    <style>
        body{
            font-size: .9em
        }
        .page_break{
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div style="width: 80vw;margin:10px auto;">
        {{-- Heading --}}
        <div style="border-bottom: 1px solid black;">
            <div style="float: left; width: 20%;margin-top:20px;">
                <img src="{{ public_path('img/tunas_daihatsu.png') }}" alt="logo" width="100%">
            </div>
            <div style="float: left; width:60%; text-align:center;line-height:.1">
                <h6>LAPORAN BULANAN PT. TUNAS DAIHATSU</h6>
                    <div>
                        <div class="d-none">
                            {{\Carbon\Carbon::setLocale('id')}}
                        </div>
                        <h6>Periode Bulan 
                        @if ($data['from'] && $data['to'])
                            {{$data['from']}} - {{$data['to']}}
                        @else
                            {{\Carbon\Carbon::now()->format('F')}}
                        @endif
                    </h6>
                </div>
            </div>
            <div style="float: left; width: 20%;margin-top:20px;">
                <img src="{{ public_path('img/tunas_daihatsu.png') }}" alt="logo" width="100%">
            </div>
            <div style="clear: both;"></div>
            <div style="text-align: right; margin-right:20px;font-style:italic;">
                Tanggal Cetak : <span>{{\Carbon\Carbon::now()->format('d-m-Y')}}</span>
            </div>
        </div>
        {{-- End Heading --}}
        
        {{-- Chart --}}
        <div class="my-5">
            <div class="card-body border text-center" style="padding:5;">
                <div>
                    <img src="data:image/png;base64,{{base64_encode(file_get_contents($data['line']))}}">
                </div>
            </div>
            <div class="card-body border text-center" style="padding:5px;">
                <div >
                    <img src="data:image/png;base64,{{base64_encode(file_get_contents($data['pie']))}}" >
                </div>
                <div class="mt-4 text-center small">
                    <span class="mr-2" style="color: #4e73df">
                        <i class="fas fa-circle text-primary"></i> Masuk
                    </span>
                    <span class="mr-2" style="color: #1cc88a">
                        <i class="fas fa-circle text-success"></i> Keluar
                    </span>
                    <span class="mr-2" style="color: #36b9cc">
                        <i class="fas fa-circle text-info"></i> Rusak
                    </span>
                </div>
            </div>
        </div>
        {{-- End Chart --}}
        <div>
            {{-- Data Barang Masuk --}}
            <div class="page_break" style="text-align: center; margin: 30px 0px">
                <h6>Data Barang Masuk Bulan @if ($data['from'] && $data['to'])
                    {{$data['from']}} - {{$data['to']}}
                @else
                    {{\Carbon\Carbon::now()->format('F')}}
                @endif</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Supplier</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Status</th>
                            <th>Kuantiti</th>
                            <th>Tanggal</th>
                            <th>Pembuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['data']['masuk']['all'] as $item)
                            <tr>
                                <td>{{$item->supplier->company_name}}</td>
                                <td>{{$item->barang->product_code}}</td>
                                <td>{{$item->barang->name}}</td>
                                <td>{{$item->refund_status ? "REFUND" : "MASUK"}}</td>
                                <td>{{$item->quantity}}</td>
                                <td>{{\Carbon\Carbon::parse($item->created_at)->format('d-m-Y')}}</td>
                                <td>{{$item->pengguna->first_name}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-right mr-4">
                    <p>
                        <span style="font-weight: bold;">Total :</span>
                        <span>{{$data["data"]['masuk']["total"]}}</span>
                    </p>
                </div>
            </div>
            {{-- End Data Barang Masuk --}}

            {{-- Data Barang Rusak --}}
            <div class="page_break" style="text-align: center; margin: 30px 0px">
                <h6>Data Barang Keluar Bulan @if ($data['from'] && $data['to'])
                    {{$data['from']}} - {{$data['to']}}
                @else
                    {{\Carbon\Carbon::now()->format('F')}}
                @endif</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Supplier</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Status</th>
                            <th>Kuantiti</th>
                            <th>Tangga</th>
                            <th>Pembuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['data']['keluar']['all'] as $item)
                            <tr>
                                <td>{{$item->supplier->company_name}}</td>
                                <td>{{$item->barang->product_code}}</td>
                                <td>{{$item->barang->name}}</td>
                                <td>{{$item->status}}</td>
                                <td>{{$item->quantity}}</td>
                                <td>{{\Carbon\Carbon::parse($item->created_at)->format('d-m-Y')}}</td>
                                <td>{{$item->pengguna->first_name}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-right mr-4">
                    <p>
                        <span style="font-weight: bold;">Total :</span>
                        <span>{{$data["data"]['keluar']["total"]}}</span>
                    </p>
                </div>
            </div>
            {{-- End Data Barang Rusak--}}

            {{-- Data Barang Rusak --}}
            <div class="page_break" style="text-align: center; margin: 30px 0px">
                <h6>Data Barang Rusak Bulan @if ($data['from'] && $data['to'])
                    {{$data['from']}} - {{$data['to']}}
                @else
                    {{\Carbon\Carbon::now()->format('F')}}
                @endif</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Supplier</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Status</th>
                            <th>Kuantiti</th>
                            <th>Tanggal</th>
                            <th>Pembuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['data']['rusak']['all'] as $item)
                            <tr>
                                <td>{{$item->supplier->company_name}}</td>
                                <td>{{$item->barang->product_code}}</td>
                                <td>{{$item->barang->name}}</td>
                                <td>{{$item->refund_status == "SUCCESS" ? "Telah di refund" : "Belum di refund"}}</td>
                                <td>{{$item->quantity}}</td>
                                <td>{{\Carbon\Carbon::parse($item->created_at)->format('d-m-Y')}}</td>
                                <td>{{$item->pengguna->first_name}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-right mr-4">
                    <p>
                        <span style="font-weight: bold;">Total :</span>
                        <span>{{$data["data"]['rusak']["total"]}}</span>
                    </p>
                </div>
            </div>
            {{-- End Data Barang Rusak--}}

            {{-- Data Stok Barang --}}
            <div class="page_break" style="text-align: center; margin: 30px 0px">
                <h6>Data Stok Barang Saat Ini Bulan {{\Carbon\Carbon::now()->format("F")}}</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Minimun Stok</th>
                            <th>Harga</th>
                            <th>Stok Saat ini</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['barangs'] as $item)
                            <tr>
                                <td>{{$item->product_code}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->min_stock}}</td>
                                <td>@currency($item->price)</td>
                                <td>{{$item->stock}}</td>
                                <td>@currency($item->price * $item->stock)</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- End Data Stok Barang --}}

            {{-- Data Restock --}}
            <div style="text-align: center; margin: 30px 0px">
                <h6>Data Barang Yang Harus Di Restok Bulan {{\Carbon\Carbon::now()->format("F")}}</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Supplier</th>
                            <th>No Telepon</th>
                            <th>Barang Masuk</th>
                            <th>Barang Keluar</th>
                            <th>Barang Rusak</th>
                            <th>Sisa Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['restock'] as $item)
                            <tr>
                                <td>{{$item['product_code']}}</td>
                                <td>{{$item['product_name']}}</td>
                                <td>{{$item['supplier']}}</td>
                                <td>{{$item['no_telepon']}}</td>
                                <td>{{$item['masuk']}}</td>
                                <td>{{$item['keluar']}}</td>
                                <td>{{$item['rusak']}}</td>
                                <td>{{$item['sisa_stock']}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- End Data Restock --}}
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>
</html>