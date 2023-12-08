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
                            <div class="d-flex align-items-center p-3">
                                <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                                    <i class="bi bi-plus"></i>
                                    Tambah
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Kuantiti</th>
                                            <th>Tanggal</th>
                                            <th>Supplier</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Kuantiti</th>
                                            <th>Tanggal</th>
                                            <th>Supplier</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>
                                            <td>KRM1021</td>
                                            <td>Kampas Rem</td>
                                            <td>20</td>
                                            <td>07-December-2023</td>
                                            <td>PT Panca Jaya Equipment</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#editModal">
                                                    <i class="bi bi-pencil-square btn-outline-success crsr"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>KRM1021</td>
                                            <td>Kampas Rem</td>
                                            <td>50</td>
                                            <td>07-December-2023</td>
                                            <td>PT Hasta Karya Ananta</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#editModal">
                                                    <i class="bi bi-pencil-square btn-outline-success crsr"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="d-flex flex-row-reverse">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Previous">
                                                    <span aria-hidden="true">Prev &laquo;</span>
                                                </a>
                                                </li>
                                                <a class="page-link" href="#" aria-label="Next">
                                                    <span aria-hidden="true">Next &raquo;</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
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

    <!-- Tambah Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah {{$heading}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="barang_id">Barang</label>
                            <select class="custom-select" id="barang_id">
                                <option selected>Choose...</option>
                                <option value="1">Kampas Rem</option>
                                <option value="2">Oli Federal</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Kuantiti</label>
                            <input type="text" class="form-control" id="quantity">
                        </div>
                        <div class="form-group">
                            <label for="date">Tanggal:</label>
                            <input type="date" id="date" class="form-control date-inp" name="date" min="2023-10-1" />
                        </div>
                        <div class="form-group">
                            <label for="supplier_id">Supplier:</label>
                            <select class="custom-select" id="supplier_id">
                                <option selected>Choose...</option>
                                <option value="1">PT Panca Jaya Equipment</option>
                                <option value="2">PT Hasta Karya Ananta</option>
                                <option value="3">PT Hikmah Jaya Sentosa</option>
                                <option value="4">PT Clarizza Eston Indonesia</option>
                                <option value="5">PT Pegasus Hikari</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Tambah Modal --}}
    {{-- Edit Modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit {{$heading}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="barang_id">Barang</label>
                            <select class="custom-select" id="barang_id" disabled>
                                <option value="1">Kampas Rem</option>
                                <option value="2" selected>Oli Federal</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Kuantiti</label>
                            <input type="text" class="form-control" value="10" id="quantity">
                        </div>
                        <div class="form-group">
                            <label for="date">Tanggal:</label>
                            <input type="date" id="date" class="form-control date-inp" value="2023-12-07" disabled name="date" min="2023-10-1" />
                        </div>
                        <div class="form-group">
                            <label for="supplier_id">Supplier:</label>
                            <select class="custom-select" id="supplier_id" disabled>
                                <option value="1" selected>PT Panca Jaya Equipment</option>
                                <option value="2">PT Hasta Karya Ananta</option>
                                <option value="3">PT Hikmah Jaya Sentosa</option>
                                <option value="4">PT Clarizza Eston Indonesia</option>
                                <option value="5">PT Pegasus Hikari</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Edit Modal --}}

@endsection()