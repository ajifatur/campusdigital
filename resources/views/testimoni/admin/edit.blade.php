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
                <h4 class="page-title">Edit Testimoni</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Konten Web</a></li>
                            <li class="breadcrumb-item"><a href="/admin/konten-web/testimoni">Testimoni</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Testimoni</li>
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
            <div class="col-lg-6 mx-auto">
                <!-- card -->
                <div class="card shadow">
                    <h5 class="card-title border-bottom">Edit Testimoni</h5>
                    <div class="card-body">
                        <form id="form" method="post" action="/admin/konten-web/testimoni/update" enctype="multipart/form-data">
                            {{ csrf_field() }}
							<input type="hidden" name="id" value="{{ $testimoni->id_testimoni }}">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Nama Klien <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_klien" class="form-control {{ $errors->has('nama_klien') ? 'is-invalid' : '' }}" value="{{ $testimoni->klien }}" placeholder="Masukkan Nama Klien">
                                    @if($errors->has('nama_klien'))
                                    <small class="text-danger">{{ ucfirst($errors->first('nama_klien')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Foto Klien</label>
									<br>
									<input type="file" id="file" class="d-none" accept="image/*">
									<button class="btn btn-sm btn-primary btn-file"><i class="fa fa-folder-open mr-2"></i>Pilih Gambar...</button>
									<br>
									<img id="img-file" src="{{ $testimoni->foto_klien != '' ? asset('assets/images/testimoni/'.$testimoni->foto_klien) : '' }}" class="mt-2 img-thumbnail {{ $testimoni->foto_klien != '' ? '' : 'd-none' }}" style="max-height: 150px">
									<input type="hidden" name="gambar" id="src-img">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Profesi Klien <span class="text-danger">*</span></label>
                                    <input type="text" name="profesi_klien" class="form-control {{ $errors->has('profesi_klien') ? 'is-invalid' : '' }}" value="{{ $testimoni->profesi_klien }}" placeholder="Masukkan Profesi Klien">
                                    @if($errors->has('profesi_klien'))
                                    <small class="text-danger">{{ ucfirst($errors->first('profesi_klien')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Testimoni <span class="text-danger">*</span></label>
                                    <textarea name="testimoni" class="form-control {{ $errors->has('testimoni') ? 'is-invalid' : '' }}" rows="5" placeholder="Masukkan Testimoni">{{ $testimoni->testimoni }}</textarea>
                                    @if($errors->has('testimoni'))
                                    <small class="text-danger">{{ ucfirst($errors->first('testimoni')) }}</small>
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
<script type="text/javascript">
    /* Croppie */
    var demo = $('#demo').croppie({
        viewport: {width: 500, height: 500},
        boundary: {width: 500, height: 500}
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

	// Crop Image
    $(document).on("click", "#btn-crop", function(e){
        demo.croppie("result", {
            type: "base64",
            format: "jpeg",
            size: {width: 600, height: 600}
        }).then(function(response){
			$("#img-file").attr("src",response).removeClass("d-none");
            $("input[name=gambar]").val(response);
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