@extends('layouts.master')

@section('title')
	List Yayasan Panti Asuhan
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
                            <h3 class="box-title">List Yayasan Panti Asuhan</h3>
                        </div>
                        <div class="box-body">
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default" title="Add">
                                <i class="fa fa-fw fa-user-plus"></i>
                                Add
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <tr>
                        <th style="vertical-align: middle;text-align: center;" width="1%">No</th>
                        <th style="vertical-align: middle;text-align: center;" width="15%">Name</th>
                        <th style="vertical-align: middle;text-align: center;" width="15%">Phone</th>
                        <th style="vertical-align: middle;text-align: center;" width="15%">Kategori</th>
                        <th style="vertical-align: middle;text-align: center;" width="15%">Address</th>
                        <th style="vertical-align: middle;text-align: center;" width="1%">Actions</th>
                    </tr>
                </tr>
            </thead>
            <tbody>
                    @if(!empty($p_asuhan))
                        @foreach($p_asuhan as $data => $value)
                        <tr style="text-align:center;font-size: 13px;">
                            <td style="vertical-align: middle;">{{ $data +1 }}</td>
                            <td style="text-transform: uppercase;vertical-align: middle;">{{ $value['name'] }}</td>
                            <td style="vertical-align: middle;">{{ $value['phone'] }}</td>
                            <td style="vertical-align: middle;">{{ $value['kategori_name'] }}</td>
                           {{-- <!-- <td style="vertical-align: middle;">
                                @if($value['kategori_pr_id']!=null)
                                    @if($value['kategori_pr_id']==1)
                                        Odgj
                                    @elseif($value['kategori_pr_id']==2)
                                        Panti Asuhan
                                    @elseif($value['kategori_pr_id']==3)
                                        Disabilitas
                                    @elseif($value['kategori_pr_id']==4)
                                        Napi
                                    @elseif($value['kategori_pr_id']==4)
                                        Transgender
                                    @else{

                                    }
                                    @endif()
                                @endif()
                            </td> --> --}}
                            <td style="vertical-align: middle;">{{ $value['address'] }}</td>
                            
                            <td style="display: flex;justify-content:center;">
                                <a class="btn btn-info btn-xs show_confirm" onClick="show({{ $value->id }})" data-nama="#" data-toggle="tooltip" title="Edit" style="margin-right: 3px">
                                   <li type="submit" class="fa fa-pencil" ></li>
                               </a>
                                <form action="{{ route('yayasan.destroy',base64_encode($value['id']),) }}" method="post" style="text-decoration: none;">
                                    @csrf
                                    @method('delete')
                                   <button class="btn btn-danger btn-xs" onclick="return confirm('Are you sure want to delete {{$value['name']}} ?')" title="Delete" style="text-decoration: none;">
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
	<div class="modal-dialog modal-sm">
		<div class="modal-content" style="border-radius: 7px">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Add yayasan</h4>
			</div>
			<form method="POST" action="{{url('/yayasan')}}" enctype="multipart/form-data">
				@csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="kategori_pr_id" value="2" class="form-control" required>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" name="name" class="form-control" placeholder="Nama Yayasan" required>
                        <span class="fa fa-bank form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="number" name="phone" class="form-control" placeholder="Phone/WA">
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <textarea type="text" name="address" class="form-control" placeholder="Address" required></textarea>
                        <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                    </div>
                </div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
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
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="border-radius: 7px">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit yayasan</h5>
            </div>
            <div class="modal-body">
                <div id="page" class="p-2"></div>
            </div>
        </div>
    </div>
</div>


@endsection


@push('scripts')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('AdminLTE-2') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="{{ asset('AdminLTE-2') }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('AdminLTE-2') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
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
</script>

<script>
    $(document).ready(function() {
        $('#content').html(data);
    });

    function show(id) {
        $.get("{{ url('/yayasan') }}/" + id, {}, function(data, status) {
            // $("#exampleModalLabel").html('Edit Karyawan')
            $("#page").html(data);
            $("#exampleModal").modal('show');
        });
    }
</script>
@endpush    
