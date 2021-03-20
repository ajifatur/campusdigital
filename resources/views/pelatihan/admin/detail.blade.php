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
                <h4 class="page-title">Pelatihan: {{ $pelatihan->nama_pelatihan }}</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item"><a href="/admin/pelatihan">Pelatihan</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $pelatihan->nama_pelatihan }}</li>
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
            <div class="col-lg-4 col-md-5">
                <!-- card -->
                <div class="card shadow">
                    <div class="card-body">
                        <img src="{{ $pelatihan->thumbnail_pelatihan != '' ? asset('assets/images/pelatihan/'.$pelatihan->thumbnail_pelatihan) : asset('assets/images/default/pelatihan.jpg') }}" class="img-fluid img-thumbnail" alt="Gambar">
                    </div>
                </div>
                <!-- card -->
            </div>
            <!-- column -->
            <!-- column -->
            <div class="col-lg-8 col-md-7">
                <!-- card -->
                <div class="card shadow">
                    <div class="card-body">
                        <ul class="list-group list-group-flush mb-4">
                            <li class="list-group-item d-md-flex justify-content-between">
                                <span><label>Nomor:</label></span>
                                <span>{{ $pelatihan->nomor_pelatihan }}</span>
                            </li>
                            <li class="list-group-item d-md-flex justify-content-between">
                                <span><label>Waktu Pelatihan:</label></span>
                                <span>{{ generate_date_range('join', $pelatihan->tanggal_pelatihan_from.' - '.$pelatihan->tanggal_pelatihan_to)['from'] }} s.d. {{ generate_date_range('join', $pelatihan->tanggal_pelatihan_from.' - '.$pelatihan->tanggal_pelatihan_to)['to'] }}</span>
                            </li>
                            <li class="list-group-item d-md-flex justify-content-between">
                                <span><label>Trainer:</label></span>
                                <span>{{ $pelatihan->nama_user }}</span>
                            </li>
                            <li class="list-group-item d-md-flex justify-content-between">
                                <span><label>Biaya Pendaftaran:</label></span>
                                <span>{{ $pelatihan->fee_member != 0 ? 'Rp '.number_format($pelatihan->fee_member,0,'.','.') : 'Gratis' }}</span>
                            </li>
                        </ul>
                        <div class="pelatihan-deskripsi">
                            <label>Deskripsi:</label>
                            <div class="ql-snow"><div class="ql-editor p-0">{!! html_entity_decode($pelatihan->deskripsi_pelatihan) !!}</div></div>
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

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script type="text/javascript">
    // Button Daftar Pelatihan
    $(document).on("click", ".btn-pelatihan", function(e){
        e.preventDefault();
		$("#modalPendaftaran").modal("show");
		//$("#form").submit();
    });
	
	// Upload Bukti Pembayaran
	$(document).on("click", "#btn-upload", function(e){
        e.preventDefault();
		$("#file").trigger("click");
	});
	
    function readURL(input){
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function(e){
                $("#foto").attr("src",e.target.result).removeClass("d-none");
				$("#btn-submit-confirmation").removeAttr("disabled");
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
	
	$(document).on("change", "#file", function(){
		readURL(this);
	});
	
    // Button Submit Daftar Pelatihan
    $(document).on("click", "#btn-submit-confirmation", function(e){
        e.preventDefault();
		$("#form-register").submit();
    });
</script>

@endsection

@section('css-extra')

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style type="text/css">
    .border-top, .border-bottom {padding: 1.25rem;}
    .form-control {border-color: #caccce;}
    .pelatihan-deskripsi {padding: 0 1.25rem;}

	/* Quill */
    .ql-editor {white-space: normal;}
	.ql-editor h2, .ql-editor h3 {margin-bottom: 1rem!important; font-weight: 600!important;}
	.ql-editor p {margin-bottom: 1rem!important;}
	.ql-editor ol {padding-left: 30px!important;}
	.ql-editor ol li {font-size: 14px!important; color: #74757f!important; padding-left: 5px!important;}
</style>

@endsection