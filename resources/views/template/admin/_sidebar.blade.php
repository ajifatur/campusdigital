
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="p-t-30">
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/admin" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>
                        @if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer())
                        <li class="sidebar-item {{ strpos(Request::url(), '/admin/user') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link {{ strpos(Request::url(), '/admin/user') ? 'active' : '' }}" href="/admin/user" aria-expanded="false"><i class="mdi mdi-account-multiple"></i><span class="hide-menu">User</span></a></li>
                        @endif
                        @if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor())
                        <li class="sidebar-item {{ strpos(Request::url(), '/admin/statistik') ? 'selected' : '' }}"> <a class="sidebar-link has-arrow waves-effect waves-dark {{ strpos(Request::url(), '/admin/statistik') ? 'active' : '' }}" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-chart-arc"></i><span class="hide-menu">Statistik</span></a>
                            <ul aria-expanded="false" class="collapse first-level {{ strpos(Request::url(), '/admin/statistik') ? 'in' : '' }}">
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/statistik/umum') ? 'active' : '' }}"><a href="/admin/statistik/umum" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Umum</span></a></li>
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/statistik/pelatihan') ? 'active' : '' }}"><a href="/admin/statistik/pelatihan" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Pelatihan</span></a></li>
                            </ul>
                        </li>
                        @endif
                        @if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer())
                        <li class="sidebar-item {{ strpos(Request::url(), '/admin/pengaturan') ? 'selected' : '' }}"> <a class="sidebar-link has-arrow waves-effect waves-dark {{ strpos(Request::url(), '/admin/pengaturan') ? 'active' : '' }}" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-settings"></i><span class="hide-menu">Pengaturan</span></a>
                            <ul aria-expanded="false" class="collapse first-level {{ strpos(Request::url(), '/admin/pengaturan') ? 'in' : '' }}">
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/pengaturan/umum') ? 'active' : '' }}"><a href="/admin/pengaturan/umum" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Umum</span></a></li>
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/pengaturan/tampilan') ? 'active' : '' }}"><a href="/admin/pengaturan/tampilan" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Tampilan</span></a></li>
                                @if(Auth::user()->role == role_it())
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/pengaturan/role') ? 'active' : '' }}"><a href="/admin/pengaturan/role" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Role</span></a></li>
                                @endif
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/pengaturan/platform') ? 'active' : '' }}"><a href="/admin/pengaturan/platform" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Platform Pembayaran</span></a></li>
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/pengaturan/rekening') ? 'active' : '' }}"><a href="/admin/pengaturan/rekening" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Rekening</span></a></li>
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/pengaturan/harga') ? 'active' : '' }}"><a href="/admin/pengaturan/harga" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Harga</span></a></li>
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/pengaturan/e-sertifikat') ? 'active' : '' }}"><a href="/admin/pengaturan/e-sertifikat" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">E-Sertifikat</span></a></li>
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/pengaturan/e-mail') ? 'active' : '' }}"><a href="/admin/pengaturan/e-mail" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">E-Mail</span></a></li>
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/pengaturan/kategori-materi') ? 'active' : '' }}"><a href="/admin/pengaturan/kategori-materi" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Kategori Materi</span></a></li>
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/pengaturan/kategori-pelatihan') ? 'active' : '' }}"><a href="/admin/pengaturan/kategori-pelatihan" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Kategori Pelatihan</span></a></li>
                            </ul>
                        </li>
                        @endif
                        @if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_finance())
                        <li class="sidebar-item {{ strpos(Request::url(), '/admin/rekening') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link {{ strpos(Request::url(), '/admin/rekening') ? 'active' : '' }}" href="/admin/rekening" aria-expanded="false"><i class="mdi mdi-credit-card-multiple"></i><span class="hide-menu">Rekening</span></a></li>
                        @endif
                        @if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_finance())
                        <li class="sidebar-item {{ strpos(Request::url(), '/admin/transaksi') ? 'selected' : '' }}"> <a class="sidebar-link has-arrow waves-effect waves-dark {{ strpos(Request::url(), '/admin/transaksi') ? 'active' : '' }}" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-credit-card-scan"></i><span class="hide-menu">Transaksi</span></a>
                            <ul aria-expanded="false" class="collapse first-level {{ strpos(Request::url(), '/admin/transaksi') ? 'in' : '' }}">
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/transaksi/komisi') ? 'active' : '' }}"><a href="/admin/transaksi/komisi" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Komisi</span></a></li>
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/transaksi/withdrawal') ? 'active' : '' }}"><a href="/admin/transaksi/withdrawal" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Withdrawal</span></a></li>
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/transaksi/pelatihan') ? 'active' : '' }}"><a href="/admin/transaksi/pelatihan" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Pelatihan</span></a></li>
                            </ul>
                        </li>
                        @endif
                        <li class="sidebar-item {{ strpos(Request::url(), '/admin/email') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link {{ strpos(Request::url(), '/admin/email') ? 'active' : '' }}" href="/admin/email" aria-expanded="false"><i class="mdi mdi-email"></i><span class="hide-menu">E-Mail</span></a></li>
                        @if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor())
                        <li class="sidebar-item {{ strpos(Request::url(), '/admin/artikel') ? 'selected' : '' }}"> <a class="sidebar-link has-arrow waves-effect waves-dark {{ strpos(Request::url(), '/admin/artikel') ? 'active' : '' }}" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-pencil"></i><span class="hide-menu">Artikel</span></a>
                            <ul aria-expanded="false" class="collapse first-level {{ strpos(Request::url(), '/admin/artikel') ? 'in' : '' }}">
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/artikel') && !strpos(Request::url(), '/admin/artikel/kategori') && !strpos(Request::url(), '/admin/artikel/tag') ? 'active' : '' }}"><a href="/admin/artikel" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Data Artikel</span></a></li>
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/artikel/kategori') ? 'active' : '' }}"><a href="/admin/artikel/kategori" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Kategori</span></a></li>
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/artikel/tag') ? 'active' : '' }}"><a href="/admin/artikel/tag" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Tag</span></a></li>
                            </ul>
                        </li>
						<!--
                        <li class="sidebar-item {{ strpos(Request::url(), '/admin/halaman') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link {{ strpos(Request::url(), '/admin/halaman') ? 'active' : '' }}" href="/admin/halaman" aria-expanded="false"><i class="mdi mdi-library-plus"></i><span class="hide-menu">Halaman</span></a></li>
						-->
                        <li class="sidebar-item {{ strpos(Request::url(), '/admin/pop-up') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link {{ strpos(Request::url(), '/admin/pop-up') ? 'active' : '' }}" href="/admin/pop-up" aria-expanded="false"><i class="mdi mdi-image"></i><span class="hide-menu">Pop-up</span></a></li>
                        @endif
                        @if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor())
						<!--
                        <li class="sidebar-item {{ strpos(Request::url(), '/admin/menu') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link {{ strpos(Request::url(), '/admin/menu') ? 'active' : '' }}" href="/admin/menu" aria-expanded="false"><i class="mdi mdi-menu"></i><span class="hide-menu">Menu</span></a></li>
						-->
                        <li class="sidebar-item {{ strpos(Request::url(), '/admin/konten-web') ? 'selected' : '' }}"> <a class="sidebar-link has-arrow waves-effect waves-dark {{ strpos(Request::url(), '/admin/konten-web') ? 'active' : '' }}" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-web"></i><span class="hide-menu">Konten Web</span></a>
                            <ul aria-expanded="false" class="collapse first-level {{ strpos(Request::url(), '/admin/konten-web') ? 'in' : '' }}">
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/konten-web/fitur') ? 'active' : '' }}"><a href="/admin/konten-web/fitur" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Fitur</span></a></li>
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/konten-web/mentor') ? 'active' : '' }}"><a href="/admin/konten-web/mentor" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Mentor</span></a></li>
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/konten-web/cabang') ? 'active' : '' }}"><a href="/admin/konten-web/cabang" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Cabang</span></a></li>
								<!--
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/konten-web/deskripsi') ? 'active' : '' }}"><a href="/admin/konten-web/deskripsi" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Deskripsi</span></a></li>
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/konten-web/layanan') ? 'active' : '' }}"><a href="/admin/konten-web/layanan" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Layanan</span></a></li>
								-->
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/konten-web/mitra') ? 'active' : '' }}"><a href="/admin/konten-web/mitra" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Mitra</span></a></li>
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/konten-web/mentor') ? 'active' : '' }}"><a href="/admin/konten-web/mentor" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Mentor</span></a></li>
								<!--
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/konten-web/testimoni') ? 'active' : '' }}"><a href="/admin/konten-web/testimoni" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Testimoni</span></a></li>
								-->
                            </ul>
                        </li>
                        @endif
                        @foreach($kategori_materi as $kategori)
                        <!-- <li class="sidebar-item {{ strpos(Request::url(), '/admin/materi/'.strtolower($kategori->kategori)) ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link {{ strpos(Request::url(), '/admin/materi/'.strtolower($kategori->kategori)) ? 'active' : '' }}" href="/admin/materi/{{ strtolower($kategori->kategori) }}" aria-expanded="false"><i class="mdi mdi-book-multiple"></i><span class="hide-menu">Materi {{ $kategori->kategori }}</span></a></li> -->
                        @endforeach

                        <li class="sidebar-item {{ strpos(Request::url(), '/admin/file-manager/e-learning') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link {{ strpos(Request::url(), '/admin/file-manager/e-learning') ? 'active' : '' }}" href="/admin/file-manager/e-learning" aria-expanded="false"><i class="mdi mdi-book-multiple"></i><span class="hide-menu">Materi E-Learning</span></a></li>
                        <li class="sidebar-item {{ strpos(Request::url(), '/admin/file-manager/e-library') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link {{ strpos(Request::url(), '/admin/file-manager/e-library') ? 'active' : '' }}" href="/admin/file-manager/e-library" aria-expanded="false"><i class="mdi mdi-book-multiple"></i><span class="hide-menu">Materi E-Library</span></a></li>
                        <li class="sidebar-item {{ strpos(Request::url(), '/admin/file-manager/e-competence') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link {{ strpos(Request::url(), '/admin/file-manager/e-competence') ? 'active' : '' }}" href="/admin/file-manager/e-competence" aria-expanded="false"><i class="mdi mdi-book-multiple"></i><span class="hide-menu">Materi E-Competence</span></a></li>
                        <li class="sidebar-item {{ strpos(Request::url(), '/admin/file-manager/e-course') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link {{ strpos(Request::url(), '/admin/file-manager/e-course') ? 'active' : '' }}" href="/admin/file-manager/e-course" aria-expanded="false"><i class="mdi mdi-video"></i><span class="hide-menu">Materi E-Course</span></a></li>
                        <li class="sidebar-item {{ strpos(Request::url(), '/admin/script') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link {{ strpos(Request::url(), '/admin/script') ? 'active' : '' }}" href="/admin/script" aria-expanded="false"><i class="mdi mdi-text-shadow"></i><span class="hide-menu">Kumpulan Copywriting</span></a></li>
                        <li class="sidebar-item {{ strpos(Request::url(), '/admin/file-manager/tools') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link {{ strpos(Request::url(), '/admin/file-manager/tools') ? 'active' : '' }}" href="/admin/file-manager/tools" aria-expanded="false"><i class="mdi mdi-briefcase"></i><span class="hide-menu">Kumpulan Tools</span></a></li>

                        <!-- <li class="sidebar-item {{ strpos(Request::url(), '/admin/e-course') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link {{ strpos(Request::url(), '/admin/e-course') ? 'active' : '' }}" href="/admin/e-course" aria-expanded="false"><i class="mdi mdi-video"></i><span class="hide-menu">Materi E-Course</span></a></li>
                        <li class="sidebar-item {{ strpos(Request::url(), '/admin/script') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link {{ strpos(Request::url(), '/admin/script') ? 'active' : '' }}" href="/admin/script" aria-expanded="false"><i class="mdi mdi-text-shadow"></i><span class="hide-menu">Kumpulan Copywriting</span></a></li>
                        <li class="sidebar-item {{ strpos(Request::url(), '/admin/tools') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link {{ strpos(Request::url(), '/admin/tools') ? 'active' : '' }}" href="/admin/tools" aria-expanded="false"><i class="mdi mdi-briefcase"></i><span class="hide-menu">Kumpulan Tools</span></a></li> -->
                        @if(Auth::user()->role == role_it() || Auth::user()->role == role_manajer() || Auth::user()->role == role_mentor())
                        <li class="sidebar-item {{ strpos(Request::url(), '/admin/magang') ? 'selected' : '' }}"> <a class="sidebar-link has-arrow waves-effect waves-dark {{ strpos(Request::url(), '/admin/magang') ? 'active' : '' }}" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-account-settings"></i><span class="hide-menu">Magang</span></a>
                            <ul aria-expanded="false" class="collapse first-level {{ strpos(Request::url(), '/admin/e-sertifikat') ? 'in' : '' }}">
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/magang/member') ? 'active' : '' }}"><a href="/admin/magang/member" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Data Member</span></a></li>
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/magang/absensi') ? 'active' : '' }}"><a href="/admin/magang/absensi" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Absensi</span></a></li>
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/magang/sosialisasi') ? 'active' : '' }}"><a href="/admin/magang/sosialisasi" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Sosialisasi</span></a></li>
                            </ul>
                        </li>
                        <li class="sidebar-item {{ strpos(Request::url(), '/admin/pelatihan') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link {{ strpos(Request::url(), '/admin/pelatihan') ? 'active' : '' }}" href="/admin/pelatihan" aria-expanded="false"><i class="mdi mdi-school"></i><span class="hide-menu">Pelatihan</span></a></li>
                        <li class="sidebar-item {{ strpos(Request::url(), '/admin/e-sertifikat') ? 'selected' : '' }}"> <a class="sidebar-link has-arrow waves-effect waves-dark {{ strpos(Request::url(), '/admin/e-sertifikat') ? 'active' : '' }}" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-certificate"></i><span class="hide-menu">Arsip E-Sertifikat</span></a>
                            <ul aria-expanded="false" class="collapse first-level {{ strpos(Request::url(), '/admin/e-sertifikat') ? 'in' : '' }}">
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/e-sertifikat/trainer') ? 'active' : '' }}"><a href="/admin/e-sertifikat/trainer" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Trainer</span></a></li>
                                <li class="sidebar-item {{ strpos(Request::url(), '/admin/e-sertifikat/peserta') ? 'active' : '' }}"><a href="/admin/e-sertifikat/peserta" class="sidebar-link"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Peserta</span></a></li>
                            </ul>
                        </li>
                        <li class="sidebar-item {{ strpos(Request::url(), '/admin/absensi') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link {{ strpos(Request::url(), '/admin/absensi') ? 'active' : '' }}" href="/admin/absensi" aria-expanded="false"><i class="mdi mdi-pencil"></i><span class="hide-menu">Absensi Online</span></a></li>
                        @endif
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('form-logout').submit();" aria-expanded="false"><i class="mdi mdi-power"></i><span class="hide-menu">Keluar</span></a></li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->