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
                <h4 class="page-title">Edit Video</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item"><a href="/admin/file-manager">File Manager</a></li>
                            <li class="breadcrumb-item"><a href="/admin/file-manager/{{ generate_permalink($kategori->folder_kategori) }}">{{ $kategori->folder_kategori }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Video</li>
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
                    <h5 class="card-title border-bottom">Edit Video</h5>
                    <div class="card-body">
                        <form id="form" method="post" action="/admin/file-manager/{{ generate_permalink($kategori->folder_kategori) }}/update" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $file->id_file }}">
                            <input type="hidden" name="folder_parent" value="{{ $directory->id_folder }}">
                            <input type="hidden" name="file_kategori" value="{{ $kategori->id_fk }}">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Judul Video <span class="text-danger">*</span></label>
                                    <input type="text" name="file_nama" class="form-control {{ $errors->has('file_nama') ? 'is-invalid' : '' }}" value="{{ $file->file_nama }}" placeholder="Masukkan Judul Video">
                                    @if($errors->has('file_nama'))
                                    <small class="text-danger">{{ ucfirst($errors->first('file_nama')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Deskripsi</label>
                                    <textarea name="file_deskripsi" class="form-control {{ $errors->has('file_deskripsi') ? 'is-invalid' : '' }}" rows="3" placeholder="Masukkan Deskripsi">{{ $file->file_deskripsi }}</textarea>
                                    @if($errors->has('file_deskripsi'))
                                    <small class="text-danger">{{ ucfirst($errors->first('file_deskripsi')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Kode YouTube <span class="text-danger">*</span></label>
                                    <input type="text" name="file_konten" class="form-control {{ $errors->has('file_konten') ? 'is-invalid' : '' }}" value="{{ $file->file_konten }}" placeholder="Masukkan Kode YouTube">
                                    @if($errors->has('file_konten'))
                                    <small class="text-danger">{{ ucfirst($errors->first('file_konten')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Kode Embed Google Slide</label>
                                    <textarea name="file_keterangan" class="form-control {{ $errors->has('file_keterangan') ? 'is-invalid' : '' }}" rows="3" placeholder="Masukkan Kode Embed">{{ html_entity_decode($file->file_keterangan) }}</textarea>
                                    @if($errors->has('file_keterangan'))
                                    <small class="text-danger">{{ ucfirst($errors->first('file_keterangan')) }}</small>
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