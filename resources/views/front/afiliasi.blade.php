@extends('template/guest/main')

@section('title', 'Afiliasi | ')

@section('content')

<!-- Page top Section end -->
<section class="page-top-section set-bg" data-setbg="{{ asset('templates/loans2go/img/page-top-bg/2.jpg') }}">
  <div class="container">
    <h2>Afiliasi</h2>
    <nav class="site-breadcrumb">
      <a class="sb-item" href="/{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">Home</a>
      <span class="sb-item active">Afiliasi</span>
    </nav>
  </div>
</section>
<!-- Page top Section end -->

<!-- Info Section -->
<section class="info-section spad">
  <div class="container">
    <div class="row">
      <div class="col-lg-5 text-center mb-2">
        <img src="{{ asset('assets/images/illustration/undraw_transfer_money_rywa.svg') }}" style="max-width: 360px;" alt="">
      </div>
      <div class="col-lg-7">
        <div class="info-text">
          <h4 class="mb-4">Afiliasi</h4>
          <p>Program afiliasi merupakan program dimana Anda dapat menerima komisi dari kami dengan cara memberikan referensi Campus Digital kepada teman, relasi atau pengunjung website Anda, kemudian pihak yang Anda referensikan tersebut melakukan order & pembayaran. Komisi diberikan sebesar Rp. {{ number_format(get_comission(),0,',','.') }} setiap pendaftaran yang berhasil transfer. Fasilitas member untuk mereferensikan yaitu dengan adanya sistem URL Referral, dimana setiap member akan mendapatkannya.</p>
          <p>Contoh URL Referral adalah: <span class="text-danger font-weight-bold">{{ URL::to('/') }}?ref=masagung</span></p>
          <p>Setiap member yang daftar melalui URL Referral Anda, maka bonus atau komisi akan otomatis masuk ke dalam data komisi yang kemudian bisa diambil kapan saja.</p>
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