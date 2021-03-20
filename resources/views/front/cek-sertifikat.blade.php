@extends('template/guest/main')

@section('title', 'Cek Sertifikat | ')

@section('content')

<!-- Page top Section end -->
<section class="page-top-section set-bg" data-setbg="{{ asset('templates/loans2go/img/page-top-bg/2.jpg') }}">
  <div class="container">
    <h2>Cek Sertifikat</h2>
    <nav class="site-breadcrumb">
      <a class="sb-item" href="/{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">Home</a>
      <span class="sb-item active">Cek Sertifikat</span>
    </nav>
  </div>
</section>
<!-- Page top Section end -->

<!-- Info Section -->
<section class="info-section spad">
  <div class="container">
    @if($member)
        <div class="alert alert-success text-center p-5">Sertifikat ini telah <strong>RESMI</strong> terdaftar di Campus Digital dengan nomor seri <strong>{{ $member->kode_sertifikat }}</strong> atas nama <strong>{{ $member->nama_user }}</strong>.</div>
    @else
        <div class="alert alert-danger text-center p-5">Sertifikat ini <strong>TIDAK TERDAFTAR</strong> di Campus Digital.</div>
    @endif
  </div>
</section>
<!-- Info Section end -->

@endsection

@section('css-extra')

<style type="text/css">
  .info-text {padding-top: 0;}
</style>

@endsection