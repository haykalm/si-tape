@extends('layouts.master')

@section('title')
	Kategori Users
@endsection

@section('content')

<!-- DataTales Example -->
<div class="content-wrapper">
    <div class="card-header">
        <section class="content-header">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">List Kategori Users</h3>
                        </div>
                        <div class="box-body">
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default" title="Add Admin">
                                <i class="fa fa-fw fa-user-plus"></i>
                                Add
                            </button>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-info" title="Print/Download">
                                <i class="fa fa-fw fa-print"></i>
                                Print
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

            <table class="table table-hover" id="zero-config" cellspacing="0">
                <thead>
                    <tr>
                        <th style="vertical-align: middle;text-align: center;" width="1%">No</th>
                        <th style="vertical-align: middle;text-align: center;" width="15%">Name Category</th>
                        <th style="vertical-align: middle;text-align: center;" width="1%">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @if(!empty($role))
                        @foreach($role as $data => $value)
                        <tr style="text-align:center;font-size: 13px;">
                            <td style="vertical-align: middle;">{{ $data +1 }}</td>
                            <td style="text-transform: uppercase;vertical-align: middle;">{{ $value['name'] }}</td>
                            
                            <td style="display: flex;justify-content:center;">
                                <a class="btn btn-info btn-xs show_confirm" onClick="show({{ $value->id }})" data-nama="#" data-toggle="tooltip" title="Edit" style="margin-right: 3px">
                                   <li type="submit" class="fa fa-pencil" ></li>
                               </a>
                                <form action="{{ route('category_users.destroy',base64_encode($value['id']),) }}" method="post" style="text-decoration: none;">
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
</div>

<!-- create Modal-->
<div class="modal fade" id="modal-default">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Add Category</h4>
			</div>
			<form method="POST" action="{{url('/category_users')}}" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
					<!-- <p>One fine body&hellip;</p> -->
					<div class="form-group has-feedback">
						<input type="text" name="name" class="form-control" placeholder="Name Category*" required>
						<span class="glyphicon glyphicon-pencil form-control-feedback"></span>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
            </div>
            <div class="modal-body">
                <div id="page" class="p-2"></div>
            </div>
        </div>
    </div>
</div>


@endsection


@push('scripts')
<!-- datatable -->
<link rel="stylesheet" type="text/css" href="{{ asset('AdminLTE-2') }}/export_plugins/table/datatable/datatables.css">
<link rel="stylesheet" type="text/css" href="{{ asset('AdminLTE-2') }}/export_plugins/table/datatable/dt-global_style.css">
<script src="{{ asset('AdminLTE-2') }}/export_plugins/table/datatable/datatables.js"></script>

<script>
    $('#zero-config').DataTable({
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 7 
    });
</script>

<script>
    $(document).ready(function() {
        $('#content').html(data);
    });

    function show(id) {
        $.get("{{ url('/category_users') }}/" + id, {}, function(data, status) {
            // $("#exampleModalLabel").html('Edit Karyawan')
            $("#page").html(data);
            $("#exampleModal").modal('show');
        });
    }
</script>
@endpush    
