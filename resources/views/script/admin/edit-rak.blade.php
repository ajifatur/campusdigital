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
                <h4 class="page-title">Edit Rak</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item"><a href="/admin/script">Kumpulan Copywriting</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Rak</li>
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
                    <h5 class="card-title border-bottom">Edit Rak</h5>
                    <div class="card-body">
                        <form id="form" method="post" action="/admin/script/update-rak" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $rak->id_rak }}">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Rak <span class="text-danger">*</span></label>
                                    <input type="text" name="rak" class="form-control {{ $errors->has('rak') ? 'is-invalid' : '' }}" value="{{ $rak->rak }}" placeholder="Masukkan Nama Rak">
                                    @if($errors->has('rak'))
                                    <small class="text-danger">{{ ucfirst($errors->first('rak')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Icon <span class="text-danger">*</span></label>
									<br>
									<input type="file" id="file" class="d-none" accept="image/*">
									<button class="btn btn-sm btn-primary btn-file"><i class="fa fa-folder-open mr-2"></i>Pilih Gambar...</button>
									<br>
									<img id="img-file" src="{{ $rak->rak_icon != '' ? asset('assets/images/rak/'.$rak->rak_icon) : '' }}" class="mt-2 img-thumbnail {{ $rak->rak_icon != '' ? '' : 'd-none' }}" style="max-height: 150px">
									<input type="hidden" name="gambar" id="src-img">
                                    @if($errors->has('gambar'))
                                    <div class="mt-2 small text-danger">{{ ucfirst($errors->first('gambar')) }}</div>
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

@endsection

@section('js-extra')

<script type="text/javascript">
    // Button Submit
    $(document).on("click", "#btn-submit", function(e){
        $("#form").submit();
    });
	
    // Button File
    $(document).on("click", ".btn-file", function(e){
		e.preventDefault();
        $("#file").trigger("click");
    });
	
    // Change Input File
    $(document).on("change", "#file", function(){
        readURL(this);
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