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
                <h4 class="page-title">Data Rekening</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/member">Home</a></li>
                            <li class="breadcrumb-item"><a href="/member/rekening">Rekening</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Rekening</li>
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
                                <h5 class="mb-0">Data Rekening</h5>
                            </div>
                            <div class="col-12 col-sm-auto text-center text-sm-left">
                                <a href="/member/rekening/create" class="btn btn-sm btn-primary"><i class="fa fa-plus mr-2"></i> Tambah Rekening</a>
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
                        @if(count($rekening) <= 0)
                            <div class="alert alert-danger mb-4" role="alert">
                                Anda belum memasukkan nomor rekening. Segera masukkan nomor rekening Anda supaya kami dapat mengirimkan komisi.
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table id="table-arsip-komisi" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="40">No.</th>
                                        <th width="150">Platform</th>
                                        <th width="150">Nomor</th>
                                        <th>Atas Nama</th>
                                        <th width="40">Edit</th>
                                        <th width="40">Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($rekening as $data)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $data->nama_platform }}</td>
                                        <td>{{ $data->nomor }}</td>
                                        <td>{{ $data->atas_nama }}</td>
                                        <td><a href="/member/rekening/edit/{{ $data->id_rekening }}" class="btn btn-warning btn-sm btn-block" title="Edit"><i class="fa fa-edit"></i></a></td>
                                        <td><a href="#" class="btn btn-danger btn-sm btn-block btn-delete" data-id="{{ $data->id_rekening }}" title="Hapus"><i class="fa fa-trash"></i></a></td>
                                    </tr>
                                    @php $i++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                            <form id="form" class="d-none" method="post" action="/member/rekening/delete">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" id="id">
                            </form>
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
    $('#table-arsip-komisi').DataTable();
    $('#table-history-withdrawal').DataTable();

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

    // Input Hanya Nomor
    $(document).on("keypress", ".number-only", function(e){
        var charCode = (e.which) ? e.which : e.keyCode;
        if (charCode >= 48 && charCode <= 57) { 
            // 0-9 only
            return true;
        }
        else{
            return false;
        }
    });

    // Input Format Ribuan
    $(document).on("keyup", ".thousand-format", function(){
        var value = $(this).val();
        $(this).val(formatRibuan(value, ""));
    });

    // Functions
    function formatRibuan(angka, prefix){
        var number_string = angka.replace(/\D/g,'');
        number_string = (number_string.length > 1) ? number_string.replace(/^(0+)/g, '') : number_string;
        var split = number_string.split(',');
        var sisa = split[0].length % 3;
        var rupiah = split[0].substr(0, sisa);
        var ribuan = split[0].substr(sisa).match(/\d{3}/gi);
     
        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
     
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah;
    }
</script>

@endsection

@section('css-extra')

<link href="{{ asset('templates/matrix-admin/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<style type="text/css">
    .border-top, .border-bottom {padding: 1.25rem;}
    .form-control {border-color: #caccce;}
    .input-group-text {border-color: #caccce;}
</style>

@endsection