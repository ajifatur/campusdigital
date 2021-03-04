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
                <h4 class="page-title">Download Produk</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/member">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Download Produk</li>
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
                    <h5 class="card-title border-bottom">Download Produk</h5>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-produk" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="30">No.</th>
                                        <th>Nama Produk</th>
                                        <th width="70">Ukuran</th>
                                        <th width="100">Tanggal</th>
                                        <th width="40">Download</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($files as $file)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>
                                            <i class="far fa-{{ mime2ext($file->tipe_file)[1] }} mr-1" style="font-size: 20px;"></i> {{ $file->nama_file }}
                                        </td>
                                        <td align="right">{{ generate_size($file->ukuran_file) }}</td>
                                        <td>{{ date('Y-m-d', strtotime($file->uploaded_at)) }}</td>
                                        <td><a href="{{ asset('assets/uploads/'.$file->url) }}" class="btn btn-primary btn-sm btn-block" target="_blank" title="Download"><i class="fa fa-download"></i></a></td>
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
    @include('template/member/_footer')
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->

@endsection

@section('js-extra')

<script src="{{ asset('templates/matrix-admin/assets/extra-libs/DataTables/datatables.min.js') }}"></script>
<script type="text/javascript">
    // DataTable
    $('#table-produk').DataTable();

    // Button Delete
    $(document).on("click", ".btn-delete", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        var ask = confirm("Anda yakin ingin menghapus data ini?");
        if(ask){
            $("#id").val(id);
            $("#form").submit();
        }
    });

    /* Upload File */

    $(document).on("click", "#btn-choose", function(e){
        e.preventDefault();
        $("#file").trigger("click");
    });

    $(document).on("change", "#file", function(){
        // ukuran maksimal upload file
        $max = 40 * 1024 * 1024;

        // validasi
        if(this.files && this.files[0]) {
            // jika ukuran melebihi batas maksimum
            if(this.files[0].size > $max){
                alert("Ukuran file terlalu besar dan melebihi batas maksimum!");
                $("#filename").addClass("d-none").text(null);
                $(".progress").addClass("d-none");
                $("#file").val(null);
                $("#btn-upload").attr("disabled","disabled");
            }
            // jika ekstensi tidak diizinkan
            else if(!validateExtension(this.files[0].name)){
                alert("Ekstensi file tidak diizinkan!");
                $("#filename").addClass("d-none").text(null);
                $(".progress").addClass("d-none");
                $("#file").val(null);
                $("#btn-upload").attr("disabled","disabled");
            }
            // validasi sukses
            else{
                $("#filename").removeClass("d-none").text(this.files[0].name);
                $(".progress").removeClass("d-none");
                $("#progressBar").text('0%').css({
                    'width' : '0%',
                    'color' : '#333',
                    'margin-left' : '5px',
                    'margin-right' : '5px',
                }).attr('aria-valuenow', 0).removeClass("bg-success");
                $("#btn-upload").removeAttr("disabled");
            }
            // console.log(this.files[0]);
        }
    });

    $(document).on("click", "#btn-upload", function(e){
        e.preventDefault();

        // membaca data file yg akan diupload, dari komponen 'file'
        var file = document.getElementById("file").files[0];
        var _token = document.getElementById("_token").value;
        var formdata = new FormData();
        formdata.append("datafile", file);
        formdata.append("_token", _token);

        // proses upload via AJAX disubmit ke 'upload.php'
        // selama proses upload, akan menjalankan progressHandler()
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.open("POST", "/member/upload-file", true);
        ajax.send(formdata);
    });

    function progressHandler(event){
        // hitung prosentase
        var percent = (event.loaded / event.total) * 100;

        // menampilkan prosentase ke komponen id 'progressBar'
        $("#progressBar").text(Math.round(percent) + '%').css({
            'width' : Math.round(percent) + '%',
            'color' : '#fff',
            'margin-left' : '0px',
            'margin-right' : '0px',
        }).attr('aria-valuenow', Math.round(percent));

        // jika sudah mencapai 100% akan mengganti warna background menjadi hijau
        if(Math.round(percent) == 100){
            $("#progressBar").addClass("bg-success");
            var filename = $("#filename").text();
            $("#uploaded-files").removeClass("d-none").append('<p class="mb-1"><i class="fa fa-check text-success mr-2"></i>' + filename + '</p>');
            $("#file").val(null);
            $("#btn-upload").attr("disabled","disabled");
        }
    }

    function getFileExtension(filename){
        var split = filename.split(".");
        var extension = split[split.length - 1];
        return extension;
    }

    function validateExtension(filename){
        var ext = getFileExtension(filename);

        // ekstensi yang tidak diizinkan
        var extensions = ['ade', 'adp', 'bat', 'chm', 'cmd', 'com', 'cpl', 'exe', 'hta', 'ins', 'isp', 'jse', 'lib', 'lnk', 'mde', 'msc', 'msp', 'mst', 'pif', 'scr', 'sct', 'shb', 'sys', 'vb', 'vbe', 'vbs', 'vxd', 'wsc', 'wsf', 'wsh'];
        for(var i in extensions){
            if(ext == extensions[i]) return false;
        }
        return true;
    }
    /* End Upload File */
</script>

@endsection

@section('css-extra')

<link href="{{ asset('templates/matrix-admin/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<style type="text/css">
    .border-top, .border-bottom {padding: 1.25rem;}
    .form-control {border-color: #caccce;}
    .input-group-text {border-color: #caccce;}
    .progress {height: 1rem; background-color: #eeeeee;}
    #uploaded-files {max-height: 150px; overflow-y: auto;}
</style>

@endsection