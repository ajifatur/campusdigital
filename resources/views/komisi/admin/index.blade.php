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
                <h4 class="page-title">Komisi</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Komisi</li>
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
                    <h5 class="card-title border-bottom">Komisi</h5>
                    <div class="card-body">
                        @if(Session::get('message') != null)
                            <div class="alert alert-success alert-dismissible mb-4 fade show" role="alert">
                                {{ Session::get('message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table id="table-arsip-komisi" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="40">No.</th>
                                        <th width="80">Invoice</th>
                                        <th width="100">Tanggal</th>
                                        <th>Nama User</th>
                                        <th>Sponsor</th>
                                        <th width="150">Komisi</th>
                                        <th width="80">Status</th>
                                        <th width="40">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($komisi as $data)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $data->inv_komisi }}</td>
                                        <td>
											@if($data->komisi_at != null)
											<span title="{{ date('d/m/Y H:i:s', strtotime($data->komisi_at)) }}" style="text-decoration: underline; cursor: help;">{{ date('d/m/Y', strtotime($data->komisi_at)) }}</span></td>
											@else
											-
											@endif
                                        <td>
											<a href="/admin/user/detail/{{ $data->id_user }}">{{ $data->nama_user }}</a>
											<br>
											<small>{{ $data->email }}</small>
											<br>
											<small class="text-success">{{ $data->nomor_hp }}</small>
										</td>
                                        <td><a href="/admin/user/detail/{{ $data->id_sponsor->id_user }}">{{ $data->id_sponsor->nama_user }}</a> <span class="font-weight-bold">{{ $data->id_sponsor->is_admin == 1 ? '(Admin)' : '' }}</span></td>
                                        <td>
                                            <strong>Aktivasi Komisi:</strong><br>
                                            Rp. {{ number_format($data->komisi_aktivasi,0,',','.') }}<br><br>
                                            <strong>Hasil Komisi:</strong><br>
                                            Rp. {{ number_format($data->komisi_hasil,0,',','.') }}
                                        </td>
                                        <td>
                                            @if($data->komisi_status == 1)
                                                <strong class="text-success">Diterima</strong>
                                            @else
                                                @if($data->komisi_proof != '')
                                                    <a href="#" class="btn btn-success btn-sm btn-block btn-verify" data-id="{{ $data->id_komisi }}" data-proof="{{ asset('assets/images/komisi/'.$data->komisi_proof) }}" data-toggle="modal" data-target="#modal-verify" title="Verifikasi Pembayaran"><i class="fa fa-check"></i></a>
                                                @else
                                                    <strong class="text-danger">User Belum Membayar</strong>
                                                @endif
                                            @endif
                                        </td>
                                        <td align="center">
                                            @if($data->komisi_proof != '')
                                                <a href="{{ asset('assets/images/komisi/'.$data->komisi_proof) }}" class="btn btn-success btn-sm btn-block image-popup-vertical-fit" title="Bukti Transfer"><i class="fa fa-image"></i></a>
                                            @else
                                                <!--<strong class="text-danger"><i class="fa fa-times"></i></strong>-->
                                                <a href="#" class="btn btn-success btn-sm btn-block btn-confirm" data-id="{{ $data->id_komisi }}" data-toggle="modal" data-target="#modal-confirm" title="Konfirmasi Pembayaran"><i class="fa fa-check"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @php $i++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
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

<!-- Modal Kirim Komisi -->
<div class="modal fade" id="modal-verify" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Verifikasi Komisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-verify" method="post" action="/admin/transaksi/komisi/verify">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Bukti Transfer:</label>
                            <br>
                            <img id="komisi-proof" class="img-thumbnail mt-2" style="max-width: 300px;">
                        </div>
                        <input type="hidden" name="id_komisi">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn-submit-verify">Verifikasi</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Kirim Komisi -->

<!-- Modal Konfirmasi -->
<div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pendaftaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-confirm" method="post" action="/admin/transaksi/komisi/konfirmasi" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Upload Bukti Transfer <span class="text-danger">*</span></label>
							<br>
                            <button id="btn-choose" type="button" class="btn btn-md btn-cyan mr-2"><i class="fa fa-folder-open mr-2"></i>Pilih File...</button>
							<input type="file" id="file" name="foto" class="d-none" accept="image/*">
							<br><br>
							<img id="image" class="img-thumbnail d-none">
							<input type="hidden" name="src_image" id="src_image">
                        </div>
                        <input type="hidden" name="id_komisi">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn-submit-confirm" disabled>Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Konfirmasi -->

@endsection

@section('js-extra')

<script src="{{ asset('templates/matrix-admin/assets/extra-libs/DataTables/datatables.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.22/sorting/datetime-moment.js"></script>
<script src="{{ asset('templates/matrix-admin/assets/libs/magnific-popup/dist/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('templates/matrix-admin/assets/libs/magnific-popup/meg.init.js') }}"></script>
<script type="text/javascript">
    // DataTable
	$.fn.dataTable.moment("DD/MM/YYYY");
    $('#table-arsip-komisi').DataTable({
        "fnDrawCallback": function(){
            $('.image-popup-vertical-fit').magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                closeBtnInside: false,
                fixedContentPos: true,
                image: {
                  verticalFit: true
                },
            });
        }
    });

    /* Verifikasi Komisi */
    $(document).on("click", ".btn-verify", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        var proof = $(this).data("proof");
        $("#form-verify input[name=id_komisi]").val(id);
        $("#komisi-proof").attr("src", proof);
    });
    
    $(document).on("click", "#btn-submit-verify", function(e){
        e.preventDefault();
        $("#form-verify")[0].submit();
    });

    $('#modal-verify').on('hidden.bs.modal', function(){
        $("#komisi-proof").removeAttr("src");
    });

    /* Konfirmasi Pendaftaran */
    $(document).on("click", ".btn-confirm", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        $("#form-confirm input[name=id_komisi]").val(id);
    });
	
    $(document).on("click", "#btn-choose", function(e){
        e.preventDefault();
        $("#file").trigger("click");
    });

    $(document).on("change", "#file", function(){
        // ukuran maksimal upload file
        $max = 2 * 1024 * 1024;

        // validasi
        if(this.files && this.files[0]) {
            // jika ukuran melebihi batas maksimum
            if(this.files[0].size > $max){
                alert("Ukuran file terlalu besar dan melebihi batas maksimum! Maksimal 2 MB");
                $("#file").val(null);
                $("#btn-submit-send").attr("disabled","disabled");
            }
            // jika ekstensi tidak diizinkan
            else if(!validateExtension(this.files[0].name)){
                alert("Ekstensi file tidak diizinkan!");
                $("#file").val(null);
                $("#btn-submit-send").attr("disabled","disabled");
            }
            // validasi sukses
            else{
        		readURL(this);
                $("#btn-submit-confirm").removeAttr("disabled");
            }
            // console.log(this.files[0]);
        }
    });
    
    $(document).on("click", "#btn-submit-confirm", function(e){
        e.preventDefault();
        $("#form-confirm")[0].submit();
    });

    function getFileExtension(filename){
        var split = filename.split(".");
        var extension = split[split.length - 1];
        return extension;
    }

    function validateExtension(filename){
        var ext = getFileExtension(filename);

        // ekstensi yang diizinkan
        var extensions = ['jpg', 'jpeg', 'png', 'bmp', 'svg'];
        for(var i in extensions){
            if(ext == extensions[i]) return true;
        }
        return false;
    }

    function readURL(input){
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function(e){
                imageURL = e.target.result;
				// $("#src_image").val(e.target.result);
				$("#image").attr("src", e.target.result).removeClass("d-none");
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection

@section('css-extra')

<link href="{{ asset('templates/matrix-admin/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('templates/matrix-admin/assets/libs/magnific-popup/dist/magnific-popup.css') }}" rel="stylesheet">

@endsection