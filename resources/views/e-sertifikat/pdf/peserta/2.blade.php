<!DOCTYPE html>
<html>
<head>
	<!--<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato:400,700" />-->
	<title>Sertifikat Peserta Pelatihan</title>
	<link rel="shortcut icon" href="{{ asset('assets/images/logo/'.get_icon()) }}">
	<style type="text/css">
		@font-face {font-family: 'Lato-Regular'; src: url({{ asset('assets/fonts/Lato-Regular.ttf') }});}
		@font-face {font-family: 'Lato-Bold'; src: url({{ asset('assets/fonts/Lato-Bold.ttf') }});}
		@font-face {font-family: 'Lato-Bold-Italic'; src: url({{ asset('assets/fonts/Lato-Bold-Italic.ttf') }});}
		
		@page {margin: 0px;}
		html {margin: 0px;}
		body {margin: 0px; font-family: 'Lato-Regular'; font-size: 18.5px; background-color: {{ get_warna_background_sertifikat() }};}
		#nomor-seri {font-size: 12px; position: absolute; top: 5px; left: 15px;}
		#text-materi {font-family: 'Lato-Bold'; font-size: 24px; position: absolute; top: 70px; left: 88px; width: 950px; text-align: center; text-transform: uppercase;}
		#table {position: absolute; top: 140px; left: 88px; width: 950px;}
		#table table {width: 100%; border-collapse: collapse; font-size: 17px;}
		#table table td {padding: 0px 5px;}
		#table table thead td, #table table tfoot td {font-family: 'Lato-Bold'; border: 1px #333 solid;}
		#table table tbody tr td {border-left: 1px #333 solid; border-right: 1px #333 solid;}
		#tanggal {position: absolute; top: 575px; left: 88px; width: 950px; text-align: center;}
		#div-sign {position: absolute; top: 620px; left: 88px; width: 950px; text-align: center;}
		#sign-trainer {max-height: 90px;}
		#text-trainer {position: absolute; top: 597px; left: 88px; width: 950px; text-align: center;}
		#trainer {position: absolute; top: 705px; left: 88px; width: 950px; text-align: center;}
		#div-line {position: absolute; top: 695px; text-align: center;}
		#line {width: 250px; border-color: #333; border-width: 1.25px;}
		#line-bg-2 {position: absolute; bottom: 25px; height: 5px; width: 100%; background-color: {{ get_warna_garis_2() }};}
		#line-bg-1 {position: absolute; bottom: 0; height: 25px; width: 100%; background-color: {{ get_warna_garis_1() }};}
		
		#logo {position: absolute; top: 50px; left: 88px; width: 950px; text-align: center;}
		#img-logo {max-height: 110px;}
		#text-diberikan-kepada {font-family: 'Lato-Bold'; font-size: 23px; position: absolute; top: 302px; left: 88px; width: 950px; text-align: center;}
		#nama {font-family: 'Lato-Bold-Italic'; font-size: 58px; position: absolute; top: 325px; left: 88px; width: 950px; text-align: center; text-decoration: underline;}
		#tipe {font-family: 'Lato-Bold'; font-size: 18px; position: absolute; top: 440px; left: 88px; width: 950px; text-align: center;}
		#deskripsi {position: absolute; top: 488px; left: 88px; width: 950px; line-height: 20px;}
		#judul {font-family: 'Lato-Bold';}
		#text-mengetahui {position: absolute; top: 575px; left: 88px;}
		#text-direktur {position: absolute; top: 597px; left: 88px;}
		#direktur {position: absolute; top: 705px; left: 88px;}
		#sign-direktur {position: absolute; top: 620px; left: 108px; max-height: 90px;}
		#line-1 {position: absolute; top: 708px; left: 85px; width: 250px; border-color: #333; margin: 0; border-width: 1.25px;}
	</style>
</head>
<body>
	<div id="nomor-seri">Nomor Seri: {{ $member->kode_sertifikat }}</div>
	<div id="text-materi">Materi {{ $pelatihan->kategori }}</div>
	<div id="table">
		<table>
			<thead>
				<tr>
					<td align="center">No.</td>
					<td align="center">Kode Unit Kompetensi</td>
					<td>Judul Unit Kompetensi</td>
					<td align="center">Durasi (JP)</td>
				</tr>
			</thead>
			<tbody>
				@foreach($pelatihan->materi_pelatihan as $key=>$materi)
				<tr>
					<td align="center">{{ ($key+1) }}.</td>
					<td align="center">{{ $materi['kode'] }}</td>
					<td>{{ $materi['judul'] }}</td>
					<td align="center">{{ $materi['durasi'] }} Jam</td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td align="center" colspan="3">TOTAL WAKTU</td>
					<td align="center">{{ $pelatihan->total_jam_pelatihan }} Jam</td>
				</tr>
			</tfoot>
		</table>
	</div>
	<div id="tanggal">{{ get_kota() }}, {{ generate_date($pelatihan->tanggal_pelatihan_to) }}</div>
	<div id="text-trainer">Trainer</div>
	<div id="div-sign">
		<img id="sign-trainer" src="{{ $signature_trainer != null ? asset('assets/images/signature/'.$signature_trainer->signature) : '' }}" style="display:{{ $signature_trainer != null ? 'block' : 'none' }};">
	</div>
	<div id="trainer">{{ $pelatihan->nama_user }}</div>
	<div id="div-line"><hr id="line"></div>
	<div id="line-bg-2"></div>
	<div id="line-bg-1"></div>
</body>
</html>