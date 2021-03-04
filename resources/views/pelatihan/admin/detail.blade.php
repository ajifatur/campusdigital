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
            <div class="col-lg-3 col-md-5">
                <!-- card -->
                <div class="card shadow">
                    <div class="card-body">
                        <p class="h5">Nomor:</p>
                        <p>{{ $pelatihan->nomor_pelatihan }}</p>
                        <br>
                        <p class="h5">Waktu Pelatihan:</p>
                        <p>
							{{ generate_date_range('join', $pelatihan->tanggal_pelatihan_from.' - '.$pelatihan->tanggal_pelatihan_to)['from'] }} s.d. {{ generate_date_range('join', $pelatihan->tanggal_pelatihan_from.' - '.$pelatihan->tanggal_pelatihan_to)['to'] }}
						</p>
                        <br>
                        <p class="h5">Trainer:</p>
                        <p>{{ $pelatihan->nama_user }}</p>
                    </div>
                </div>
                <!-- card -->
            </div>
            <!-- column -->
            <!-- column -->
            <div class="col-lg-9 col-md-7">
                <!-- card -->
                <div class="card shadow">
                    <div class="card-body">
                        <div class="ql-snow"><div class="ql-editor p-0">{!! html_entity_decode($pelatihan->deskripsi_pelatihan) !!}</div></div>
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

@endsection

@section('css-extra')

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style type="text/css">
	/* Quill */
	.ql-editor h1, .ql-editor h2, .ql-editor h3, .ql-editor h4, .ql-editor h5, .ql-editor h6, .ql-editor p {margin-bottom: 1rem!important;}
	.ql-editor ol li {font-size: 14px!important; color: #74757f!important; padding-left: 5px!important;}
</style>

@endsection