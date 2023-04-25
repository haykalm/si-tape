<div class="p1">
    <form action="{{ url('/yayasan',$data->id) }}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="form-group has-feedback">
            <input value="{{ $data->name }}" type="name" name="name" class="form-control" placeholder="Name*" required>
            <span class="fa fa-bank form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input value="{{ $data->phone }}" type="text" name="phone" class="form-control" placeholder="Phone/WA">
            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <textarea type="text" name="address" class="form-control" placeholder="Address">{{ $data->address }}</textarea>
            <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
        </div>

        <div class="form-group">
        	<select class="form-control select2 select2-hidden-accessible" name="kategori_pr_id" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" required>
        		<option value=""><b>select kategori :</b></option>
        		@foreach($kategori_pr as $data => $value)
        		<option value="{{$value['id']}}">{{$data+1}}. {{$value['name']}}</option>
        		@endforeach()

        	</select>
        </div>
        <div class="form-group">
            <label for="exampleInputFile">File input</label>
            <input name="foto" type="file" id="exampleInputFile">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</div>


