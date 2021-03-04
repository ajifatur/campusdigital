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
                <h4 class="page-title">Lihat Video</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item"><a href="/admin/file-manager">File Manager</a></li>
                            <li class="breadcrumb-item"><a href="/admin/file-manager/{{ generate_permalink($kategori->folder_kategori) }}">{{ $kategori->folder_kategori }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Lihat Video</li>
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
                    <div class="card-body">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                @foreach($breadcrumb as $key=>$data)
                                    <li class="breadcrumb-item"><a href="/admin/file-manager/{{ generate_permalink($kategori->folder_kategori) }}?dir={{ $data->folder_dir }}">{{ $data->folder_nama == '/' ? 'Home' : $data->folder_nama }}</a></li>
                                @endforeach
                                <li class="breadcrumb-item active" aria-current="page">{{ $file->file_nama }}</li>
                            </ol>
                        </nav>
                        <!-- /Breadcrumb -->
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="embed-responsive embed-responsive-16by9 mb-3">
                                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $file->file_konten }}?rel=0&modestbranding=1&autoplay=1" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-secondary"><i class="fa fa-user mr-2"></i>{{ $file->nama_user }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-secondary"><i class="fa fa-calendar mr-2"></i>{{ generate_date(date('Y-m-j', strtotime($file->file_at))) }}</p>
                                    </div>
                                </div>
                                <p class="h3">{{ $file->file_nama }}</p>
                                <p>{!! html_entity_decode($file->file_deskripsi) !!}</p>
								<div class="embedded">{!! html_entity_decode($file->file_keterangan) !!}</div>
                            </div>
                            <div class="col-lg-4" style="border-left: 1px solid #bebebe;">
                                <p class="h4 mb-3">Navigasi</p>
                                <ul>
                                    @foreach($all_files as $data)
                                    <li><a class="{{ $file->id_file == $data->id_file ? 'font-weight-bold' : '' }}" href="/admin/file-manager/view/{{ $data->id_file }}"><i class="fa fa-video mr-2"></i>{{ $data->file_nama }}</a></li>
                                    @endforeach
                                </ul>
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

@section('css-extra')

<style type="text/css">
    ul {list-style: none; padding-left: 0;}
	.embedded iframe {width: 100%;}
</style>

@endsection