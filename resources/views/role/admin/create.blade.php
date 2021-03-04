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
                <h4 class="page-title">Tambah Role</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
                            <li class="breadcrumb-item"><a href="/admin/pengaturan/role">Role</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Role</li>
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
                    <h5 class="card-title border-bottom">Tambah Role</h5>
                    <div class="card-body">
                        <form id="form" method="post" action="/admin/pengaturan/role/store" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Nama Role <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_role" class="form-control {{ $errors->has('nama_role') ? 'is-invalid' : '' }}" value="{{ old('nama_role') }}" placeholder="Masukkan Nama Role">
                                    @if($errors->has('nama_role'))
                                    <small class="text-danger">{{ ucfirst($errors->first('nama_role')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Sebagai Admin? <span class="text-danger">*</span></label>
									<div class="row">
										<div class="col-auto">
											<div class="form-check form-check-inline">
												<input class="form-check-input" name="sebagai_admin" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1">
												<label class="form-check-label" for="inlineRadio1">Ya</label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" name="sebagai_admin" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="0">
												<label class="form-check-label" for="inlineRadio2">Tidak</label>
											</div>
										</div>
									</div>
                                    @if($errors->has('sebagai_admin'))
                                    <div><small class="text-danger">{{ ucfirst($errors->first('sebagai_admin')) }}</small></div>
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