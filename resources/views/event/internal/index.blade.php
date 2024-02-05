@extends('layouts.master')

@section('title')
    List Kegiatan Per-orangan
@endsection

@section('content')

<!-- DataTales Example -->
<div class="content-wrapper" style="border-radius: 7px">

    <div class="card-header">
        <section class="content-header">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">List Kegiatan Per-orangan</h3>
                        </div>
                        <div class="box-body">
                            <a href="{{url('/create_event_internal')}}" type="button" class="btn btn-default" title="Add">
                                <i class="fa fa-fw fa-user-plus"></i>
                                Add
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-default">
                        <br>
                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" style="color: #ffffff;">&times;</a>
                        </div>
                        @endif
                        @if (session('warning'))
                        <div class="alert alert-warning">
                            {{ session('warning') }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" style="color: #ffffff;">&times;</a>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-3 pull-right" style="margin-right: 10px; margin-left:10px">
                                <div class="box box-default collapsed-box box-solid">
                                    <div class="box-header with-border" style="padding:5px">
                                        <p class="box-title" style="font-size: 15px">Filter</p>

                                        <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                        </button>
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <form action="{{ route(Route::currentRouteName()) }}">
                                            <label class="form-label fs-6 fw-semibold">Pilih Bulan dan Tahun:</label>
                                            <input type="month" name="month_year" style="margin: 7px" value="{{ old('month_year') }}">
                                            <div class="pull-right" style="margin-top: 10px">
                                                <button type="submit" style="font-size: 12px">Apply</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-body mb-4">
                            {{ $dataTable->table() }}
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- <div class="box-body table-responsive">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
            <a href="#" class="close" data-dismiss="alert" aria-label="close" style="color: #ffffff;">&times;</a>
        </div>
        @endif
        @if (session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
            <a href="#" class="close" data-dismiss="alert" aria-label="close" style="color: #ffffff;">&times;</a>
        </div>
        @endif
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <tr>
                        <th style="vertical-align: middle;text-align: center;" width="1%">No</th>
                        <th style="vertical-align: middle;text-align: center;" width="15%">Name Kegiatan</th>
                        <th style="vertical-align: middle;text-align: center;" width="15%">NIK</th>
                        <th style="vertical-align: middle;text-align: center;" width="15%">Tempat</th>
                        <th style="vertical-align: middle;text-align: center;" width="15%">Tanggal</th>
                        <th style="vertical-align: middle;text-align: center;" width="1%">Actions</th>
                    </tr>
                </tr>
            </thead>
            <tbody>
                    @if(!empty($event))

                        @foreach($event as $data => $value)
                        <tr style="text-align:center;font-size: 13px;">
                            <td style="vertical-align: middle;">{{ $data +1 }}</td>
                            <td style="vertical-align: middle;">{{ $value->event_name }}</td>
                            <td style="vertical-align: middle;">{{ $value->nik }}</td>
                            <td style="text-transform: uppercase;vertical-align: middle;">{{ $value->event_location }}</td>
                            <td style="vertical-align: middle;">{{ date("d-M-Y",strtotime($value->date)) }}</td>

                            <td style="display: flex;justify-content:center;">
                                <a class="btn btn-success btn-xs show_confirm" onClick="show({{ $value->id_event }})" data-nama="#" data-toggle="tooltip" title="show images" style="margin-right: 3px">
                                   <li type="submit" class="fa fa-eye" ></li>
                               </a>
                                <a href="{{url('/event_pdf', base64_encode($value->id_event),)}}" class="btn btn-primary btn-xs show_confirm" title="Download Event" style="margin-right: 3px" target="_blank">
                                   <li type="button" class="fa fa-cloud-download" ></li>
                                </a>
                                <a href="{{ route('edit_event.internal',base64_encode($value->id_event),) }}" class="btn btn-info btn-xs" title="Edit" style="margin-right: 3px">
                                   <li type="button" class="fa fa-pencil" ></li>
                               </a>
                                <form action="{{ route('event.destroy',base64_encode($value->id_event),) }}" method="post" style="text-decoration: none;">
                                    @csrf
                                    @method('delete')
                                   <button class="btn btn-danger btn-xs" onclick="return confirm('Hapus Kegiatan: {{$value->event_name }} tgl: {{ date("d-M-Y",strtotime($value->date)) }} ?')" title="Delete" style="text-decoration: none;">
                                       <li class="fa fa-trash" ></li>
                                   </button>
                               </form>
                            </td>
                        </tr>

                        @endforeach()

                    @else()

                    @endif()
            </tbody>
        </table>
    </div> --}}
</div>
<!-- /.box-body -->

<!-- Modal master to edit and update-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="border-radius: 7px">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Gambar kegiatan</h5>
            </div>
            <div class="modal-body">
                <div id="page"></div>
            </div>
        </div>
    </div>
</div>

@endsection


@push('scripts')
{{ $dataTable->scripts() }}
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('AdminLTE-2') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="{{ asset('AdminLTE-2') }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('AdminLTE-2') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
{{-- <script>
    $(function () {
        $('#example1').DataTable({
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true
        })
    })
</script> --}}
<script>
    $('#datepicker').datepicker({
        autoclose: true
    });
</script>
<script>
    $(document).ready(function() {
        $('#content').html(data);
    });

    function show(id) {
        $.get("{{ url('/event') }}/" + id, {}, function(data) {
            // $("#exampleModalLabel").html('Edit Karyawan')
            $("#page").html(data);
            $("#exampleModal").modal('show');
        });
    }
</script>
@endpush
