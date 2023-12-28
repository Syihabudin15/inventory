@extends('layout')
@section('content')
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">
                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Barang Re-Stock</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Supplier</th>
                                        <th>Email</th>
                                        <th>No Telepon</th>
                                        <th>Barang Masuk</th>
                                        <th>Barang Keluar</th>
                                        <th>Barang Rusak</th>
                                        <th>Sisa Stok</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Supplier</th>
                                        <th>Email</th>
                                        <th>No Telepon</th>
                                        <th>Barang Masuk</th>
                                        <th>Barang Keluar</th>
                                        <th>Barang Rusak</th>
                                        <th>Sisa Stok</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($re_stock as $re)
                                        <tr>
                                            <td>{{$re['product_code']}}</td>
                                            <td>{{$re['product_name']}}</td>
                                            <td>{{$re['supplier']}}</td>
                                            <td>{{$re['email']}}</td>
                                            <td>{{$re['no_telepon']}}</td>
                                            <td>{{$re['masuk']}}</td>
                                            <td>{{$re['keluar']}}</td>
                                            <td>{{$re['rusak']}}</td>
                                            <td>{{$re['sisa_stock']}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data {{$heading}}</h6>
                        </div>
                        @if ($message = Session::get('error'))
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>	
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        <div class="card-body">
                            <div class="d-flex justify-content-around flex-wrap">
                                <form action="/laporan" method="GET">
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex justify-content-center">
                                            <div class="form-group mx-2">
                                                <label for="from">From:</label>
                                                <input type="date" id="from" class="form-control date-inp" name="from" value="{{request("from")}}" />
                                            </div>
                                            <div class="form-group">
                                                <label for="to">To:</label>
                                                <input type="date" id="to" class="form-control date-inp" name="to" value="{{request("to")}}" />
                                            </div>
                                        </div>
                                        <button type="submit" class="btn m-1 h-45 mt-3 btn-outline-primary btn-sm">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </form>
                                <div class="d-flex align-items-center p-3">
                                    <form action="/laporan/download" method="POST">
                                        @csrf
                                        @method("post")
                                        <div class="d-none">
                                            <div class="d-flex justify-content-center">
                                                <div class="form-group mx-2">
                                                    <label for="from">From:</label>
                                                    <input type="text" class="form-control date-inp" name="from" value="{{request('from')}}" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="to">To:</label>
                                                    <input type="text" class="form-control date-inp" name="to" value="{{request('to')}}" />
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-outline-primary btn-sm" >
                                            <i class="bi bi-printer-fill"></i>
                                            Cetak
                                        </button>
                                    <form>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Kuantiti</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                            <th>Supplier</th>
                                            <th>Pembuat</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Kuantiti</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                            <th>Supplier</th>
                                            <th>Pembuat</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($data as $trx)
                                            <tr>
                                                <td>{{$trx->barang->product_code}}</td>
                                                <td>{{$trx->barang->name}}</td>
                                                <td>{{$trx->quantity}}</td>
                                                <td>{{$trx->status}}</td>
                                                <td>{{ \Carbon\Carbon::parse($trx->created_at)->format('d/m/Y')}}</td>
                                                {{-- <td>
                                                    @if ($trx->supplier->company_name)
                                                        {{$trx->supplier->company_name}}    
                                                    @else
                                                        -
                                                    @endif --}}
                                                <td>
                                                    @if ($trx->supplier_id)
                                                        {{$trx->supplier->company_name}}    
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{$trx->pengguna->first_name}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
@endsection()