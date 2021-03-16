<!DOCTYPE html>
<html lang="zxx">
<head>
    @include('template/guest/_head')
    <style type="text/css">
		html, body {font-family: Lato;}
		p {font-size: 1rem;}
		.btn-link-primary {color: #46157a;}
		.btn-link-primary:hover {color: #46157a; text-decoration: underline;}
		.btn-link-secondary {color: #fdd100;}
		.btn-link-secondary:hover {color: #fdd100; text-decoration: underline;}
		.site-btn {color: #fff; background-color: #46157a; border: 2px solid #46157a; transition: .2s ease}
		.site-btn:hover {color: #46157a; background-color: transparent;}
		.icon-box-item .ib-icon {color: #46157a; border-color: #46157a;}
		.icon-box-item:hover .ib-icon {color: #fdd100; background-color: #46157a;}
		.sb-whatsapp {color: #333; background-color: #25D366; border-color: #25D366;}
		.sb-whatsapp:hover {color: #25D366; background-color: transparent;}
		
		.navbar-light .navbar-nav .nav-item {margin-left: .5rem; margin-right: .5rem;}
		.navbar-light .navbar-nav .nav-link {color: #333; font-size: 17px; font-weight: 600;}
		.navbar-light .navbar-nav .nav-link:hover {color: #46157a;}
		.navbar-light .navbar-nav .active > .nav-link {color: #46157a;}
		.btn-navbar {font-size: 17px; font-weight: 600; margin-left: .5rem; margin-right: .5rem;}
		.btn-login {background-color: #46157a; border: 2px solid #46157a; color: #fff; padding: 1rem; border-radius: 0;}
		.btn-login:hover {background-color: transparent; color: #46157a;}
		.btn-register {background-color: #fdd100; border: 2px solid #fdd100; color: #46157a; font-weight: 600; padding: 1rem; border-radius: 0;}
		.btn-register:hover {background-color: transparent; color: #46157a;}
		.btn-register-2 {font-size: 1rem; text-transform: uppercase; font-weight: 600; background-color: #fdd100; border: 2px solid #fdd100; color: #46157a; padding: 1rem 2rem; border-radius: 0; transition: .2s ease;}
		.btn-register-2:hover {background-color: transparent; color: #fdd100;}
		.navbar-light .navbar-toggler {background-color: #fdd100; border-width: 2px; border-color: #fdd100;}
		.navbar-light .navbar-toggler:hover {background-color: transparent; border-radius: 0;}
		
		/*.page-top-section {border-top: 5px solid #fdd100!important;}*/
		
        .footer-section {background-color: #46157a;}
        .footer-widget ul li {margin-bottom: 5px;}

		/* edited by isna prasetyo */

		/*theme*/
		.btn-theme-1{background-color: #46157a; color: #ffffff; border: 2px solid #46157a}
		.btn-theme-1:hover{color: #46157a!important; background-color: #ffffff!important; border: 2px solid #46157a!important}
		.btn-theme-1-1{background-color: #46157a; color: #ffffff;}
		.btn-theme-1:hover{color: #ffffff; background-color: #46157a;}
		.btn-theme-2{background-color: #fdd100; color: #46157a; border: 2px solid #fdd100}
		.btn-theme-2:hover{color: #fdd100!important; background-color: #ffffff!important; border: 2px solid #fdd100!important}
		.color-theme-1{color: #46157a;}

		.bg-theme-1{background-color: #46157a;}
		.bg-theme-2{background-color: #fdd100;}

		.border-theme-1{border-color: #46157a;}
		.border-theme-2{border-color: #fdd100;}

		/* style own */
		.rounded-1{border-radius: 1em!important}
		.rounded-2{border-radius: 2em!important}
		.rounded-3{border-radius: 3em!important}
		.rounded-4{border-radius: 4em!important}
		.rounded-5{border-radius: 5em!important}

		/*.navbar{border-bottom: 3px solid #fdd100}*/
		.navbar-light .navbar-nav .nav-link.active, .navbar-light .navbar-nav .show>.nav-link {color: #46157a;}
		.feature-section .owl-item{margin-top: 1em; margin-bottom: 1em; padding: 4em 0 1em 0;}
		.mitra-section .owl-item{margin-top:.2em; margin-bottom: .2em; padding: 4em 0 1em 0;}

		.btn-link-primary:hover{color: #46157a; text-decoration: none;}

		/*beasiswa*/
		.page-top-section {
		    height: auto;
		    padding: 3em 0em;
		    margin-top: 5em;
		}
		/**{border: 1px solid red}*/
		.account.dropdown-toggle:after{display: none;}
		/*.info-message{font-size: calc(.2em + 1vw);}*/

		.owl-carousel .owl-item img{margin: auto; width: 80%}

		@media (max-width: 991.98px){
		    .icon-box-item .ib-icon {width: 76px; margin: 0 auto;}
		    .icon-box-item:hover .ib-icon{color: #340369; background-color: transparent;}
		    .ib-text{text-align: center}
		    .owl-carousel .owl-item img{margin: auto; width: 60%}
		}

    </style>
    @yield('css-extra')
    <style type="text/css">
    	.hero-section {border-top: none!important;}
    	.page-top-section{border-top: none!important}
    </style>
</head>
<body>
    @include('template/guest/_preloader')
    @include('template/guest/_header')
    @yield('content')
    @include('template/guest/_footer')
    @include('template/guest/_js')
    @yield('js-extra')
</body>
</html>
