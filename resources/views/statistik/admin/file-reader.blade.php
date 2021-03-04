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
                <h4 class="page-title">Pembaca Materi</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Statistik</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pembaca Materi</li>
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
        <!-- row -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- column -->
            <div class="col-lg-12">
                <!-- card -->
                <div class="card shadow">
                    <div class="card-title border-bottom">
                        <div class="row">
                            <div class="col-12 col-sm py-1 mb-2 mb-sm-0 text-center text-sm-left">
                                <h5 class="mb-0">Aktivitas Pembaca</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="40">No.</th>
                                        <th>Materi</th>
                                        <th width="150">User</th>
                                        <th width="150">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($file_reader as $data)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td><a href="/admin/materi/{{ generate_permalink($data->kategori) }}/view/{{ $data->id_file }}">{{ $data->nama_file }}</a></td>
                                        <td><a href="/admin/user/detail/{{ $data->id_user }}">{{ $data->nama_user }}</a><br><small>{{ $data->email }}</small></td>
                                        <td>{{ date('Y-m-d H:i:s', strtotime($data->read_at)) }}</td>
                                    </tr>
                                    @php $i++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- card -->
            </div>
            <!-- column -->
            <!-- column -->
            <div class="col-lg-12">
                <!-- card -->
                <div class="card shadow">
                    <div class="card-title border-bottom">
                        <div class="row">
                            <div class="col-12 col-sm py-1 mb-2 mb-sm-0 text-center text-sm-left">
                                <h5 class="mb-0">Top Pembaca</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-2" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="40">No.</th>
                                        <th>User</th>
                                        <th width="80">Membaca</th>
                                        <th width="150">Terakhir Membaca</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($by_reader as $data)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td><a href="/admin/user/detail/{{ $data->id_user }}">{{ $data->nama_user }}</a><br><small>{{ $data->email }}</small></td>
                                        <td>{{ count_reads($data->id_user) }}</td>
                                        <td>{{ date('Y-m-d H:i:s', strtotime(last_user_reads($data->id_user))) }}</td>
                                    </tr>
                                    @php $i++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- card -->
            </div>
            <!-- column -->
            <!-- column -->
            <div class="col-lg-12">
                <!-- card -->
                <div class="card shadow">
                    <div class="card-title border-bottom">
                        <div class="row">
                            <div class="col-12 col-sm py-1 mb-2 mb-sm-0 text-center text-sm-left">
                                <h5 class="mb-0">Top Materi</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-3" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="40">No.</th>
                                        <th>Materi</th>
                                        <th width="80">Dibaca</th>
                                        <th width="150">Terakhir Dibaca</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($by_file as $data)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td><a href="/admin/materi/{{ generate_permalink($data->kategori) }}/view/{{ $data->id_file }}">{{ $data->nama_file }}</a></td>
                                        <td>{{ count_file_read($data->id_file) }}</td>
                                        <td>{{ date('Y-m-d H:i:s', strtotime(last_file_read($data->id_file))) }}</td>
                                    </tr>
                                    @php $i++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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

<script src="{{ asset('templates/matrix-admin/assets/extra-libs/DataTables/datatables.min.js') }}"></script>
<script type="text/javascript">
    // DataTable
    $('#table').DataTable();

    $('#table-2').DataTable({
        "columns": [
            null,
            null,
            { "type": "num" },
            null,
        ],
        "order": [[ 2, "desc" ]]
    });

    $('#table-3').DataTable({
        "columns": [
            null,
            null,
            { "type": "num" },
            null,
        ],
        "order": [[ 2, "desc" ]]
    });
</script>

@endsection

@section('css-extra')

<link href="{{ asset('templates/matrix-admin/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">

@endsection