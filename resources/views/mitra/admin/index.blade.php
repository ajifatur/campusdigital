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
		'title' => 'Data Mitra',
		'items' => [
			['text' => 'Konten Web', 'url' => '/admin/konten-web'],
			['text' => 'Mitra', 'url' => '/admin/konten-web/mitra'],
			['text' => 'Data Mitra', 'url' => '#'],
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
        <!-- row -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- column -->
            <div class="col-lg-12">
                <!-- card -->
                <div class="card shadow">
                    <div class="card-title border-bottom d-sm-flex justify-content-between align-items-center">
                        <div>
                            <a href="/admin/konten-web/mitra/create" class="btn btn-sm btn-primary"><i class="fa fa-plus mr-2"></i> Tambah Data</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(Session::get('message') != null)
                            <div class="alert alert-success alert-dismissible mb-4 fade show" Blog="alert">
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
                                        <th>Mitra</th>
                                        <th width="150">Logo</th>
                                        <th width="60">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mitra as $data)
                                    <tr>
                                        <td><input type="checkbox"></td>
                                        <td>{{ $data->nama_mitra }}</td>
										<td><a href="{{ asset('assets/images/mitra/'.$data->logo_mitra) }}" class="image-popup-vertical-fit"><img src="{{ asset('assets/images/mitra/'.$data->logo_mitra) }}" class="img-thumbnail" style="max-height: 150px;"></a></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="/admin/konten-web/mitra/edit/{{ $data->id_mitra }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                                <a href="#" class=" btn-sm btn-danger btn-delete" data-id="{{ $data->id_mitra }}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <form id="form" class="d-none" method="post" action="/admin/konten-web/mitra/delete">
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
</script>

@endsection