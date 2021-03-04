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
                <h4 class="page-title">Pengaturan Umum</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item"><a href="/#">Pengaturan</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Umum</li>
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
            <div class="col-md-12">
                <!-- card -->
                <div class="card shadow">
                    <h5 class="card-title border-bottom">Pengaturan Umum</h5>
                    <div class="card-body">
                        <form id="form" method="post" action="/admin/pengaturan/update" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="category" value="1">
                            @if(Session::get('message') != null)
                            <div class="alert alert-success alert-dismissible mb-4 fade show" role="alert">
                                {{ Session::get('message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                            <div class="row">
								@foreach($settings as $key=>$setting)
                                    @if($settings[$key]->setting_key == 'logo' || $settings[$key]->setting_key == 'icon')
                                    <div class="form-group col-md-6">
                                        <label>{{ $settings[$key]->setting_name }} <span class="text-danger">{{ strpos($settings[$key]->setting_rules, 'required') ? '*' : '' }}</span></label>
                                        <input type="file" id="{{ $settings[$key]->setting_key }}" class="file d-none">
                                        <br>
                                        <button class="btn btn-sm btn-primary btn-upload" data-id="{{ $settings[$key]->setting_key }}"><i class="fa fa-folder-open mr-2"></i>Upload</button>
                                        @if($settings[$key]->setting_key == 'icon')
                                        <button class="btn btn-sm btn-secondary btn-preview d-none" data-id="{{ $settings[$key]->setting_key }}"><i class="fa fa-eye mr-2"></i>Preview</button>
                                        @endif
                                        <button class="btn btn-sm btn-danger btn-delete d-none" data-id="{{ $settings[$key]->setting_key }}"><i class="fa fa-trash mr-2"></i>Hapus</button>
                                        <br>
                                        <input type="hidden" name="settings[{{ $settings[$key]->setting_key }}]" class="src" data-id="{{ $settings[$key]->setting_key }}" data-old="{{ $settings[$key]->setting_value }}" value="{{ $settings[$key]->setting_value }}">
                                        <img class="img-thumbnail mt-3" data-id="{{ $settings[$key]->setting_key }}" src="{{ asset('assets/images/logo/'.$settings[$key]->setting_value) }}" style="max-height: 250px;">
                                    </div>
                                    @else
                                    <div class="form-group col-md-6">
                                        <label>{{ $settings[$key]->setting_name }} <span class="text-danger">{{ is_int(strpos($settings[$key]->setting_rules, 'required')) ? '*' : '' }}</span></label>
                                        <input type="text" name="settings[{{ $settings[$key]->setting_key }}]" class="form-control {{ $errors->has('settings.'.$settings[$key]->setting_key) ? 'border-danger' : '' }}" value="{{ $settings[$key]->setting_value }}" placeholder="Masukkan {{ $settings[$key]->setting_name }}">
                                        <div class="row mt-1">
                                            @if($errors->has('settings.'.$settings[$key]->setting_key))
                                            <small class="col-12 text-danger">{{ display_errors($settings[$key]->setting_name, $errors->first('settings.'.$settings[$key]->setting_key)) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
								@endforeach
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
    // Button Upload
	$(document).on("click", ".btn-upload", function(e){
		e.preventDefault();
        var id = $(this).data("id");
		$("#"+id).trigger("click");
	});

	// File Change
    $(document).on("change", ".file", function(){
		readURL(this);
        $(this).val(null);
    });

    // Read URL
    function readURL(input){
        if(input.files && input.files[0]){
            var reader = new FileReader();
            var id = $(input).attr("id");
            reader.onload = function(e){
				$(".src[data-id="+id+"]").val(e.target.result);
                $("img[data-id="+id+"]").attr("src",e.target.result).removeClass("d-none");
                $(".btn-preview[data-id="+id+"]").removeClass("d-none");
                $(".btn-delete[data-id="+id+"]").removeClass("d-none");
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Button Preview
	$(document).on("click", ".btn-preview", function(e){
		e.preventDefault();
        var id = $(this).data("id");
        if(id == "icon"){
            $(".logo-icon img").attr("src", $("img[data-id="+id+"]").attr("src"));
        }
        else if(id == "logo"){
            $(".logo-text img").attr("src", $("img[data-id="+id+"]").attr("src"));
        }
	});

    // Button Delete
    $(document).on("click", ".btn-delete", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        if(id == "icon"){
            $(".logo-icon img").attr("src", "{{ asset('assets/images/logo/'.get_icon()) }}");
            $("img[data-id="+id+"]").attr("src","{{ asset('assets/images/logo/'.get_icon()) }}");
        }
        else if(id == "logo"){
            $(".logo-text img").attr("src", "{{ asset('assets/images/logo/'.get_logo()) }}");
            $("img[data-id="+id+"]").attr("src","{{ asset('assets/images/logo/'.get_logo()) }}");
        }
		$(".src[data-id="+id+"]").val($(".src[data-id="+id+"]").data("old"));
        $(".btn-preview[data-id="+id+"]").addClass("d-none");
        $(".btn-delete[data-id="+id+"]").addClass("d-none");
    });

    // Button Submit
    $(document).on("click", "#btn-submit", function(e){
        $("#form").submit();
    });
</script>

@endsection