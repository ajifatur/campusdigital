<section class="page-top-section set-bg" data-setbg="{{ asset('templates/loans2go/img/page-top-bg/2.jpg') }}">
	<div class="container">
		<h2>@yield('subtitle')</h2>
		<nav class="site-breadcrumb">
			<a class="sb-item" href="/{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">Home</a>
			<a class="sb-item" href="#">Program</a>
			<span class="sb-item active">@yield('subtitle')</span>
		</nav>
	</div>
</section>