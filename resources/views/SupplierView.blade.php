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
                        
                        <div class="card-body">
                            <div class="d-flex justify-content-around align-items-center p-3">
                                <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                                    <i class="bi bi-plus"></i>
                                    Tambah
                                </button>
                                <div class="search-brg-wrap">
                                    <form action="/supplier" method="GET">
                                        <input class="search-brg" name=search value="{{request("search")}}">
                                        <button type="submit" value="search" class="btn btn-sm btn-outline-primary">Cari</button>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Perusahaan</th>
                                            <th>Alamat</th>
                                            <th>Kecamatan</th>
                                            <th>Kota</th>
                                            <th>Kode Pos</th>
                                            <th>Negara</th>
                                            <th>Email</th>
                                            <th>No Telepon</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Perusahaan</th>
                                            <th>Alamat</th>
                                            <th>Kecamatan</th>
                                            <th>Kota</th>
                                            <th>Kode Pos</th>
                                            <th>Negara</th>
                                            <th>Email</th>
                                            <th>No Telepon</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($data as $sup)
                                            <tr>
                                                <td>{{$sup->company_name}}</td>
                                                <td>{{$sup->address}}</td>
                                                <td>{{$sup->sub_district}}</td>
                                                <td>{{$sup->city}}</td>
                                                <td>{{$sup->zip_code}}</td>
                                                <td>{{$sup->country}}</td>
                                                <td>{{$sup->email}}</td>
                                                <td>{{$sup->no_telepon}}</td>
                                                <td>
                                                    <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#hapusModal" onclick="onHapus({{$sup->id}})">
                                                        <i class="bi bi-trash btn-outline-danger crsr"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-success btn-sm" onclick="onEdit({{$sup->id}}, '{{$sup->company_name}}','{{$sup->address}}','{{$sup->sub_district}}','{{$sup->city}}','{{$sup->zip_code}}','{{$sup->country}}','{{$sup->email}}','{{$sup->no_telepon}}')" data-toggle="modal" data-target="#editModal">
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
                <form action="/supplier" method="POST">
                    @csrf
                    @method('post')
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah {{$heading}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="company_name">Nama Perusahaan</label>
                            <input type="text" class="form-control" id="company_name" placeholder="PT. Example" value="{{old('company_name')}}" name="company_name">
                        </div>
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <input type="text" class="form-control" id="address" value="{{old('address')}}" name="address">
                        </div>
                        <div class="form-group">
                            <label for="sub_district">Kecamatan</label>
                            <input type="text" class="form-control" id="sub_district" value="{{old('sub_district')}}" name="sub_district">
                        </div>
                        <div class="form-group">
                            <label for="city">Kota</label>
                            <input type="text" class="form-control" id="city" value="{{old('city')}}" name="city">
                        </div>
                        <div class="form-group">
                            <label for="zip_code">Kode Pos</label>
                            <input type="text" class="form-control" id="zip_code" value="{{old('zip_code')}}" name="zip_code">
                        </div>
                        <div class="form-group">
                            <label for="country">Negara</label>
                            <input type="text" class="form-control" id="country" value="{{old('country')}}" name="country">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" value="{{old('email')}}" name="email">
                        </div>
                        <div class="form-group">
                            <label for="no_telepon">No Telepon</label>
                            <input type="text" class="form-control" id="no_telepon" value="{{old('no_telepon')}}" name="no_telepon">
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
                <form method="post" action="/supplier">
                    @csrf
                    @method("put")
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
                <form action="/supplier/delete" method="post">
                    @csrf
                    @method('post')
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Yakin ingin menghapus pilihan?</p>
                    </div>
                    <div id="inputIdHapus" class="d-none">
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
    var editModal = document.getElementById("edit");  
    var hapusModal = document.getElementById("inputIdHapus");
    function onEdit(id,company_name, address, sub_district, city, zip_code, country, email, no_telepon){
        var code = `
            <div class="form-group d-none">
                <label for="id">Id</label>
                <input type="text" class="form-control" value="${id}" id="id" name="id">
            </div>
            <div class="form-group">
                <label for="company_name">Nama Perusahaan</label>
                <input type="text" class="form-control" id="company_name" placeholder="PT. Example" value="${company_name}" name="company_name">
            </div>
            <div class="form-group">
                <label for="address">Alamat</label>
                <input type="text" class="form-control" id="address" value="${address}" name="address">
            </div>
            <div class="form-group">
                <label for="sub_district">Kecamatan</label>
                <input type="text" class="form-control" id="sub_district" value="${sub_district}" name="sub_district">
            </div>
            <div class="form-group">
                <label for="city">Kota</label>
                <input type="text" class="form-control" id="city" value="${city}" name="city">
            </div>
            <div class="form-group">
                <label for="zip_code">Kode Pos</label>
                <input type="text" class="form-control" id="zip_code" value="${zip_code}" name="zip_code">
            </div>
            <div class="form-group">
                <label for="country">Negara</label>
                <input type="text" class="form-control" id="country" value="${country}" name="country">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" value="${email}" name="email">
            </div>
            <div class="form-group">
                <label for="no_telepon">No Telepon</label>
                <input type="text" class="form-control" id="no_telepon" value="${no_telepon}" name="no_telepon">
            </div>
        `;
        editModal.innerHTML = code;
    };
    function onHapus(id){
        hapusModal.innerHTML = `<label for="id">ID</label><input name="id" id="inputIdHapus" value="${id}" >`
    }

</script>
@endsection()