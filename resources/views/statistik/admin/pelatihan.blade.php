@extends('template/admin/main')

@section('content')

<div class="page-wrapper">
     <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Statistik Pelatihan</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item"><a href="/admin/statistik">Statistik</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pelatihan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <form id="form-filter" method="get" action="">
            <div class="row align-items-end">
                <div class="col-lg-3"><p class="font-weight-bold m-0">Filter</p></div>
                <div class="col-lg-3">
                    <p class="m-0">Pelatihan</p>
                    <select name="pelatihan" class="form-control form-control-sm">
                        <option value="" disabled selected>--Pilih--</option>
                        @if(count($pelatihan)>0)
                            @foreach($pelatihan as $data)
                                <option value="{{ $data->id_pelatihan }}" {{ isset($member) ? $member->id_pelatihan == $data->id_pelatihan ? 'selected' : '' : '' }}>{{ $data->nama_pelatihan }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-lg-3">
                    <p class="m-0">Member</p>
                    <select name="member" class="form-control form-control-sm">
                        <option value="" disabled selected>--Pilih--</option>
                        @if(isset($member))
                            @if(count($pelatihan_member)>0)
                                @foreach($pelatihan_member as $data)
                                    <option value="{{ $data->id_user }}" {{ isset($member) ? $member->id_user == $data->id_user ? 'selected' : '' : '' }}>{{ $data->nama_user }}</option>
                                @endforeach
                            @endif
                        @endif
                    </select>
                </div>
                <div class="col-lg-3 text-right"><button class="btn btn-primary" type="submit" {{ isset($member) ? '' : 'disabled' }}>Terapkan</button></div>
            </div>
        </form>
        <hr>
        @if(isset($member))
        <div class="row">
            <div class="col-lg-3">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Pelatihan:</label><br>{{ $member->nama_pelatihan }}
                        </div>
                        <div class="form-group">
                            <label>Member:</label><br>{{ $member->nama_user }}
                        </div>
                        <div class="form-group">
                            <label>Waktu:</label><br>{{ date('d/m/Y', strtotime($member->tanggal_pelatihan_from)) }} s.d {{ date('d/m/Y', strtotime($member->tanggal_pelatihan_to)) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow">
                            <div class="card-header bg-transparent">
                                <p class="font-weight-bold m-0">Login</p>
                                <p class="m-0 text-muted">Statistik Login</p>
                            </div>
                            <div class="card-body">
                                <canvas id="chartLogin" width="600" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    @include('template/admin/_footer')
</div>

@endsection

@section('js-extra')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

<script type="text/javascript">
    // Pelatihan
    $(document).on("change", "select[name=pelatihan]", function(){
        var value = $(this).val();
        $.ajax({
            type: "get",
            url: "/admin/api/statistik/member-pelatihan/" + value,
            success: function(response){
                var html = '<option value="" disabled selected>--Pilih--</option>';
                $(response.data).each(function(key,data){
                    html += '<option value="' + data.id_user + '">' + data.nama_user + '</option>';
                });
                $("select[name=member]").html(html);
                $("#form-filter").find("button[type=submit]").attr("disabled","disabled");
            }
        });
    });

    // Member
    $(document).on("change", "select[name=member]", function(){
        $("#form-filter").find("button[type=submit]").removeAttr("disabled");
    });

    // Submit
    $(document).on("submit", "#form-filter", function(e){
        e.preventDefault();
        var pelatihan = $("select[name=pelatihan]").val();
        var member = $("select[name=member]").val();
        window.location.href = "/admin/statistik/pelatihan/" + pelatihan + "/member/" + member;
    });
</script>

@if(isset($member))
<script>
function generate_chart_line(selector, label, color, labels, data){
    var ctx = document.getElementById(selector).getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: label,
                data: data,
                backgroundColor: color,
                borderColor: color,
                fill: false,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }]
            }
        }
    });
}

$(function(){
    $.ajax({
        type: "get",
        url: "/admin/api/statistik/member-pelatihan/login/{{ $member->id_pm }}",
        success: function(response){
            generate_chart_line("chartLogin", "Login", "#da542e", response.data.tanggal, response.data.visit);
        }
    })
});
</script>
@endif

@endsection