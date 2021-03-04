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
                <h4 class="page-title">{{ $kategori->folder_kategori }}</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item"><a href="/admin/file-manager">File Manager</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $kategori->folder_kategori }}</li>
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
                                <h5 class="mb-0">{{ $kategori->folder_kategori }}</h5>
                            </div>
                            <div class="col-12 col-sm-auto text-center text-sm-left">
								<form id="form-search" class="{{ $directory->id_folder != 1 ? 'd-none' : '' }}" method="post" action="#">
									{{ csrf_field() }}
									<input type="hidden" name="file_kategori" value="{{ $kategori->id_fk }}">
									<input type="text" name="search" id="search" class="form-control form-control-sm" placeholder="Cari disini...">
								</form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                @foreach($breadcrumb as $key=>$data)
                                    @if($key + 1 == count($breadcrumb))
                                    <li class="breadcrumb-item active" aria-current="page">{{ $data->folder_nama == '/' ? 'Home' : $data->folder_nama }}</li>
                                    @else
                                    <li class="breadcrumb-item"><a href="/member/file-manager/{{ generate_permalink($kategori->folder_kategori) }}?dir={{ $data->folder_dir }}">{{ $data->folder_nama == '/' ? 'Home' : $data->folder_nama }}</a></li>
                                    @endif
                                @endforeach
                            </ol>
                        </nav>
                        <!-- /Breadcrumb -->
                        <div class="row">
                            <div class="col-12">
                                <div class="row" id="data-folder">
                                    @foreach($folders as $folder)
                                    <a class="col-md-6 col-lg-3 col-xlg-3 {{ $folder->folder_voucher != '' ? session()->get('id_folder') != $folder->id_folder ? 'btn-voucher' : '' : '' }}" data-id="{{ $folder->id_folder }}" href="/member/file-manager/{{ generate_permalink($kategori->folder_kategori) }}?dir={{ $folder->folder_dir }}">
                                        <div class="card card-hover shadow">
                                            <div class="box text-center">
                                                @if(date('Y-m-d') == date('Y-m-d', strtotime($folder->folder_up)))<div class="badge-new bg-success text-dark">Baru!</div>@endif
                                                <img src="{{ $folder->folder_icon != '' ? asset('assets/images/icon/'.$folder->folder_icon) : asset('assets/images/default/folder.png') }}" height="100">
                                                <h6 class="text-dark mt-2">{{ $folder->folder_nama }}</h6>
												@if($folder->folder_kategori != 1)
                                                <p class="mb-0 text-secondary">({{ count_folders($folder->id_folder, $folder->folder_kategori) }} folder, {{ count_files($folder->id_folder, $folder->folder_kategori) }} file)</p>
												@endif
                                            </div>
                                        </div>
                                    </a>
                                    @endforeach
                                </div>
                                <div class="row" id="data-file">
                                    @if(count($folders)>0 || count($files)>0)
                                        @foreach($files as $file)
                                        <div class="col-md-6 col-lg-3 col-xlg-3">
                                            <div class="card card-hover shadow">
                                                @if(date('Y-m-d') == date('Y-m-d', strtotime($file->file_up)))<div class="badge-new bg-success text-dark">Baru!</div>@endif
                                                <a class="{{ $file->folder_voucher != '' ? session()->get('id_folder') != $file->id_folder ? 'btn-voucher' : '' : '' }}" href="{{ $file->file_kategori == 3 ? '/assets/tools/'.$file->file_konten : '/member/file-manager/view/'.$file->id_file }}">
                                                    <img class="card-img-top" src="{{ $file->file_thumbnail != '' ? asset('assets/images/file-thumbnail/'.$file->file_thumbnail) : asset('assets/images/default/tool.png') }}" alt="Gambar">
                                                </a>
                                                <div class="card-body text-center">
                                                    <h6 class="text-dark mt-2">{{ $file->file_nama }}</h6>
                                                    <p class="mb-0 text-secondary"></p>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                    <div class="col-12">
                                        <div class="alert alert-danger text-center">Folder dan File belum tersedia.</div>
                                    </div>
                                    @endif
                                </div>
                            </div>
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

<!-- Modal Voucher -->
<div class="modal fade" id="modal-voucher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Voucher</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				@if(Session::get('message'))
				<div class="alert alert-danger text-center">
					{{ Session::get('message') }}
				</div>
				@endif
				<div class="alert alert-warning text-center">
					Masukkan kode voucher yang Anda miliki untuk mengakses konten ini.
				</div>
				<form id="form-voucher" method="post" action="/member/file-manager/{{ generate_permalink($kategori->folder_kategori) }}/voucher">
					{{ csrf_field() }}
					<input type="hidden" name="id" value="{{ Session::get('id_folder') }}">
					<input type="hidden" name="dir" value="{{ $_GET['dir'] }}">
					<div class="form-group">
						<label>Kode Voucher</label>
						<input type="text" name="voucher" class="form-control" required>
					</div>
					<div class="form-group">
                		<button type="submit" class="btn btn-success">Submit</button>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Voucher -->

@endsection

@section('js-extra')

<script type="text/javascript">
	@if(Session::get('message'))
    $("#modal-voucher").modal("show");
	@endif
	
	// Button voucher
	$(document).on("click", ".btn-voucher", function(e){
		e.preventDefault();
		var id = $(this).data("id");
		$("#form-voucher input[name=id]").val(id);
		$("#modal-voucher").modal("show");
	});

	// Search
	$(document).on("keyup", "#search", function(){
		var search = $.trim($(this).val());
		//if(search != ''){
			$.ajax({
				type: "post",
				url: "/member/file-manager/{{ generate_permalink($kategori->folder_kategori) }}/search",
				data: {_token: "{{ csrf_token() }}", search: search},
				success: function(response){
					var result = JSON.parse(response);
					var html = '';
					var html2 = '';
					var html3 = '';
					html3 += '<div class="col-12">';
					html3 += '<div class="alert alert-danger text-center">Pencarian tidak ditemukan.</div>';
					html3 += '</div>';
					$(result.folders).each(function(key,data){
						html += '<a class="col-md-6 col-lg-3 col-xlg-3" href="/member/file-manager/{{ generate_permalink($kategori->folder_kategori) }}?dir='+data.folder_dir+'">';
						html += '<div class="card card-hover shadow">';
						html += '<div class="box text-center">';
						html += generate_yyyymmdd(new Date()) == generate_yyyymmdd(new Date(data.folder_up)) ? '<div class="badge-new bg-success text-dark">Baru!</div>' : '';
						html += data.folder_icon != '' ? '<img src="{{ asset('assets/images/icon') }}/'+data.folder_icon+'" height="100">' : '<img src="{{ asset('assets/images/default/folder.png') }}" height="100">' ;
						html += '<h6 class="text-dark mt-2">'+data.folder_nama+'</h6>';
						html += data.folder_kategori != 1 ? '<p class="mb-0 text-secondary">('+data.count_folders+' folder, '+data.count_files+' file)</p>' : '';
						html += '</div>';
						html += '</div>';
						html += '</a>';
					});
					$(result.files).each(function(key,data){
                        html2 += '<div class="col-md-6 col-lg-3 col-xlg-3">';
                        html2 += '<div class="card card-hover shadow">';
						html2 += generate_yyyymmdd(new Date()) == generate_yyyymmdd(new Date(data.file_up)) ? '<div class="badge-new bg-success text-dark">Baru!</div>' : '';
                        html2 += data.file_kategori != 3 ? '<a href="/member/file-manager/view/'+data.id_file+'">' : '<a href="/assets/tools/'+data.file_konten+'">';
                        html2 += data.file_thumbnail != '' ? '<img class="card-img-top" src="{{ asset('assets/images/file-thumbnail') }}/'+data.file_thumbnail+'">' : '<img class="card-img-top" src="{{ asset('assets/images/default/tool.png') }}">';
                        html2 += '</a>';
                        html2 += '<div class="card-body text-center">';
						html2 += '<h6 class="text-dark mt-2">'+data.file_nama+'</h6>';
						// html2 += '<p class="mb-0 text-secondary">('+data.count+' halaman)</p>';
                        html2 += '</div>';
                        html2 += '</div>';
						html2 += '</div>';
					});
					if(result.folders.length > 0 || result.files.length > 0){
						$("#data-folder").html(html);
						$("#data-file").html(html2);
					}
					else{
						$("#data-folder").html('');
						$("#data-file").html(html3);
					}
				}
			});
		//}
	});

	// Generate date ke format yyyy-mm-dd
	function generate_yyyymmdd(date){
		return date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
	} 
</script>

@endsection

@section('css-extra')

<style type="text/css">
	.box {background-color: #fff!important; cursor: pointer;}
	.badge-new {position: absolute; right: .5rem; top: .5rem; border-radius: .25rem; padding: .25rem; font-weight: bold; font-size: 80%;}
	#data-file .card-body {padding: .5rem!important;}
</style>

@endsection