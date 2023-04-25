<div class="p1">
    <form action="{{ url('/category_users',$data->id) }}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="form-group has-feedback">
            <input value="{{ $data->name }}" type="text" name="name" class="form-control" placeholder="Full name*" required>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</div>


