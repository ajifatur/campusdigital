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
                <h4 class="page-title">Detail Aktivitas</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Statistik</a></li>
                            <li class="breadcrumb-item"><a href="#">Aktivitas</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Aktivitas</li>
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
            <div class="col-lg-4">
                <!-- card -->
                <div class="card shadow">
                    <div class="card-title border-bottom">
                        <div class="row">
                            <div class="col-12 col-sm py-1 mb-2 mb-sm-0 text-center text-sm-left">
                                <h5 class="mb-0">Data User</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>User:</label>
                                <div>{{ $user->nama_user }}</div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Kunjungan:</label>
                                <div>{{ number_format(count_visits($user->id_user),0,'.','.') }}x</div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Login Terakhir:</label>
                                <div>{{ generate_date(date('Y-m-j', strtotime($user->last_visit))) }} pukul {{ date('H:i:s', strtotime($user->last_visit)) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- card -->
            </div>
            <!-- column -->

            <!-- column -->
            <div class="col-lg-8">
                <!-- card -->
                <div class="card shadow">
                    <div class="card-title border-bottom">
                        <div class="row">
                            <div class="col-12 col-sm py-1 mb-2 mb-sm-0 text-center text-sm-left">
                                <h5 class="mb-0">Detail Aktivitas</h5>
                            </div>
							<div class="col-12 col-sm-auto text-center text-sm-left">
								<select id="login" class="form-control form-control-sm">
									@foreach($all_aktivitas as $data)
									<option value="{{ $data->id_aktivitas }}" {{ $login == $data->id_aktivitas ? 'selected' : '' }}>{{ date('d/m/Y H:i:s', strtotime($data->aktivitas_at)) }}</option>
									@endforeach
								</select>
							</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="40">No.</th>
                                        <th width="150">Waktu</th>
                                        <th>URL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
									@foreach($aktivitas->aktivitas as $row)
									<tr>
										<td>{{ $i }}</td>
										<td>{{ date('d/m/Y H:i:s', strtotime($row['time'])) }}</td>
										<td><a href="{{ URL::to('/') }}{{ $row['path'] }}" target="_blank">{{ URL::to('/') }}{{ $row['path'] }}</a></td>
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
	$.fn.dataTable.moment("DD/MM/YYYY HH:mm:ss");
    $('#table').DataTable({
        "order": [[ 1, "desc" ]]
    });
    
    // Change Value
    $(document).on("change", "#login", function(){
        var login = $("#login").val();
        window.location.href = '/admin/statistik/aktivitas/{{ $user->id_user }}?login='+login;
    });
</script>

@endsection

@section('css-extra')

<link href="{{ asset('templates/matrix-admin/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<style type="text/css">
    .table td, .table th {padding: .5rem;}
</style>

@endsection