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
                <h4 class="page-title">Edit Layanan</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Konten Web</a></li>
                            <li class="breadcrumb-item"><a href="/admin/konten-web/layanan">Layanan</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Layanan</li>
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
                    <h5 class="card-title border-bottom">Edit Layanan</h5>
                    <div class="card-body">
                        @if(Session::get('message') != null)
                            <div class="alert alert-success alert-dismissible mb-4 fade show" role="alert">
                                {{ Session::get('message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <form id="form" method="post" action="/admin/konten-web/layanan/update" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $layanan->id_layanan }}">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Layanan <span class="text-danger">*</span></label>
                                    <input type="text" name="layanan" class="form-control {{ $errors->has('layanan') ? 'is-invalid' : '' }}" value="{{ $layanan->layanan }}" placeholder="Masukkan Layanan">
                                    @if($errors->has('layanan'))
                                    <small class="text-danger">{{ ucfirst($errors->first('layanan')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Caption <span class="text-danger">*</span></label>
                                    <textarea name="caption" class="form-control {{ $errors->has('caption') ? 'is-invalid' : '' }}" rows="5" placeholder="Masukkan Caption">{{ $layanan->layanan_caption }}</textarea>
                                    @if($errors->has('caption'))
                                    <small class="text-danger">{{ ucfirst($errors->first('caption')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Icon <span class="text-danger">*</span></label>
                                    <br>
                                    <button class="btn btn-sm btn-primary btn-search"><i class="fa fa-search mr-2"></i>Cari Icon</button>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-6 mb-2 mt-3 text-center" id="selected-icon">
                                            <div class="card card-hover shadow bg-warning">
                                                <div class="card-body">
                                                    <i class="fa-3x {{ $layanan->layanan_icon }}"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="icon">
                                    @if($errors->has('icon'))
                                    <small class="text-danger">{{ ucfirst($errors->first('icon')) }}</small>
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

<!-- Modal -->
<div class="modal fade" id="modalIcon" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cari Icon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row icons">
                    @foreach($icons as $icon)
                        <a class="col-md-3 col-sm-6 mb-2 text-center icon" href="#" data-id="{{ $icon }}">
                            <div class="card card-hover shadow bg-warning">
                                <div class="card-body">
                                    <i class="fa-3x {{ $icon }}"></i>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            <!-- <div class="modal-footer">
				<button type="button" class="btn btn-md btn-success" id="btn-choose" disabled>Pilih</button>
			</div> -->
        </div>
    </div>
</div>
<!-- End Modal -->

@endsection

@section('js-extra')

<script type="text/javascript">
    // Button Search Icon
    $(document).on("click", ".btn-search", function(e){
        e.preventDefault();
        $("#modalIcon").modal("show");
    });

    // Button Choose Icon
    $(document).on("click", ".icon", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        $("#selected-icon").find("i").attr("class","").addClass("fa-3x "+id);
        $("#selected-icon").removeClass("d-none");
        $("input[name=icon]").val(id);
        $("#modalIcon").modal("toggle");
    });

    // Button Submit
    $(document).on("click", "#btn-submit", function(e){
        $("#form").submit();
    });
</script>

@endsection

@section('css-extra')

<style type="text/css">
    .icons {height: 500px; overflow-y: scroll;}
</style>

@endsection