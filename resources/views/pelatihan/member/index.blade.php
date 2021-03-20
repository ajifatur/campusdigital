@extends('template/member/main')

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
                <h4 class="page-title">Pelatihan</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/member">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pelatihan</li>
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
			@if(Auth::user()->role == 6)
            <!-- column -->
            <div class="col-lg-12">
                <!-- card -->
                <div class="card shadow">
                    <div class="card-title border-bottom">
                        <div class="row">
                            <div class="col-12 col-sm py-1 mb-2 mb-sm-0 text-center text-sm-left">
                                <h5 class="mb-0">Data Pelatihan</h5>
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
                        <div class="table-responsive">
                            <table id="table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="40">No.</th>
                                        <th>Pelatihan</th>
                                        <th width="150">Tanggal</th>
                                        <th width="100">Peserta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($pelatihan_sendiri as $data)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>
											<a href="/member/pelatihan/detail/{{ $data->id_pelatihan }}">{{ $data->nama_pelatihan }}</a>
											<br>
											<small>{{ $data->nomor_pelatihan }}</small>
										</td>
                                        <td>
											{{ generate_date_range('join', $data->tanggal_pelatihan_from.' - '.$data->tanggal_pelatihan_to)['from'] }}
											<br>
											s.d.
											<br>
											{{ generate_date_range('join', $data->tanggal_pelatihan_from.' - '.$data->tanggal_pelatihan_to)['to'] }}
										</td>
										<td><a href="/member/pelatihan/peserta/{{ $data->id_pelatihan }}" title="Lihat Daftar Peserta">{{ number_format($data->jumlah_peserta,0,'.','.') }} orang</a></td>
                                    </tr>
                                    @php $i++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- card -->
            </div>
            <!-- column -->
			@endif
            <!-- column -->
            <div class="col-lg-12">
                <!-- card -->
                <div class="card shadow">
                    <div class="card-title border-bottom">
                        <div class="row">
                            <div class="col-12 col-sm py-1 mb-2 mb-sm-0 text-center text-sm-left">
                                <h5 class="mb-0">Pelatihan Yang Akan Datang</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
						<div class="col-12">
							<div class="row">
								@if(count($pelatihan)>0)
									@foreach($pelatihan as $data)
									<div class="col-md-6 col-lg-3 col-xlg-3">
										<div class="card card-hover shadow">
											<a href="/member/pelatihan/detail/{{ $data->id_pelatihan }}">
												<img class="card-img-top" src="{{ $data->thumbnail_pelatihan != '' ? asset('assets/images/pelatihan/'.$data->thumbnail_pelatihan) : asset('assets/images/default/pelatihan.jpg') }}" alt="Gambar">
											</a>
											<div class="card-body">
												<p class="pelatihan-title h4"><a href="/member/pelatihan/detail/{{ $data->id_pelatihan }}" title="{{ $data->nama_pelatihan }}">{{ $data->nama_pelatihan }}</a></p>
												<div class="pelatihan-caption"><div>{{ $data->nama_user }}</div></div>
											</div>
                                            <div class="card-footer text-muted border border-top">
                                                <div class="d-sm-flex justify-content-between">
                                                    <span><i class="fa fa-calendar"></i> {{ explode(' ', generate_date_range('join', $data->tanggal_pelatihan_from.' - '.$data->tanggal_pelatihan_to)['from'])[0] }}</span>
                                                    <span><i class="fa fa-clock mr-2"></i>{{ explode(' ', generate_date_range('join', $data->tanggal_pelatihan_from.' - '.$data->tanggal_pelatihan_to)['from'])[1] }} WIB</span>
                                                </div>
                                            </div>
										</div>
									</div>
									@endforeach
								@else
								<div class="col-12">
									<div class="alert alert-danger text-center">Belum ada pelatihan yang bisa diikuti.</div>
								</div>
								@endif
							</div>
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
    @include('template/member/_footer')
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->

@endsection

@section('js-extra')

<script src="{{ asset('templates/matrix-admin/assets/extra-libs/DataTables/datatables.min.js') }}"></script>
<script type="text/javascript">
    // DataTable
    $('#table').DataTable();
</script>

@endsection

@section('css-extra')

<link href="{{ asset('templates/matrix-admin/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<style type="text/css">
    .border-top, .border-bottom {padding: 1.25rem;}
    .form-control {border-color: #caccce;}
    .input-group-text {border-color: #caccce;}
	.box {background-color: #ffffff!important; cursor: pointer;}
	.pelatihan-title {line-height: 21px; height: 42px; display: -webkit-box !important; -webkit-line-clamp: 2; -moz-line-clamp: 2; -ms-line-clamp: 2; -o-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; -ms-box-orient: vertical; -o-box-orient: vertical; box-orient: vertical; overflow: hidden; text-overflow: ellipsis;}
	.pelatihan-caption {line-height: 21px; height: 21px; display: -webkit-box !important; -webkit-line-clamp: 3; -moz-line-clamp: 3; -ms-line-clamp: 3; -o-line-clamp: 3; line-clamp: 3; -webkit-box-orient: vertical; -ms-box-orient: vertical; -o-box-orient: vertical; box-orient: vertical; overflow: hidden; text-overflow: ellipsis;}
</style>

@endsection