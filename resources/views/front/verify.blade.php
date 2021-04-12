@extends('template/guest/main')

@section('title', 'Verifikasi Email | ')

@section('content')

<!-- Page top Section end -->
<section class="page-top-section set-bg" data-setbg="{{ asset('templates/loans2go/img/page-top-bg/2.jpg') }}">
  <div class="container">
    <h2>Verifikasi Email</h2>
    <nav class="site-breadcrumb">
      <a class="sb-item" href="/{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">Home</a>
      <span class="sb-item active">Verifikasi Email</span>
    </nav>
  </div>
</section>
<!-- Page top Section end -->

<!-- Info Section -->
<section class="info-section spad">
  <div class="container">
    @if($status == 1)
        <div class="alert alert-success text-center p-5">Pengguna dengan email <strong>{{ $_GET['email'] }}</strong> sudah terverifikasi. Silahkan <a href="/login">Login disini</a>.</div>
    @elseif($status == 0)
        <div class="alert alert-danger text-center p-5">Tidak ada pengguna yang terdaftar dengan email <strong>{{ $_GET['email'] }}</strong>. Pastikan Anda benar-benar mendaftar menggunakan email ini atau tidak.</div>
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