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
                <h4 class="page-title">Lihat Script</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item"><a href="/admin/file-manager">File Manager</a></li>
                            <li class="breadcrumb-item"><a href="/admin/file-manager/{{ generate_permalink($kategori->folder_kategori) }}">{{ $kategori->folder_kategori }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Lihat Script</li>
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
            <div class="col-lg-12 mx-auto">
                <!-- card -->
                <div class="card shadow">
                    <div class="card-title border-bottom">
                        <div class="row">
                            <div class="col-12 col-sm py-1 mb-2 mb-sm-0 text-center text-sm-left">
                                <h5 class="mb-0">Lihat Script</h5>
                            </div>
                             <div class="col-12 col-sm-auto text-center text-sm-left">
                                <button class="btn btn-success btn-sm btn-copy" type="button" data-toggle="tooltip" data-placement="top" title="Salin Teks"><i class="fa fa-copy mr-2"></i>Salin Teks</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                @foreach($breadcrumb as $key=>$data)
                                    <li class="breadcrumb-item"><a href="/admin/file-manager/{{ generate_permalink($kategori->folder_kategori) }}?dir={{ $data->folder_dir }}">{{ $data->folder_nama == '/' ? 'Home' : $data->folder_nama }}</a></li>
                                @endforeach
                                <li class="breadcrumb-item active" aria-current="page">{{ $file->file_nama }}</li>
                            </ol>
                        </nav>
                        <!-- /Breadcrumb -->
                        <p class="h4 mb-3">{{ $file->file_nama }}</p>
                        <textarea class="form-control" id="textarea" rows="25" readonly>{!! html_entity_decode($file->file_konten) !!}</textarea>
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
	// Button Copy to Clipboard
    $(document).on("click", ".btn-copy", function(e){
		e.preventDefault();
		var copyText = document.getElementById("textarea");
		copyText.select();
		copyText.setSelectionRange(0, 999999);
		console.log(document.execCommand("copy"));
		$(this).attr('data-original-title','Berhasil Menyalin Teks!');
		$(this).tooltip("show");
		$(this).attr('data-original-title','Salin Teks');
    });
</script>

@endsection