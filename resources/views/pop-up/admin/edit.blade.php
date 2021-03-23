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
		'title' => 'Edit Pop-up',
		'items' => [
			['text' => 'Pop-up', 'url' => '/admin/pop-up'],
			['text' => 'Edit Pop-up', 'url' => '#'],
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
                    <form id="form" method="post" action="/admin/pop-up/update" enctype="multipart/form-data">
                        <div class="card-body">
                            @if(Session::get('message') != null)
                                <div class="alert alert-success alert-dismissible mb-4 fade show" Blog="alert">
                                    {{ Session::get('message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            {{ csrf_field() }}
							<input type="hidden" name="id" value="{{ $popup->id_popup }}">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Judul <span class="text-danger">*</span></label>
									<input type="text" name="judul" class="form-control {{ $errors->has('judul') ? 'is-invalid' : '' }}" placeholder="Masukkan Judul" value="{{ $popup->popup_judul }}">
                                    @if($errors->has('judul'))
                                    <small class="text-danger">{{ ucfirst($errors->first('judul')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
									<div class="row">
										<div class="col-md-6">
											<label>Waktu Aktif Pop-up <span class="text-danger">*</span></label>
											<input type="text" name="waktu_aktif" id="daterangepicker" class="form-control {{ $errors->has('waktu_aktif') ? 'is-invalid' : '' }}" placeholder="Masukkan Waktu Aktif Pop-up" value="{{ $glue }}">
											@if($errors->has('waktu_aktif'))
											<small class="text-danger">{{ ucfirst($errors->first('waktu_aktif')) }}</small>
											@endif
										</div>
									</div>
                                </div>
                                <div class="form-group col-md-12">
									<div class="row">
										<div class="col-md-6">
											<label>Tipe <span class="text-danger">*</span></label>
											<br>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" name="tipe" id="inlineRadio1" value="1" {{ !filter_var($popup->popup_gambar, FILTER_VALIDATE_URL) ? 'checked' : '' }}>
												<label class="form-check-label" for="inlineRadio1">Gambar</label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" name="tipe" id="inlineRadio2" value="2" {{ filter_var($popup->popup_gambar, FILTER_VALIDATE_URL) ? 'checked' : '' }}>
												<label class="form-check-label" for="inlineRadio2">Video</label>
											</div>
											@if($errors->has('tipe'))
											<br>
											<small class="text-danger">{{ ucfirst($errors->first('tipe')) }}</small>
											@endif
										</div>
									</div>
                                </div>
                                <div class="form-group col-md-12 {{ !filter_var($popup->popup_gambar, FILTER_VALIDATE_URL) ? '' : 'd-none' }}" id="input-gambar">
                                    <label>Gambar <span class="text-danger">*</span></label>
									<br>
									<input type="file" name="gambar" id="file" class="d-none" accept="image/*">
									<button class="btn btn-primary" id="btn-upload"><i class="fa fa-folder-open mr-2"></i>Upload</button>
									<br>
									<input type="hidden" name="gambar_src" value="{{ $popup->popup_gambar }}">
									<img class="img-thumbnail mt-3" src="{{ asset('assets/images/pop-up/'.$popup->popup_gambar) }}" id="img-upload" style="max-height: 250px;">
                                    @if($errors->has('gambar'))
                                    <div class="small mt-2 text-danger">{{ ucfirst($errors->first('gambar')) }}</div>
                                    @endif
                                </div>
                                <div class="form-group col-md-12 {{ filter_var($popup->popup_gambar, FILTER_VALIDATE_URL) ? '' : 'd-none' }}" id="input-video">
									<div class="row">
										<div class="col-md-6">
											<label>URL Video <span class="text-danger">*</span></label>
											<input type="text" name="video" class="form-control {{ $errors->has('video') ? 'is-invalid' : '' }}" placeholder="Masukkan URL Video" value="{{ $popup->popup_gambar }}">
											@if($errors->has('video'))
											<small class="text-danger">{{ ucfirst($errors->first('video')) }}</small>
											@endif
										</div>
									</div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Konten <span class="text-danger">*</span></label>
                                    <textarea name="konten" id="konten" class="d-none"></textarea>
                                    <div id="editor">{!! html_entity_decode($popup->popup_konten) !!}</div> 
                                    @if($errors->has('konten'))
                                    <small class="text-danger">{{ ucfirst($errors->first('konten')) }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="border-top">
                            <button id="btn-submit" type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
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

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script type="text/javascript">
	// Daterangepicker
	$("#daterangepicker").daterangepicker({
		locale: {
			format: 'DD/MM/YYYY'
		}
	});

	// Tipe Change
    $(document).on("change", "input[name=tipe]", function(){
		var value = $(this).val();
		if(value == 1){
			$("#input-gambar").removeClass("d-none");
			$("#input-video").addClass("d-none");
		}
		else if(value == 2){
			$("#input-gambar").addClass("d-none");
			$("#input-video").removeClass("d-none");
		}
    });
	
    // Quill Editor
    var toolbarOptions = [
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'script': 'sub'}, { 'script': 'super' }],
        ['link', 'image', 'video'],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'align': [] }],
        [{ 'indent': '-1'}, { 'indent': '+1' }],
        [{ 'direction': 'rtl' }],
        [{ 'color': [] }, { 'background': [] }],
        ['clean']     
    ];

    var quill = new Quill('#editor', {
        modules: {
            toolbar: toolbarOptions
        },
        placeholder: 'Tulis sesuatu...',
        theme: 'snow',
        imageResize: {
            displayStyles: {
                backgroundColor: 'black',
                border: 'none',
                color: 'white'
            },
            modules: [ 'Resize', 'DisplaySize', 'Toolbar' ]
        }
    });
	
	/* Upload File */
	$(document).on("click", "#btn-upload", function(e){
		e.preventDefault();
		$("#file").trigger("click");
	});

	// File Change
    $(document).on("change", "#file", function(){
		readURL(this);
    });

    function readURL(input){
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function(e){
				$("input[name=gambar_src]").val("1");
                $("#img-upload").attr("src",e.target.result).removeClass("d-none");
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
	
    // Button Submit
    $(document).on("click", "#btn-submit", function(e){
        var myEditor = document.querySelector('#editor');
        var html = myEditor.children[0].innerHTML;
        $("#konten").text(html);
        $("#form").submit();
    });
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style type="text/css">
    #editor {height: 500px;}
	.ql-editor h1, .ql-editor h2, .ql-editor h3, .ql-editor h4, .ql-editor h5, .ql-editor h6, .ql-editor p {margin-bottom: 1rem!important;}
</style>

@endsection