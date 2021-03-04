@extends('template/admin/main')

@section('content')

<div class="preloader-2">
	<div class="preloader-animation" style="background-image: url({{ asset('assets/loaders/preloader.gif') }});"></div>
</div>
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
                <h4 class="page-title">Tambah E-Book</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item"><a href="/admin/file-manager">File Manager</a></li>
                            <li class="breadcrumb-item"><a href="/admin/file-manager/{{ generate_permalink($kategori->folder_kategori) }}">{{ $kategori->folder_kategori }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah E-Book</li>
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
                <div class="row">
                    <div class="col-md-6 mx-md-auto">
                        <div class="card shadow">
                            <h5 class="card-title border-bottom">Tambah E-Book</h5>
                            <div class="card-body">
                                <form id="form" method="post" action="/admin/file-manager/{{ generate_permalink($kategori->folder_kategori) }}/store" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="folder_parent" value="{{ $directory->id_folder }}">
                                    <input type="hidden" name="file_kategori" value="{{ $kategori->id_fk }}">
                                    <input type="hidden" name="file_konten">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>Nama File <span class="text-danger">*</span></label>
                                            <input type="text" name="file_nama" class="form-control {{ $errors->has('file_nama') ? 'is-invalid' : '' }}" value="{{ old('file_nama') }}" placeholder="Masukkan Nama File">
                                            @if($errors->has('file_nama'))
                                            <small class="text-danger">{{ ucfirst($errors->first('file_nama')) }}</small>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Thumbnail</label>
                                            <br>
                                            <input type="file" id="file" class="d-none" accept="image/*">
                                            <button class="btn btn-sm btn-primary btn-file"><i class="fa fa-folder-open mr-2"></i>Pilih Gambar...</button>
                                            <div class="mt-2 text-muted">Resolusi gambar direkomendasikan 16:9</div>
                                            <img id="img-file" class="mt-2 img-thumbnail d-none" style="max-height: 150px">
                                            <input type="hidden" name="thumbnail" id="src-img">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>File PDF</label>
                                            <br>
                                            <input type="file" id="file-pdf" class="d-none" accept="application/pdf">
                                            <button class="btn btn-sm btn-primary btn-file-pdf"><i class="fa fa-folder-open mr-2"></i>Pilih File PDF...</button>
                                            <div class="d-none" id="file-detail">
                                                <div class="mt-3 mb-1"><span id="page-total">0</span> halaman berhasil di-render.</div>
                                                <div class="progress mb-3">
                                                    <div class="progress-bar" id="progressBar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="border-top">
                                <button id="btn-submit" type="submit" class="btn btn-success" disabled>Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="row">
					<div class="col-md-6 mx-auto" id="preview">
					</div>
				</div>
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

<!-- Modal Croppie -->
<div class="modal fade" id="modalCroppie" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Crop Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				<div class="table-responsive">
                	<div id="demo" class="mt-3"></div>
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn-crop">Crop and Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Croppie -->

@endsection

@section('js-extra')

<script type="text/javascript" src="{{ asset('assets/plugins/croppie/croppie.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/pdf.js/pdf.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/pdf.js/pdf.worker.js') }}"></script>
<script type="text/javascript">
/* Croppie */
    var demo = $('#demo').croppie({
        viewport: {width: 640, height: 360},
        boundary: {width: 640, height: 360}
    });
    var imageURL;
	
    // Button File
    $(document).on("click", ".btn-file", function(e){
		e.preventDefault();
        $("#file").trigger("click");
    });
	
    // Change Input File
    $(document).on("change", "#file", function(){
        readURL(this);
        $("#modalCroppie").modal("show");
    });
	
	// Show Modal Croppie
    $('#modalCroppie').on('shown.bs.modal', function(){
        demo.croppie('bind', {
            url: imageURL
        }).then(function(){
            console.log('jQuery bind complete');
        });
    });
	
	// Hide Modal Croppie
    $('#modalCroppie').on('shown.bs.hidden', function(){
		$("#img-file").removeAttr("src");
        $("input[name=thumbnail]").val("");
        $("#file").val(null);
    });

	// Crop Image
    $(document).on("click", "#btn-crop", function(e){
        demo.croppie("result", {
            type: "base64",
            format: "jpg",
            size: {width: 640, height: 360}
        }).then(function(response){
			$("#img-file").attr("src",response).removeClass("d-none");
            $("input[name=thumbnail]").val(response);
        });
        $("#file").val(null);
        $("#modalCroppie").modal("hide");
    });

    function readURL(input){
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function(e){
                imageURL = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<script type="text/javascript">
    /* Upload File */
    $(document).on("click", ".btn-file-pdf", function(e){
        e.preventDefault();
        $("#file-pdf").trigger("click");
    });

    $(document).on("change", "#file-pdf", function(){
        // ukuran maksimal upload file
        $max = 16 * 1024 * 1024;

        // validasi
        if(this.files && this.files[0]) {
            // jika ukuran melebihi batas maksimum
            if(this.files[0].size > $max){
                alert("Maksimal file 16 MB!");
                $(".progress").addClass("d-none");
                $("#file").val(null);
                $("#btn-upload").attr("disabled","disabled");
            }
            // jika ekstensi tidak diizinkan
            else if(!validateExtension(this.files[0].name)){
                alert("Ekstensi file tidak diizinkan!");
                $(".progress").addClass("d-none");
                $("#file").val(null);
                $("#btn-upload").attr("disabled","disabled");
            }
            // validasi sukses
            else{
				showPDF(URL.createObjectURL($("#file-pdf").get(0).files[0]));
                $("#file-detail").removeClass("d-none");
                $(".progress").removeClass("d-none");
                $("#progressBar").text('0%').css({
                    'width' : '0%',
                    'color' : '#333',
                    'margin-left' : '5px',
                    'margin-right' : '5px',
                }).attr('aria-valuenow', 0).removeClass("bg-success");
            }
        }
    });

	// Submit Form
    $(document).on("click", "#btn-submit", function(e){
        e.preventDefault();
		if($("input[name=file_nama]").val() == null || $("input[name=file_nama]").val() == ''){
			alert("Nama file harus diisi!");
		}
		else{
            $(".preloader-2").show();
            var array = [];
            var d = new Date();
            var n = d.getTime();
            var i = 1;
            canvases = $("canvas");
            canvases.each(function(key,elem){
                var code = $(elem).get(0).toDataURL();
                $.ajax({
                    type: 'post',
                    url: '/admin/file-manager/{{ generate_permalink($kategori->folder_kategori) }}/upload-pdf',
                    data: {
                        _token: "{{ csrf_token() }}",
                        code: code,
                        key: key,
                        name: n,
                    },
                    success: function(){
                        if(i == canvases.length){
                            $("input[name=file_konten]").val(n);
                            $("#form").submit();
                        }
                        i++;
                    }
                });
            });
        }
	});

	var currPage = 1; //Pages are 1-based not 0-based
	var numPages = 0;
	var thePDF = null;

	function showPDF(pdf_url) {
		//This is where you start
		PDFJS.getDocument({url : pdf_url}).then(function(pdf) {
			//Set PDFJS global object (so we can easily access in our page functions
			thePDF = pdf;

			//How many pages it has
			numPages = pdf.numPages;

			//Start with first page
			pdf.getPage( 1 ).then( handlePages );
		});
	}

	function handlePages(page)
	{
		//This gives us the page's dimensions at full scale
		var viewport = page.getViewport( 1.5 );

		//We'll create a canvas for each page to draw it on
		var canvas = document.createElement("canvas");
		canvas.style.display = "none";
		var context = canvas.getContext('2d');
		canvas.height = viewport.height;
		canvas.width = viewport.width;

		//Draw it on the canvas
		page.render({canvasContext: context, viewport: viewport});

		//Add it to the web page
		$("#preview").append(canvas);
		$("canvas").addClass("mb-2 mx-auto").css("width", "100%");

		$("#page-total").text(currPage);
		progressHandler(currPage, numPages);

		//Move to next page
		currPage++;
		if ( thePDF !== null && currPage <= numPages )
		{
			thePDF.getPage( currPage ).then( handlePages );
		}
	}

	function progressHandler(loaded, total){
		// hitung prosentase
		var percent = (loaded / total) * 100;

		// menampilkan prosentase ke komponen id 'progressBar'
		$("#progressBar").text(Math.round(percent) + '%').css({
			'width' : Math.round(percent) + '%',
			'color' : '#fff',
			'margin-left' : '0px',
			'margin-right' : '0px',
		}).attr('aria-valuenow', Math.round(percent));

		// jika sudah mencapai 100% akan mengganti warna background menjadi hijau
		if(Math.round(percent) == 100){
            $(".btn-file-pdf").attr("disabled","disabled");
			$("#progressBar").addClass("bg-success");
            // $("#btn-upload").removeAttr("disabled");
            $("#btn-submit").removeAttr("disabled");
			$("#file-pdf").val(null);
		}
		else{
            $("#btn-upload").attr("disabled","disabled");
		}
	}

	// Get file extension
    function getFileExtension(filename){
        var split = filename.split(".");
        var extension = split[split.length - 1];
        return extension;
    }

	// Validate extension
    function validateExtension(filename){
        var ext = getFileExtension(filename);
        var extensions = ['pdf'];
        for(var i in extensions){
            if(ext == extensions[i]) return true;
        }
        return false;
    }
    /* End Upload File */
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/croppie/croppie.css') }}">
<style type="text/css">
    .progress {height: 1rem; background-color: #eeeeee;}
    #uploaded-files {max-height: 250px; overflow-y: auto;}
    .preloader-2 {display: none; position: fixed; height: 100%; width: 100%; top: 0; right: 0; left: 0; bottom: 0; z-index: 9999; background: rgba(0,0,0,.55);}
    .preloader-animation {background-position: center; background-repeat: no-repeat; height: 100%;}
</style>

@endsection