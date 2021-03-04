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
                <h4 class="page-title">Edit Rekening</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/member">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
                            <li class="breadcrumb-item"><a href="/admin/pengaturan/rekening">Rekening</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Rekening</li>
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
                    <h5 class="card-title border-bottom">Edit Rekening</h5>
                    <div class="card-body">
                        <form id="form" method="post" action="/admin/pengaturan/rekening/update">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $rekening->id_dr }}">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Platform <span class="text-danger">*</span></label>
									<select name="platform" class="form-control {{ $errors->has('platform') ? 'is-invalid' : '' }}">
										<option value="" disabled selected>--Pilih Platform--</option>
										<optgroup label="Bank">
											@foreach($bank as $data)
											<option value="{{ $data->id_platform }}" {{ $rekening->id_platform == $data->id_platform ? 'selected' : '' }}>{{ $data->nama_platform }}</option>
											@endforeach
										</optgroup>
										<optgroup label="Fintech">
											@foreach($fintech as $data)
											<option value="{{ $data->id_platform }}" {{ $rekening->id_platform == $data->id_platform ? 'selected' : '' }}>{{ $data->nama_platform }}</option>
											@endforeach
										</optgroup>
									</select>
                                    @if($errors->has('platform'))
                                    <small class="text-danger">{{ ucfirst($errors->first('platform')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Nomor <span class="text-danger">*</span></label>
                                    <input type="text" name="nomor" class="form-control number-only {{ $errors->has('nomor') ? 'is-invalid' : '' }}" value="{{ $rekening->nomor }}" placeholder="Masukkan Nomor">
                                    @if($errors->has('nomor'))
                                    <small class="text-danger">{{ ucfirst($errors->first('nomor')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Atas Nama <span class="text-danger">*</span></label>
                                    <input type="text" name="atas_nama" class="form-control {{ $errors->has('atas_nama') ? 'is-invalid' : '' }}" value="{{ $rekening->atas_nama }}" placeholder="Masukkan Nama Pemilik Rekening">
                                    @if($errors->has('atas_nama'))
                                    <small class="text-danger">{{ ucfirst($errors->first('atas_nama')) }}</small>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="border-top">
                        <button id="btn-submit" type="submit" class="btn btn-success">Simpan</button>
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

    // Button Submit
    $(document).on("click", "#btn-submit", function(e){
        $("#form").submit();
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
    // End Input Hanya Nomor

    // Input Format Ribuan
    $(document).on("keyup", ".thousand-format", function(){
        var value = $(this).val();
        $(this).val(formatRibuan(value, ""));
    });
    // End Input Format Ribuan

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