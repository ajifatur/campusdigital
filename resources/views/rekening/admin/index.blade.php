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
		'title' => 'Data Rekening',
		'items' => [
			['text' => 'Rekening', 'url' => '/admin/rekening'],
			['text' => 'Data Rekening', 'url' => '#'],
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
                                        <th>User</th>
                                        <th width="150">Platform</th>
                                        <th width="150">Nomor</th>
                                        <th>Atas Nama</th>
                                        <th width="60">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rekening as $data)
                                    <tr>
                                        <td><input type="checkbox"></td>
                                        <td>
                                            <a href="/admin/user/detail/{{ $data->id_user }}">{{ $data->nama_user }}</a>
                                            <br>
                                            <small><i class="fa fa-envelope mr-2"></i>{{ $data->email }}</small>
                                            <br>
                                            <small><i class="fa fa-phone mr-2"></i>{{ $data->nomor_hp }}</small>
                                        </td>
                                        <td>{{ $data->nama_platform }}</td>
                                        <td>{{ $data->nomor }}</td>
                                        <td>{{ $data->atas_nama }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="/admin/rekening/edit/{{ $data->id_rekening }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                                <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="{{ $data->id_rekening }}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <form id="form" class="d-none" method="post" action="/admin/rekening/delete">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" id="id-rekening">
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
</script>

@endsection