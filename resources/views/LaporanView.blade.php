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
                            <div id="date-picker-example" class="d-flex justify-content-around py-3">
                                <form class="search-date">
                                    <label for="date">Bulan:</label>
                                    <input type="month" id="date" class="date-inp" name="date" min="2023-12" />
                                    <button class="btn btn-outline-primary btn-sm">Cari</button>
                                </form>
                                <button class="btn btn-outline-primary btn-sm" type="submit">
                                    <i class="bi bi-printer-fill"></i> Cetak
                                </button>
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