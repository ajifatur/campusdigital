@extends('template/admin/main')

@section('content')

<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
     <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Data User</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item"><a href="/admin/user">Admin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data User</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- URL Referral -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- column -->
            <div class="col-lg-12">
                <!-- card -->
                <div class="card shadow">
                    <div class="card-title border-bottom">
                        <div class="row">
                            <div class="col-12 col-sm py-1 mb-2 mb-sm-0 text-center text-sm-left">
                                <h5 class="mb-0">Data User</h5>
                            </div>
                             <div class="col-12 col-sm-auto text-center text-sm-left">
                                <a href="/admin/user/export?filter={{ $filter }}" class="btn btn-sm btn-success"><i class="fa fa-file-excel mr-2"></i> Export ke Excel</a>
                                <a href="/admin/user/create" class="btn btn-sm btn-primary"><i class="fa fa-plus mr-2"></i> Tambah User</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(Session::get('message') != null)
                            <div class="alert alert-success alert-dismissible mb-4 fade show" role="alert">
                                {{ Session::get('message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="form-group col-lg-3 col-md-6">
                            <label>Filter:</label>
                            <select id="filter" class="form-control">
                                <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>Semua</option>
                                <option value="admin" {{ $filter == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="member" {{ $filter == 'member' ? 'selected' : '' }}>Member</option>
                                <option value="aktif" {{ $filter == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="belum-aktif" {{ $filter == 'belum-aktif' ? 'selected' : '' }}>Belum Aktif</option>
                            </select>
                        </div>
                        <div class="table-responsive">
                            <table id="table-user" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="40">No.</th>
                                        <th>Nama / Email</th>
                                        <th width="100">Role</th>
                                        <th width="100">Saldo</th>
                                        <th width="50">Refer</th>
                                        <th width="100">Waktu Daftar</th>
                                        <th width="40">Edit</th>
                                        <th width="40">Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>
                                            <a href="{{ $user->id_user == Auth::user()->id_user ? '/admin/profil' : '/admin/user/detail/'.$user->id_user }}">{{ $user->nama_user }}</a>
                                            <br>
                                            <small>{{ $user->email }}</small>
                                        </td>
                                        <td>{{ $user->nama_role }}</td>
                                        <td>{{ $user->is_admin == 0 ? number_format($user->saldo,0,',',',') : '-' }}</td>
                                        <td>{{ $user->is_admin == 0 ? number_format($user->refer,0,',',',') : '-' }}</td>
										<td><span title="{{ date('d/m/Y H:i:s', strtotime($user->register_at)) }}" style="text-decoration: underline; cursor: help;">{{ date('d/m/Y', strtotime($user->register_at)) }}</span></td>
                                        <td><a href="/admin/user/edit/{{ $user->id_user }}" class="btn btn-warning btn-sm btn-block" data-id="{{ $user->id_user }}" title="Edit"><i class="fa fa-edit"></i></a></td>
                                        <td><a href="#" class="btn btn-danger btn-sm btn-block {{ $user->id_user > 6 ? 'btn-delete' : '' }}" data-id="{{ $user->id_user }}" style="{{ $user->id_user > 6 ? '' : 'cursor: not-allowed' }}" title="{{ $user->id_user <= 6 ? $user->id_user == Auth::user()->id_user ? 'Tidak dapat menghapus akun sendiri' : 'Akun ini tidak boleh dihapus' : 'Hapus' }}"><i class="fa fa-trash"></i></a></td>
                                    </tr>
                                    @php $i++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                            <form id="form" class="d-none" method="post" action="/admin/user/delete">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" id="id">
                            </form>
                        </div>
                    </div>
                </div>
                <!-- card -->
            </div>
            <!-- column -->
        </div>
        <!-- ============================================================== -->
        <!-- Recent comment and chats -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    @include('template/admin/_footer')
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->

@endsection

@section('js-extra')

<script src="{{ asset('templates/matrix-admin/assets/extra-libs/DataTables/datatables.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.22/sorting/datetime-moment.js"></script>
<script type="text/javascript">
    // DataTable
	$.fn.dataTable.moment("DD/MM/YYYY");
    $('#table-user').DataTable({
        "columns": [
            null,
            null,
            null,
            { "type": "num-fmt" },
            { "type": "num-fmt" },
            null,
            null,
            null,
        ],
    });

    // Filter
    $(document).on("change", "#filter", function(){
        var value = $(this).val();
        if(value == 'all') window.location.href = '/admin/user?filter=all';
        else if(value == 'admin') window.location.href = '/admin/user?filter=admin';
        else if(value == 'member') window.location.href = '/admin/user?filter=member';
        else if(value == 'aktif') window.location.href = '/admin/user?filter=aktif';
        else if(value == 'belum-aktif') window.location.href = '/admin/user?filter=belum-aktif';
    });

    // Button Delete
    $(document).on("click", ".btn-delete", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        var ask = confirm("Anda yakin ingin menghapus data ini?");
        if(ask){
            $("#id").val(id);
            $("#form").submit();
        }
    });
</script>

@endsection

@section('css-extra')

<link href="{{ asset('templates/matrix-admin/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">

@endsection