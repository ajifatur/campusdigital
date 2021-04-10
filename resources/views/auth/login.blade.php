<!DOCTYPE html>
<html dir="ltr">

<head>
    <title>Login | {{ get_website_name() }}</title>
	<meta name="description" content="{{ get_tagline() }}"/>
	<meta property="og:title" content="{{ get_website_name() }}"/>
	<meta property="og:description" content="{{ get_tagline() }}"/>
    @include('template/admin/_head')
    <style type="text/css">
        /*.auth-wrapper {height: calc(100vh)!important; background-color: {{ get_warna_primer() }}!important;}*/
        .main-wrapper{margin-top: 86px}
        /*.auth-box {background-color: {{ get_warna_tersier() }}!important; border-color: {{ get_warna_sekunder() }}!important; margin: auto!important;}*/
        .input-group>.input-group-append:not(:last-child)>.input-group-text {border-top-right-radius: 2px; border-bottom-right-radius: 2px;}
        #btn-toggle-password {cursor: pointer;}
        .auth-wrapper {
            min-height: unset; 
            position: relative;}
        .auth-wrapper .auth-box {
            background: #fff;
            padding: 20px;
            max-width: unset;
            width: 75%;
            margin: 0 auto}
        .image-login{margin: 10% 0;}
        @media (max-width: 768px){
            .auth-box {width: 100%!important; margin: 0 auto}
        }
        /*.rounded{border-radius: 3px!important}*/

/*        .border-or:before{content: ""; width: calc(100vh - 23em); border-bottom: 1px solid rgba(0,0,0,.2); position: absolute; left: 2em; top: 1em}
        .border-or:after{content: ""; width: 200px; border-bottom: 1px solid rgba(0,0,0,.2); position: absolute; right: 2em; top: 1em}
        @media (max-width: 425px){
        .border-or:before{content: ""; width: 70px; border-bottom: 1px solid rgba(0,0,0,.2); position: absolute; left: 2em; top: 1em}
        .border-or:after{content: ""; width: 70px; border-bottom: 1px solid rgba(0,0,0,.2); position: absolute; right: 2em; top: 1em}
        }
        @media (max-width: 375px){
        .border-or:before{content: ""; width: 40px; border-bottom: 1px solid rgba(0,0,0,.2); position: absolute; left: 2em; top: 1em}
        .border-or:after{content: ""; width: 40px; border-bottom: 1px solid rgba(0,0,0,.2); position: absolute; right: 2em; top: 1em}
        }
        @media (max-width: 320px){
        .border-or:before{content: ""; width: 30px; border-bottom: 1px solid rgba(0,0,0,.2); position: absolute; left: 2em; top: 1em}
        .border-or:after{content: ""; width: 30px; border-bottom: 1px solid rgba(0,0,0,.2); position: absolute; right: 2em; top: 1em}
        }*/
    </style>
</head>

<body>
@extends('template/guest/main')

@section('title', 'Daftar | ')

@section('content')

    <div class="main-wrapper">
        @include('template/admin/_preloader')
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="auth-wrapper w-100 my-4">
                        <div class="auth-box border-0 border-secondary rounded shadow">
                            <div id="loginform">
                                <div class="text-center p-b-20">
                                    <span class="db"><a href="/{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}"><img src="{{ asset('assets/images/logo/1599202531-logo.png') }}" height="100" alt="logo" /></a></span>
                                    <h3 class="mt-4">Masuk</h3>
                                </div>
                                <!-- Form -->
                                <form class="form-horizontal mt-2" id="loginform" action="/login" method="post">
                                    {{ csrf_field() }}
                                    @if(isset($message))
                                    <div class="alert alert-danger">
                                        {{ $message }}
                                    </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input-group mb-4">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text p-0 border-0 rounded {{ $errors->has('username') ? 'border-danger bg-danger' : 'bg-success' }}" id="basic-addon1"><!-- <i class="ti-user"></i> --></span>
                                                </div>
                                                <input type="text" name="username" class="form-control rounded {{ $errors->has('username') ? 'border-danger' : '' }}" value="{{ old('username') }}" placeholder="Email atau Username" aria-label="Username" aria-describedby="basic-addon1">
                                                @if($errors->has('username'))
                                                <small class="form-row col-12 mt-1 text-danger">{{ ucfirst($errors->first('username')) }}</small>
                                                @endif
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text p-0 border-0 rounded {{ $errors->has('password') ? 'border-danger bg-danger' : 'bg-success' }}" id="basic-addon2"><!-- <i class="ti-pencil"></i> --></span>
                                                </div>
                                                <input type="password" name="password" class="form-control rounded-start {{ $errors->has('password') ? 'border-danger' : '' }}" placeholder="Password" aria-label="Password" aria-describedby="basic-addon2">
                                                <div class="input-group-append">
                                                    <a href="#" class="input-group-text bg-theme-1 border-0 text-white {{ $errors->has('password') ? 'border-danger bg-danger' : 'bg-theme-1' }}" id="btn-toggle-password"><i class="fa fa-eye"></i></a>
                                                </div>
                                                @if($errors->has('password'))
                                                <small class="form-row col-12 mt-1 text-danger">{{ ucfirst($errors->first('password')) }}</small>
                                                @endif
                                            </div>
                                            <div class="lupa-password text-right mb-2">
                                                <a href="/recovery-password" class="color-theme-1">Lupa password?</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="p-t-20">
                                                    <button class="btn btn-theme-1 btn-block mb-3" type="submit">Masuk</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group mb-0">
                                                <div class="">
                                                    <p class="text-center border-or mb-0">Belum punya akun?</p>
                                                    <a class="btn btn-block btn-theme-2" href="/register{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">Daftar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>  
                </div>
                <div class="col-12 col-lg-6 d-none d-lg-block">
                    <div class="image-login">
                        <img src="{{ asset('assets/images/illustration/undraw_Login_re_4vu2.svg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
    </div>



    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="{{ asset('templates/matrix-admin/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('templates/matrix-admin/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('templates/matrix-admin/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>

    $(".preloader").fadeOut();

    // Button toggle password
    $(document).on("click", "#btn-toggle-password", function(e){
        e.preventDefault();
        if(!$(this).hasClass("show")){
            $("input[name=password]").attr("type","text");
            $(this).find(".fa").removeClass("fa-eye").addClass("fa-eye-slash");
            $(this).addClass("show");
        }
        else{
            $("input[name=password]").attr("type","password");
            $(this).find(".fa").removeClass("fa-eye-slash").addClass("fa-eye");
            $(this).removeClass("show");
        }
    });
    </script>
    <script type="text/javascript">
         $(document).on("click", ".navbar-toggler", function(e){
            e.preventDefault();
            if($(".navbar-collapse").hasClass('show'))
                $(".navbar-collapse").removeClass('show')
            else
                $(".navbar-collapse").addClass('show')
         });
    </script>
</body>

</html>