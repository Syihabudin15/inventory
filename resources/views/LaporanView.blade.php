@extends('layout')
@section('content')
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data {{$heading}}</h6>
                        </div>
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
                                    <form action="/laporan/cetak" method="post">
                                        @csrf
                                        @method('post')
                                        <div class="d-none">
                                            <div class="form-group mx-2">
                                                <label for="from">From:</label>
                                                <input type="date" id="from" class="form-control date-inp" name="from" value="{{request("from")}}" />
                                            </div>
                                            <div class="form-group">
                                                <label for="to">To:</label>
                                                <input type="date" id="to" class="form-control date-inp" name="to" value="{{request("to")}}" />
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                                            <i class="bi bi-plus"></i>
                                            Cetak
                                        </button>
                                    </form>
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
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>
                                            <td>KRM1021</td>
                                            <td>Kampas Rem</td>
                                            <td>200</td>
                                            <td>MASUK</td>
                                            <td>11-December-2023</td>
                                            <td>PT Panca Jaya Equipment</td>
                                        </tr>
                                        <tr>
                                            <td>MDC4353</td>
                                            <td>Motor DC 4353</td>
                                            <td>120</td>
                                            <td>MASUK</td>
                                            <td>11-December-2023</td>
                                            <td>PT Hasta Karya Ananta</td>
                                        </tr>
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
    <script>
        var doc = document.getElementById("dp3");
        doc.datepicker()
        .on('changeDate', function(ev){
            if (ev.date.valueOf() < startDate.valueOf()){
            
            }
        })
        .on('click', () => console.log("Date Klicked"));
    </script>
@endsection()