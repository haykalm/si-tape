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
            <label style="margin-bottom:0.1px; margin-top: 0.2px;">Nama :</label>
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
            <label style="margin-bottom: 0.5px">Kategori :</label>
            <select class="form-control select2 select2-hidden-accessible" name="kategori_pr_id" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" required>
                <option value="{{$old_kategori_pr->id}}">{{$old_kategori_pr->name}}</option>
                <option value=""></option>
                @foreach($kategori_pr as $data => $value)
                <option value="{{$value['id']}}">{{$data+1}}. {{$value['name']}}</option>
                @endforeach()
            </select>
        </div>
        <div class="form-group">
            <label style="margin-bottom: 0.5px">Yayasan :</label>
            <select class="form-control select2 select2-hidden-accessible" name="yayasan_id" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                @if($old_yayasan)
                    <option value="{{$old_yayasan->id}}">{{$old_yayasan->name}}</option>
                @endif()
                <option value=""></option>
                @foreach($yayasan as $data => $value)
                <option value="{{$value['id']}}">{{$data+1}}. {{$value['name']}}</option>
                @endforeach()
            </select>
        </div>
        <div class="form-group">
            {!! Form::label('Lampiran:', '') !!}
            <div class="input-group ">
                <span class="input-group-addon"><i class="fa fa-picture-o"></i></span>
                <input type="file" class="form-control has-feedback" id="lampiran" name="lampiran">
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('Nota Dinas:', '') !!}
            <div class="input-group ">
                <span class="input-group-addon"><i class="fa fa-picture-o"></i></span>
                <input type="file" class="form-control has-feedback" id="file" name="file">
            </div>
        </div>
        
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</div>


