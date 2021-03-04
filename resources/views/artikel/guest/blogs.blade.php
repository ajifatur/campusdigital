@extends('template/guest/main')

@section('title', 'Artikel | ')

@section('content')

<!-- Page top Section end -->
<section class="page-top-section set-bg" data-setbg="{{ asset('templates/loans2go/img/page-top-bg/2.jpg') }}">
  <div class="container">
    <h2>Artikel</h2>
    <nav class="site-breadcrumb">
      <a class="sb-item" href="/{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">Home</a>
      <span class="sb-item active">Artikel</span>
    </nav>
  </div>
</section>
<!-- Page top Section end -->

<!-- Info Section -->
<section class="info-section spad">
  <div class="container">
    <div class="row">
      @foreach($blogs as $blog)
      <div class="col-lg-6 my-2">
  		  <div class="card bg-light shadow border-0">
    			<div class="card-body">
    			  <h5 class="card-title"><a class="text-dark" href="/artikel/{{ $blog->blog_permalink }}{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">{{ $blog->blog_title }}</a></h5>
    			  <p class="card-text">{!! substr(strip_tags(html_entity_decode($blog->konten)),0,150) !!}...</p>
    			  <span class="card-link text-secondary small" title="{{ date('Y-m-d H:i:s', strtotime($blog->blog_at)) }}" style="cursor: help;">
    				<i class="fa fa-clock-o mr-2"></i> {{ generate_date($blog->blog_at) }}
    			  </span>
    			  <span class="card-link text-secondary small"><i class="fa fa-user mr-2"></i> {{ $blog->nama_user }}</span>
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
</style>

@endsection