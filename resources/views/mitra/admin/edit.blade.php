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
		'title' => 'Edit Mitra',
		'items' => [
			['text' => 'Konten Web', 'url' => '/admin/konten-web'],
			['text' => 'Mitra', 'url' => '/admin/konten-web/mitra'],
			['text' => 'Edit Mitra', 'url' => '#'],
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
                    <form id="form" method="post" action="/admin/konten-web/mitra/update" enctype="multipart/form-data">
                        <div class="card-body">
                            {{ csrf_field() }}
							<input type="hidden" name="id" value="{{ $mitra->id_mitra }}">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Nama Mitra <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_mitra" class="form-control {{ $errors->has('nama_mitra') ? 'is-invalid' : '' }}" value="{{ $mitra->nama_mitra }}" placeholder="Masukkan Nama Mitra">
                                    @if($errors->has('nama_mitra'))
                                    <small class="text-danger">{{ ucfirst($errors->first('nama_mitra')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Logo Mitra <span class="text-danger">*</span></label>
									<br>
									<input type="file" id="file" class="d-none" accept="image/*">
									<button class="btn btn-sm btn-primary btn-file"><i class="fa fa-folder-open mr-2"></i>Pilih Gambar...</button>
									<br>
									<img id="img-file" src="{{ $mitra->logo_mitra != '' ? asset('assets/images/mitra/'.$mitra->logo_mitra) : '' }}" class="mt-2 img-thumbnail {{ $mitra->logo_mitra != '' ? '' : 'd-none' }}" style="max-height: 150px">
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

@endsection

@section('js-extra')

<script type="text/javascript">	
    // Button File
    $(document).on("click", ".btn-file", function(e){
		e.preventDefault();
        $("#file").trigger("click");
    });
	
    // Change Input File
    $(document).on("change", "#file", function(){
        readURL(this);
    });
	
    // Button Submit
    $(document).on("click", "#btn-submit", function(e){
        $("#form").submit();
    });

    function readURL(input){
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function(e){
				$("#img-file").attr("src",e.target.result).removeClass("d-none");
				$("input[name=gambar]").val(e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        	$("#file").val(null);
        }
    }
</script>

@endsection