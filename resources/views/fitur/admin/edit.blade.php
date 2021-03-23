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
		'title' => 'Edit Fitur',
		'items' => [
			['text' => 'Konten Web', 'url' => '/admin/konten-web'],
			['text' => 'Fitur', 'url' => '/admin/konten-web/fitur'],
			['text' => 'Edit Fitur', 'url' => '#'],
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
            <div class="col-lg-6 mx-auto">
                <!-- card -->
                <div class="card shadow">
                    <form id="form" method="post" action="/admin/konten-web/fitur/update" enctype="multipart/form-data">
                        <div class="card-body">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $fitur->id_fitur }}">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Nama Fitur</label>
                                    <input type="text" name="nama_fitur" class="form-control {{ $errors->has('nama_fitur') ? 'is-invalid' : '' }}" value="{{ $fitur->nama_fitur }}" placeholder="Masukkan Nama Fitur">
                                    @if($errors->has('nama_fitur'))
                                    <small class="text-danger">{{ ucfirst($errors->first('nama_fitur')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Keterangan Fitur</label>
                                    <textarea name="keterangan_fitur" class="form-control {{ $errors->has('keterangan_fitur') ? 'is-invalid' : '' }}" placeholder="Masukkan Keterangan Fitur">{{ $fitur->keterangan_fitur }}</textarea>
                                    @if($errors->has('keterangan_fitur'))
                                    <small class="text-danger">{{ ucfirst($errors->first('keterangan_fitur')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>URL</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text {{ $errors->has('url_fitur') ? 'border-danger' : '' }}">{{ URL::to('/') }}/member/</span>
                                        </div>
                                        <input type="text" name="url_fitur" class="form-control {{ $errors->has('url_fitur') ? 'border-danger' : '' }}" value="{{ $fitur->url_fitur }}" placeholder="Masukkan URL">
                                    </div>
                                    @if($errors->has('url_fitur'))
                                    <div class="text-danger small mt-1">{{ ucfirst($errors->first('url_fitur')) }}</div>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Icon</label>
									<br>
									<input type="file" id="file" class="d-none" accept="image/*">
									<button class="btn btn-sm btn-primary btn-file"><i class="fa fa-folder-open mr-2"></i>Pilih Gambar...</button>
									<br>
									<img id="img-file" class="mt-2 img-thumbnail {{ $fitur->icon_fitur != '' ? '' : 'd-none' }}" src="{{ $fitur->icon_fitur != '' ? asset('assets/images/fitur/'.$fitur->icon_fitur) : '' }}" style="max-height: 150px">
									<input type="hidden" name="gambar" id="src-img">
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
<script type="text/javascript">
    /* Croppie */
    var demo = $('#demo').croppie({
        viewport: {width: 400, height: 400},
        boundary: {width: 400, height: 400}
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

    // Close Modal Croppie
    $('#modalCroppie').on('hidden.bs.modal', function(e){
        $("#file").val(null);
    });

	// Crop Image
    $(document).on("click", "#btn-crop", function(e){
        demo.croppie("result", {
            type: "base64",
            format: "png",
            size: {width: 400, height: 400}
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