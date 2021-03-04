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
                <h4 class="page-title">{{ $rak->rak }}</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/member">Home</a></li>
                            <li class="breadcrumb-item"><a href="/member/script">Kumpulan Copywriting</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $rak->rak }}</li>
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
                <!-- accordion -->
                <div class="accordion shadow" id="accordionExample">
                    @foreach($script as $key=>$data)
                    <div class="card m-b-0 border-top">
                        <div class="card-header" id="heading-{{ $key }}">
                            <h5 class="mb-0">
                                <a  data-toggle="collapse" data-target="#collapse-{{ $key }}" aria-expanded="true" aria-controls="collapse-{{ $key }}">
                                    <i class="m-r-5 fa fa-clipboard" aria-hidden="true"></i>
                                    <span>{{ $data->script_title }}</span>
                                </a>
                            </h5>
                        </div>
                        <div id="collapse-{{ $key }}" class="collapse {{ $key == 0 ? 'show' : '' }}" aria-labelledby="collapse-{{ $key }}" data-parent="#accordionExample">
                            <div class="card-footer">
                                <button class="btn btn-success btn-sm btn-copy" data-id="{{ $key }}" type="button" data-toggle="tooltip" data-placement="top" title="Salin Teks"><i class="fa fa-copy mr-2"></i>Salin Teks</button>
                            </div>
                            <div class="card-body">{!! nl2br(html_entity_decode($data->script)) !!}</div>
                            <textarea id="textarea-{{ $key }}">{!! html_entity_decode($data->script) !!}</textarea>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- accordion -->
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
	// Button Copy to Clipboard
    $(document).on("click", ".btn-copy", function(e){
		e.preventDefault();
        var id = $(this).data("id");
		// var copyText = document.getElementById("textarea");
		var copyText = document.getElementById("textarea-"+id);
		copyText.select();
		copyText.setSelectionRange(0, 999999);
		console.log(document.execCommand("copy"));
		$(this).attr('data-original-title','Berhasil Menyalin Teks!');
		$(this).tooltip("show");
		$(this).attr('data-original-title','Salin Teks');
    });
</script>

@endsection

@section('css-extra')

<style type="text/css">
    .accordion .card-header {cursor: pointer;}
    .accordion .border-top {padding: 0;}
    textarea {position: absolute; z-index: -10;}
</style>

@endsection