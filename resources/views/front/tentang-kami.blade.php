@extends('template/guest/main')

@section('title', 'Tentang Kami | ')

@section('content')

<!-- Page top Section end -->
<section class="page-top-section set-bg" data-setbg="{{ asset('templates/loans2go/img/page-top-bg/2.jpg') }}">
  <div class="container">
    <h2>Tentang Kami</h2>
    <nav class="site-breadcrumb">
      <a class="sb-item" href="/{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">Home</a>
      <span class="sb-item active">Tentang Kami</span>
    </nav>
  </div>
</section>
<!-- Page top Section end -->

<!-- Info Section -->
<section class="info-section spad">
  <div class="container">
    <div class="row">
      <div class="col-lg-5 text-center mb-2">
        <img src="{{ asset('assets/images/illustration/undraw_team_spirit_hrr4.svg') }}" style="max-width: 360px;" alt="">
      </div>
      <div class="col-lg-7">
        <div class="info-text">
          <h4 class="mb-4">Tentang Kami</h4>
          <p>Era digital telah berkembang pesat, kebutuhan terhadap tenaga digital marketing semakin tinggi dalam melaksanakan marketing di dunia online dan digital. Oleh karena itu kami hadir untuk melahirkan SDM yang memiliki kompetensi di bidang digital marketing.</p>
          <p>Dengan memiliki mentor yang ahli di bidangnya, lulusan Campus Digital kami harap akan menjadi tenaga kerja baru di bidang teknologi digital marketing atau menjadi wirausaha yang memiliki marketing online yang handal.</p>
        </div>
      </div>
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