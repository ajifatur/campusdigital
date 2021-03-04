@extends('template/guest/main')

@section('title', $karir->karir_title.' - Karir | ')

@section('content')

<section id="breadcrumb-container">
	<div class="container">
		<div class="row">
			<div class="col-12 px-0">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb px-lg-3 px-md-0">
						<li class="breadcrumb-item"><a href="/"><i data-feather="home"></i></a></li>
						<li class="breadcrumb-item"><a href="/karir">Karir</a></li>
						<li class="breadcrumb-item active" aria-current="page">{{ $karir->karir_title }}</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</section>
<section id="main-slide-top">
	<div>
		<div class="title">
			<div class="container">
				<div class="row">
					<div>
						<h1 class="col-12 px-md-0">Karir</h1>
						<p class="col-12 px-md-0">{{ $karir->karir_title }}</p>
					</div>
				</div>
			</div>
		</div>
		<div class="overlay"></div>
	</div>
</section>
<section class="my-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-9">
        <div class="info-text">
          <h3 class="mb-3">{{ $karir->karir_title }}</h3>
          <div class="">
            <div class="col-12 p-1 text-light small" style="background-color: #fb8312;">
              <div class="row">
                <div class="col-md">
                  <span title="{{ date('Y-m-d H:i:s', strtotime($karir->karir_at)) }}"><i class="fa fa-clock-o mr-2"></i> {{ setFullDate($karir->karir_at) }}</span>
                </div>
                <div class="col-md">
                  <i class="fa fa-user mr-2"></i> {{ $karir->nama_user }}
                </div>
              </div>
            </div>
          </div>
		  <div class="text-center mt-3">
		  	<img class="img-fluid" src="{{ asset('assets/images/cover-karir/'.$karir->karir_gambar) }}">
	      </div>
          <div class="row ql-snow mt-2"><div class="ql-editor">{!! html_entity_decode($karir->konten) !!}</div></div>
		  <div class="text-center">
			<a href="{{ $karir->karir_url }}" class="btn btn-primary" target="_blank">Daftar Sekarang</a>
	      </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection

@section('css-extra')

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style type="text/css">
  .header-section {background: #340369!important;}
  .info-section {margin-top: 126px!important;}
  #registration-form .h6:before, #registration-form .h6:after {content: '---';}
  label {font-size: .875rem;}

  /* Quill */
  .ql-editor h2 {margin-bottom: 1rem!important; font-weight: 600!important;}
  .ql-editor h3 {margin-bottom: 1rem!important; font-weight: 600!important;}
  .ql-editor ol {padding-left: 30px!important;}
  .ql-editor ol li {font-size: 14px!important; color: #74757f!important; padding-left: 5px!important;}
</style>

@endsection