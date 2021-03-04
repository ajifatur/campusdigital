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
                <h4 class="page-title">Cara Jualan</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/member">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Afiliasi</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Cara Jualan</li>
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
                    <div class="card-body">
                        <div class="m-t-20 m-b-20">
                            <div class="d-flex no-block align-items-center">
                                <div class="row">
                                    <div class="col-md-6 col-sm-9 col-12 mx-auto p-3 text-center border border-secondary bg-warning shadow">
                                        <h4>URL Referral Anda</h4>
                                        <p class="mb-0 h5"><a class="font-weight-bold" href="{{ URL::to('/') }}?ref={{ Auth::user()->username }}" target="_blank">{{ URL::to('/') }}?ref={{ Auth::user()->username }}</a></p>
                                    </div>
                                    <div class="col-12 mt-4 text-center">
                                        <p class="h5">Promosikan URL Referral Anda dan dapatkan Komisi Sponsor sebesar <strong class="text-danger">Rp. {{ Auth::user()->role == role_trainer() ? number_format(get_special_comission(),0,',','.') : number_format(get_comission(),0,',','.') }}</strong> setiap ada member baru yang bergabung melalui URL Anda. Tidak ada batasan jumlah member yang Anda sponsori, Anda bisa mensponsori puluhan, bahkan ratusan member.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- column -->
            <!-- column -->
            <div class="col-lg-12">
                <!-- card -->
                <div class="card shadow">
                    <div class="card-body text-justify">
                        <h4 class="card-title">Apa itu Referral?</h4>
                        <div class="m-t-20 m-b-20">
                            <p>Referral adalah seseorang yang kita ajak (refer) dimana mereka mendaftar ke salah satu situs yang kita tawarkan. Setiap PTC akan memberikan alat kepada anggota untuk mempromosikan situs mereka kepada orang lain. Ini dapat berupa text link (URL) atau banner yang tentunya menggunakan kode script.</p>
                            <p>Jika orang yang diajak mendaftar melalui URL referral, maka kita biasanya kita akan mendapatkan komisi. Disini, kami memberikan komisi berupa uang sebesar <strong class="text-danger">Rp. {{ Auth::user()->role == role_trainer() ? number_format(get_special_comission(),0,',','.') : number_format(get_comission(),0,',','.') }}</strong> setiap ada member baru yang bergabung melalui URL referral.</p>
                            <p class="mb-1">Berikut adalah tips sebelum memulai program referral:</p>
                            <ol>
                                <li>Pahami dan kuasai sistem produk secara baik.</li>
                                <li>Buatlah daftar calon prospek. Bisa dimulai dari orang terdekat Anda, atau bisa juga mitra Anda.</li>
                                <li>Promosikan URL Referral Anda melalui situs iklan baris, PPC (Pay-Per-Click), PTC (Pay-To-Click), atau situs-situs lain yang <em>trafficnya</em> tinggi.</li>
                            </ol>
                        </div>
                    </div>
                </div>
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