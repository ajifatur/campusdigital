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
                <h4 class="page-title">Peserta Pelatihan</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/member">Home</a></li>
                            <li class="breadcrumb-item"><a href="/member/pelatihan">Pelatihan</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Peserta Pelatihan</li>
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
                                <h5 class="mb-0">Peserta Pelatihan: {{ $pelatihan->nama_pelatihan }}</h5>
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
                                        <th>Nama</th>
                                        <th width="150">Kode Sertifikat</th>
                                        <th width="100">Status</th>
                                        <th width="150">Tanggal Mendaftar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($pelatihan_member as $data)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $data->nama_user }}</td>
										<td>{{ $data->kode_sertifikat }}</td>
										<td>
											<select class="form-control form-control-sm select-status" data-id="{{ $data->id_pm }}">
												<option value="1" {{ $data->status_pelatihan == 1 ? 'selected' : '' }}>Lulus</option>
												<option value="11" {{ $data->status_pelatihan == 11 ? 'selected' : '' }}>Lulus (A: Sangat Baik)</option>
												<option value="12" {{ $data->status_pelatihan == 12 ? 'selected' : '' }}>Lulus (B: Baik)</option>
												<option value="13" {{ $data->status_pelatihan == 13 ? 'selected' : '' }}>Lulus (C: Cukup)</option>
												<option value="0" {{ $data->status_pelatihan == 0 ? 'selected' : '' }}>Belum Lulus</option>
											</select>
										</td>
                                        <td>{{ date('Y-m-d H:i:s', strtotime($data->pm_at)) }}</td>
                                    </tr>
                                    @php $i++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
						<form id="form" class="d-none" method="post" action="/member/pelatihan/update-status">
							{{ csrf_field() }}
							<input type="hidden" name="id" id="id">
							<input type="hidden" name="status" id="status">
						</form>
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
	
    // Change Status
    $(document).on("change", ".select-status", function(e){
        e.preventDefault();
        var id = $(this).data("id");
		$("#id").val(id);
		$("#status").val($(this).val());
		$.ajax({
			type: "post",
			url: "/member/pelatihan/update-status",
			data: {_token: "{{ csrf_token() }}", id: id, status: $(this).val()},
			success: function(response){
				alert(response);
			}
		});
		// $("#form").submit();
    });
</script>

@endsection

@section('css-extra')

<link href="{{ asset('templates/matrix-admin/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<style type="text/css">
    .border-top, .border-bottom {padding: 1.25rem;}
    .form-control {border-color: #caccce;}
    .input-group-text {border-color: #caccce;}
	.box {background-color: #fdd100!important; cursor: pointer;}
</style>

@endsection