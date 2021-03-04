@extends('template/admin/main')

@section('content')

<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
<!--      <div class="page-breadcrumb">
        <div class="row"> -->
<!--             <div class="d-flex no-block align-items-center"> -->
                <!-- <h4 class="page-title">Baca E-Book</h4> -->
<!--                 <div class="text-right"> -->

<!--                 </div>
            </div> -->
<!--         </div>
    </div> -->
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <nav aria-label="breadcrumb" class="d-none">
            <ol class="breadcrumb m-0 p-0">
                <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                <li class="breadcrumb-item"><a href="/admin/file-manager">File Manager</a></li>
                <li class="breadcrumb-item"><a href="/admin/file-manager/{{ generate_permalink($kategori->folder_kategori) }}">{{ $kategori->folder_kategori }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Baca E-Book</li>
            </ol>
        </nav>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0 p-0">
                                @foreach($breadcrumb as $key=>$data)
                                    <li class="breadcrumb-item"><a href="/admin/file-manager/{{ generate_permalink($kategori->folder_kategori) }}?dir={{ $data->folder_dir }}">{{ $data->folder_nama == '/' ? 'Home' : $data->folder_nama }}</a></li>
                                @endforeach
                                <li class="breadcrumb-item active" aria-current="page">{{ $file->file_nama }}</li>
                            </ol>
                        </nav>
        <!-- ============================================================== -->
        <!-- URL Referral -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- column -->
            <div class="col-lg-12">
                <!-- card -->
                <div class="card shadow rounded">
                    <!-- <div class="card-title border-bottom">
                        <div class="row">
                            <div class="col-12 col-sm py-1 mb-2 mb-sm-0 text-center text-sm-left">
                                <h5 class="mb-0">{{ $file->file_nama }}</h5>
                            </div>
                        </div>
                    </div> -->
                    <div class="card-body text-center p-0">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb" class="d-none">
                            <ol class="breadcrumb">
                                @foreach($breadcrumb as $key=>$data)
                                    <li class="breadcrumb-item"><a href="/admin/file-manager/{{ generate_permalink($kategori->folder_kategori) }}?dir={{ $data->folder_dir }}">{{ $data->folder_nama == '/' ? 'Home' : $data->folder_nama }}</a></li>
                                @endforeach
                                <li class="breadcrumb-item active" aria-current="page">{{ $file->file_nama }}</li>
                            </ol>
                        </nav>
                        <!-- /Breadcrumb -->
						<div class="row">
							<div class="col-md-12 col-12 mx-auto" id="image-wrapper">
								@foreach($file_detail as $data)
									@php
										$explode_dot = explode('.', $data->nama_fd);
										$explode_strip = explode('-', $explode_dot[0]);
									@endphp
									<p class="mb-1">{{ remove_zero($explode_strip[1]) }} / {{ count($file_detail) }}</p>
									<img class="border border-secondary mb-2" style="max-width: 100%;" src="{{ asset('assets/uploads/'.$data->nama_fd) }}">
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
    @include('template/member/_footer')
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->

@endsection

@section('js-extra')

<script type="text/javascript">
	$(window).on("load", function(){
		resize_image();
	});
	
	$(window).on("resize", function(){
		resize_image();
	});
	
    // Prevent Right Click
	document.addEventListener("contextmenu", function(e){
	 	e.preventDefault();
	}, false);
	
	function resize_image(){
		var imageWrapper = $("#image-wrapper");
		$(imageWrapper).each(function(key,elem){
			if(window.screen.width <= 576)
				$(elem).find("img").css("height", "auto");
			else
				$(elem).find("img").css("height", imageWrapper.height() - 30);
		});
	}
</script>

@endsection

@section('css-extra')

<style type="text/css">
    body{overflow-y: hidden;}
    #image-wrapper {height: calc(100vh - 10em); overflow-y: scroll;}
</style>

@endsection