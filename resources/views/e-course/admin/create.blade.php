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
                <h4 class="page-title">Tambah Video</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item"><a href="/admin/e-course">Materi E-Course</a></li>
                            <li class="breadcrumb-item"><a href="/admin/e-course">Chapter</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Video</li>
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
                    <h5 class="card-title border-bottom">Tambah Video</h5>
                    <div class="card-body">
                        <form id="form" method="post" action="/admin/e-course/store" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="chapter" value="{{ $chapter->id_cc }}">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Nomor <span class="text-danger">*</span></label>
                                    <select name="course_nomor" class="form-control {{ $errors->has('course_nomor') ? 'is-invalid' : '' }}">
										<option value="" disabled selected>--Pilih Nomor Video--</option>
                                        @for($i=1; $i<=100; $i++)
										<option value="{{ $i }}" {{ in_array($i, $array) ? 'disabled' : '' }}>#{{ $i }}</option>
                                        @endfor
									</select>
                                    @if($errors->has('course_nomor'))
                                    <small class="text-danger">{{ ucfirst($errors->first('course_nomor')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-8">
                                    <label>Judul <span class="text-danger">*</span></label>
                                    <input type="text" name="judul" class="form-control {{ $errors->has('judul') ? 'is-invalid' : '' }}" value="{{ old('judul') }}" placeholder="Masukkan Judul">
                                    @if($errors->has('judul'))
                                    <small class="text-danger">{{ ucfirst($errors->first('judul')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Thumbnail</label>
									<br>
									<input type="file" id="file" class="d-none" accept="image/*">
									<button class="btn btn-sm btn-primary btn-file"><i class="fa fa-folder-open mr-2"></i>Pilih Gambar...</button>
                                    <div class="mt-2 text-muted">Resolusi gambar direkomendasikan 16:9</div>
									<img id="img-file" class="mt-2 img-thumbnail d-none" style="max-height: 150px">
									<input type="hidden" name="thumbnail" id="src-img">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Caption <span class="text-danger">*</span></label>
                                    <textarea name="caption" class="form-control {{ $errors->has('caption') ? 'is-invalid' : '' }}" rows="3" placeholder="Masukkan Caption"></textarea>
                                    @if($errors->has('caption'))
                                    <small class="text-danger">{{ ucfirst($errors->first('caption')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Kode YouTube <span class="text-danger">*</span></label>
                                    <input type="text" name="kode_youtube" class="form-control {{ $errors->has('kode_youtube') ? 'is-invalid' : '' }}" value="{{ old('kode_youtube') }}" placeholder="Masukkan Kode YouTube">
                                    @if($errors->has('kode_youtube'))
                                    <small class="text-danger">{{ ucfirst($errors->first('kode_youtube')) }}</small>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="border-top">
                        <button id="btn-submit" type="submit" class="btn btn-success">Simpan</button>
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

<!-- Modal Croppie -->
<div class="modal fade" id="modalCroppie" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
<script type="text/javascript">
    /* Croppie */
    var demo = $('#demo').croppie({
        viewport: {width: 848, height: 480},
        boundary: {width: 848, height: 480}
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
        $("input[name=thumbnail]").val("");
        $("#file").val(null);
    });

	// Crop Image
    $(document).on("click", "#btn-crop", function(e){
        demo.croppie("result", {
            type: "base64",
            format: "jpg",
            size: {width: 848, height: 480}
        }).then(function(response){
			$("#img-file").attr("src",response).removeClass("d-none");
            $("input[name=thumbnail]").val(response);
        });
        $("#file").val(null);
        $("#modalCroppie").modal("hide");
    });

    // Button Submit
    $(document).on("click", "#btn-submit", function(e){
        $("#form").submit();
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
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/croppie/croppie.css') }}">

@endsection