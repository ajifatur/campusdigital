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
                <h4 class="page-title">Komisi</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/member">Home</a></li>
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
            <div class="col-lg-5">
                <!-- card -->
                <div class="card shadow">
                    <h5 class="card-title border-bottom">Ambil Komisi</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-9 col-12 mx-auto p-3 text-center border border-secondary bg-warning shadow">
                                <h5>Total Saldo Anda Saat Ini</h5>
                                <p class="mb-0 h3 font-weight-bold {{ Auth::user()->saldo >= get_min_withdrawal() ? 'text-primary' : 'text-danger' }}">Rp. {{ number_format(Auth::user()->saldo,0,',','.') }}</p>
                            </div>
                        </div>
                        <form id="form" class="mt-5" method="post" action="/member/transaksi/komisi/take-comission">
                            {{ csrf_field() }}
                            @if($current_withdrawal)
                            <div class="alert alert-success mb-4" role="alert">
                                Komisi sedang diproses untuk dikirimkan ke rekening Anda. Kode transaksinya adalah <strong>{{ $current_withdrawal->inv_withdrawal }}</strong>.
                            </div>
                            @endif
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Withdrawal <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text {{ $errors->has('withdrawal_hidden') ? 'border-danger' : '' }}">Rp.</span>
                                        </div>
                                        <input type="text" name="withdrawal" class="form-control number-only thousand-format {{ $errors->has('withdrawal_hidden') ? 'border-danger' : '' }}" value="{{ old('withdrawal') }}" placeholder="Masukkan nominal withdrawal yang akan diambil" {{ Auth::user()->saldo < get_min_withdrawal() || $current_withdrawal ? 'disabled' : '' }}>
                                        <input type="hidden" name="withdrawal_hidden" value="{{ old('withdrawal_hidden') }}">
                                    </div>
                                    <div class="row mt-1">
                                        @if($errors->has('withdrawal_hidden'))
                                        <small class="col-12 text-danger">Nominal withdrawal yang dapat diambil yaitu antara Rp. {{ number_format(get_min_withdrawal(),0,',','.') }} dan Rp. {{ number_format(Auth::user()->saldo,0,',','.') }}.</small>
                                        @else
                                        <small class="col-12 text-muted">Minimum nominal withdrawal yang dapat diambil adalah Rp. {{ number_format(get_min_withdrawal(),0,'.','.') }}.</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label>Rekening <span class="text-danger">*</span></label>
                                    <select class="form-control {{ $errors->has('rekening') ? 'border-danger' : '' }}" name="rekening" {{ Auth::user()->saldo < get_min_withdrawal() || $current_withdrawal ? 'disabled' : '' }}>
                                        <option value="" disabled selected>--Pilih--</option>
                                        @foreach($rekening as $data)
                                        <option value="{{ $data->id_rekening }}" {{ $data->id_rekening == old('rekening') ? 'selected' : '' }}>{{ $data->nama_platform }} | {{ $data->nomor }} | {{ $data->atas_nama }}</option>
                                        @endforeach
                                    </select>
                                    <div class="row mt-1">
                                        @if($errors->has('rekening'))
                                        <small class="col-12 text-danger">{{ ucfirst($errors->first('rekening')) }}</small>
                                        @else
                                        <small class="col-12 text-muted">Komisi akan ditransfer ke rekening ini.</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="border-top">
                        <button id="btn-submit" type="submit" class="btn btn-success" title="{{ $current_withdrawal ? 'Belum bisa mengambil komisi karena masih memproses pengambilan komisi yang sebelumnya' : '' }}" {{ Auth::user()->saldo < get_min_withdrawal() || $current_withdrawal ? 'disabled' : '' }}>Ambil Komisi</button>
                    </div>
                </div>
                <!-- card -->
            </div>
            <!-- column -->
            <!-- column -->
            <div class="col-lg-7">
                <!-- card -->
                <div class="card shadow">
                    <h5 class="card-title border-bottom">Arsip Komisi</h5>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-arsip-komisi" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="40">No.</th>
                                        <th width="100">Tanggal</th>
                                        <th>Nama</th>
                                        <th width="100">Masuk Saldo?</th>
                                        <th width="100">Komisi (Rp.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($komisi as $data)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td><span title="{{ date('d/m/Y H:i:s', strtotime($data->komisi_at)) }}" style="text-decoration: underline; cursor: help;">{{ date('d/m/Y', strtotime($data->komisi_at)) }}</span></td>
                                        <td>{{ $data->nama_user }}</td>
                                        <td><strong class="{{ $data->masuk_ke_saldo == 1 ? 'text-success' : 'text-danger' }}">{{ $data->masuk_ke_saldo == 1 ? 'Sudah' : 'Belum' }}</strong></td>
                                        <td align="right">{{ number_format($data->komisi_hasil,0,',','.') }}</td>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.22/sorting/datetime-moment.js"></script>
<script src="{{ asset('templates/matrix-admin/assets/libs/magnific-popup/dist/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('templates/matrix-admin/assets/libs/magnific-popup/meg.init.js') }}"></script>
<script type="text/javascript">
    // DataTable
	$.fn.dataTable.moment("DD/MM/YYYY");
    $('#table-arsip-komisi').DataTable();

    // Button Submit
    $(document).on("click", "#btn-submit", function(e){
        e.preventDefault();
        var withdrawal = $("input[name=withdrawal]").val();
        withdrawal = withdrawal.replace(/\./g, '');
        $("input[name=withdrawal_hidden]").val(withdrawal);
        $("#form").submit();
    })

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

@section('css-extra')

<link href="{{ asset('templates/matrix-admin/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('templates/matrix-admin/assets/libs/magnific-popup/dist/magnific-popup.css') }}" rel="stylesheet">

@endsection