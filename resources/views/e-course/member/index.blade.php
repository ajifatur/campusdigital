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
                <h4 class="page-title">Materi E-Course</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/member">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Materi E-Course</li>
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
                                <h5 class="mb-0">Materi E-Course</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
						<div class="col-12">
							<div class="row">
                                @foreach($chapter as $data)
                                    <a class="col-md-6 col-lg-3 col-xlg-3 {{ $data->voucher != '' ? session()->get('id_cc') != $data->id_cc ? 'btn-voucher' : '' : '' }}" href="/member/e-course/chapter/{{ $data->chapter_nomor }}" data-id="{{ $data->id_cc }}">
                                        <div class="card card-hover shadow">
                                            <div class="box text-center">
                                                <img src="{{ $data->chapter_icon != '' ? asset('assets/images/chapter/'.$data->chapter_icon) : asset('assets/images/default/chapter.png') }}" height="100">
                                                <h6 class="text-dark mt-2">{{ $data->chapter_judul }}</h6>
											    <p class="mb-0 text-secondary">({{ count_videos($data->id_cc) }} video)</p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
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

<!-- Modal Voucher -->
<div class="modal fade" id="modal-voucher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Voucher</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				@if(Session::get('message'))
				<div class="alert alert-danger text-center">
					{{ Session::get('message') }}
				</div>
				@endif
				<div class="alert alert-warning text-center">
					Masukkan kode voucher yang Anda miliki untuk mengakses konten ini.
				</div>
				<form id="form-voucher" method="post" action="/member/e-course/voucher">
					{{ csrf_field() }}
					<input type="hidden" name="id" value="{{ Session::get('id_cc') }}">
					<div class="form-group">
						<label>Kode Voucher</label>
						<input type="text" name="voucher" class="form-control" required>
					</div>
					<div class="form-group">
                		<button type="submit" class="btn btn-success">Submit</button>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Voucher -->

@endsection

@section('js-extra')

<script>
	@if(Session::get('message'))
	$("#modal-voucher").modal("show");
	@endif
	
	// Button voucher
	$(document).on("click", ".btn-voucher", function(e){
		e.preventDefault();
		var id = $(this).data("id");
		$("#form-voucher input[name=id]").val(id);
		$("#modal-voucher").modal("show");
	});
</script>

@endsection

@section('css-extra')

<style type="text/css">
	.box {background-color: #fff!important; cursor: pointer;}
</style>

@endsection