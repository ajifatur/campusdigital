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
		'title' => 'Tambah Artikel',
		'items' => [
			['text' => 'Artikel', 'url' => '/admin/artikel'],
			['text' => 'Tambah Artikel', 'url' => '#'],
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
                    <form id="form" method="post" action="/admin/artikel/store" enctype="multipart/form-data">
                        <div class="card-body">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Judul <span class="text-danger">*</span></label>
                                    <input type="text" name="judul_artikel" class="form-control {{ $errors->has('judul_artikel') ? 'is-invalid' : '' }}" value="{{ old('judul_artikel') }}" placeholder="Masukkan Judul Artikel">
                                    @if($errors->has('judul_artikel'))
                                    <small class="text-danger">{{ ucfirst($errors->first('judul_artikel')) }}</small>
                                    @endif
                                </div>
								<div class="form-group col-lg-4 col-md-6">
									<label>Kategori <span class="text-danger">*</span></label>
									<select name="kategori" class="form-control {{ $errors->has('kategori') ? 'is-invalid' : '' }}" >
										<option value="" disabled selected>--Pilih--</option>
										@foreach($kategori as $data)
										<option value="{{ $data->id_ka }}" {{ old('kategori') == $data->id_ka ? 'selected' : '' }}>{{ $data->kategori }}</option>
										@endforeach
									</select>
									@if($errors->has('kategori'))
									<small class="text-danger">{{ ucfirst($errors->first('kategori')) }}</small>
									@endif
								</div>
                                <div class="form-group col-md-12">
                                    <label>Gambar</label>
									<br>
									<input type="file" id="file" class="d-none" accept="image/*">
									<button class="btn btn-sm btn-primary btn-file"><i class="fa fa-folder-open mr-2"></i>Pilih Gambar...</button>
									<br>
									<img id="img-file" class="mt-2 img-thumbnail d-none" style="max-height: 150px">
									<input type="hidden" name="gambar" id="src-img">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Tag</label>
                                    <br>
                                    <input type="text" name="tag" data-role="tagsinput" class="form-control {{ $errors->has('tag') ? 'is-invalid' : '' }}" value="{{ old('tag') }}" placeholder="Masukkan Tag">
                                    @if($errors->has('tag'))
                                    <small class="text-danger">{{ ucfirst($errors->first('tag')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Konten <span class="text-danger">*</span></label>
                                    <textarea name="konten" id="konten" class="d-none"></textarea>
                                    <div id="editor"></div> 
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

<!-- Modal Croppie -->
<div class="modal fade" id="modalCroppie" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Crop Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				<div class="table-responsive">
                	<div id="demo" class="mt-3"></div>
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn-crop">Crop and Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Croppie -->

@endsection

@section('js-extra')

<script type="text/javascript" src="{{ asset('assets/plugins/croppie/croppie.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g==" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/typeahead/typeahead.js') }}"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script type="text/javascript">
    /* Croppie */
    var demo = $('#demo').croppie({
        viewport: {width: 500, height: 333},
        boundary: {width: 500, height: 333}
    });
    var imageURL;
	
    // Button File
    $(document).on("click", ".btn-file", function(e){
		e.preventDefault();
        $("#file").trigger("click");
    });
	
    // Change Input File
    $(document).on("change", "#file", function(){
        readURL(this);
        $("#modalCroppie").modal("show");
    });
	
	// Show Modal Croppie
    $('#modalCroppie').on('shown.bs.modal', function(){
        demo.croppie('bind', {
            url: imageURL
        }).then(function(){
            console.log('jQuery bind complete');
        });
    });
	
	// Hide Modal Croppie
    $('#modalCroppie').on('shown.bs.hidden', function(){
		$("#img-file").removeAttr("src");
        $("input[name=gambar]").val("");
        $("#file").val(null);
    });

	// Crop Image
    $(document).on("click", "#btn-crop", function(e){
        demo.croppie("result", {
            type: "base64",
            format: "jpg",
            size: {width: 1000, height: 667}
        }).then(function(response){
			$("#img-file").attr("src",response).removeClass("d-none");
            $("input[name=gambar]").val(response);
        });
        $("#file").val(null);
        $("#modalCroppie").modal("hide");
    });

    function readURL(input){
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function(e){
                imageURL = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

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

    var substringMatcher = function(strs) {
        return function findMatches(q, cb) {
            var matches, substringRegex;

            // an array that will be populated with substring matches
            matches = [];

            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');

            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function(i, str) {
            if (substrRegex.test(str)) {
                matches.push(str);
            }
            });

            cb(matches);
        };
    };

    $("input[name=tag]").tagsinput({
        typeaheadjs: {
            source: substringMatcher({!! json_tag() !!})
        }
    });

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

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/croppie/croppie.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" />
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style type="text/css">
    .bootstrap-tagsinput {width: 100%!important;}
    .tt-menu {background-color: #fff!important; width: 100%; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15)!important; -webkit-box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15)!important}
    .tt-suggestion {padding: .5rem; cursor: pointer;}
    .tt-suggestion:hover {background-color: #e5e5e5;}
    #editor {height: 400px;}
	.ql-editor h1, .ql-editor h2, .ql-editor h3, .ql-editor h4, .ql-editor h5, .ql-editor h6, .ql-editor p {margin-bottom: 1rem!important;}
</style>

@endsection