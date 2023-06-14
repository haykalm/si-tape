<div class="p1">
    <form action="{{ url('/user',$data->id) }}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="form-group has-feedback">
            <input value="{{ $data->name }}" type="text" name="name" class="form-control" placeholder="Name" required>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input value="{{ $data->email }}" type="email" name="email" class="form-control" placeholder="Email" required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input value="{{ $data->phone }}" type="number" name="phone" class="form-control" placeholder="Phone/WA">
            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <textarea type="text" name="address" class="form-control" placeholder="Address">{{ $data->address }}</textarea>
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
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</div>


