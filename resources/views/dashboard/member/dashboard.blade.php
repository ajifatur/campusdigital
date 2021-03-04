@extends('template/member/main')

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
                <h4 class="page-title">Dashboard</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/member">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
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
            <!-- welcome text -->
            <div class="col-lg-12">
                <div class="alert alert-success text-center shadow">
                    Selamat datang <span class="font-weight-bold">{{ Auth::user()->nama_user }}</span> di {{ get_website_name() }}.
                </div>
            </div>
            <!-- welcome text -->
			@if(Auth::user()->status == 1)
                @if(Auth::user()->role == role_trainer() && $signature == null)
                <div class="col-lg-12">
                    <div class="alert alert-danger text-center shadow">
                        Anda merupakan Mentor tetapi belum mempunyai Tanda Tangan Digital. <a href="/member/e-signature">Buat disini</a>.
                    </div>
                </div>
                @endif
                <div class="col-lg-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <h4 class="card-title text-center">Profil {{ get_website_name() }}</h4>
                            <div class="m-t-20 m-b-20">
						        <div class="ql-snow"><div class="ql-editor p-0">{!! html_entity_decode($deskripsi->deskripsi) !!}</div></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        @foreach($fitur as $data)
                        <a class="col-lg-3 col-md-6" href="/member/{{ $data->url_fitur }}">
                            <div class="card card-hover shadow">
                                <div class="box text-center">
                                    <img src="{{ $data->icon_fitur != '' ? asset('assets/images/fitur/'.$data->icon_fitur) : asset('assets/images/default/fitur.png') }}" height="100">
                                    <h5 class="text-dark mt-2">{{ $data->nama_fitur }}</h5>
                                    <div class="card-caption mb-0 text-secondary"><div>{{ $data->keterangan_fitur }}</div></div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
			@elseif(Auth::user()->status == 0 && Auth::user()->email_verified == 1)
			<div class="col-lg-12">
				<div class="alert alert-warning text-center shadow">
					Email Anda sudah terverifikasi. Tahap selanjutnya adalah melakukan pembayaran.
				</div>
			</div>
            <!-- column -->
            <div class="col-lg-6">
                <!-- card -->
                <div class="card shadow">
                    <div class="card-body text-justify">
                        <h4 class="card-title">Aktivasi Akun Anda</h4>
                        <div class="m-t-20 m-b-20">
                            <div class="alert alert-info">Kode pembayaran Anda adalah <strong>{{ $komisi->inv_komisi }}</strong>. Kode ini akan digunakan saat Anda melakukan konfirmasi pembayaran.</div>
                            <p class="mb-1">Aktivasi akun Anda dengan melakukan pembayaran sejumlah <del>Rp. 499.000</del> <strong>Rp. {{ number_format($komisi->komisi_aktivasi,0,'.','.') }}</strong> ke rekening berikut:</p>
                            <ol>
                                @foreach($default_rekening as $data)
                                <li><strong>{{ $data->nama_platform }}</strong> dengan nomor rekening <strong>{{ $data->nomor }}</strong> a/n <strong>{{ $data->atas_nama }}</strong>.</li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- column -->
            <!-- column -->
            <div class="col-lg-6">
                <!-- card -->
                <div class="card shadow">
                    <div class="card-body text-justify">
                        <h4 class="card-title">Anda Sudah Membayar?</h4>
                        <div class="m-t-20 m-b-20">
                            @if($komisi->komisi_proof == '')
                            <p>Jika Anda sudah membayar, segera lakukan konfirmasi pembayaran <a href="#" class="font-weight-bold" id="btn-confirm">DISINI</a>.</p>
                            @else
                            <div class="alert alert-success">Anda sudah membayar dan melakukan konfirmasi pembayaran. Tunggu beberapa saat sampai pihak Admin memverifikasi konfirmasi pembayaran Anda.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- column -->
			@elseif(Auth::user()->status == 0 && Auth::user()->email_verified == 0)
			<div class="col-lg-12">
				<div class="alert alert-warning text-center shadow">
					<i class="fa fa-exclamation-triangle mr-2"></i> Verifikasi email Anda untuk dapat menuju ke tahap berikutnya. <strong>Cek inbox email Anda atau juga di folder spam untuk melakukan verifikasi email.</strong>
				</div>
			</div>
			@endif
        </div>
        <!-- ============================================================== -->
        <!-- Recent comment and chats -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    @include('template/member/_footer')
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->

@if(count($popup)>0)
<!-- Popup -->
<div class="modal fade" id="popupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center p-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
				<div class="owl-carousel owl-theme carousel-popup">
					@foreach($popup as $key=>$data)
						@if(filter_var($data->popup_gambar, FILTER_VALIDATE_URL))
						<div class="item item-video">
							<a class="owl-video" href="{{ $data->popup_gambar }}" title="{{ $data->popup_judul }}. Klik untuk info lebih lanjut"></a>
						</div>
						@else
							<div class="item">
								<a href="/member/informasi/detail/{{ $data->id_popup }}" title="{{ $data->popup_judul }}. Klik untuk info lebih lanjut">
									<img src="{{ asset('assets/images/pop-up/'.$data->popup_gambar) }}" class="img-fluid">
								</a>
							</div>
						@endif
					@endforeach
				</div>
            </div>
        </div>
    </div>
</div>
<!-- Popup -->
@endif

@if(Auth::user()->status == 0)
<!-- Modal Konfirmasi Pembayaran -->
<div class="modal fade" id="modalKonfirmasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				<form id="form-confirmation" method="post" action="/member/transaksi/komisi/konfirmasi" enctype="multipart/form-data">
					{{ csrf_field() }}
                    <div class="form-group">
                        <label>Kode Pembayaran <span class="text-danger">*</span></label>
                        <input type="text" name="kode_pembayaran" class="form-control" placeholder="Masukkan Kode Pembayaran" value="{{ $komisi->inv_komisi }}" readonly>
                    </div>
					<input type="file" name="foto" id="file" class="d-none" name="bukti_pembayaran" accept="image/*">
				</form>
                <button type="button" class="btn btn-md btn-primary" id="btn-upload">Upload Bukti Pembayaran</button>
				<img id="foto" class="img-thumbnail mt-3">
            </div>
            <div class="modal-footer">
				<button type="button" class="btn btn-md btn-success" id="btn-submit-confirmation" disabled>Submit</button>
			</div>
        </div>
    </div>
</div>
<!-- End Modal Konfirmasi Pembayaran -->
@endif

@endsection

@section('js-extra')

<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
	@if(count($popup)>0)
        // Popup Modal
        $(window).on("load", function(){
            $("#popupModal").modal("show");
        });
        
        var owl = $(".carousel-popup").owlCarousel({
            loop: true,
            nav: true,
            dots: false,
            items: 1,
            autoHeight: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            video: false,
        });
		owl.on('changed.owl.carousel', function(event) {
			if( $(".owl-item.active iframe", this.$element)[0]){
				$(".owl-item.active iframe", this.$element)[0].play();
			}
		});
	@endif

	// Button Konfirmasi Pembayaran
    $(document).on("click", "#btn-confirm", function(e){
        e.preventDefault();
        $("#modalKonfirmasi").modal("show");
    });
	
	// Upload Bukti Pembayaran
	$(document).on("click", "#btn-upload", function(e){
        e.preventDefault();
		$("#file").trigger("click");
	});
	
	$(document).on("change", "#file", function(){
		// jika ekstensi tidak diizinkan
		if(!validateExtension(this.files[0].name)){
			alert("Ekstensi file tidak diizinkan! Hanya mengizinkan ekstensi JPG, JPEG, PNG, SVG dan GIF.");
			$("#file").val(null);
			$("#btn-submit-confirmation").attr("disabled","disabled");
		}
		else{
			readURL(this);
			$.trim($("input[name=kode_pembayaran]").val()) != '' || $.trim($("input[name=kode_pembayaran]").val()) != null ? $("#btn-submit-confirmation").removeAttr("disabled") : $("#btn-submit-confirmation").attr("disabled", "disabled");
		}
	});
	
	// Read URL
    function readURL(input){
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function(e){
                $("#foto").attr("src",e.target.result).show();
            }
            reader.readAsDataURL(input.files[0]);
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
        var extensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
        for(var i in extensions){
            if(ext == extensions[i]) return true;
        }
        return false;
    }
	
	// Button Submit
    $(document).on("click", "#btn-submit-confirmation", function(e){
		e.preventDefault();
        $("#form-confirmation").submit();
    });

    // Mouseover
    $(document).on("mouseover", ".card-caption", function(){
        var captionHeight = $(this).height();
        var innerHeight = $(this).find("div").height();
        innerHeight >= captionHeight ? $(this).css("overflow-y","scroll") : $(this).css("overflow-y","hidden");
    });

    // Mouseleave
    $(document).on("mouseleave", ".card-caption", function(){
        var captionHeight = $(this).height();
        var innerHeight = $(this).find("div").height();
        innerHeight >= captionHeight ? $(this).css("overflow-y","hidden") : $(this).css("overflow-y","hidden");
    });
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" />
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style type="text/css">
	#foto {display: none; max-width: 350px;}
	#popupModal .close {position: absolute; right: -15px; top: -15px; background-color: {{ get_warna_primer() }}; color: {{ get_warna_sekunder() }}; width: 25px; height: 25px; opacity: 1!important; z-index: 2;}
	.owl-nav {position: absolute; width: 100%; top: 45%;}
	.owl-carousel .owl-nav button.owl-prev {position: absolute; font-size: 30px; top: 0; left: -10px; width: 20px; background-color: {{ get_warna_sekunder() }}; color: {{ get_warna_primer() }};}
	.owl-carousel .owl-nav button.owl-next {position: absolute; font-size: 30px; top: 0; right: -10px; width: 20px; background-color: {{ get_warna_sekunder() }}; color: {{ get_warna_primer() }};}
	.owl-carousel .owl-nav button.owl-prev:hover, .owl-carousel .owl-nav button.owl-next:hover {background-color: #ad993b;}
    @media (min-width: 768px) { .card-caption {height: 5rem; overflow-y: hidden;} }
	.item-video, .item-video iframe {height: 400px;}

    /* Quill */
    .ql-editor h2, .ql-editor h3 {margin-bottom: 1rem!important; font-weight: 600!important;}
    .ql-editor p {margin-bottom: 1rem!important;}
    .ql-editor ol {padding-left: 30px!important;}
    .ql-editor ol li {font-size: 14px!important; color: #74757f!important; padding-left: 5px!important;}
</style>

@endsection