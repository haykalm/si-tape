@extends('layouts.master')

@section('title')
	List odgj
@endsection

@section('content')

<!-- DataTales Example -->

<div class="content-wrapper" style="border-radius: 7px">
    <div class="card-header">
        <section class="content-header">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-default">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (isset($errors) && $errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif

                        @if (session()->has('failures'))
                            <table class="table table-danger" style="background-color: red;">
                                <tr>
                                    <th width="30%">Row</th>
                                    <!-- <th>Attribute</th> -->
                                    <th width="40%">Errors message</th>
                                    <th width="30%">Column Validations</th>
                                </tr>

                                @foreach (session()->get('failures') as $validation)
                                <tr>
                                    <td width="30%">{{ $validation->row() }}</td>
                                    <!-- <td>{{ $validation->attribute() }}</td> -->
                                    <td width="40%">
                                        <!-- <ul>
                                            @foreach ($validation->errors() as $e)
                                                <li>{{ $e }}</li>
                                            @endforeach
                                        </ul> -->
                                        @foreach ($validation->errors() as $e)
                                            {{ $e }}
                                        @endforeach
                                    </td>
                                    <td width="30%">
                                        {{ $validation->values()[$validation->attribute()] }}
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        @endif
                        <div class="box-header with-border">
                            <h3 class="box-title">List Odgj</h3>
                        </div>
                        <div class="box-body">
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default" title="Add">
                                <i class="fa fa-fw fa-user-plus"></i>
                                Add
                            </button>
                            <a href="{{url('/odgj_pdf')}}" class="btn btn-info" title="Download/Pdf" target="_blank">
                                <i class="fa fa-fw fa-print"></i>
                                Print
                            </a>
                            <a href="{{url('/odgj_excel')}}" title="Download/Excel" class="btn btn-success my-3"><i class="fa fa-fw fa-file-excel-o"></i>
                                 Excel
                            </a>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-import" title="Import data">
                                <i class="fa fa-fw fa-file-text-o"></i>
                                Import
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
             <thead>
                <tr style="text-align:center;">
                    <th style="vertical-align: middle;text-align: center;" width="1%">No</th>
                    <th style="vertical-align: middle;text-align: center;" width="15%">Nik</th>
                    <th style="vertical-align: middle;text-align: center;" width="15%">Name</th>
                    <th style="vertical-align: middle;text-align: center;" width="15%">TTL</th>
                    <th style="vertical-align: middle;text-align: center;" width="15%">Alamat</th>
                    <th style="vertical-align: middle;text-align: center;" width="15%">jenis kelamin</th>
                    <th style="vertical-align: middle;text-align: center;" width="15%">Yayasan</th>
                    <th style="vertical-align: middle;text-align: center;" width="1%">Actions</th>
                </tr>
            </thead>
            <tbody>
                    @if(!empty($odgj))

                        @foreach($odgj as $data => $value)
                        <tr style="text-align:center;font-size: 12px;">
                            <td style="vertical-align: middle;">{{ $data +1 }}</td>
                            <td style="vertical-align: middle;">{{ $value->nik }}</td>
                            <td style="text-transform: uppercase;vertical-align: middle;">{{ $value->name }}</td>
                            <td style="vertical-align: middle;">{{ $value->ttl }}</td>
                            <td style="text-transform: lowercase;vertical-align: middle;">{{ $value->address }}</td>
                            <td style="vertical-align: middle;">{{ $value->gender }}</td>
                            <td style="vertical-align: middle;">{{ $value->yayasan_name }}</td>
                            
                            <td style="display: flex;justify-content:center;vertical-align: middle;text-decoration: none;">
                                <a href="{{url('/download_lampiran', base64_encode($value->id),)}}" class="btn btn-primary btn-xs show_confirm" title="Download Lampiran" style="margin-right: 2px">
                                    <li type="button" class="fa fa-cloud-download" ></li>
                                </a>
                                <a href="{{url('/download_nota_dinas', base64_encode($value->id),)}}" class="btn bg-purple btn-xs show_confirm" title="download nota dinas" style="margin-right: 2px">
                                    <li type="button" class="fa fa-download" ></li>
                                </a>
                                <a href="{{url('/detail_pr_pdf', base64_encode($value->id),)}}" class="btn bg-orange btn-xs show_confirm" target="_blank" title="download detail" style="margin-right: 2px">
                                    <li type="button" class="glyphicon glyphicon-download"></li>
                                </a>
                                <a class="btn btn-info btn-xs show_confirm" onClick="show({{ $value->id }})" data-nama="#" data-toggle="tooltip" title="Edit" style="margin-right: 2px">
                                    <li type="submit" class="fa fa-pencil" ></li>
                                </a>
                                <form action="{{ route('penduduk.destroy',base64_encode($value->id),) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-xs" onclick="return confirm('Are you sure want to delete {{$value->name}} ?')" title="Hapus" style="text-decoration: none;">
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
    </div>
</div>
<!-- /.box-body -->


        
<!-- create Modal-->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 7px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Penduduk Rentan</h4>
            </div>
            <form method="POST" action="{{url('/penduduk')}}" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <!-- <p>One fine body&hellip;</p> -->
                    <div class="form-group has-feedback">
                        <input type="hidden" name="kategori_pr_id" value="1" class="form-control">
                    </div>
                    <div class="form-group has-feedback">
                        <label style="margin-bottom: 0.5px">NIk :</label>
                        <input type="number" name="nik" class="form-control" placeholder="Nik KTP*" required>
                        <span class="glyphicon glyphicon-credit-card form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label style="margin-bottom:0.1px; margin-top: 0.2px;">Nama :</label>
                        <input type="text" name="name" class="form-control" placeholder="Name*" required>
                        <span class="fa fa-text-width form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label style="margin-bottom: 0.5px">TTL :</label>
                        <input type="text" name="ttl" class="form-control" placeholder="Bekasi, 28 Februari 1987" required>
                        <span class="fa fa-birthday-cake form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label style="margin-bottom: 0.5px">Alamat :</label>
                        <textarea type="text" name="address" class="form-control" placeholder="Address" required></textarea>
                        <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                    </div>
                    <div class="form-group">
                        <label style="margin-bottom: 0.5px">Jenis Kelamin :</label>
                        <div class="radio">
                            <label style="margin-right: 10px">
                                <input type="radio" name="gender" id="gender" value="male" checked="">
                                male (pria)
                            </label>
                            <label>
                                <input type="radio" name="gender" id="gender" value="female" checked="">
                                female (wanita)
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="margin-bottom: 0.5px">Yayasan :</label>
                        <select class="form-control select2 select2-hidden-accessible" name="yayasan_id" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                            <option value=""><b>pilih yayasan :</b></option>
                            @foreach($yayasan as $data => $value)
                                <option value="{{$value->id}}">{{$data+1}}. {{$value->name}}</option>
                            @endforeach()
                        </select>
                    </div>
                    <div class="form-group">
                        {!! Form::label('Lampiran: (format:jpg,jpeg,png,pdf)', '') !!}
                        <div class="input-group ">
                            <span class="input-group-addon"><i class="fa fa-picture-o"></i></span>
                            <input type="file" class="form-control has-feedback" id="lampiran" name="lampiran">
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('Nota Dinas: (format:pdf,docx)', '') !!}
                        <div class="input-group ">
                            <span class="input-group-addon"><i class="fa fa-picture-o"></i></span>
                            <input type="file" class="form-control has-feedback" id="file" name="file" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info"><li class="fa fa-user-plus"></li>
                        Add
                    </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal master to edit and update-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 7px">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Odgj</h5>
            </div>
            <div class="modal-body">
                <div id="page" class="p-2"></div>
            </div>
        </div>
    </div>
</div>

<!-- import modal -->
<div class="modal fade" id="modal-import">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Import Penduduk Rentan</h4>
            </div>
            <form method="POST" action="{{url('/import_penduduk')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="import_excel">masukan file excel :</label>
                        <input type="file" name="import_excel" id="import_excel">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info"><li class="fa fa-user-plus"></li>
                        Import
                    </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@endsection


@push('scripts')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('AdminLTE-2') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="{{ asset('AdminLTE-2') }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('AdminLTE-2') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>

<script>
    $(document).ready(function() {
        $('#content').html(data);
    });

    function show(id) {
        $.get("{{ url('/penduduk') }}/" + id, {}, function(data, status) {
            // $("#exampleModalLabel").html('Edit Karyawan')
            $("#page").html(data);
            $("#exampleModal").modal('show');
        });
    }
</script>
@endpush    
