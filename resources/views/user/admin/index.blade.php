@extends('template/admin/main')

@section('content')

<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
	@include('template/admin/_breadcrumb', ['breadcrumb' => [
		'title' => 'Data User',
		'items' => [
			['text' => 'User', 'url' => '/admin/user'],
			['text' => 'Data User', 'url' => '#'],
		]
	]])
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
                    <div class="card-title border-bottom d-sm-flex justify-content-between align-items-center">
                        <div>
                            <a href="/admin/user/create" class="btn btn-sm btn-primary"><i class="fa fa-plus mr-2"></i> Tambah Data</a>
                            <a href="/admin/user/export?filter={{ $filter }}" class="btn btn-sm btn-success"><i class="fa fa-file-excel mr-2"></i> Export ke Excel</a>
                        </div>
                        <div>
                            <select id="filter" class="form-control form-control-sm">
                                <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>Semua</option>
                                <option value="admin" {{ $filter == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="member" {{ $filter == 'member' ? 'selected' : '' }}>Member</option>
                                <option value="aktif" {{ $filter == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="belum-aktif" {{ $filter == 'belum-aktif' ? 'selected' : '' }}>Belum Aktif</option>
                            </select>
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
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="20"><input type="checkbox"></th>
                                        <th>Identitas</th>
                                        <th width="80">Role</th>
                                        <th width="70">Saldo</th>
                                        <th width="50">Refer</th>
                                        <th width="90">Waktu Daftar</th>
                                        <th width="60">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td><input type="checkbox"></td>
                                        <td>
                                            <a href="{{ $user->id_user == Auth::user()->id_user ? '/admin/profil' : '/admin/user/detail/'.$user->id_user }}">{{ $user->nama_user }}</a>
                                            <br>
                                            <small><i class="fa fa-envelope mr-2"></i>{{ $user->email }}</small>
                                            <br>
                                            <small><i class="fa fa-phone mr-2"></i>{{ $user->nomor_hp }}</small>
                                        </td>
                                        <td>{{ $user->nama_role }}</td>
                                        <td>{{ $user->is_admin == 0 ? number_format($user->saldo,0,',',',') : '-' }}</td>
                                        <td>{{ $user->is_admin == 0 ? number_format($user->refer,0,',',',') : '-' }}</td>
										<td>
                                            <span class="d-none">{{ $user->register_at }}</span>
                                            {{ date('d/m/Y', strtotime($user->register_at)) }}
                                            <br>
                                            <small><i class="fa fa-clock mr-2"></i>{{ date('H:i', strtotime($user->register_at)) }} WIB</small>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="/admin/user/edit/{{ $user->id_user }}" class="btn btn-sm btn-warning" data-id="{{ $user->id_user }}" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                                <a href="#" class="btn btn-sm btn-danger {{ $user->id_user > 6 ? 'btn-delete' : '' }}" data-id="{{ $user->id_user }}" style="{{ $user->id_user > 6 ? '' : 'cursor: not-allowed' }}" data-toggle="tooltip" title="{{ $user->id_user <= 6 ? $user->id_user == Auth::user()->id_user ? 'Tidak dapat menghapus akun sendiri' : 'Akun ini tidak boleh dihapus' : 'Hapus' }}"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
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

<script type="text/javascript">
    // DataTable
    generate_datatable("#dataTable");

    // Filter
    $(document).on("change", "#filter", function(){
        var value = $(this).val();
        if(value == 'all') window.location.href = '/admin/user?filter=all';
        else if(value == 'admin') window.location.href = '/admin/user?filter=admin';
        else if(value == 'member') window.location.href = '/admin/user?filter=member';
        else if(value == 'aktif') window.location.href = '/admin/user?filter=aktif';
        else if(value == 'belum-aktif') window.location.href = '/admin/user?filter=belum-aktif';
    });
</script>

@endsection