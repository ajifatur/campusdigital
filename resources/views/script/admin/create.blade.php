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
                <h4 class="page-title">Tambah Script</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item"><a href="/admin/script">Kumpulan Copywriting</a></li>
                            <li class="breadcrumb-item"><a href="/admin/script/rak/{{ $rak->id_rak }}">{{ $rak->rak }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Script</li>
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
            <div class="col-lg-6 mx-auto">
                <!-- card -->
                <div class="card shadow">
                    <h5 class="card-title border-bottom">Tambah Script</h5>
                    <div class="card-body">
                        <form id="form" method="post" action="/admin/script/store" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="id_rak" value="{{ $rak->id_rak }}">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Judul Script <span class="text-danger">*</span></label>
                                    <input type="text" name="judul" class="form-control {{ $errors->has('judul') ? 'is-invalid' : '' }}" value="{{ old('judul') }}" placeholder="Masukkan Judul Script">
                                    @if($errors->has('judul'))
                                    <small class="text-danger">{{ ucfirst($errors->first('judul')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Script <span class="text-danger">*</span></label>
                                    <textarea name="script" class="form-control {{ $errors->has('script') ? 'is-invalid' : '' }}" placeholder="Masukkan Script" rows="10">{{ old('script') }}</textarea>
                                    @if($errors->has('script'))
                                    <small class="text-danger">{{ ucfirst($errors->first('script')) }}</small>
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
</script>

@endsection