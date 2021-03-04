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
                <h4 class="page-title">File Tidak Terpakai</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item"><a href="/admin/file">File</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tidak Terpakai</li>
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
        <!-- row -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- column -->
            <div class="col-lg-12">
                <!-- card -->
                <div class="card shadow">
                    <div class="card-title border-bottom">
                        <div class="row">
                            <div class="col-12 col-sm py-1 mb-2 mb-sm-0 text-center text-sm-left">
                                <h5 class="mb-0">File Tidak Terpakai</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(Session::get('message') != null)
                            <div class="alert alert-success alert-dismissible mb-4 fade show" Blog="alert">
                                {{ Session::get('message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
						<div class="row mb-3">
							<div class="col-12">
								<label>Direktori:</label>
								{{ URL::to('/') }}/
								<select name="dir" id="dir">
                                    @foreach($path as $data)
									<option value="{{ $data->path }}" {{ $dir == $data->path ? 'selected' : '' }}>{{ $data->path }}</option>
                                    @endforeach
								</select>
								<br>
								<strong>{{ count($array) }} file ditemukan</strong>
								@if(count($array) > 0)
								<br>
								<form id="form-delete-all" class="mt-2" method="post" action="/admin/file/unused/delete-all">
									{{ csrf_field() }}
									<button type="button" class="btn btn-primary btn-delete-all">Hapus Semua</button>
									<input type="hidden" name="dir" value="{{ $dir }}">
								</form>
								@endif
							</div>
						</div>
						<div class="row">
							@if(count($array) > 0)
								@foreach($array as $data)
								<div class="col-lg-3 col-md-6">
									<div class="card shadow">
										<a href="{{ asset($dir.'/'.$data) }}" class="image-popup-vertical-fit card-image-top" title="{{ $data }}" style="background-image: url('{{ asset($dir.'/'.$data) }}');"></a>
										<div class="card-body">
											<a href="#" class="btn btn-danger btn-delete" data-id="{{ $data }}">Hapus</a>
										</div>
									</div>
								</div>
								@endforeach
							@else
								<div class="col-12">
									<div class="alert alert-danger text-center">
										Tidak ada file yang tidak terpakai.
									</div>
								</div>
							@endif
						</div>
                    </div>
					<form id="form" class="d-none" method="post" action="/admin/file/unused/delete">
						{{ csrf_field() }}
						<input type="hidden" name="id" id="id">
						<input type="hidden" name="dir" value="{{ $dir }}">
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

<script src="{{ asset('templates/matrix-admin/assets/libs/magnific-popup/dist/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('templates/matrix-admin/assets/libs/magnific-popup/meg.init.js') }}"></script>
<script type="text/javascript">
	// Popup image
	$('.image-popup-vertical-fit').magnificPopup({
		type: 'image',
		closeOnContentClick: true,
		closeBtnInside: false,
		fixedContentPos: true,
		image: {
			verticalFit: true
		},
		zoom: {
			enabled: true,
			duration: 300 // don't foget to change the duration also in CSS
		},
	});

    // Change Directory
    $(document).on("change", "#dir", function(){
        var dir = $(this).val();
        window.location.href = '/admin/file/unused?dir='+dir;
    });

    // Button Delete
    $(document).on("click", ".btn-delete", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        var ask = confirm("Anda yakin ingin menghapus data ini?");
        if(ask){
            $("#id").val(id);
            $("#form").submit();
        }
    });

    // Button Delete All
    $(document).on("click", ".btn-delete-all", function(e){
        e.preventDefault();
        var ask = confirm("Anda yakin ingin menghapus semua data ini?");
        if(ask){
            $("#form-delete-all").submit();
        }
    });
</script>

@endsection

@section('css-extra')

<link href="{{ asset('templates/matrix-admin/assets/libs/magnific-popup/dist/magnific-popup.css') }}" rel="stylesheet">
<style type="text/css">
	.card-image-top {background-position: top center; background-size: cover; background-repeat: no-repeat; height: 200px;}
</style>

@endsection