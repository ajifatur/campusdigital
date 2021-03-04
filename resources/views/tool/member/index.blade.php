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
                <h4 class="page-title">Kumpulan Tools</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/member">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Kumpulan Tools</li>
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
                                <h5 class="mb-0">Kumpulan Tools</h5>
                            </div>
                            <div class="col-12 col-sm-auto text-center text-sm-left">
								<form id="form-search" class="{{ $directory->id_toolbox != 1 ? 'd-none' : '' }}" method="post" action="#">
									{{ csrf_field() }}
									<input type="text" name="search" id="search" class="form-control form-control-sm" placeholder="Cari disini...">
								</form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
						<div class="col-12 mb-4">
							@if($directory->toolbox_parent == 0)
								<strong>Folder:</strong> Home
							@elseif($directory->toolbox_parent == 1)
								<strong>Folder:</strong> <a href="/member/tools?dir=/">Home</a> / {{ $directory->nama_toolbox }}
							@endif
						</div>
						<div class="col-12">
							<div class="row" id="data-folder">
								@foreach($toolboxes as $toolbox)
								<a class="col-md-6 col-lg-3 col-xlg-3" href="/member/tools?dir={{ $toolbox->dir_toolbox }}">
									<div class="card card-hover shadow">
										<div class="box text-center">
											@if(date('Y-m-d') == date('Y-m-d', strtotime($toolbox->modified_at)))<div class="badge-new text-success">Baru!</div>@endif
											<img src="{{ $toolbox->toolbox_icon != '' ? asset('assets/images/toolbox/'.$toolbox->toolbox_icon) : asset('assets/images/default/toolbox.png') }}" height="100">
											<h6 class="text-dark mt-2">{{ $toolbox->nama_toolbox }}</h6>
											<p class="mb-0 text-secondary">({{ count_tools($toolbox->id_toolbox) }} file)</p>
										</div>
									</div>
								</a>
								@endforeach
							</div>
							<div class="row" id="data-file">
								@if(count($toolboxes)>0 || count($tools)>0)
									@foreach($tools as $tool)
                                    <div class="col-md-6 col-lg-3 col-xlg-3">
                                        <div class="card card-hover shadow">
											@if(date('Y-m-d') == date('Y-m-d', strtotime($tool->uploaded_at)))<div class="badge-new text-success">Baru!</div>@endif
                                            <a href="{{ asset('assets/tools/'.$tool->nama_tool.'.'.mime_to_ext($tool->tipe_tool)[0]) }}">
                                                <img class="card-img-top" src="{{ $tool->thumbnail_tool != '' ? asset('assets/images/tool/'.$tool->thumbnail_tool) : asset('assets/images/default/tool.png') }}" alt="Gambar">
                                            </a>
                                            <div class="card-body text-center">
												<h6 class="text-dark mt-2">{{ $tool->nama_tool.'.'.mime_to_ext($tool->tipe_tool)[0] }}</h6>
												<p class="mb-0 text-secondary">({{ generate_size($tool->ukuran_tool) }})</p>
                                            </div>
                                        </div>
                                    </div>
									@endforeach
								@else
								<div class="col-12">
									<div class="alert alert-danger text-center">Tools belum tersedia.</div>
								</div>
								@endif
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

@endsection

@section('js-extra')

<script type="text/javascript">
	
	// Search
	$(document).on("keyup", "#search", function(){
		var search = $.trim($(this).val());
		//if(search != ''){
			$.ajax({
				type: "post",
				url: "/member/tools/search",
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
						html += '<a class="col-md-6 col-lg-3 col-xlg-3" href="/member/tools?dir='+data.dir_toolbox+'">';
						html += '<div class="card card-hover shadow">';
						html += '<div class="box text-center">';
						html += generate_yyyymmdd(new Date()) == generate_yyyymmdd(new Date(data.modified_at)) ? '<div class="badge-new text-success">Baru!</div>' : '';
						html += data.toolbox_icon != '' ? '<img src="{{ asset('assets/images/toolbox') }}/'+data.toolbox_icon+'" height="100">' : '<img src="{{ asset('assets/images/default/toolbox.png') }}" height="100">' ;
						html += '<h6 class="text-dark mt-2">'+data.nama_toolbox+'</h6>';
						html += '<p class="mb-0 text-secondary">('+data.count+' file)</p>';
						html += '</div>';
						html += '</div>';
						html += '</a>';
					});
					$(result.files).each(function(key,data){
                        html2 += '<div class="col-md-6 col-lg-3 col-xlg-3">';
                        html2 += '<div class="card card-hover shadow">';
						html2 += generate_yyyymmdd(new Date()) == generate_yyyymmdd(new Date(data.uploaded_at)) ? '<div class="badge-new text-success">Baru!</div>' : '';
                        html2 += '<a href="{{ asset('assets/tools') }}/'+data.nama_tool+'">';
                        html2 += data.thumbnail_tool != '' ? '<img class="card-img-top" src="{{ asset('assets/images/tool') }}/'+data.thumbnail_tool+'">' : '<img class="card-img-top" src="{{ asset('assets/images/default/tool.png') }}">';
                        html2 += '</a>';
                        html2 += '<div class="card-body text-center">';
						html2 += '<h6 class="text-dark mt-2">'+data.nama_tool+'</h6>';
						html2 += '<p class="mb-0 text-secondary">('+data.count+')</p>';
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
	.badge-new {font-weight: 800; position: absolute; right: 15px;}
	#data-file .card-body {padding: .5rem!important;}
</style>

@endsection