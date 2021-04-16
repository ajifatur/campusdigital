<!DOCTYPE html>
<html>
<head>
	<!--<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato:400,700" /> #fff57e-->
	<title>Sertifikat Peserta Pelatihan</title>
	<link rel="shortcut icon" href="{{ asset('assets/images/logo/'.get_icon()) }}">
	<style type="text/css">
		@font-face {font-family: 'Lato-Regular'; src: url({{ asset('assets/fonts/Lato-Regular.ttf') }});}
		@font-face {font-family: 'Lato-Bold'; src: url({{ asset('assets/fonts/Lato-Bold.ttf') }});}
		@font-face {font-family: 'Lato-Bold-Italic'; src: url({{ asset('assets/fonts/Lato-Bold-Italic.ttf') }});}
		
		@page {margin: 0px;}
		html {margin: 0px;}
		body {margin: 0px; font-family: 'Lato-Regular'; font-size: 18.5px; background-color: {{ get_warna_background_sertifikat() }};}
		.pattern {position: absolute; top: 0px; left: 0px; width: 100%;}
		#nomor-seri {font-size: 12px; position: absolute; top: 5px; left: 15px;}
		#qr-code {position: absolute; top: 15px; right: 15px;}
		#logo {position: absolute; left: 88px; top: {{ $pelatihan->id_pelatihan < 18 ? '50px' : '40px' }}; width: 950px; text-align: center;}
		#img-logo {max-height: {{ $pelatihan->id_pelatihan < 18 ? '110px' : '120px' }};}
		#text-sertifikat {font-family: 'Lato-Bold'; font-size: 66px; position: absolute; top: 145px; left: 88px; width: 950px; color: #d4b064; text-align: center; text-transform: uppercase;}
		#nomor-sertifikat {font-size: 29px; position: absolute; top: 242px; left: 88px; width: 950px; text-align: center;}
		#text-diberikan-kepada {font-family: 'Lato-Bold'; font-size: 23px; position: absolute; top: 302px; left: 88px; width: 950px; text-align: center;}
		#nama {font-family: 'Lato-Bold-Italic'; font-size: {{ $member->id_user == 642 || $member->id_user == 650 ? '40px' : '58px' }}; position: absolute; top: {{ $member->id_user == 642 || $member->id_user == 650 ? '340px' : '325px' }}; left: 88px; width: 950px; text-align: center; text-decoration: underline;}
		#tipe {font-family: 'Lato-Bold'; font-size: 21px; position: absolute; top: 437px; left: 88px; width: 950px; text-align: center;}
		#deskripsi {position: absolute; top: 488px; left: 88px; width: 950px; line-height: 20px; text-align: center;}
		#judul {font-family: 'Lato-Bold';}
		#predikat {font-family: 'Lato-Bold'; font-size: 21px;}
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
		
		#page-break {page-break-after: always;}
		
		#text-materi {font-family: 'Lato-Bold'; font-size: 24px; position: absolute; top: 70px; left: 88px; width: 950px; text-align: center; text-transform: uppercase;}
		#table {position: absolute; top: 140px; left: 88px; width: 950px;}
		#table table {width: 100%; border-collapse: collapse; font-size: 17px;}
		#table table td {padding: 0px 5px;}
		#table table thead td, #table table tfoot td {font-family: 'Lato-Bold'; border: 1px #333 solid;}
		#table table tbody tr td {border-left: 1px #333 solid; border-right: 1px #333 solid;}
		#tanggal-2 {position: absolute; top: 575px; left: 88px; width: 950px; text-align: center;}
		#div-sign {position: absolute; top: 620px; left: 88px; width: 950px; text-align: center;}
		#sign-trainer {max-height: 90px;}
		#stempel-2 {position: absolute; top: 620px; left: 415px; max-height: 90px;}
		#text-trainer {position: absolute; top: 597px; left: 88px; width: 950px; text-align: center;}
		#trainer {position: absolute; top: 705px; left: 88px; width: 950px; text-align: center;}
		#div-line {position: absolute; top: 695px; text-align: center;}
		#line {width: 250px; border-color: #333; border-width: 1.25px;}
	</style>
</head>
@php
	if($member->status_pelatihan == 11)
		$status_pelatihan = 'A (Sangat Baik)';
	elseif($member->status_pelatihan == 12)
		$status_pelatihan = 'B (Baik)';
	elseif($member->status_pelatihan == 13)
		$status_pelatihan = 'C (Cukup)';
	else
		$status_pelatihan = '';
@endphp
<body>
	<!--<div class="pattern"><img src="{{ asset('assets/images/others/bg-pattern.png') }}" width="100%"></div>-->
	<div id="nomor-seri">Nomor Seri: {{ $member->kode_sertifikat }}</div>
	<div id="logo"><img id="img-logo" src="{{ $pelatihan->id_pelatihan < 18 ? asset('assets/images/logo/'.get_logo()) : asset('assets/images/logo/6.png') }}"></div>
	<div id="qr-code">
		<img width="80" src="data:image/png;base64, {!! $qrcode !!}">
	</div>
	<div id="text-sertifikat">Sertifikat</div>
	<div id="nomor-sertifikat">Nomor: {{ $pelatihan->nomor_pelatihan }}</div>
	<div id="text-diberikan-kepada">Diberikan Kepada:</div>
	<div id="nama">{{ $member->nama_user}}</div>
	<div id="tipe">Sebagai Peserta</div>
	<div id="deskripsi">
		{{ $pelatihan->kategori }} dengan tema <span id="judul">"{{ $pelatihan->nama_pelatihan }}"</span>.
		<br>
		Diselenggarakan oleh {{ get_website_name() }} pada tanggal {{ date('Y-m-d', strtotime($pelatihan->tanggal_sertifikat_from)) == date('Y-m-d', strtotime($pelatihan->tanggal_sertifikat_to)) ? generate_date($pelatihan->tanggal_sertifikat_to) : generate_date($pelatihan->tanggal_sertifikat_from).' sampai '.generate_date($pelatihan->tanggal_sertifikat_to) }}{{ $pelatihan->tempat_pelatihan != '' ? ' di '.$pelatihan->tempat_pelatihan : '' }}{{ $status_pelatihan == '' ? '.' : ',' }}
		@if($status_pelatihan != '')
			<br>
			dengan predikat:
			<span id="predikat">{{ $status_pelatihan }}</span>
		@endif
	</div>
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
	<div id="page-break"></div>
	<!-- <div class="pattern"><img src="{{ asset('assets/images/others/bg-pattern.png') }}" width="100%"></div> -->
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
	<div id="tanggal-2">{{ get_kota() }}, {{ generate_date($pelatihan->tanggal_sertifikat_to) }}</div>
	<div id="text-trainer">Trainer</div>
	<div id="div-sign">
		<img id="sign-trainer" src="{{ $signature_trainer != null ? asset('assets/images/signature/'.$signature_trainer->signature) : '' }}" style="display:{{ $signature_trainer != null ? 'block' : 'none' }};">
	</div>
	<img id="stempel-2" src="{{ asset('assets/images/others/stempel.png') }}">
	<div id="trainer">{{ $pelatihan->nama_user }}</div>
	<div id="div-line"><hr id="line"></div>
	<div id="line-bg-2"></div>
	<div id="line-bg-1"></div>
</body>
</html>