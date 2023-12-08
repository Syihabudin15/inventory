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
                            <div class="d-flex justify-content-around align-items-center p-3">
                                <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                                    <i class="bi bi-plus"></i>
                                    Tambah
                                </button>
                                <div class="search-brg-wrap">
                                    <input class="search-brg">
                                    <button class="btn btn-sm btn-outline-primary">Cari</button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Kode Produk</th>
                                            <th>Nama Produk</th>
                                            <th>Stok</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Kode Produk</th>
                                            <th>Nama Produk</th>
                                            <th>Stok</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>
                                            <td>KRM1021</td>
                                            <td>Kampas Rem</td>
                                            <td>200</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#hapusModal">
                                                    <i class="bi bi-trash btn-outline-danger crsr"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#editModal">
                                                    <i class="bi bi-pencil-square btn-outline-success crsr"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>MDC4353</td>
                                            <td>Motor DC 4353</td>
                                            <td>500</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#hapusModal">
                                                    <i class="bi bi-trash btn-outline-danger crsr"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#editModal">
                                                    <i class="bi bi-pencil-square btn-outline-success crsr"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>OFM2332</td>
                                            <td>Oli Federal Matic</td>
                                            <td>300</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#hapusModal">
                                                    <i class="bi bi-trash btn-outline-danger crsr"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#editModal">
                                                    <i class="bi bi-pencil-square btn-outline-success crsr"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>STS8948</td>
                                            <td>Standar Soul</td>
                                            <td>300</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#hapusModal">
                                                    <i class="bi bi-trash btn-outline-danger crsr"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#editModal">
                                                    <i class="bi bi-pencil-square btn-outline-success crsr"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>JAG3647</td>
                                            <td>Jok Agla</td>
                                            <td>10</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#hapusModal">
                                                    <i class="bi bi-trash btn-outline-danger crsr"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#editModal">
                                                    <i class="bi bi-pencil-square btn-outline-success crsr"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>RVM4418</td>
                                            <td>Revolution Motor</td>
                                            <td>23</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#hapusModal">
                                                    <i class="bi bi-trash btn-outline-danger crsr"></i>
                                                </button>
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
                            <label for="name">Nama Barang</label>
                            <input type="text" class="form-control" id="name" placeholder="Ban Tubles">
                        </div>
                        <div class="form-group">
                            <label for="product_code">Kode Barang</label>
                            <input type="text" class="form-control" id="product_code" placeholder="B1145">
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
                            <label for="name">Nama Barang</label>
                            <input type="text" class="form-control" id="name" placeholder="Ban Tubles">
                        </div>
                        <div class="form-group">
                            <label for="product_code">Kode Barang</label>
                            <input type="text" class="form-control" id="product_code" placeholder="B1145">
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
    {{-- Hapus Barang --}}
    <div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Yakin ingin menghapus pilihan?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">
                            <a>YA</a>
                        </button>
                    </div>
            </div>
        </div>
    </div>
    {{-- End Hapus Modal --}}
@endsection()