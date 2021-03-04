@extends('template/admin/main')

@section('content')

<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
     <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Pengaturan E-Mail</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item"><a href="/#">Pengaturan</a></li>
                            <li class="breadcrumb-item active" aria-current="page">E-Mail</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
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
            <!-- column -->
            <div class="col-md-6 mx-md-auto">
                <!-- card -->
                <div class="card shadow">
                    <h5 class="card-title border-bottom">Pengaturan E-Mail</h5>
                    <div class="card-body">
                        <form id="form" method="post" action="/admin/pengaturan/update">
                            {{ csrf_field() }}
                            <input type="hidden" name="category" value="5">
                            @if(Session::get('message') != null)
                            <div class="alert alert-success alert-dismissible mb-4 fade show" role="alert">
                                {{ Session::get('message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                            <div class="row">
								@foreach($settings as $key=>$setting)
                                <div class="form-group col-md-12">
                                    <label>{{ $settings[$key]->setting_name }} <span class="text-danger">{{ is_int(strpos($settings[$key]->setting_rules, 'required')) ? '*' : '' }}</span></label>
                                    <br>
                                    <input type="text" name="settings[{{ $settings[$key]->setting_key }}]" class="form-control {{ $errors->has('settings.'.$settings[$key]->setting_key) ? 'border-danger' : '' }}" id="email" data-role="tagsinput" value="{{ $settings[$key]->setting_value }}" placeholder="Masukkan Email">
                                    <div class="row mt-1">
                                        @if($errors->has('settings.'.$settings[$key]->setting_key))
                                        <small class="col-12 text-danger">{{ display_errors($settings[$key]->setting_name, $errors->first('settings.'.$settings[$key]->setting_key)) }}</small>
                                        @endif
                                    </div>
                                </div>
								@endforeach
                            </div>
                        </form>
                    </div>
                    <div class="border-top">
                        <button id="btn-submit" type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
                <!-- card -->
            </div>
            <!-- column -->
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g==" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/typeahead/typeahead.js') }}"></script>
<script type="text/javascript">
    var substringMatcher = function(strs) {
        return function findMatches(q, cb) {
            var matches, substringRegex;

            // an array that will be populated with substring matches
            matches = [];

            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');

            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function(i, str) {
            if (substrRegex.test(str)) {
                matches.push(str);
            }
            });

            cb(matches);
        };
    };

    $("#email").tagsinput({
        typeaheadjs: {
            source: substringMatcher({!! json_email() !!})
        }
    });

    // Button Submit
    $(document).on("click", "#btn-submit", function(e){
        $("#form").submit();
    });
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" />
<style type="text/css">
    .bootstrap-tagsinput {width: 100%!important;}
    .tt-menu {background-color: #fff!important; width: 200px!important; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15)!important; -webkit-box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15)!important}
    .tt-suggestion {padding: .5rem; cursor: pointer;}
    .tt-suggestion:hover {background-color: #e5e5e5;}
</style>

@endsection