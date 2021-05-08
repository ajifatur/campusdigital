@extends('template/admin/main')

@section('content')

<div class="page-wrapper">
     <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Statistik</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Statistik</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-transparent">
                        <p class="font-weight-bold m-0">Usia</p>
                        <p class="m-0 text-muted">Statistik usia</p>
                    </div>
                    <div class="card-body">
                        <canvas id="cartUsia" width="600" height="400"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-transparent">
                        <p class="font-weight-bold m-0">Gender</p>
                        <p class="m-0 text-muted">Statistik Gender</p>
                    </div>
                    <div class="card-body">
                        <canvas id="cartGender" width="600" height="400"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-transparent">
                        <p class="font-weight-bold m-0">Lokasi</p>
                        <p class="m-0 text-muted">Statistik Lokasi</p>
                    </div>
                    <div class="card-body">
                        <canvas id="cartLokasi" width="600" height="400"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-transparent">
                        <p class="font-weight-bold m-0">Kunjungan</p>
                        <p class="m-0 text-muted">Statistik Kunjungan</p>
                    </div>
                    <div class="card-body">
                        <canvas id="cartKunjungan" width="600" height="400"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-transparent">
                        <p class="font-weight-bold m-0">Pelatihan</p>
                        <p class="m-0 text-muted">Statistik Pelatihan</p>
                    </div>
                    <div class="card-body">
                        <canvas id="cartPelatihan" width="600" height="400"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-transparent">
                        <p class="font-weight-bold m-0">Churn Rate</p>
                        <p class="m-0 text-muted">Statistik Churn Rate</p>
                    </div>
                    <div class="card-body">
                        <canvas id="cartChurn" width="600" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('template/admin/_footer')
</div>

@endsection

@section('js-extra')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script type="text/javascript">
var canvasUsia = document.getElementById("cartUsia");
var canvasGender = document.getElementById("cartGender");
var canvasLokasi = document.getElementById("cartLokasi");
var canvasKunjungan = document.getElementById("cartKunjungan");
var canvasPelatihan = document.getElementById("cartPelatihan");
var canvasChurn = document.getElementById("cartChurn");
var oilData = {
    labels: [
        "Saudi Arabia",
        "Russia",
        "Iraq",
        "United Arab Emirates",
        "Canada"
    ],
    datasets: [
        {
            data: [133.3, 86.2, 52.2, 51.2, 50.2],
            backgroundColor: [
                "#FF6384",
                "#63FF84",
                "#84FF63",
                "#8463FF",
                "#6384FF"
            ]
        }]
};

var pieChart = new Chart(cartUsia, {
  type: 'pie',
  data: oilData
});
var pieChart = new Chart(cartGender, {
  type: 'pie',
  data: oilData
});
var pieChart = new Chart(cartLokasi, {
  type: 'pie',
  data: oilData
});
var pieChart = new Chart(cartKunjungan, {
  type: 'pie',
  data: oilData
});
var pieChart = new Chart(cartPelatihan, {
  type: 'pie',
  data: oilData
});
var pieChart = new Chart(cartChurn, {
  type: 'pie',
  data: oilData
});


</script>

@endsection

@section('css-extra')

@endsection