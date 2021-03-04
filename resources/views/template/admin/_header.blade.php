
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="/" target="_blank">
                        <!-- Logo icon -->
                        <b class="logo-icon p-l-10">
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="{{ asset('assets/images/logo/'.get_icon()) }}" height="30" alt="homepage" class="light-logo" />
                           
                        </b>
                        <!--End Logo icon -->
                         <!-- Logo text -->
                        <span class="logo-text ml-2">
                             <!-- dark Logo text -->
                             Admin Area
                             <!-- <img src="{{ asset('assets/images/logo/'.get_logo()) }}" height="30" alt="homepage" class="light-logo" /> -->
                            
                        </span>
                        <!-- Logo icon -->
                        <!-- <b class="logo-icon"> -->
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <!-- <img src="{{ asset('templates/matrix-admin/assets/images/logo-text.png') }}" alt="homepage" class="light-logo" /> -->
                            
                        <!-- </b> -->
                        <!--End Logo icon -->
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->
                        @if(Auth::user()->role == role_it())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="font-24 mdi mdi-chart-arc"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown shadow">
                                <ul class="list-style-none">
                                    <li>
                                        <a href="/admin/statistik/visitor" class="link border-top">
                                            <div class="d-flex no-block align-items-center p-10">
                                                <span class="btn btn-primary btn-circle"><i class="ti-pie-chart"></i></span>
                                                <div class="m-l-10">
                                                    <h5 class="m-b-0">Visitor</h5> 
                                                    <span class="mail-desc">Lihat Selengkapnya</span> 
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/admin/statistik/top-visitor" class="link border-top">
                                            <div class="d-flex no-block align-items-center p-10">
                                                <span class="btn btn-success btn-circle"><i class="ti-pie-chart"></i></span>
                                                <div class="m-l-10">
                                                    <h5 class="m-b-0">Top Visitor</h5> 
                                                    <span class="mail-desc">Lihat Selengkapnya</span> 
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/admin/statistik/file-reader" class="link border-top">
                                            <div class="d-flex no-block align-items-center p-10">
                                                <span class="btn btn-warning btn-circle"><i class="ti-book"></i></span>
                                                <div class="m-l-10">
                                                    <h5 class="m-b-0">Pembaca Materi</h5> 
                                                    <span class="mail-desc">Lihat Selengkapnya</span> 
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="font-24 mdi mdi-bell"></i>
								@if($global_total > 0) <span class="badge badge-danger" style="font-size: 10px">{{ $global_total }}</span> @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown shadow" aria-labelledby="2">
                                <ul class="list-style-none">
                                    <li>
                                        <a href="/admin/transaksi/komisi" class="link border-top">
                                            <div class="d-flex no-block align-items-center p-10">
                                                <span class="btn btn-success btn-circle"><i class="ti-money"></i></span>
                                                <div class="m-l-10">
                                                    <h5 class="m-b-0">Verifikasi Komisi</h5> 
                                                    <span class="mail-desc">{{ $global_komisi_total }} pemberitahuan baru.</span> 
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/admin/transaksi/withdrawal" class="link border-top">
                                            <div class="d-flex no-block align-items-center p-10">
                                                <span class="btn btn-warning btn-circle"><i class="ti-money"></i></span>
                                                <div class="m-l-10">
                                                    <h5 class="m-b-0">Pengambilan Komisi</h5> 
                                                    <span class="mail-desc">{{ $global_withdrawal_total }} pemberitahuan baru.</span> 
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/admin/transaksi/pelatihan" class="link border-top">
                                            <div class="d-flex no-block align-items-center p-10">
                                                <span class="btn btn-info btn-circle"><i class="ti-money"></i></span>
                                                <div class="m-l-10">
                                                    <h5 class="m-b-0">Pembayaran Pelatihan</h5> 
                                                    <span class="mail-desc">{{ $global_pelatihan_member_total }} pemberitahuan baru.</span> 
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ Auth::user()->foto != '' ? asset('assets/images/users/'.Auth::user()->foto) : asset('assets/images/default/user.jpg') }}" alt="user" class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                <span class="dropdown-item bg-success" href="javascript:void(0)"><i class="ti-face-smile m-r-5 m-l-5"></i> Hai, <strong>{{ Auth::user()->nama_user }}</strong></span>
                                <a class="dropdown-item" href="/" target="_blank"><i class="ti-home m-r-5 m-l-5"></i> Ke Halaman Utama</a>
                                <a class="dropdown-item" href="/admin/profil"><i class="ti-user m-r-5 m-l-5"></i> Profil</a>
                                @if(Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor())
                                <a class="dropdown-item" href="/admin/e-signature"><i class="ti-pencil m-r-5 m-l-5"></i> E-Signature</a>
                                @endif
                                <a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('form-logout').submit();"><i class="ti-power-off m-r-5 m-l-5"></i> Logout</a>
                                <form id="form-logout" method="post" action="/admin/logout">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->