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
                            <li class="breadcrumb-item"><a href="/admin/file-manager">File Manager</a></li>
                            <li class="breadcrumb-item"><a href="/admin/file-manager/{{ generate_permalink($kategori->folder_kategori) }}">{{ $kategori->folder_kategori }}</a></li>
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
            <div class="col-lg-6 mx-auto">
                <!-- card -->
                <div class="card shadow">
                    <h5 class="card-title border-bottom">Tambah Video</h5>
                    <div class="card-body">
                        <form id="form" method="post" action="/admin/file-manager/{{ generate_permalink($kategori->folder_kategori) }}/store" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="folder_parent" value="{{ $directory->id_folder }}">
                            <input type="hidden" name="file_kategori" value="{{ $kategori->id_fk }}">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Judul Video <span class="text-danger">*</span></label>
                                    <input type="text" name="file_nama" class="form-control {{ $errors->has('file_nama') ? 'is-invalid' : '' }}" value="{{ old('file_nama') }}" placeholder="Masukkan Judul Video">
                                    @if($errors->has('file_nama'))
                                    <small class="text-danger">{{ ucfirst($errors->first('file_nama')) }}</small>
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
                                    <label>Deskripsi</label>
                                    <textarea name="file_deskripsi" class="form-control {{ $errors->has('file_deskripsi') ? 'is-invalid' : '' }}" rows="3" placeholder="Masukkan Deskripsi">{{ old('file_deskripsi') }}</textarea>
                                    @if($errors->has('file_deskripsi'))
                                    <small class="text-danger">{{ ucfirst($errors->first('file_deskripsi')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Kode YouTube <span class="text-danger">*</span></label>
                                    <input type="text" name="file_konten" class="form-control {{ $errors->has('file_konten') ? 'is-invalid' : '' }}" value="{{ old('file_konten') }}" placeholder="Masukkan Kode YouTube">
                                    @if($errors->has('file_konten'))
                                    <small class="text-danger">{{ ucfirst($errors->first('file_konten')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Kode Embed Google Slide</label>
                                    <textarea name="file_keterangan" class="form-control {{ $errors->has('file_keterangan') ? 'is-invalid' : '' }}" rows="3" placeholder="Masukkan Kode Embed">{{ old('file_keterangan') }}</textarea>
                                    @if($errors->has('file_keterangan'))
                                    <small class="text-danger">{{ ucfirst($errors->first('file_keterangan')) }}</small>
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
        viewport: {width: 640, height: 360},
        boundary: {width: 640, height: 360}
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
            size: {width: 640, height: 360}
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