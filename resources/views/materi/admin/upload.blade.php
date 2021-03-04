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
                <h4 class="page-title">Upload Materi</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item"><a href="/admin/materi/{{ generate_permalink($kategori->kategori) }}">Materi {{ $kategori->kategori }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Upload Materi</li>
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
                            <h5 class="card-title border-bottom">Upload Materi</h5>
                            <div class="card-body text-center">
								<button id="btn-choose" type="button" class="btn btn-md btn-cyan mr-2"><i class="fa fa-folder-open mr-2"></i>Pilih File...</button>
								<input type="file" id="file" class="d-none" accept="application/pdf"/>
								<input type="hidden" name="id_folder" id="id_folder" value="{{ $directory->id_folder }}">
								<input type="hidden" name="jenis_file" id="jenis_file" value="{{ $kategori->id_km }}">
								<div class="d-none" id="file-detail">
									<input type="text" id="nama_file" class="form-control mt-3" placeholder="Masukkan Nama File...">
									<div class="mt-3 mb-1"><span id="page-total">0</span> halaman berhasil di-render.</div>
									<div class="progress mb-3">
										<div class="progress-bar" id="progressBar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
									</div>
									<button id="btn-upload" type="button" class="btn btn-md btn-primary"><i class="fa fa-upload mr-2" disabled></i>Upload</button>
								</div>
                            </div>
                            <div class="border-top">
                                <a href="/admin/materi/{{ generate_permalink($kategori->kategori) }}?dir={{ $directory->dir_folder }}" class="btn btn-block btn-warning">Kembali ke Materi {{ $kategori->kategori }}</a>
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

@endsection

@section('js-extra')

<script type="text/javascript" src="{{ asset('assets/plugins/pdf.js/pdf.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/pdf.js/pdf.worker.js') }}"></script>
<script type="text/javascript">
    /* Upload File */
    $(document).on("click", "#btn-choose", function(e){
        e.preventDefault();
        $("#file").trigger("click");
    });

    $(document).on("change", "#file", function(){
        // ukuran maksimal upload file
        $max = 16 * 1024 * 1024;

        // validasi
        if(this.files && this.files[0]) {
            // jika ukuran melebihi batas maksimum
            if(this.files[0].size > $max){
                alert("Ukuran file terlalu besar dan melebihi batas maksimum!");
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
				showPDF(URL.createObjectURL($("#file").get(0).files[0]));
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

	// Upload File
    $(document).on("click", "#btn-upload", function(e){
        e.preventDefault();
		if($("#nama_file").val() == null || $("#nama_file").val() == ''){
			alert("Nama file harus diisi!");
		}
		else{
			$(".preloader-2").show();
			var array = [];
			var d = new Date();
			var n = d.getTime();

			$.ajax({
				type: 'post',
				url: '/admin/materi/{{ generate_permalink($kategori->kategori) }}/upload',
				data: {
					_token: "{{ csrf_token() }}",
					id_folder: $("#id_folder").val(),
					jenis_file: $("#jenis_file").val(),
					nama_file: $("#nama_file").val(),
					name: n,
					detail: 0
				},
				success: function(response){
					console.log(response);
				}
			});

			var i = 1;
			canvases = $("canvas");
			canvases.each(function(key,elem){
				var code = $(elem).get(0).toDataURL();
				$.ajax({
					type: 'post',
					url: '/admin/materi/{{ generate_permalink($kategori->kategori) }}/upload',
					data: {
						_token: "{{ csrf_token() }}",
						id_folder: $("#id_folder").val(),
						jenis_file: $("#jenis_file").val(),
						nama_file: $("#nama_file").val(),
						code: code,
						key: key,
						name: n,
						detail: 1
					},
					success: function(){
						if(i == canvases.length){
							alert('Sukses mengupload file!');
							window.location.href = '/admin/materi/{{ generate_permalink($kategori->kategori) }}?dir={{ $directory->dir_folder }}';
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
            $("#btn-choose").addClass("d-none");
			$("#progressBar").addClass("bg-success");
            $("#btn-upload").removeAttr("disabled");
			$("#file").val(null);
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

<style type="text/css">
    .progress {height: 1rem; background-color: #eeeeee;}
    #uploaded-files {max-height: 250px; overflow-y: auto;}
    .preloader-2 {display: none; position: fixed; height: 100%; width: 100%; top: 0; right: 0; left: 0; bottom: 0; z-index: 9999; background: rgba(0,0,0,.55);}
    .preloader-animation {background-position: center; background-repeat: no-repeat; height: 100%;}
</style>

@endsection