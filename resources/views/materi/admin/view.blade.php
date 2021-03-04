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
                <h4 class="page-title">Baca Materi</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item"><a href="/admin/materi/{{ generate_permalink($kategori->kategori) }}">Materi {{ $kategori->kategori }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Baca Materi</li>
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
                    <div class="card-title border-bottom">
                        <div class="row">
                            <div class="col-12 col-sm py-1 mb-2 mb-sm-0 text-center text-sm-left">
                                <h5 class="mb-0">{{ $file->nama_file }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-center">
						<div class="row">
							<div class="col-md-10 col-12 mx-auto" id="image-wrapper">
								@foreach($file_detail as $data)
									@php
										$explode_dot = explode('.', $data->nama_fd);
										$explode_strip = explode('-', $explode_dot[0]);
									@endphp
									<p class="mb-1">{{ remove_zero($explode_strip[1]) }} / {{ count($file_detail) }}</p>
									<img class="img-fluid border border-secondary mb-2" src="{{ asset('assets/uploads/'.$data->nama_fd) }}">
								@endforeach
							</div>
						</div>
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
    // Prevent Right Click
	document.addEventListener("contextmenu", function(e){
		e.preventDefault();
	}, false);
</script>

@endsection

@section('css-extra')

<style type="text/css">
    #image-wrapper {height: 100vh; overflow-y: scroll;}
</style>

@endsection