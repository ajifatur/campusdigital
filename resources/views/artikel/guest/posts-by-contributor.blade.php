@extends('template/guest/main')

@section('title', 'Artikel | ')

@section('content')

<!-- Page top Section end -->
<section class="page-top-section set-bg" data-setbg="{{ asset('templates/loans2go/img/page-top-bg/2.jpg') }}">
  <div class="container">
    <h2>Artikel</h2>
    <nav class="site-breadcrumb">
      <a class="sb-item" href="/{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">Home</a>
      <a class="sb-item" href="/artikel{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">Artikel</a>
      <span class="sb-item active">Kontributor: {{ $kontributor }}</span>
    </nav>
  </div>
</section>
<!-- Page top Section end -->

<!-- Info Section -->
<section class="info-section spad">
  <div class="container">
    <div class="row">
      @foreach($blogs as $blog)
      <div class="col-lg-4 col-md-6 mb-3">
        <div class="card">
          <a href="/artikel/{{ $blog->blog_permalink }}{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">
          <img class="card-img-top" src="{{ $blog->blog_gambar != '' ? asset('assets/images/blog/'.$blog->blog_gambar) : asset('assets/images/default/artikel.jpg') }}" alt="Card image cap">
          </a>
          <div class="card-body">
            <h5 class="card-title"><a href="/artikel/{{ $blog->blog_permalink }}{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">{{ $blog->blog_title }}</a></h5>
          </div>
          <div class="card-footer d-flex justify-content-between">
            <small class="text-muted"><i class="fa fa-clock-o mr-1"></i>{{ time_elapsed_string($blog->blog_at) }}</small>
            <small class="text-muted"><i class="fa fa-user mr-1"></i><a class="text-link" href="{{ $blog->kontributor != '' ? '/kontributor/'.$blog->kontributor_slug : '/author/'.$blog->username }}{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">{{ $blog->kontributor != '' ? $blog->kontributor : $blog->nama_user }}</a></small>
          </div>
        </div>
      </div>
      @endforeach
    </div>
	<div class="row mt-3" id="pagination">
		{!! $blogs->links() !!}
	</div>
  </div>
</section>
<!-- Info Section end -->

@endsection

@section('js-extra')

<script>

</script>

@endsection

@section('css-extra')

<style type="text/css">
  .info-text {padding-top: 0;}
  .info-text p {margin-bottom: 1rem!important;}
  #pagination nav {margin-right: auto; margin-left: auto;}

  .ql-align-left {text-align: left!important;}
  .ql-align-right {text-align: right!important;}
  .ql-align-center {text-align: center!important;}
  .ql-align-justify {text-align: justify!important;}
  .page-item.active .page-link {
    color: #fff;
    background-color: #46157a;
    border-color: #46157a;}
  .page-link{color: #46157a}
  .page-link:hover{color: #46157a}

.card-body {padding-top: 1rem; padding-bottom: 1rem;}
.card-title {margin-bottom: 0; line-height: 22px; height: 44px; display: -webkit-box !important; -webkit-line-clamp: 2; -moz-line-clamp: 2; -ms-line-clamp: 2; -o-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; -ms-box-orient: vertical; -o-box-orient: vertical; box-orient: vertical; overflow: hidden; text-overflow: ellipsis;}
</style>

@endsection