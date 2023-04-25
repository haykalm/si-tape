<div class="p1">
    <form action="{{ url('/penduduk',$data->id) }}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="form-group has-feedback">
            <label style="margin-bottom: 0.5px">NIk :</label>
            <input value="{{ $data->nik }}" type="text" name="nik" class="form-control" placeholder="Nik KTP*" required>
            <span class="glyphicon glyphicon-credit-card form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <label style="margin-bottom: 0.5px">Nama :</label>
            <input value="{{ $data->name }}" type="text" name="name" class="form-control" placeholder="Name*" required>
            <span class="fa fa-text-width form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <label style="margin-bottom: 0.5px">TTL :</label>
            <input value="{{ $data->ttl }}" type="text" name="ttl" class="form-control" placeholder="Bekasi, 28 Februari 1987">
            <span class="fa fa-birthday-cake form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <label style="margin-bottom: 0.5px">Alamat :</label>
            <textarea type="text" name="address" class="form-control" placeholder="Address">{{ $data->address }}</textarea>
            <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
        </div>
        <div class="form-group">
            <label style="margin-bottom: 0.5px">Jenis Kelamin :</label>
            <select class="form-control select2 select2-hidden-accessible" name="gender" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" required>
                <option value=""><b>select gender :</b></option>
                <option value="male">1. male (pria)</option>
                <option value="female">2. female (wanita)</option>
            </select>
        </div>
        <div class="form-group">
            <label style="margin-bottom: 0.5px">Kategori :</label>
            <select class="form-control select2 select2-hidden-accessible" name="kategori_pr_id" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                <option value=""><b>pilih yayasan :</b></option>
                @foreach($kategori_pr as $data => $value)
                <option value="{{$value['id']}}">{{$data+1}}. {{$value['name']}}</option>
                @endforeach()

            </select>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</div>


