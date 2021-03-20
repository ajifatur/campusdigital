<!-- Header Section -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow fixed-top">
	<div class="container ">
		<a class="navbar-brand" href="/{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">
			<img src="{{ asset('assets/images/logo/'.get_logo()) }}" height="60" alt="">
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarTogglerDemo02">
			<ul class="navbar-nav ml-auto mt-2 mt-lg-0">
				<li class="nav-item {{ Request::path() == '/' ? 'active' : '' }}">
					<a class="nav-link" href="/{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">Home</a>
				</li>
				<li class="nav-item dropdown {{ strpos(Request::url(), '/program/') ? 'active' : '' }}">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					  Program
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					  <a class="dropdown-item {{ strpos(Request::url(), '/program/pelatihan-digital-marketing-reguler') ? 'active' : '' }}" href="/program/pelatihan-digital-marketing-reguler">Pelatihan Digital Marketing Reguler</a>
					  <div class="dropdown-divider"></div>
					  <a class="dropdown-item text-wrap {{ strpos(Request::url(), '/program/paket-pelatihan-dan-sertifikasi-digital-marketing') ? 'active' : '' }}" href="/program/paket-pelatihan-dan-sertifikasi-digital-marketing">Paket Pelatihan dan Sertifikasi Digital Marketing</a>
					  <div class="dropdown-divider"></div>
					  <a class="dropdown-item {{ strpos(Request::url(), '/program/pelatihan-pkdm-program-kerjasama') ? 'active' : '' }}" href="/program/pelatihan-pkdm-program-kerjasama">Pelatihan PKDM (Program Kerjasama)</a>
					  <div class="dropdown-divider"></div>
					  <a class="dropdown-item {{ strpos(Request::url(), '/program/praktek-kerja-industri-pkl-online') ? 'active' : '' }}" href="/program/praktek-kerja-industri-pkl-online">Praktek Kerja Industri (PRAKERIN Online)</a>
					  <div class="dropdown-divider"></div>
					  <a class="dropdown-item {{ strpos(Request::url(), '/program/kelas-industri-digital-marketing') ? 'active' : '' }}" href="/program/kelas-industri-digital-marketing">Kelas Industri Digital Marketing</a>
					  <div class="dropdown-divider"></div>
					  <a class="dropdown-item {{ strpos(Request::url(), '/program/training-of-trainer') ? 'active' : '' }}" href="/program/training-of-trainer">Training Of Trainer</a>
					  <div class="dropdown-divider"></div>
					  <a class="dropdown-item text-wrap {{ strpos(Request::url(), '/program/uji-kompetensi-keahlian-digital-marketing-ukk-smk') ? 'active' : '' }}" href="/program/uji-kompetensi-keahlian-digital-marketing-ukk-smk">Uji Kompetensi Keahlian Digital Marketing (UKK SMK)</a>
					  <div class="dropdown-divider"></div>
					  <a class="dropdown-item {{ strpos(Request::url(), '/program/beasiswa') ? 'active' : '' }}" href="/program/beasiswa">Beasiswa</a>
					</div>
				</li>
<!-- 				<li class="nav-item {{ strpos(Request::url(), '/beasiswa') ? 'active' : '' }}">
					<a class="nav-link" href="/beasiswa{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">Beasiswa</a>
				</li> -->
				<li class="nav-item {{ strpos(Request::url(), '/afiliasi') ? 'active' : '' }}">
					<a class="nav-link" href="/afiliasi{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">Afiliasi</a>
				</li>
				<li class="nav-item {{ strpos(Request::url(), '/artikel') ? 'active' : '' }}">
					<a class="nav-link" href="/artikel{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">Artikel</a>
				</li>
				<li class="nav-item mb-2 mb-lg-0 {{ strpos(Request::url(), '/tentang-kami') ? 'active' : '' }}">
					<a class="nav-link" href="/tentang-kami{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">Tentang Kami</a>
				</li>

		        @if(Auth::guest())
				<li class="nav-item">
		          <a class="btn btn-theme-1 rounded-2 btn-block mb-3 mb-lg-0" href="/login{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">Masuk</a>
		        </li>
				<li class="nav-item">
		          <a class="btn btn-theme-2 rounded-2 btn-block mb-3 mb-lg-0" href="/register{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">Daftar</a>
		        </li>
				@else
				<!-- <li class="nav-item d-lg-none {{ strpos(Request::url(), '/register') ? 'active' : '' }}">
					<a class="nav-link" href="/register{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">Daftar</a>
				</li> -->


				<li class="nav-item dropdown">
					<a class="nav-link account dropdown-toggle d-flex align-items-center p-0 pb-2 pb-lg-0" href="#" id="navbarScrollingDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
					  <img src="{{ Auth::user()->foto != '' ? asset('assets/images/users/'.Auth::user()->foto) : asset('assets/images/default/user.jpg') }}" alt="user" class="rounded-circle pt-lg-1 mr-2" width="31">
					  <span class="d-lg-none">{{ Auth::user()->nama_user }}</span>
					</a>
					<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarScrollingDropdown">
					  <li><a class="dropdown-item" href="{{Auth::user()->is_admin==1? '/admin' : '/member'}}">Dashboard</a></li>
					  <li><a class="dropdown-item" href="{{Auth::user()->is_admin==1? '/admin/profil' : '/member/profil'}}">Profil</a></li>
					  @if(Auth::user()->is_admin==0)
					  <li><a class="dropdown-item" href="/member/afiliasi/cara-jualan">Afiliasi</a></li>
					  @endif
					  <li><hr class="dropdown-divider"></li>
					  <li><a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('form-logout').submit();">Keluar</a></li>
						<form id="form-logout" method="post" action="{{Auth::user()->is_admin==1? '/admin/logout' : '/member/logout'}}">
					        {{ csrf_field() }}
					    </form>
					</ul>
				</li>
				@endif

			</ul>
			<!-- <a class="btn btn-navbar btn-login d-lg-inline-block d-none" href="/login{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">Login</a>
			<a class="btn btn-navbar btn-register d-lg-inline-block d-none" href="/register{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">Daftar</a> -->
			<!-- <li class="nav-item"> -->
			<button class="btn btn-theme-1 rounded-2 ms-2 d-none">
				<a class="content-btn-nav" href="/login{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">Masuk</a>
				<span class="content-btn-nav" >|</span>
				<a class="content-btn-nav" href="/register{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">Daftar</a>
			</button>

	        <!-- </li> -->
		</div>
	</div>
</nav>
<!-- Header Section end -->