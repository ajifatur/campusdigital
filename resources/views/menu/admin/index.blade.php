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
                <h4 class="page-title">Menu</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Menu</li>
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
            <div class="col-lg-4">
                <!-- card -->
                <div class="card shadow">
                    <h5 class="card-title border-bottom">Tambah Menu</h5>
                    <div class="card-body">
                        @if(Session::get('message') != null)
                            <div class="alert alert-success alert-dismissible mb-4 fade show" role="alert">
                                {{ Session::get('message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <form id="form-add" method="post" action="/admin/menu/store" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Nama Menu <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_menu" class="form-control {{ $errors->has('nama_menu') ? 'is-invalid' : '' }}" value="{{ old('nama_menu') }}" placeholder="Masukkan Nama Menu">
                                    @if($errors->has('nama_menu'))
                                    <small class="text-danger">{{ ucfirst($errors->first('nama_menu')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>URL <span class="text-danger">*</span></label>
                                    <input type="text" name="url" class="form-control {{ $errors->has('url') ? 'is-invalid' : '' }}" value="{{ old('url') }}" placeholder="Masukkan URL">
                                    @if($errors->has('url'))
                                    <small class="text-danger">{{ ucfirst($errors->first('url')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Warna Tulisan <span class="text-danger">*</span></label>
                                    <input type="text" name="warna_tulisan" class="form-control colorpicker {{ $errors->has('warna_tulisan') ? 'is-invalid' : '' }}" value="{{ get_warna_primer() }}" placeholder="Masukkan Warna Tulisan">
                                    @if($errors->has('warna_tulisan'))
                                    <small class="text-danger">{{ ucfirst($errors->first('warna_tulisan')) }}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Warna Background <span class="text-danger">*</span></label>
                                    <input type="text" name="warna_background" class="form-control colorpicker {{ $errors->has('warna_background') ? 'is-invalid' : '' }}" value="#ffffff" placeholder="Masukkan Warna Background">
                                    @if($errors->has('warna_background'))
                                    <small class="text-danger">{{ ucfirst($errors->first('warna_background')) }}</small>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="border-top">
                        <button id="btn-submit-add" type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
                <!-- card -->
            </div>
            <!-- column -->
            <div class="col-lg-8">
                <!-- card -->
                <div class="card shadow">
                    <h5 class="card-title border-bottom">Urutkan Menu</h5>
                    <div class="card-body">
                        @if(Session::get('message_sort') != null)
                            <div class="alert alert-success alert-dismissible mb-4 fade show" role="alert">
                                {{ Session::get('message_sort') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <form id="form-sort" method="post" action="/admin/menu/sort" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="json" id="json" value="">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <ol class="example mb-0">
                                        @foreach($menu->menu as $key=>$data)
                                            <li data-name="{{ $data['name'] }}" data-url="{{ $data['url'] }}" data-color="{{ $data['color'] }}" data-bgcolor="{{ $data['bgcolor'] }}" data-id="{{ $data['id'] }}">
                                                <span class="list-text" data-id="{{ $data['id'] }}">{{ $data['name'] }}</span>
                                                <span class="list-btn">
                                                    <a href="#" class="btn btn-sm btn-primary btn-edit" title="Edit" data-id="{{ $data['id'] }}"><i class="fa fa-edit"></i></a>
                                                    <a href="#" class="btn btn-sm btn-danger btn-delete" title="Hapus" data-id="{{ $data['id'] }}"><i class="fa fa-trash"></i></a>
                                                </span>
                                                <ol>
                                                    @if(count(array_filter($data['children'])) > 0)
                                                        @foreach($data['children'][0] as $key2=>$children)
                                                            <li data-name="{{ $children['name'] }}" data-url="{{ $children['url'] }}" data-color="{{ $children['color'] }}" data-bgcolor="{{ $children['bgcolor'] }}" data-id="{{ $children['id'] }}">
                                                                <span class="list-text" data-id="{{ $children['id'] }}">{{ $children['name'] }}</span>
                                                                <span class="list-btn">
                                                                    <a href="#" class="btn btn-sm btn-primary btn-edit" title="Edit" data-id="{{ $children['id'] }}"><i class="fa fa-edit"></i></a>
                                                                    <a href="#" class="btn btn-sm btn-danger btn-delete" title="Hapus" data-id="{{ $children['id'] }}"><i class="fa fa-trash"></i></a>
                                                                </span>
                                                                <ol></ol>
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                </ol>
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="border-top">
                        <button id="btn-sort" type="submit" class="btn btn-success">Simpan Perubahan</button>
                    </div>
                    <form id="form-delete" class="d-none" method="post" action="/admin/menu/delete">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" id="id">
                    </form>
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

<!-- Modal Edit Menu -->
<div class="modal fade" id="modal-edit-menu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-edit" method="post" action="/admin/menu/update">
                    {{ csrf_field() }}
					<input type="hidden" name="id" id="id-2" value="">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Nama Menu <span class="text-danger">*</span></label>
                            <input type="text" name="nama_menu_2" class="form-control {{ $errors->has('nama_menu_2') ? 'is-invalid' : '' }}" value="{{ old('nama_menu_2') }}" placeholder="Masukkan Nama Menu">
                            @if($errors->has('nama_menu_2'))
                            <small class="text-danger">{{ ucfirst($errors->first('nama_menu_2')) }}</small>
                            @endif
                        </div>
                        <div class="form-group col-md-12">
                            <label>URL <span class="text-danger">*</span></label>
                            <input type="text" name="url_2" class="form-control {{ $errors->has('url_2') ? 'is-invalid' : '' }}" value="{{ old('url_2') }}" placeholder="Masukkan URL">
                            @if($errors->has('url_2'))
                            <small class="text-danger">{{ ucfirst($errors->first('url_2')) }}</small>
                            @endif
                        </div>
                        <div class="form-group col-md-12">
                            <label>Warna Tulisan <span class="text-danger">*</span></label>
                            <input type="text" name="warna_tulisan_2" class="form-control colorpicker {{ $errors->has('warna_tulisan_2') ? 'is-invalid' : '' }}" value="{{ old('warna_tulisan_2') }}" placeholder="Masukkan Warna Tulisan">
                            @if($errors->has('warna_tulisan_2'))
                            <small class="text-danger">{{ ucfirst($errors->first('warna_tulisan_2')) }}</small>
                            @endif
                        </div>
                        <div class="form-group col-md-12">
                            <label>Warna Background <span class="text-danger">*</span></label>
                            <input type="text" name="warna_background_2" class="form-control colorpicker {{ $errors->has('warna_background_2') ? 'is-invalid' : '' }}" value="{{ old('warna_background_2') }}" placeholder="Masukkan Warna Background">
                            @if($errors->has('warna_background_2'))
                            <small class="text-danger">{{ ucfirst($errors->first('warna_background_2')) }}</small>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn-submit-edit">Simpan</button>
                <button type="button" class="btn btn-danger"data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Edit Menu -->

@endsection

@section('js-extra')

<script src="{{ asset('templates/matrix-admin/assets/libs/jquery-asColor/dist/jquery-asColor.min.js') }}"></script>
<script src="{{ asset('templates/matrix-admin/assets/libs/jquery-asGradient/dist/jquery-asGradient.js') }}"></script>
<script src="{{ asset('templates/matrix-admin/assets/libs/jquery-asColorPicker/dist/jquery-asColorPicker.min.js') }}"></script>
<script src="{{ asset('templates/matrix-admin/assets/libs/jquery-minicolors/jquery.minicolors.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/jquery-sortable/jquery-sortable.min.js') }}"></script>
<script type="text/javascript">
    // Colorpicker
    $(".colorpicker").each(function(){
        $(this).minicolors({
            control: $(this).attr('data-control') || 'hue',
            position: $(this).attr('data-position') || 'bottom left',
            change: function(value, opacity) {
                if (!value) return;
            },
            theme: 'bootstrap'
        });
    });

    // Sortable
    var group = $("ol.example").sortable({
        isValidTarget: function ($item, container) {
            var depth = 1; // Start with a depth of one (the element itself)
            var maxDepth = 2;
            var children = $item.find('ol').first().find('li');

            // Add the amount of parents to the depth
            depth += container.el.parents('ol').length;

            // Increment the depth for each time a child
            while (children.length) {
                depth++;
                children = children.find('ol').first().find('li');
            }

            return depth <= maxDepth;
        },
    });

    // Button Sort
    $(document).on("click", "#btn-sort", function(e){
        e.preventDefault();
        var data = group.sortable("serialize").get();
        $("#json").val(JSON.stringify(data));
        $("#form-sort").submit();
    });

    // Button Submit (Add)
    $(document).on("click", "#btn-submit-add", function(e){
        e.preventDefault();
        $("#form-add").submit();
    });

    // Button Edit
    $(document).on("click", ".btn-edit", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        $("#id-2").val(id);
        $("input[name=nama_menu_2]").val($("ol.example").find("li[data-id="+id+"]").data("name"));
        $("input[name=url_2]").val($("ol.example").find("li[data-id="+id+"]").data("url"));
        $("input[name=warna_tulisan_2]").val($("ol.example").find("li[data-id="+id+"]").data("color"));
        $("input[name=warna_background_2]").val($("ol.example").find("li[data-id="+id+"]").data("bgcolor"));
        $("input[name=warna_tulisan_2]").siblings(".minicolors-swatch.minicolors-sprite.minicolors-input-swatch").find(".minicolors-swatch-color").css("background-color",$("ol.example").find("li[data-id="+id+"]").data("color"));
        $("input[name=warna_background_2]").siblings(".minicolors-swatch.minicolors-sprite.minicolors-input-swatch").find(".minicolors-swatch-color").css("background-color",$("ol.example").find("li[data-id="+id+"]").data("bgcolor"));
        $("#modal-edit-menu").modal("show");
    });

    // Button Submit (Edit)
    $(document).on("click", "#btn-submit-edit", function(e){
        e.preventDefault();
        $("#form-edit").submit();
    });

    // Button Delete
    $(document).on("click", ".btn-delete", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        var ask = confirm("Anda yakin ingin menghapus data ini?");
        if(ask){
            $("#id").val(id);
            $("#form-delete").submit();
        }
    });
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('templates/matrix-admin/assets/libs/jquery-minicolors/jquery.minicolors.css') }}">
<style type="text/css">
    body.dragging, body.dragging * {cursor: move !important;}
    .dragged {position: absolute; opacity: 0.5; z-index: 2000;}
    ol {list-style: none;}
    ol.example {padding-left: 0px;}
    ol.example li {border: 1px solid #bebebe; padding: .5rem; line-height: 30px; cursor: pointer;}
    ol.example li.placeholder {position: relative; padding: 0; border-width: 0;}
    ol.example li.placeholder:before {position: absolute; content:"\A"; border-style: solid; border-width: 5px 10px 5px 0; border-color: transparent {{ get_warna_primer() }} transparent transparent; top: -7px; left: -15px; transform: rotate(-180deg); -webkit-transform: rotate(-180deg);}
    ol.example li span.list-btn {position: absolute; right: 30px;}
</style>

@endsection