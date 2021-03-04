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
                            <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
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
            <!-- column -->
            <div class="col-lg-12">
                <!-- card -->
                <div class="card shadow">
                    <h5 class="card-title border-bottom">Pelatihan</h5>
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
                            <table id="table-arsip-pelatihan" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="40">No.</th>
                                        <th width="80">Invoice</th>
                                        <th width="100">Tanggal</th>
                                        <th>Pelatihan</th>
                                        <th width="150">Jumlah (Rp.)</th>
                                        <th width="80">Status</th>
                                        <th width="40">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($pelatihan_member as $data)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $data->inv_pelatihan }}</td>
                                        <td><span title="{{ date('d/m/Y H:i:s', strtotime($data->pm_at)) }}" style="text-decoration: underline; cursor: help;">{{ date('d/m/Y', strtotime($data->pm_at)) }}</span></td>
                                        <td>
                                            <a href="/member/pelatihan/detail/{{ $data->id_pelatihan }}">{{ $data->nama_pelatihan }}</a>
                                            <br>
                                            <small>{{ $data->nomor_pelatihan }}</small>
                                        </td>
                                        <td>
                                            {{ $data->fee > 0 ? number_format($data->fee,0,',','.') : 'Free' }}
                                        </td>
                                        <td>
                                            @if($data->fee_status == 1)
                                                <strong class="text-success">Diterima</strong>
                                            @else
                                                @if($data->fee_bukti != '')
                                                    <a href="#" class="btn btn-success btn-sm btn-block btn-verify" data-id="{{ $data->id_pm }}" data-proof="{{ asset('assets/images/fee-pelatihan/'.$data->fee_bukti) }}" data-toggle="modal" data-target="#modal-verify" title="Verifikasi Pembayaran"><i class="fa fa-check"></i></a>
                                                @else
                                                    <strong class="text-danger">User Belum Membayar</strong>
                                                @endif
                                            @endif
                                        </td>
                                        <td align="center">
                                            @if($data->fee_bukti != '')
                                                <a href="{{ asset('assets/images/fee-pelatihan/'.$data->fee_bukti) }}" class="btn btn-success btn-sm btn-block image-popup-vertical-fit" title="Bukti Transfer"><i class="fa fa-image"></i></a>
                                            @else
                                                <strong class="text-danger"><i class="fa fa-times"></i></strong>
                                            @endif
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
    @include('template/member/_footer')
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->

@endsection

@section('js-extra')

<script src="{{ asset('templates/matrix-admin/assets/extra-libs/DataTables/datatables.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.22/sorting/datetime-moment.js"></script>
<script src="{{ asset('templates/matrix-admin/assets/libs/magnific-popup/dist/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('templates/matrix-admin/assets/libs/magnific-popup/meg.init.js') }}"></script>
<script type="text/javascript">
    // DataTable
	$.fn.dataTable.moment("DD/MM/YYYY");
    $('#table-arsip-pelatihan').DataTable({
		"fnDrawCallback": function(){
			$('.image-popup-vertical-fit').magnificPopup({
				type: 'image',
				closeOnContentClick: true,
				closeBtnInside: false,
				fixedContentPos: true,
				image: {
				  verticalFit: true
				},
			});
		}
	});
</script>

@endsection

@section('css-extra')

<link href="{{ asset('templates/matrix-admin/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('templates/matrix-admin/assets/libs/magnific-popup/dist/magnific-popup.css') }}" rel="stylesheet">

@endsection