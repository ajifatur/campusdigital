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
                <h4 class="page-title">Tambah Pelatihan</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/member">Home</a></li>
                            <li class="breadcrumb-item"><a href="/admin/pelatihan">Pelatihan</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Pelatihan</li>
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
                    <h5 class="card-title border-bottom">Tambah Pelatihan</h5>
                    <div class="card-body">
                        <form id="form" method="post" action="/admin/pelatihan/store">
                            {{ csrf_field() }}
                            <div class="row">
								<div class="form-group col-md-6">
									<label>Nama Pelatihan <span class="text-danger">*</span></label>
									<input type="text" name="nama_pelatihan" class="form-control {{ $errors->has('nama_pelatihan') ? 'is-invalid' : '' }}" value="{{ old('nama_pelatihan') }}" placeholder="Masukkan Nama Pelatihan">
									@if($errors->has('nama_pelatihan'))
									<small class="text-danger">{{ ucfirst($errors->first('nama_pelatihan')) }}</small>
									@endif
								</div>
								<div class="form-group col-md-6">
									<label>Kategori <span class="text-danger">*</span></label>
									<select name="kategori" class="form-control {{ $errors->has('kategori') ? 'is-invalid' : '' }}" >
										<option value="" disabled selected>--Pilih--</option>
										@foreach($kategori as $data)
										<option value="{{ $data->id_kp }}" {{ old('kategori') == $data->id_kp ? 'selected' : '' }}>{{ $data->kategori }}</option>
										@endforeach
									</select>
									@if($errors->has('kategori'))
									<small class="text-danger">{{ ucfirst($errors->first('kategori')) }}</small>
									@endif
								</div>
								<div class="form-group col-md-6">
									<label>Trainer <span class="text-danger">*</span></label>
									<select name="trainer" class="form-control {{ $errors->has('trainer') ? 'is-invalid' : '' }}">
										<option value="" disabled selected>--Pilih--</option>
										@foreach($mentor as $data)
										<option value="{{ $data->id_user }}" {{ old('trainer') == $data->id_user ? 'selected' : '' }}>{{ $data->nama_user }}</option>
										@endforeach
									</select>
									@if($errors->has('trainer'))
									<small class="text-danger">{{ ucfirst($errors->first('trainer')) }}</small>
									@endif
								</div>
								<div class="form-group col-md-6">
									<label>Tempat Pelatihan</label>
									<input type="text" name="tempat_pelatihan" class="form-control {{ $errors->has('tempat_pelatihan') ? 'is-invalid' : '' }}" value="{{ old('tempat_pelatihan') }}" placeholder="Masukkan Tempat Pelatihan">
									@if($errors->has('tempat_pelatihan'))
									<small class="text-danger">{{ ucfirst($errors->first('tempat_pelatihan')) }}</small>
									@endif
								</div>
								<div class="form-group col-md-6">
									<label>Waktu Mendaftar Pelatihan <span class="text-danger">*</span></label>
									<input type="text" name="tanggal_pelatihan" class="form-control {{ $errors->has('tanggal_pelatihan') ? 'border-danger' : '' }}" placeholder="Masukkan Tanggal Pelatihan">
									@if($errors->has('tanggal_pelatihan'))
									<div class="small text-danger mt-1">{{ ucfirst($errors->first('tanggal_pelatihan')) }}</div>
									@endif
								</div>
								<div class="form-group col-md-6">
									<label>Waktu di Sertifikat <span class="text-danger">*</span></label>
									<input type="text" name="tanggal_sertifikat" class="form-control {{ $errors->has('tanggal_sertifikat') ? 'border-danger' : '' }}" placeholder="Masukkan Tanggal Sertifikat">
									@if($errors->has('tanggal_sertifikat'))
									<div class="small text-danger mt-1">{{ ucfirst($errors->first('tanggal_sertifikat')) }}</div>
									@endif
								</div>
                                <div class="form-group col-md-6">
                                    <label>Fee Member <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text {{ $errors->has('fee_member') ? 'border-danger' : '' }}">Rp.</span>
                                        </div>
                                        <input type="text" name="fee_member" class="form-control number-only thousand-format {{ $errors->has('fee_member') ? 'border-danger' : '' }}" value="{{ old('fee_member') }}" placeholder="Masukkan Fee Member">
                                    </div>
                                    <div class="row mt-1">
                                        @if($errors->has('fee_member'))
                                        <small class="col-12 text-danger">{{ ucfirst($errors->first('fee_member')) }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Fee Umum <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text {{ $errors->has('fee_umum') ? 'border-danger' : '' }}">Rp.</span>
                                        </div>
                                        <input type="text" name="fee_umum" class="form-control number-only thousand-format {{ $errors->has('fee_umum') ? 'border-danger' : '' }}" value="{{ old('fee_umum') }}" placeholder="Masukkan Fee Umum">
                                    </div>
                                    <div class="row mt-1">
                                        @if($errors->has('fee_umum'))
                                        <small class="col-12 text-danger">{{ ucfirst($errors->first('fee_umum')) }}</small>
                                        @endif
                                    </div>
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
                                    <label>Materi <span class="text-danger">*</span></label>
									<div class="table-responsive mt-2">
										<table class="table table-bordered" id="table-materi">
											<tbody>
												<tr data-id="1">
													<td><input type="text" name="kode_unit[]" class="form-control kode-unit" data-id="1" placeholder="Kode Unit"></td>
													<td><input type="text" name="judul_unit[]" class="form-control judul-unit" data-id="1" placeholder="Judul Unit"></td>
													<td width="150"><input type="text" name="durasi[]" class="form-control number-only durasi" data-id="1" placeholder="Durasi (Jam)"></td>
													<td width="50"><button class="btn btn-danger btn-block btn-delete-materi d-none" data-id="1" title="Hapus"><i class="fa fa-trash"></i></button></td>
												</tr>
											</tbody>
										</table>
									</div>
									<button class="btn btn-sm btn-primary btn-add" title="Tambah"><i class="fa fa-plus mr-2"></i>Tambah Materi</button>
								</div>
                                <div class="form-group col-md-12">
                                    <label>Deskripsi <span class="text-danger">*</span></label>
                                    <textarea name="deskripsi" id="deskripsi" class="d-none"></textarea>
                                    <div id="editor"></div> 
                                    @if($errors->has('deskripsi'))
                                    <small class="text-danger">{{ ucfirst($errors->first('deskripsi')) }}</small>
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

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		// Daterangepicker
		$("input[name=tanggal_pelatihan], input[name=tanggal_sertifikat]").daterangepicker({
			timePicker: true,
			timePicker24Hour: true,
    		showDropdowns: true,
			startDate: "{{ date('d/m/Y H:i') }}",
			endDate: "{{ date('d/m/Y H:i') }}",
			locale: {
			  format: 'DD/MM/YYYY HH:mm'
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
	});

	// Input Hanya Nomor
	$(document).on("keypress", ".number-only", function(e){
		var charCode = (e.which) ? e.which : e.keyCode;
		if ((charCode >= 48 && charCode <= 57) || (charCode==190 || charCode==110 || charCode==46)) { 
			// 0-9, and . only
			return true;
		}
		else{
			return false;
		}
	});
	// End Input Hanya Nomor
	
	// Button Tambah Materi
	$(document).on("click", ".btn-add", function(e){
		e.preventDefault();
		var count = $("#table-materi tbody tr").length;
		var html = '';
		html += '<tr data-id="'+(count+1)+'">';
		html += '<td><input type="text" name="kode_unit[]" class="form-control kode-unit" data-id="'+(count+1)+'" placeholder="Kode Unit"></td>';
		html += '<td><input type="text" name="judul_unit[]" class="form-control judul-unit" data-id="'+(count+1)+'" placeholder="Judul Unit"></td>';
		html += '<td width="150"><input type="text" name="durasi[]" class="form-control number-only durasi" data-id="'+(count+1)+'" placeholder="Durasi (Jam)"></td>';
		html += '<td width="50"><button class="btn btn-danger btn-block btn-delete-materi" data-id="'+(count+1)+'" title="Hapus"><i class="fa fa-trash"></i></button></td>';
		html += '</tr>';
		$("#table-materi tbody").append(html);
		var rows = $("#table-materi tbody tr");
		rows.each(function(key,elem){
			$(elem).find(".btn-delete-materi").removeClass("d-none")
		});
	});
	
	// Button Hapus Materi
	$(document).on("click", ".btn-delete-materi", function(e){
		e.preventDefault();
		var id = $(this).data("id");
		$("#table-materi tbody tr[data-id="+id+"]").remove();
		var rows = $("#table-materi tbody tr");
		rows.each(function(key,elem){
			rows.length <= 1 ? $(elem).find(".btn-delete-materi").addClass("d-none") : $(elem).find(".btn-delete-materi").removeClass("d-none");		
			$(elem).attr("data-id", (key+1));
			$(elem).find(".kode-unit").attr("data-id", (key+1));
			$(elem).find(".judul-unit").attr("data-id", (key+1));
			$(elem).find(".durasi").attr("data-id", (key+1));
			$(elem).find(".btn-delete").attr("data-id", (key+1));
		});
	});
	
	
    // Button Submit
    $(document).on("click", "#btn-submit", function(e){
		e.preventDefault();
		
		// Cek Materi
		var rows = $("#table-materi tbody tr");
		if(rows.length == 1){
			if($(rows).find(".kode-unit").val() == '' || $(rows).find(".judul-unit").val() == '' || $(rows).find(".durasi").val() == '' ){
				alert("Materi harus diisi minimal 1 (satu) !");
				return;
			}
		}
		
        var myEditor = document.querySelector('#editor');
        var html = myEditor.children[0].innerHTML;
        $("#deskripsi").text(html);
        $("#form").submit();
    });
</script>

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

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/croppie/croppie.css') }}">
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style type="text/css">
	#platform {width: 200px; height: 250px; overflow-y: scroll; overflow-x: hidden;}
    #editor {height: 400px;}
	.ql-editor h1, .ql-editor h2, .ql-editor h3, .ql-editor h4, .ql-editor h5, .ql-editor h6, .ql-editor p {margin-bottom: 1rem!important;}
</style>

@endsection