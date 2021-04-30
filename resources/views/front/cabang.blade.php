@extends('template/guest/main')

@section('title', 'Cabang | ')

@section('content')

<!-- Page top Section end -->
<section class="page-top-section set-bg" data-setbg="{{ asset('templates/loans2go/img/page-top-bg/2.jpg') }}">
  <div class="container">
    <h2>Cabang</h2>
    <nav class="site-breadcrumb">
      <a class="sb-item" href="/{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">Home</a>
      <span class="sb-item active">Cabang</span>
    </nav>
  </div>
</section>
<!-- Page top Section end -->

<!-- Info Section -->
<section class="info-section spad">
  <div class="container">
    <div class="row">
        @if(count($cabang)>0)
            @foreach($cabang as $data)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card">
                    <div class="card-header">{{ $data->nama_cabang }}</div>
                    <div class="card-body">
                        <p class="card-text mb-0"><i class="fa fa-home mr-2"></i>{{ $data->alamat_cabang }}</p>
                        <p class="card-text mb-0"><i class="fa fa-whatsapp mr-2"></i><a href="https://wa.me/{{ $data->whatsapp_cabang }}" target="_blank">Hubungi Cabang</a></p>
                        <p class="card-text mb-0"><i class="fa fa-instagram mr-2"></i><a href="https://instagram.com/{{ $data->instagram_cabang }}" target="_blank">{{ $data->instagram_cabang }}</a></p>
                        <p class="card-text mb-0"><i class="fa fa-globe mr-2"></i><a href="{{ $data->website_cabang }}" target="_blank">Kunjungi Situs</a></p>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
  </div>
</section>
<!-- Info Section end -->

@endsection

@section('css-extra')

<style type="text/css">
  .info-text {padding-top: 0;}
</style>

@endsection