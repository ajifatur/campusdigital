@extends('template/admin/main')

@section('content')

<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
	@include('template/admin/_breadcrumb', ['breadcrumb' => [
		'title' => 'Dashboard',
		'items' => [
			['text' => 'Dashboard', 'url' => '#']
		]
	]])
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
            <!-- welcome text -->
            <div class="col-lg-12">
                <div class="alert alert-success text-center shadow">
                    Selamat datang <span class="font-weight-bold">{{ Auth::user()->nama_user }}</span> di {{ get_website_name() }}.
                </div>
            </div>
            <!-- visitor last 7 days -->
            <div class="col-lg-6">
				<div class="card shadow">
                    <h5 class="card-title border-bottom">Pengunjung 7 Hari Terakhir</h5>
					<div class="card-body">
						<canvas id="myChart" width="400" height="270"></canvas>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="card shadow">
					<div class="card-body">
						<h5 class="card-title m-b-0">Statistik</h5>
						<div class="list-group mt-3">
							@foreach($array as $key=>$data)
							<a href="{{ $data['url'] }}" class="list-group-item list-group-item-action d-flex justify-content-between {{ $key == 0 ? 'bg-warning' : '' }}">
								<span>{{ $data['data'] }}</span>
								<span>{{ number_format($data['total'],0,'.','.') }}</span>
							</a>
							@endforeach
						</div>
					</div>
				</div>
			</div>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha512-s+xg36jbIujB2S2VKfpGmlC3T5V2TF3lY48DX7u2r9XzGzgPsa6wTpOQA7J9iffvdeBN0q9tKzRxVxw1JviZPg==" crossorigin="anonymous"></script>
<script>
	$(window).on("load", function(){
		count_visitor();
	});
	
	function count_visitor(){
		$.ajax({
			type: "get",
			url: "/admin/ajax/count-visitor",
			success: function(response){
				var result = JSON.parse(response);
				var date = [];
				var date_str = [];
				var visitor_all = [];
				var visitor_admin = [];
				var visitor_member = [];
				$(result).each(function(key,data){
					date.push(data.date);
					date_str.push(data.date_str);
					visitor_all.push(data.visitor_all);
					visitor_admin.push(data.visitor_admin);
					visitor_member.push(data.visitor_member);
				});
				chart_js("myChart", "line", date_str, visitor_all, visitor_admin, visitor_member);
			}
		});
	}
	
	function chart_js(selector, type, labels, data1, data2, data3){
		var ctx = document.getElementById(selector);
		var myChart = new Chart(ctx, {
			type: type,
			data: {
				labels: labels,
				datasets: [
					{
						label: 'Semua',
						data: data1,
						backgroundColor: '#28b779',
						borderColor: '#28b779',
						fill: false,
						borderWidth: 1
					},
					{
						label: 'Admin',
						data: data2,
						backgroundColor: '#da542e',
						borderColor: '#da542e',
						fill: false,
						borderWidth: 1
					},
					{
						label: 'Member',
						data: data3,
						backgroundColor: '#27a9e3',
						borderColor: '#27a9e3',
						fill: false,
						borderWidth: 1
					},
				]
			},
			options: {
				responsive: true,
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true,
							//stepSize: 2
						}
					}]
				}
			}
		});
	}
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
<style type="text/css">
	.card-title {text-align: center!important;}
    .border-top, .border-bottom {padding: 1.25rem;}
</style>

@endsection