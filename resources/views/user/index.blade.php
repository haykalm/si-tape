    @extends('layouts.master')

    @section('title')
    	Admin List
    @endsection

    @section('content')

        @if(Auth::user()->role_id == 1)
            <!-- DataTales Example -->
            <div class="content-wrapper" style="border-radius: 7px">
                <div class="card-header">
                    <section class="content-header">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-default">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">List Users</h3>
                                    </div>
                                    <div class="box-body">
                                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default" title="Add User">
                                            <i class="fa fa-fw fa-user-plus"></i>
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="zero-config" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="vertical-align: middle;text-align: center;" width="1%">No</th>
                                        <th style="vertical-align: middle;text-align: center;" width="15%">Name</th>
                                        <th style="vertical-align: middle;text-align: center;" width="15%">Email</th>
                                        <th style="vertical-align: middle;text-align: center;" width="10%">Phone</th>
                                        <th style="vertical-align: middle;text-align: center;" width="10%">Address</th>
                                        <th style="vertical-align: middle;text-align: center;" width="10%">Status</th>
                                        <th style="vertical-align: middle;text-align: center;" width="1%">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @if(!empty($data))
                                        @foreach($data as $data => $value)
                                        <tr style="text-align:center;font-size: 13px;">
                                            <td style="vertical-align: middle;">{{ $data +1 }}</td>
                                            <td style="text-transform: uppercase;vertical-align: middle;">{{ $value['name'] }}</td>
                                            <td style="vertical-align: middle;">{{ $value['email'] }}</td>
                                            <td style="vertical-align: middle;">
                                                @if($value['phone']!=null)
                                                {{ $value['phone'] }}
                                                @endif()
                                            </td>
                                            <td style="vertical-align: middle;">{{ $value['address'] }}</td>
                                            <td style="vertical-align: middle;">
                                                @if($value['name_category']!=null)
                                                {{ $value['name_category'] }}
                                                @endif()
                                            </td>
                                            <td style="display: flex;justify-content:center;">
                                                <a class="btn btn-info btn-xs show_confirm" onClick="show({{ $value->id }})" data-nama="#" data-toggle="tooltip" title="Edit" style="margin-right: 3px">
                                                   <li type="submit" class="fa fa-pencil" ></li>
                                               </a>
                                                <form action="{{ route('user.destroy',base64_encode($value['id']),) }}" method="post" style="text-decoration: none;">
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
            </div>

            <!-- create Modal-->
            <div class="modal fade" id="modal-default">
            	<div class="modal-dialog modal-sm">
            		<div class="modal-content" style="border-radius: 7px">
            			<div class="modal-header">
            				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            				<h4 class="modal-title">Add User</h4>
            			</div>
            			<form method="POST" action="{{url('/user')}}" enctype="multipart/form-data">
            				@csrf
            				<div class="modal-body">
            					<!-- <p>One fine body&hellip;</p> -->
            					<div class="form-group has-feedback">
            						<input name="name" id="name" class="form-control" placeholder="Name" required>
            						<span class="glyphicon glyphicon-user form-control-feedback"></span>
            					</div>
            					<div class="form-group has-feedback">
            						<input type="email" name="email" class="form-control" placeholder="Email" required>
            						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            					</div>
            					<div class="form-group has-feedback">
            						<input type="password" name="password" class="form-control" placeholder="Password">
            						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
            					</div>
            					<div class="form-group has-feedback">
            						<input type="number" name="phone" class="form-control" placeholder="Phone/WA">
            						<span class="glyphicon glyphicon-phone form-control-feedback"></span>
            					</div>
            					<div class="form-group has-feedback">
            						<textarea type="text" name="address" class="form-control" placeholder="Address"></textarea>
            						<span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
            					</div>
                                <div class="form-group has-feedback">
                                    <input type="file" class="form-control has-feedback" id="foto" name="foto">
                                    <span class="glyphicon glyphicon-camera form-control-feedback"></span>
                                </div>
            					<center>
                                    <div class="form-group">
                                        {!! Form::label('Status:', '') !!}
                                        <div class="radio">
                                            <label style="margin-right: 12px">
                                                <input type="radio" name="role_id" id="role_id" value="1" checked="">
                                                Super Admin
                                            </label>
                                            <label>
                                                <input type="radio" name="role_id" id="role_id" value="2" checked="">
                                                Admin
                                            </label>
                                        </div>
                                    </div>
                                </center>

            				</div>
            				<div class="modal-footer">
            					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            					<button type="submit" class="btn btn-primary">Save </button>
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                        </div>
                        <div class="modal-body">
                            <div id="page" class="p-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        @else()
            <div class="content-wrapper" style="background-color: red;border-radius: 7px">
                <section class="content">
                  <div class="error-page">
                    <h2 class="headline text-yellow"> 404</h2>

                    <div class="error-content">
                      <h3><i class="fa fa-warning text-yellow"></i> Oops! Anda tidak memiliki hak akses halaman ini.</h3>

                      <p>
                        kami tidak dapat menampilkan halaman yang anda minta. sementara itu, anda dapat <a href="{{url('/home')}}">kembali ke Dashboard</a> atau tekan tombol di bawah ini
                      </p>


                      <a href="{{url('/home')}}" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-dashboard"></i>
                        Kembali
                      </a>
                    </div>
                    <!-- /.error-content -->
                  </div>
                  <!-- /.error-page -->
                </section>
            </div>
        @endif()

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
            $.get("{{ url('/user') }}/" + id, {}, function(data, status) {
                // $("#exampleModalLabel").html('Edit Karyawan')
                $("#page").html(data);
                $("#exampleModal").modal('show');
            });
        }
    </script>
    @endpush


