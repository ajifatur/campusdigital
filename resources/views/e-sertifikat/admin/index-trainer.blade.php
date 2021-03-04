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
                <h4 class="page-title">E-Sertifikat Trainer</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">E-Sertifikat</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Trainer</li>
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
                                <h5 class="mb-0">E-Sertifikat Trainer</h5>
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
                                        <th>Peserta</th>
                                        <th>Pelatihan</th>
                                        <th width="120">Waktu Awal</th>
                                        <th width="120">Waktu Akhir</th>
                                        <th width="40">Cetak</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($sertifikat as $data)
                                    <tr>
                                        <td>{{ $i }}</td>
										<td>
                                            <a href="/admin/user/detail/{{ $data->id_user }}">{{ $data->nama_user }}</a>
                                            <br>
                                            <small>{{ $data->kode_trainer }}</small>
                                        </td>
										<td>
                                            <a href="/admin/pelatihan/detail/{{ $data->id_pelatihan }}">{{ $data->nama_pelatihan }}</a>
                                            <br>
                                            <small>{{ $data->nomor_pelatihan }}</small>
                                        </td>
                                        <td>{{ generate_date_range('join', $data->tanggal_pelatihan_from.' - '.$data->tanggal_pelatihan_to)['from'] }}</td>
										<td>{{ generate_date_range('join', $data->tanggal_pelatihan_from.' - '.$data->tanggal_pelatihan_to)['to'] }}
										</td>
										<td>
											<button type="button" class="btn btn-primary btn-sm btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf mr-2"></i>Cetak</button>
											<div class="dropdown-menu dropdown-menu-right shadow">
											  <a class="dropdown-item" href="/admin/e-sertifikat/trainer/detail/{{ $data->id_pelatihan }}?page=1" target="_blank">Halaman Depan</a>
											  <!--<a class="dropdown-item" href="/admin/e-sertifikat/trainer/detail/{{ $data->id_pelatihan }}?page=2" target="_blank">Halaman Belakang</a>-->
											</div>
										</td>
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
	$.fn.dataTable.moment("DD/MM/YYYY HH:mm");
    $('#table').DataTable();
</script>

@endsection

@section('css-extra')

<link href="{{ asset('templates/matrix-admin/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">

@endsection