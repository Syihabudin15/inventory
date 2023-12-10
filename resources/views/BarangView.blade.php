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
                        {{-- Handle Error --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>	
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif

                        @if ($message = Session::get('info'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>	
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif

                        @if ($message = Session::get('error'))
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>	
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        {{-- End Handle Error --}}
                        <div class="card-body">
                            <div class="d-flex justify-content-around align-items-center p-3">
                                <div>
                                    <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                                        <i class="bi bi-plus"></i>
                                        Tambah
                                    </button>
                                </div>
                                <div>
                                    <form action="/barang" method="GET">
                                        <input class="search-brg" name=search value="{{request("search")}}">
                                        <button type="submit" value="search" class="btn btn-sm btn-outline-primary">Cari</button>
                                    </form>
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
                                        @foreach ($data as $brg)
                                        <tr>
                                            <td>{{$brg->product_code}}</td>
                                            <td>{{$brg->name}}</td>
                                            <td>{{$brg->stock}}</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#hapusModal" onclick="onHapus('{{$brg->id}}')">
                                                    <i class="bi bi-trash btn-outline-danger crsr"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#editModal" onclick="onEdit('{{$brg->id}}','{{$brg->name}}','{{$brg->product_code}}')">
                                                    <i class="bi bi-pencil-square btn-outline-success crsr"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex flex-row-reverse">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">
                                            @php
                                                $page = 1;
                                            @endphp
                                            <li class="page-item btn btn-sm {{$page === 1 ? "disabled" : ""}}">
                                                <a class="page-link" href="/supplier?page={{$page === 1 ? 1 : $page-1}}" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo; Prev</span>
                                                </a>
                                            </li>
                                            <li class="page-item btn btn-sm {{($page == ceil($total / 5)) || (ceil($total / 5) == 0) ? "disabled" : ""}}">
                                                <a class="page-link" href="/supplier?page={{$page < ceil($total/5) ? $page+1 : ceil($total/5)}}" aria-label="Next">
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
                <form action="/barang" method="post">
                    @csrf
                    @method('post')
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah {{$heading}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Barang</label>
                            <input type="text" class="form-control" id="name" placeholder="Ban Tubles" name="name" value="{{old('name')}}">
                        </div>
                        <div class="form-group">
                            <label for="product_code">Kode Barang</label>
                            <input type="text" class="form-control" id="product_code" placeholder="B1145" name="product_code" value="{{old('product_code')}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
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
                <form action="/barang" method="post">
                    @csrf
                    @method('put')
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit {{$heading}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body" id="edit">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
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
                <form action="/barang/delete" method="post">
                    @csrf
                    @method('post')
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div id="hapus" class="d-none"></div>
                    <div class="modal-body">
                        <p>Yakin ingin menghapus pilihan?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <a>YA</a>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Hapus Modal --}}
    <script>
        var edit = document.getElementById("edit");
        var hapus = document.getElementById("hapus");

        function onEdit(id, name, product_code){
            edit.innerHTML = `
                <div class="form-group d-none">
                    <label for="id">ID</label>
                    <input type="text" class="form-control" id="id" name="id" value="${id}">
                </div>
                <div class="form-group">
                    <label for="name">Nama Barang</label>
                    <input type="text" class="form-control" id="name" name="name" value="${name}">
                </div>
                <div class="form-group">
                    <label for="product_code">Kode Barang</label>
                    <input type="text" class="form-control" id="product_code" name="product_code" value="${product_code}">
                </div>
            `;
        };
        function onHapus(id){
            hapus.innerHTML = `
                <label for="id">ID</label>
                <input type="text" class="form-control" id="id" name="id" value="${id}">
            `;
        };
    </script>
@endsection()