@extends('template/admin/main')

@section('content')

<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
	@include('template/admin/_breadcrumb', ['breadcrumb' => [
		'title' => 'Edit Cabang',
		'items' => [
			['text' => 'Konten Web', 'url' => '/admin/konten-web'],
			['text' => 'Cabang', 'url' => '/admin/konten-web/cabang'],
			['text' => 'Edit Cabang', 'url' => '#'],
		]
	]])
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
                    <form id="form" method="post" action="/admin/konten-web/cabang/update" enctype="multipart/form-data">
                        <div class="card-body">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $cabang->id_cabang }}">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Nama Cabang <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_cabang" class="form-control {{ $errors->has('nama_cabang') ? 'is-invalid' : '' }}" value="{{ $cabang->nama_cabang }}" placeholder="Masukkan Nama Cabang">
                                    @if($errors->has('nama_cabang'))
                                    <small class="text-danger">{{ ucfirst($errors->first('nama_cabang')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Alamat <span class="text-danger">*</span></label>
                                    <textarea name="alamat_cabang" class="form-control {{ $errors->has('alamat_cabang') ? 'is-invalid' : '' }}" rows="3" placeholder="Masukkan Alamat">{{ $cabang->alamat_cabang }}</textarea>
                                    @if($errors->has('alamat_cabang'))
                                    <small class="text-danger">{{ ucfirst($errors->first('alamat_cabang')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Nomor WhatsApp <span class="text-danger">*</span></label>
                                    <input type="text" name="whatsapp_cabang" class="form-control {{ $errors->has('whatsapp_cabang') ? 'is-invalid' : '' }}" value="{{ $cabang->whatsapp_cabang }}" placeholder="Masukkan No. WhatsApp">
                                    @if($errors->has('whatsapp_cabang'))
                                    <small class="text-danger">{{ ucfirst($errors->first('whatsapp_cabang')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Instagram</label>
                                    <input type="text" name="instagram_cabang" class="form-control {{ $errors->has('instagram_cabang') ? 'is-invalid' : '' }}" value="{{ $cabang->instagram_cabang }}" placeholder="Masukkan Instagram">
                                    @if($errors->has('instagram_cabang'))
                                    <small class="text-danger">{{ ucfirst($errors->first('instagram_cabang')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Website</label>
                                    <input type="text" name="website_cabang" class="form-control {{ $errors->has('website_cabang') ? 'is-invalid' : '' }}" value="{{ $cabang->website_cabang }}" placeholder="Masukkan Website">
                                    @if($errors->has('website_cabang'))
                                    <small class="text-danger">{{ ucfirst($errors->first('website_cabang')) }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="border-top">
                            <button id="btn-submit" type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
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