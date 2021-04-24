@extends('template/guest/main')

@section('title', $blog->blog_title.' - Artikel | ')

@section('content')

<!-- Page top Section end -->
<section class="page-top-section set-bg" data-setbg="{{ asset('templates/loans2go/img/page-top-bg/2.jpg') }}">
  <div class="container">
    <h2>Artikel</h2>
    <nav class="site-breadcrumb">
      <a class="sb-item" href="/{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">Home</a>
      <a class="sb-item" href="/artikel{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">Artikel</a>
      <span class="sb-item active">{{ $blog->blog_title }}</span>
    </nav>
  </div>
</section>
<!-- Page top Section end -->

<!-- Info Section -->
<section class="info-section spad">
  <div class="container">
    <div class="row">
      <div class="col-lg-2">
        <div class="sticky-top border-right" style="top: 8em">
          <div class="bg-light rounded-circle mb-2 d-flex align-items-center justify-content-center mx-auto" style="width: 70px; height: 70px"><i class="fa fa-user" style="font-size: 1.7rem"></i></div>
          <div class="text-center">
            <p class="text-body font-weight-bold m-0">{{ $blog->kontributor != '' ? $blog->kontributor : $blog->nama_user }}</p>
            <p class="m-0"><small><i class="fa fa-bookmark"></i> {{ $blog->kontributor != '' ? 'Kontributor' : get_role_name($blog->role) }}</small></p>
            <p class="m-0"><small> {{$blog->kategori}}</small></p>
            <p class="m-0"><small><i class="fa fa-clock-o"></i> {{ time_elapsed_string($blog->blog_at) }}</small></p>
          </div>
          <hr>
          @foreach($blog_tags as $tag)
          <span class="badge badge-primary">{{ $tag->tag }}</span>
          @endforeach
        </div>
      </div>
      <div class="col-lg-7"> 
        <article>
          <h2 class="mb-3">{{ $blog->blog_title }}</h2>
    			<img src="{{ $blog->blog_gambar != '' ? asset('assets/images/blog/'.$blog->blog_gambar) : asset('assets/images/default/artikel.jpg') }}" class="img-fluid rounded">
          <div class="ql-snow mt-2"><div class="ql-editor">{!! html_entity_decode($blog->konten) !!}</div></div>
        </article>
      </div>
      <div class="col-lg-3">
        <div class="kategori mb-3">
          <div class="heading">
            <h5 class="m-0">Kategori</h5>
            <hr>
          </div>
          <div class="card border-0">
            <div class="card-body">
              @foreach($kategori as $data)
              <ul class="list-unstyled">
                <li class="mb-2">{{$data->kategori}}</li>
              </ul>
              @endforeach
            </div>  
          </div>
        </div>
        <div class="last-post">
          <div class="heading">
            <h5 class="m-0">Artikel Lainya</h5>
            <hr>
          </div>
          <div class="card border-0">
            <div class="card-body">
              @foreach($recents as $data)
              <a href="/artikel/{{ $data->blog_permalink }}{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">
                <img src="{{ $data->blog_gambar != '' ? asset('assets/images/blog/'.$data->blog_gambar) : asset('assets/images/default/artikel.jpg') }}" class="img-fluid rounded">   
                <p>{{$data->blog_title}}</p>
              </a>
              @endforeach
            </div>  
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Info Section end -->

@endsection

@section('css-extra')

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style type="text/css">
  article {padding-top: 0;}
  article p {margin-bottom: 1rem!important;}

  /* Quill */
  .ql-editor h2 {margin-bottom: 1rem!important; font-weight: 600!important;}
  .ql-editor h3 {margin-bottom: 1rem!important; font-weight: 600!important;}
  .ql-editor ol {padding-left: 30px!important;}
  .ql-editor ol li {font-size: 14px!important; color: #74757f!important; padding-left: 5px!important;}
</style>

@endsection