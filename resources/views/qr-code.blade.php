<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
    
<div class="visible-print text-center">
	<h1>Laravel 5.7 - QR Code Generator Example</h1>
     
    {!! QrCode::size(250)->generate('https://campusdigital.id/cek-sertifikat/1'); !!}
     
    <p>example by ItSolutionStuf.com.</p>
</div>
    
</body>
</html>