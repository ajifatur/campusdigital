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
                <h4 class="page-title">Data Absensi</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item"><a href="/admin/absensi">Absensi</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Absensi</li>
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
        <!-- row -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- column -->
            <div class="col-lg-12">
                <!-- card -->
                <div class="card shadow">
                    <div class="card-title border-bottom">
                        <div class="row">
                            <div class="col-12 col-sm py-1 mb-2 mb-sm-0 text-center text-sm-left">
                                <h5 class="mb-0">Data Absensi</h5>
                            </div>
							<div class="col-12 col-sm-auto text-center text-sm-left px-sm-0 pb-3 pb-sm-0">
								<a href="/admin/absensi/export?tanggal={{ isset($_GET['tanggal']) ? $_GET['tanggal'] : date('d/m/Y') }}" class="btn btn-sm btn-success"><i class="fa fa-file-excel mr-2"></i> Export ke Excel</a>
							</div>
							<div class="col-12 col-sm-auto text-center text-sm-left">
								<div class="input-group">
								  <div class="input-group-prepend">
									  <a href="#" class="btn btn-sm btn-primary btn-date"><i class="fa fa-calendar"></i></a>
								  </div>
								  <input type="text" id="date" class="form-control form-control-sm" value="{{ isset($_GET['tanggal']) ? $_GET['tanggal'] : date('d/m/Y') }}" readonly>
								</div>
							</div>
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
                            <table id="table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="40">No.</th>
                                        <th>User</th>
                                        <th width="100">Instansi</th>
                                        <th width="100">Jurusan / Kelas</th>
                                        <th width="150">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($absensi as $data)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td><a href="/admin/user/detail/{{ $data->id_user }}">{{ $data->nama_user }}</a><br><small class="text-secondary">{{ $data->email }}</small></td>
                                        <td>{{ $data->instansi }}</td>
										<td>{{ $data->jurusan }}<br><small class="text-secondary">{{ $data->kelas }}</small></td>
                                        <td>{{ date('d/m/Y H:i:s', strtotime($data->absensi_at)) }}</td>
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
<script src="{{ asset('templates/matrix-admin/assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    // DataTable
	$.fn.dataTable.moment("DD/MM/YYYY HH:mm:ss");
    $('#table').DataTable();
	
    // Datepicker
    $(document).ready(function(){
        $("#date").datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: true,
            autoclose: true
        });
    });
	
	// Klik btn-date
	$(document).on("click", ".btn-date", function(e){
		e.preventDefault();
		$("#date").focus();
	});
	
	// Ubah tanggal
	$(document).on("change", "#date", function(){
		var date = $(this).val();
		window.location.href = '/admin/absensi?tanggal='+date;
	});
</script>

@endsection

@section('css-extra')

<link href="{{ asset('templates/matrix-admin/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('templates/matrix-admin/assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<style type="text/css">
	#date {cursor: pointer!important;}
</style>

@endsection