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
		'title' => 'Detail Pop-up',
		'items' => [
			['text' => 'Pop-up', 'url' => '/admin/pop-up'],
			['text' => 'Detail Pop-up', 'url' => '#'],
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
                    <div class="card-body">
						<div class="row">
							<div class="col-lg-auto">
								<img src="{{ asset('assets/images/pop-up/'.$popup->popup_gambar) }}" class="img-thumbnail" style="max-width: 300px">
							</div>
							<div class="col-lg mt-3 mt-lg-0">
								<strong>Judul:</strong>
                                <p>{{ $popup->popup_judul }}</p>
								<p>{{ generate_date(date('Y-m-d', strtotime($popup->popup_from))) }} sampai {{ generate_date(date('Y-m-d', strtotime($popup->popup_to))) }}.</p>
								<strong>Waktu:</strong>
								<p>{{ generate_date(date('Y-m-d', strtotime($popup->popup_from))) }} sampai {{ generate_date(date('Y-m-d', strtotime($popup->popup_to))) }}.</p>
								<strong>Deskripsi:</strong>
								<div class="ql-snow"><div class="ql-editor p-0">{!! html_entity_decode($popup->popup_konten) !!}</div></div>
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
	.ql-editor h1, .ql-editor h2, .ql-editor h3, .ql-editor h4, .ql-editor h5, .ql-editor h6, .ql-editor p {margin-bottom: 1rem!important;}
</style>

@endsection