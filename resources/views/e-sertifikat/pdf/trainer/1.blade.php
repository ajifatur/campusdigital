<!DOCTYPE html>
<html>
<head>
	<!--<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato:400,700" />-->
	<title>Sertifikat Trainer Pelatihan</title>
	<link rel="shortcut icon" href="{{ asset('assets/images/logo/'.get_icon()) }}">
	<style type="text/css">
		@font-face {font-family: 'Lato-Regular'; src: url({{ asset('assets/fonts/Lato-Regular.ttf') }});}
		@font-face {font-family: 'Lato-Bold'; src: url({{ asset('assets/fonts/Lato-Bold.ttf') }});}
		@font-face {font-family: 'Lato-Bold-Italic'; src: url({{ asset('assets/fonts/Lato-Bold-Italic.ttf') }});}
		
		@page {margin: 0px;}
		html {margin: 0px;}
		body {margin: 0px; font-family: 'Lato-Regular'; font-size: 18.5px; background-color: {{ get_warna_background_sertifikat() }};}
		#nomor-seri {font-size: 12px; position: absolute; top: 5px; left: 15px;}
		#logo {position: absolute; top: 50px; left: 88px; width: 950px; text-align: center;}
		#img-logo {max-height: 110px;}
		#text-sertifikat {font-family: 'Lato-Bold'; font-size: 66px; position: absolute; top: 145px; left: 88px; width: 950px; color: #d4b064; text-align: center; text-transform: uppercase;}
		#nomor-sertifikat {font-size: 29px; position: absolute; top: 242px; left: 88px; width: 950px; text-align: center;}
		#text-diberikan-kepada {font-family: 'Lato-Bold'; font-size: 23px; position: absolute; top: 302px; left: 88px; width: 950px; text-align: center;}
		#nama {font-family: 'Lato-Bold-Italic'; font-size: 58px; position: absolute; top: 325px; left: 88px; width: 950px; text-align: center; text-decoration: underline;}
		#tipe {font-family: 'Lato-Bold'; font-size: 21px; position: absolute; top: 437px; left: 88px; width: 950px; text-align: center;}
		#deskripsi {position: absolute; top: 488px; left: 88px; width: 950px; line-height: 20px; text-align: center;}
		#judul {font-family: 'Lato-Bold';}
		#text-mengetahui {position: absolute; top: 575px; left: 88px;}
		#text-direktur {position: absolute; top: 597px; left: 88px;}
		#direktur {position: absolute; top: 705px; left: 88px;}
		#sign-direktur {position: absolute; top: 620px; left: 138px; max-height: 90px;}
		#stempel {position: absolute; top: 620px; left: 48px; max-height: 90px;}
		#tanggal {position: absolute; top: 575px; left: 790px;}
		#text-dosen {position: absolute; top: 597px; left: 790px;}
		#dosen {position: absolute; top: 705px; left: 790px;}
		#sign-dosen {position: absolute; top: 620px; left: 810px; max-height: 90px;}
		#line-1 {position: absolute; top: 708px; left: 85px; width: 250px; border-color: #333; margin: 0; border-width: 1.25px;}
		#line-2 {position: absolute; top: 708px; left: 787px; width: 250px; border-color: #333; margin: 0; border-width: 1.25px;}
		#line-bg-2 {position: absolute; bottom: 25px; height: 5px; width: 100%; background-color: {{ get_warna_garis_2() }};}
		#line-bg-1 {position: absolute; bottom: 0; height: 25px; width: 100%; background-color: {{ get_warna_garis_1() }};}
	</style>
</head>
<body>
	<div id="nomor-seri">Nomor Seri: {{ $member->kode_trainer }}</div>
	<div id="logo"><img id="img-logo" src="{{ asset('assets/images/logo/'.get_logo()) }}"></div>
	<div id="text-sertifikat">Sertifikat</div>
	<div id="nomor-sertifikat">Nomor: {{ $pelatihan->nomor_pelatihan }}</div>
	<div id="text-diberikan-kepada">Diberikan Kepada:</div>
	<div id="nama">{{ $member->nama_user}}</div>
	<div id="tipe">Sebagai Trainer</div>
	<div id="deskripsi">{{ $pelatihan->kategori }} dengan tema <span id="judul">"{{ $pelatihan->nama_pelatihan }}"</span>. <br>Diselenggarakan oleh {{ get_website_name() }} pada tanggal {{ date('Y-m-d', strtotime($pelatihan->tanggal_sertifikat_from)) == date('Y-m-d', strtotime($pelatihan->tanggal_sertifikat_to)) ? generate_date($pelatihan->tanggal_sertifikat_to) : generate_date($pelatihan->tanggal_sertifikat_from).' sampai '.generate_date($pelatihan->tanggal_sertifikat_to) }}{{ $pelatihan->tempat_pelatihan != '' ? ' di '.$pelatihan->tempat_pelatihan : '' }}.</div>
	<div id="text-mengetahui">Mengetahui,</div>
	<div id="text-direktur">Direktur {{ get_website_name() }}</div>
	<div id="direktur">{{ $direktur->nama_user }}</div>
	<img id="sign-direktur" src="{{ $signature_direktur != null ? asset('assets/images/signature/'.$signature_direktur->signature) : '' }}" style="display:{{ $signature_direktur != null ? 'block' : 'none' }};">
	<img id="stempel" src="{{ asset('assets/images/others/stempel.png') }}">
	<div id="tanggal">{{ get_kota() }}, {{ generate_date($pelatihan->tanggal_sertifikat_to) }}</div>
	<div id="text-dosen">Manager</div>
	<div id="dosen">{{ $dosen->nama_user }}</div>
	<img id="sign-dosen" src="{{ $signature_dosen != null ? asset('assets/images/signature/'.$signature_dosen->signature) : '' }}" style="display:{{ $signature_dosen != null ? 'block' : 'none' }};">
	<hr id="line-1">
	<hr id="line-2">
	<div id="line-bg-2"></div>
	<div id="line-bg-1"></div>
</body>
</html>