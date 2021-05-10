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
        <form method="get" action="">
            <div class="row align-items-end">
                <div class="col-lg-3"><p class="font-weight-bold m-0">Urutkan</p></div>
                <div class="col-lg-3">
                    <p class="m-0">Mulai</p>            
                    <div class="input-group">
                    <div class="input-group-prepend">
                        <a href="#" class="btn btn-sm btn-primary btn-date"><i class="fa fa-calendar"></i></a>
                    </div>
                    <input type="text" name="tanggal1" id="tanggal1" class="form-control form-control-sm" value="{{ $tanggal1 }}" readonly>
                    </div>
                </div>
                <div class="col-lg-3">
                    <p class="m-0">Akhir</p>
                    <div class="input-group">
                    <div class="input-group-prepend">
                        <a href="#" class="btn btn-sm btn-primary btn-date"><i class="fa fa-calendar"></i></a>
                    </div>
                    <input type="text" name="tanggal2" id="tanggal2" class="form-control form-control-sm" value="{{ $tanggal2 }}" readonly>
                    </div>
                </div>
                <div class="col-lg-3 text-right"><button class="btn btn-primary" type="submit">Terapkan</button></div>
            </div>
        </form>
        <hr>
        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-transparent">
                        <p class="font-weight-bold m-0">Usia</p>
                        <p class="m-0 text-muted">Statistik usia</p>
                    </div>
                    <div class="card-body">
                        <canvas id="chartUsia" width="600" height="400"></canvas>
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
                        <canvas id="chartGender" width="600" height="400"></canvas>
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
                        <canvas id="chartLokasi" width="600" height="400"></canvas>
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
                        <canvas id="chartKunjungan" width="600" height="400"></canvas>
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
                        <canvas id="chartPelatihan" width="600" height="400"></canvas>
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
                        <canvas id="chartChurn" width="600" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('template/admin/_footer')
</div>

@endsection

@section('js-extra')
<script src="{{ asset('templates/matrix-admin/assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script type="text/javascript">

// AJAX global events
$(document).bind("ajaxStart", function(){
    $(".page-wrapper .card-body").prepend("<p>Loading...</p>");
}).bind("ajaxComplete", function(){
    $(".page-wrapper .card-body p").hide();
});

$(function(){
    // Tanggal
    var tanggal1 = "{{ $tanggal1 }}";
    var tanggal2 = "{{ $tanggal2 }}";

    // Chart usia
    $.ajax({
        type: "get",
        url: "/admin/api/statistik/usia",
        data: {tanggal1: tanggal1, tanggal2: tanggal2},
        success: function(response){
            var result = response;
            generate_chart_pie(document.getElementById("chartUsia"), result.data.label, result.data.data_num, result.data.total, result.data.colors);
        }
    });

    // Chart gender
    $.ajax({
        type: "get",
        url: "/admin/api/statistik/gender",
        data: {tanggal1: tanggal1, tanggal2: tanggal2},
        success: function(response){
            var result = response;
            generate_chart_pie(document.getElementById("chartGender"), result.data.label, result.data.data_num, result.data.total, result.data.colors);
        }
    });

    // Chart lokasi
    $.ajax({
        type: "get",
        url: "/admin/api/statistik/lokasi",
        data: {tanggal1: tanggal1, tanggal2: tanggal2},
        success: function(response){
            var result = response;
            generate_chart_pie(document.getElementById("chartLokasi"), result.data.label, result.data.data_num, result.data.total, result.data.colors);
        }
    });

    // Chart kunjungan member
    $.ajax({
        type: "get",
        url: "/admin/api/statistik/kunjungan-member",
        data: {tanggal1: tanggal1, tanggal2: tanggal2},
        success: function(response){
            var result = response;
            generate_chart_pie(document.getElementById("chartKunjungan"), result.data.label, result.data.data_num, result.data.total, result.data.colors);
        }
    });

    // Chart pelatihan member
    $.ajax({
        type: "get",
        url: "/admin/api/statistik/pelatihan-member",
        data: {tanggal1: tanggal1, tanggal2: tanggal2},
        success: function(response){
            var result = response;
            generate_chart_pie(document.getElementById("chartPelatihan"), result.data.label, result.data.data_num, result.data.total, result.data.colors);
        }
    });

    // Chart churn rate member
    $.ajax({
        type: "get",
        url: "/admin/api/statistik/churn-rate-member",
        data: {tanggal1: tanggal1, tanggal2: tanggal2},
        success: function(response){
            var result = response;
            generate_chart_pie(document.getElementById("chartChurn"), result.data.label, result.data.data_num, result.data.total, result.data.colors);
        }
    });
});

function generate_chart_pie(canvas, labels, data, total, colors){
    var chart = new Chart(canvas, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: colors
            }]
        },
        options: {
            tooltips: {
                callbacks: {
                    title: function(tooltipItem, data) {
                        return data['labels'][tooltipItem[0]['index']];
                    },
                    label: function(tooltipItem, data) {
                        return data['datasets'][0]['data'][tooltipItem['index']] + " Member";
                    },
                    afterLabel: function(tooltipItem, data) {
                        var dataset = data['datasets'][0];
                        var percent = Math.round((dataset['data'][tooltipItem['index']] / total) * 100);
                        return '(' + percent + '%)';
                    }
                }
            }
        }
    });
    return chart;
}

$("#tanggal1").datepicker({
    format: 'dd/mm/yyyy',
    todayHighlight: true,
    autoclose: true
});
$("#tanggal2").datepicker({
    format: 'dd/mm/yyyy',
    todayHighlight: true,
    autoclose: true
});
</script>

@endsection

@section('css-extra')
<link href="{{ asset('templates/matrix-admin/assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endsection