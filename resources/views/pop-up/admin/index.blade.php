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
		'title' => 'Data Pop-up',
		'items' => [
			['text' => 'Pop-up', 'url' => '/admin/pop-up'],
			['text' => 'Data Pop-up', 'url' => '#'],
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
                            <a href="/admin/pop-up/create" class="btn btn-sm btn-primary"><i class="fa fa-plus mr-2"></i> Tambah Data</a>
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
                                        <th>Judul</th>
                                        <th width="200">Gambar / Video</th>
                                        <th width="90">Waktu Awal</th>
                                        <th width="90">Waktu Akhir</th>
                                        <th width="60">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($popup as $data)
                                    <tr>
                                        <td><input type="checkbox"></td>
										<td><a href="/admin/pop-up/detail/{{ $data->id_popup }}">{{ $data->popup_judul }}</a></td>
										<td>
											@if(!filter_var($data->popup_gambar, FILTER_VALIDATE_URL))
											<a href="{{ asset('assets/images/pop-up/'.$data->popup_gambar) }}" class="btn-magnify-popup"><img src="{{ asset('assets/images/pop-up/'.$data->popup_gambar) }}" class="img-thumbnail" style="max-width: 200px;"></a>
											@else
											<a href="{{ $data->popup_gambar }}" target="_blank">Lihat Video</a>
											@endif
										</td>
										<td>
                                            <span class="d-none">{{ $data->popup_from }}</span>
                                            {{ date('d/m/Y', strtotime($data->popup_from)) }}
                                            <br>
                                            <small><i class="fa fa-clock mr-2"></i>{{ date('H:i', strtotime($data->popup_from)) }} WIB</small>
                                        </td>
										<td>
                                            <span class="d-none">{{ $data->popup_to }}</span>
                                            {{ date('d/m/Y', strtotime($data->popup_to)) }}
                                            <br>
                                            <small><i class="fa fa-clock mr-2"></i>{{ date('H:i', strtotime($data->popup_to)) }} WIB</small>
                                        </td>
                                        <td>
                                            <div class="btn btn-group">
                                                <a href="/admin/pop-up/edit/{{ $data->id_popup }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                                <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="{{ $data->id_popup }}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <form id="form" class="d-none" method="post" action="/admin/pop-up/delete">
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