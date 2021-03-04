@extends('template/admin/main')

@section('content')

<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
     <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">E-Signature</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">E-Signature</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- URL Referral -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- column -->
            <div class="col-lg-12">
                <!-- card -->
                <div class="card shadow">
                    <div class="card-title border-bottom">
                        <div class="row">
                            <div class="col-12 col-sm py-1 mb-2 mb-sm-0 text-center text-sm-left">
                                <h5 class="mb-0">E-Signature</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(Session::get('message') != null)
                            <div class="alert alert-success alert-dismissible mb-4 fade show" role="alert">
                                {{ Session::get('message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
						<!-- Content -->
						<div class="row">
							<div class="col-lg-6">
								<div class="row">
									<div class="col-md-12">
										<p>Tulis tanda tangan Anda di bawah ini:</p>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<canvas id="sig-canvas" width="500" height="250" style="width: 100%">
											Browser Anda tidak support, bro.
										</canvas>
									</div>
								</div>
								<div class="row mt-2">
									<div class="col-md-12">
										<button class="btn btn-primary" id="sig-submitBtn">Simpan</button>
										<button class="btn btn-danger" id="sig-clearBtn">Bersihkan</button>
									</div>
								</div>
								<br/>
								<div class="row">
									<div class="col-md-12">
										<form id="form" method="post" action="/admin/e-signature/update" class="d-none">
											{{ csrf_field() }}
											<input type="hidden" name="signature" id="sig-dataUrl">
											<img id="sig-image" class="d-none" src="" alt="Your signature will go here!"/>
										</form>
									</div>
								</div>
								<div class="row mt-3">
									<div class="col-md-12">
										<label>Atau upload tanda tangan Anda disini (Format PNG):</label>
										<br>
										<input type="file" id="file" class="d-none" accept="image/*">
										<button class="btn btn-success" id="btn-upload"><i class="fa fa-folder-open mr-2"></i>Upload</button>
										<br>
										<img class="img-thumbnail mt-3 d-none" id="img-upload" style="max-height: 200px;">
										<form id="form-2" method="post" action="/admin/e-signature/update" class="d-none">
											{{ csrf_field() }}
											<input type="hidden" name="upload" id="input-upload">
										</form>
										<br>
										<button class="btn btn-primary mt-3 d-none" id="btn-submit">Simpan</button>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="row">
									<div class="col-md-12">
										<p>Tanda tangan Anda:</p>
										<img src="{{ $signature != null ? asset('assets/images/signature/'.$signature->signature) : '' }}" class="img-thumbnail {{ $signature != null ? '' : 'd-none' }}" style="max-height: 200px;">
									</div>
								</div>
							</div>
						</div>
                    </div>
                </div>
                <!-- card -->
            </div>
            <!-- column -->
        </div>
        <!-- ============================================================== -->
        <!-- Recent comment and chats -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    @include('template/admin/_footer')
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->

@endsection

@section('js-extra')

<script type="text/javascript">
(function() {
  window.requestAnimFrame = (function(callback) {
    return window.requestAnimationFrame ||
      window.webkitRequestAnimationFrame ||
      window.mozRequestAnimationFrame ||
      window.oRequestAnimationFrame ||
      window.msRequestAnimaitonFrame ||
      function(callback) {
        window.setTimeout(callback, 1000 / 60);
      };
  })();

  var canvas = document.getElementById("sig-canvas");
  var ctx = canvas.getContext("2d");
  ctx.strokeStyle = "#222222";
  ctx.lineWidth = 5;

  var drawing = false;
  var mousePos = {
    x: 0,
    y: 0
  };
  var lastPos = mousePos;

  canvas.addEventListener("mousedown", function(e) {
    drawing = true;
    lastPos = getMousePos(canvas, e);
  }, false);

  canvas.addEventListener("mouseup", function(e) {
    drawing = false;
  }, false);

  canvas.addEventListener("mousemove", function(e) {
    mousePos = getMousePos(canvas, e);
  }, false);

  // Add touch event support for mobile
  canvas.addEventListener("touchstart", function(e) {

  }, false);

  canvas.addEventListener("touchmove", function(e) {
    var touch = e.touches[0];
    var me = new MouseEvent("mousemove", {
      clientX: touch.clientX,
      clientY: touch.clientY
    });
    canvas.dispatchEvent(me);
  }, false);

  canvas.addEventListener("touchstart", function(e) {
    mousePos = getTouchPos(canvas, e);
    var touch = e.touches[0];
    var me = new MouseEvent("mousedown", {
      clientX: touch.clientX,
      clientY: touch.clientY
    });
    canvas.dispatchEvent(me);
  }, false);

  canvas.addEventListener("touchend", function(e) {
    var me = new MouseEvent("mouseup", {});
    canvas.dispatchEvent(me);
  }, false);

  function getMousePos(canvasDom, mouseEvent) {
    var rect = canvasDom.getBoundingClientRect();
    return {
      x: mouseEvent.clientX - rect.left,
      y: mouseEvent.clientY - rect.top
    }
  }

  function getTouchPos(canvasDom, touchEvent) {
    var rect = canvasDom.getBoundingClientRect();
    return {
      x: touchEvent.touches[0].clientX - rect.left,
      y: touchEvent.touches[0].clientY - rect.top
    }
  }

  function renderCanvas() {
    if (drawing) {
      ctx.moveTo(lastPos.x, lastPos.y);
      ctx.lineTo(mousePos.x, mousePos.y);
      ctx.stroke();
      lastPos = mousePos;
    }
  }

  // Prevent scrolling when touching the canvas
  document.body.addEventListener("touchstart", function(e) {
    if (e.target == canvas) {
      e.preventDefault();
    }
  }, false);
  document.body.addEventListener("touchend", function(e) {
    if (e.target == canvas) {
      e.preventDefault();
    }
  }, false);
  document.body.addEventListener("touchmove", function(e) {
    if (e.target == canvas) {
      e.preventDefault();
    }
  }, false);

  (function drawLoop() {
    requestAnimFrame(drawLoop);
    renderCanvas();
  })();

  function clearCanvas() {
    canvas.width = canvas.width;
  }

  // Set up the UI
  var sigText = document.getElementById("sig-dataUrl");
  var sigImage = document.getElementById("sig-image");
  var clearBtn = document.getElementById("sig-clearBtn");
  var submitBtn = document.getElementById("sig-submitBtn");
  clearBtn.addEventListener("click", function(e) {
    clearCanvas();
    sigText.value = "";
  }, false);
  submitBtn.addEventListener("click", function(e) {
    var dataUrl = canvas.toDataURL();
    sigText.value = dataUrl;
	document.getElementById("form").submit();
  }, false);
})();

	/* Upload File */
	$(document).on("click", "#btn-upload", function(e){
		e.preventDefault();
		$("#file").trigger("click");
	});

	// File Change
    $(document).on("change", "#file", function(){
        // ukuran maksimal upload file
		var maximum = 1;
        var max = maximum * 1024 * 1024;

        // validasi
        if(this.files && this.files[0]) {
            // jika ukuran melebihi batas maksimum
            if(this.files[0].size > max){
                alert("Ukuran file terlalu besar dan melebihi batas maksimum! Maksimal adalah "+maximum+" MB.");
                $("#file").val(null);
            }
            // jika ekstensi tidak diizinkan
            else if(!validateExtension(this.files[0].name)){
                alert("Ekstensi file tidak diizinkan!");
                $("#file").val(null);
            }
            // validasi sukses
            else{
				readURL(this);
            }
        }
    });
	
	// Btn-submit
	$(document).on("click", "#btn-submit", function(e){
		e.preventDefault();
		$("#form-2").submit();
	});

	// Get file extension
    function getFileExtension(filename){
        var split = filename.split(".");
        var extension = split[split.length - 1];
        return extension;
    }

	// Validate extension
    function validateExtension(filename){
        var ext = getFileExtension(filename);
        var extensions = ['png'];
        for(var i in extensions){
            if(ext == extensions[i]) return true;
        }
        return false;
    }

    function readURL(input){
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function(e){
                $("#img-upload").attr("src",e.target.result).removeClass("d-none");
                $("#input-upload").val(e.target.result);
                $("#btn-submit").removeClass("d-none");
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection

@section('css-extra')

<style type="text/css">
    .border-top, .border-bottom {padding: 1.25rem;}
    .form-control {border-color: #caccce;}
    .input-group-text {border-color: #caccce;}
	.box {background-color: #fdd100!important; cursor: pointer;}
	#sig-canvas {border: 2px dotted #CCCCCC; border-radius: 15px; cursor: crosshair;}
</style>

@endsection