<!DOCTYPE html>
<html>
<head>
	<!--<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato:400,700" />-->
	<title>ID Card</title>
	<link rel="shortcut icon" href="{{ asset('assets/images/logo/'.get_icon()) }}">
	<style type="text/css">
		@font-face {font-family: 'Lato-Regular'; src: url({{ asset('assets/fonts/Lato-Regular.ttf') }});}
		@font-face {font-family: 'Lato-Bold'; src: url({{ asset('assets/fonts/Lato-Bold.ttf') }});}
		@font-face {font-family: 'Lato-Bold-Italic'; src: url({{ asset('assets/fonts/Lato-Bold-Italic.ttf') }});}
		
		@page {size: 250pt 400pt; margin: 0px; border-radius: 16px;}
		html {margin: 0px;}
		body {margin: 0px; font-family: 'Lato-Regular'; font-size: 18.5px; background-color: #eeeeef;}
		#logo {position: absolute; top: 30px; width: 100%; text-align: center;}
		#img-logo {max-height: 100px;}
		#photo {position: absolute; top: 180px; width: 100%; text-align: center;}
		#img-photo {height: 150px; width: 150px;}
		#identity {position: absolute; top: 375px; width: 100%; height: 150px; text-align: center;}
		#nama {font-family: 'Lato-Bold-Italic'; font-size: 22px; text-decoration: underline;}
		#tipe {font-family: 'Lato'; font-size: 16px; margin-top: 3px;}
		#line-bg-1 {position: absolute; bottom: 0; height: 25px; width: 100%; background-color: {{ get_warna_garis_1() }};}
		#line-bg-2 {position: absolute; bottom: 25px; height: 5px; width: 100%; background-color: {{ get_warna_garis_2() }};}
	</style>
</head>
<body>
	<div id="logo"><img id="img-logo" src="{{ asset('assets/images/logo/'.get_logo()) }}"></div>
	<div id="photo"><img id="img-photo" src="{{ asset('assets/images/users/'.Auth::user()->foto) }}"></div>
	<div id="identity">
		<div id="nama">{{ $member->nama_user}}</div>
		<div id="tipe">{{ $member->role != role_member() ? $member->nama_role : 'Member' }}</div>
	</div>
	<div id="line-bg-2"></div>
	<div id="line-bg-1"></div>
</body>
</html>