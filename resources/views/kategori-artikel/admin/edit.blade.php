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
		'title' => 'Edit Kategori',
		'items' => [
			['text' => 'Artikel', 'url' => '/admin/artikel'],
			['text' => 'Kategori', 'url' => '/admin/artikel/kategori'],
			['text' => 'Edit Kategori', 'url' => '#'],
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
                    <form id="form" method="post" action="/admin/artikel/kategori/update" enctype="multipart/form-data">
                        <div class="card-body">
                            @if(Session::get('message') != null)
                                <div class="alert alert-success alert-dismissible mb-4 fade show" role="alert">
                                    {{ Session::get('message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $kategori->id_ka }}">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Kategori <span class="text-danger">*</span></label>
                                    <input type="text" name="kategori" class="form-control {{ $errors->has('kategori') ? 'is-invalid' : '' }}" value="{{ $kategori->kategori }}" placeholder="Masukkan Kategori">
                                    @if($errors->has('kategori'))
                                    <small class="text-danger">{{ ucfirst($errors->first('kategori')) }}</small>
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