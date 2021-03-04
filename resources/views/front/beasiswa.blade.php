@extends('template/guest/main')

@section('title', 'Beasiswa | ')

@section('content')

<!-- Page top Section end -->
<section class="page-top-section set-bg" data-setbg="{{ asset('templates/loans2go/img/page-top-bg/2.jpg') }}">
	<div class="container">
		<h2>Beasiswa</h2>
		<nav class="site-breadcrumb">
			<a class="sb-item" href="/{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">Home</a>
			<span class="sb-item active">Beasiswa</span>
		</nav>
	</div>
</section>
<!-- Page top Section end -->

<!-- Loans Section end -->
<section class="loans-section spad">
	<div class="container">
	    <div class="text-center mb-5 pb-4">
	      <h2>Persyaratan</h2>
	    </div>
		<div class="row">
			<div class="col-lg-6">
				<div class="row">
					<div class="col-lg-12 col-md-6 col-sm-12">
				        <div class="icon-box-item">
				        	<div class="ib-icon">
				        		<i class="flaticon-038-wall-clock"></i>
				        	</div>
				        	<div class="ib-text">
				            	<h5>Waktu Belajar</h5>
				            	<p>2 Bulan Belajar Intensif di kelas dan 2 Bulan Mengabdi di Campus Digital.</p>
				          	</div>
				        </div>
					</div>
					<div class="col-lg-12 col-md-6 col-sm-12">
				        <div class="icon-box-item">
				        	<div class="ib-icon">
				        		<i class="flaticon-018-map"></i>
				        	</div>
				        	<div class="ib-text">
				            	<h5>Lokasi Belajar</h5>
				            	<p>Jl. Sadewa I No.30, Pendrikan Kidul, Kec. Semarang Tengah, Kota Semarang, Jawa Tengah 50131.</p>
				          	</div>
				        </div>
					</div>
					<div class="col-lg-12 col-md-6 col-sm-12">
				        <div class="icon-box-item">
				        	<div class="ib-icon">
				        		<i class="flaticon-010-contract"></i>
				        	</div>
				        	<div class="ib-text">
				            	<h5>Biaya Administrasi</h5>
				            	<p>Biaya Administrasi Rp 250.000,-<br>Uang Jaminan Keseriusan : Rp 500.000,-</p>
				          	</div>
				        </div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="loans-text">
					<p class="h6 text-secondary font-weight-bold">Syarat Khusus:</p>
					<ol class="text-secondary ml-4">
						<li>Bersedia mengikuti program inkubator selama 2 bulan penuh, 6 hari kerja per minggu, 8 jam kerja per hari (08.00 – 16.00).</li>
						<li>Bersedia mengabdi di Campus Digital selama 2 bulan pasca lulus dari program inkubator dan siap di tempatkan di mana saja.</li>
						<li>Menitipkan uang jaminan sebesar IDR 500.000,-. Uang jaminan akan dikembalikan setelah peserta menyelesaikan semua program selama 2 bulan + menyelesaikan kewajiban Mengabdi selama 2 bulan.</li>
						<li>Jika peserta mundur ditengah jalan, maka WAJIB membayar ganti rugi sebesar IDR 5.000.000.</li>
						<li>Kelas ini adalah kelas TATAP MUKA, dilaksanakan di Campus Digital.</li>
						<li>Biaya hidup (makan – akomodasi) di tanggung masing-masing peserta.</li>
						<li>Tidak diperkenankan minta ijin, bolos selama kegiatan berlangsung. Ijin hanya diberikan jika untuk kepentingan suami/istri, anak, kedua orang tua, dan saudara kandung.</li>
						<li>Setiap ijin 1 hari, wajib diganti dengan masuk selama 2 hari. Diluar Jadwal Kelas.</li>
						<li>Calon peserta wajib menyerahkan fotocopy KTP dan Kartu Keluarga.</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Loans Section end -->

<!-- Why Section end -->
<section class="why-section bg-warning spad">
  <div class="container">
<!--     <div class="text-center mb-5 pb-4">
      <h2>Materi yang Diajarkan</h2>
    </div> -->
    <div class="row">
      <div class="col-md-4">
        <div class="icon-box-item">
          <div class="ib-icon">
            <i class="fa fa-dropbox"></i>
          </div>
          <div class="ib-text">
            <!-- <h5>Riset</h5> -->
            <p class="text-dark">Setiap peserta jalur Beasiswa telah disediakan Produk dari Campus Digital.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="icon-box-item">
          <div class="ib-icon">
            <i class="fa fa-shopping-cart"></i>
          </div>
          <div class="ib-text">
            <!-- <h5>Social Media Marketing</h5> -->
            <p class="text-dark">Peserta jalur Beasiswa juga dapat menjual produknya sendiri atas persetujuan Campus Digital.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="icon-box-item">
          <div class="ib-icon">
            <i class="fa fa-tasks"></i>
          </div>
          <div class="ib-text">
            <!-- <h5>Marketplace</h5> -->
            <p class="text-dark">Secara berkala, peserta akan mendapatkan tugas khusus dari supervisor pendamping yang akan di bahas saat pertemuan pertama.</p>
          </div>
        </div>
      </div>
  	</div>
  </div>
</section>
<!-- Why Section end -->

<!-- Why Section end -->
<section class="why-section spad">
  <div class="container">
    <div class="text-center mb-5 pb-4">
      <h2>Materi yang Diajarkan</h2>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="icon-box-item">
          <div class="ib-icon">
            <i class="flaticon-004-assistance"></i>
          </div>
          <div class="ib-text">
            <h5>Riset</h5>
            <p>Bagaimana cara untuk melakukan riset pasar dan produk.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="icon-box-item">
          <div class="ib-icon">
            <i class="flaticon-024-laptop"></i>
          </div>
          <div class="ib-text">
            <h5>Social Media Marketing</h5>
            <p>Bagaimana menggunakan social media untuk aktivitas marketing.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="icon-box-item">
          <div class="ib-icon">
            <i class="flaticon-032-placeholder"></i>
          </div>
          <div class="ib-text">
            <h5>Marketplace</h5>
            <p>Bagaimana berjualan menggunakan marketplace.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="icon-box-item">
          <div class="ib-icon">
            <i class="flaticon-006-smartphone-2"></i>
          </div>
          <div class="ib-text">
            <h5>FB/IG Ads</h5>
            <p>Bagaimana beriklan di Facebook dan Instagram.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="icon-box-item">
          <div class="ib-icon">
            <i class="flaticon-016-smartphone"></i>
          </div>
          <div class="ib-text">
            <h5>SEO Dasar</h5>
            <p>Bagaimana agar website nomor satu di halaman Search Engine.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="icon-box-item">
          <div class="ib-icon">
            <i class="flaticon-037-responsive"></i>
          </div>
          <div class="ib-text">
            <h5>Desain Web</h5>
            <p>Bagaimana membuat website dan landing page untuk promosi.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="text-center pt-3">
      <a href="/register{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}" class="site-btn sb-big">Daftar Sekarang!</a>
    </div>
  </div>
</section>
<!-- Why Section end -->

@endsection

@section('css-extra')

<style type="text/css">
	.loans-text {padding-top: 0;}
	.loans-text ol li {margin-bottom: 5px;}
</style>

@endsection