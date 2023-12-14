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
                                @if (Auth::user()->role === "ADMIN")
                                    <div class="d-flex align-items-center p-3">
                                        <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                                            <i class="bi bi-plus"></i>
                                            Tambah
                                        </button>
                                    </div>
                                @endif
                                <form action="/barang-keluar" method="GET">
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
                            </div>
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
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Kuantiti</th>
                                            <th>Tanggal</th>
                                            <th>Pembuat</th>
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
                                            <th>pembuat</th>
                                            <th>Supplier</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($data as $trx)
                                        <tr>
                                            <td>{{$trx->barang->product_code}}</td>
                                            <td>{{$trx->barang->name}}</td>
                                            <td>{{$trx->quantity}}</td>
                                            <td> {{ \Carbon\Carbon::parse($trx->created_at)->format('d/m/Y')}}</td>
                                            <td>{{$trx->pengguna->first_name}}</td>
                                            <td>
                                                @if (Auth::user()->role === "ADMIN")
                                                    <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#editModal" onclick="onEdit('{{$trx->id}}', '{{$trx->barang->id}}', '{{$trx->barang->name}}', '{{$trx->quantity}}', '{{$trx->supplier_id}}', '{{$trx->supplier->company_name}}'">
                                                        <i class="bi bi-pencil-square btn-outline-success crsr"></i>
                                                    </button>
                                                @endif
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
                <form action="/barang-keluar" method="POST">
                    @csrf
                    @method('post')
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah {{$heading}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="barang_id">Barang</label>
                            <select class="custom-select" id="barang_id" name="barang_id">
                                <option selected>Choose...</option>
                                @foreach ($barang as $brg)
                                <option value="{{$brg->id}}">{{$brg->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Kuantiti</label>
                            <input type="number" class="form-control" id="quantity" name="quantity">
                        </div>
                        <div class="form-group">
                            <label for="supplier_id">Supplier:</label>
                            <select class="custom-select" id="supplier_id" name="supplier_id">
                                <option selected>Choose...</option>
                                @foreach ($supplier as $sup)
                                    <option value="{{$sup->id}}">{{$sup->company_name}}</option>
                                @endforeach
                            </select>
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
                <form action="/barang-keluar" method="POST">
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
    <script>
        var edit = document.getElementById('edit');

        function onEdit(id, barang_id, barang, kuantiti, supplier_id, supplier){
            edit.innerHTML = `
            <div class="form-group d-none">
                <label for="id">ID</label>
                <input type="text" class="form-control" id="id" name="id" value="${id}">
            </div>
            <div class="form-group">
                <label for="barang_id">Barang</label>
                <select class="custom-select" id="barang_id" disabled>
                    <option value="${barang_id}" selected>${barang}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="quantity">Kuantiti</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="${kuantiti}">
            </div>
            <div class="form-group">
                <label for="supplier_id">Barang</label>
                <select class="custom-select" name="supplier_id" id="supplier_id" disabled>
                    <option value="${supplier_id}" selected>${supplier}</option>
                </select>
            </div>
            `;
        }
        </script>
@endsection()