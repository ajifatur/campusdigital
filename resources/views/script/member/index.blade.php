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
                <h4 class="page-title">Kumpulan Copywriting</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/member">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Kumpulan Copywriting</li>
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
                                <h5 class="mb-0">Kumpulan Copywriting</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
						<div class="col-12">
							<div class="row">
                                @foreach($rak as $data)
                                    <a class="col-md-6 col-lg-3 col-xlg-3" href="/member/script/rak/{{ $data->id_rak }}">
                                        <div class="card card-hover shadow">
                                            <div class="box text-center">
                                                <img src="{{ $data->rak_icon != '' ? asset('assets/images/rak/'.$data->rak_icon) : asset('assets/images/default/rak.png') }}" height="100">
                                                <h6 class="text-dark mt-2">{{ $data->rak }}</h6>
											    <p class="mb-0 text-secondary">({{ count_scripts($data->id_rak) }} script)</p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
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

@section('css-extra')

<style type="text/css">
	.box {background-color: #fff!important; cursor: pointer;}
</style>

@endsection