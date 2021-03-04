@extends('template/member/main')

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
                            <li class="breadcrumb-item"><a href="/member">Home</a></li>
                            <li class="breadcrumb-item"><a href="/member/e-course">Materi E-Course</a></li>
                            <li class="breadcrumb-item"><a href="/member/e-course/chapter/{{ $course->chapter_nomor }}">{{ $course->chapter_judul }}</a></li>
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
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="embed-responsive embed-responsive-16by9 mb-3">
                                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $course->course_youtube }}?rel=0&modestbranding=1&autoplay=1" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-6">
                                        <a href="{{ $prev != null ? '/member/e-course/detail/'.$prev->id_course : 'Javascript:alert("Video ini paling awal");' }}" class="btn btn-primary btn-block"><i class="fa fa-chevron-left mr-2"></i>Sebelumnya</a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ $next != null ? '/member/e-course/detail/'.$next->id_course : 'Javascript:alert("Video ini paling akhir");' }}" class="btn btn-primary btn-block">Selanjutnya<i class="fa fa-chevron-right ml-2"></i></a>
                                    </div>
                                </div>
                                <p class="h4 mb-3 text-secondary"><i class="fa fa-tag mr-2"></i> Chapter {{ $course->chapter_nomor }} : {{ $course->chapter_judul }}</p>
                                <p class="h3">{{ $course->course_judul }}</p>
                                <p>{{ $course->course_caption }}</p>
                            </div>
                            <div class="col-lg-4" style="border-left: 1px solid #bebebe;">
                                <p class="h4 mb-3">Navigasi</p>
                                <ul>
                                    @foreach($all_courses as $data)
                                    <li><a class="{{ $course->id_course == $data->id_course ? 'font-weight-bold' : '' }}" href="/member/e-course/detail/{{ $data->id_course }}">Video {{ $data->course_nomor }}: {{ $data->course_judul }}</a></li>
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
    @include('template/member/_footer')
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->

@endsection