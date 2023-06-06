@extends('layouts.master')

@section('title')
    Create Kegiatan Yayasan
@endsection

@section('content')
<div class="content-wrapper">
	<div class="box-body">
        <h3 class="box-title"><i><u>Tambah Kegiatan Yayasan</u></i></h3>
		<div class="row">
		    <div class="col-lg-12">
		        <div class="box" style="border-radius: 5px">

		            {!! Form::open(['url'=>url('/event'),'method'=>'POST', 'files'=>'true', 'class'=>'form-horizontal', 'autocomplete'=>'off']) !!}
		            <div class="row">
		                <div class="col-md-12">
		                    <div class="panel panel-primary">
		                        <div class="box-body">
		                        	<center>
		                        		<table class="table" style="width: 984px;border:0px solid #333;border-collapse:collapse;margin:0 auto;vertical-align: middle;text-align: center;background-color: #d5d5d5;">
		                        			<tr style="padding:10px;border:0px solid #333;width:100px;height: 20px;font-size: 20px;">
		                        				<td>
		                        					DATA KEGIATAN
		                        				</td>
		                        			</tr>
		                        		</table>
		                        	</center>
		                            <div class="col-md-12">
		                                <div class="box-body col-md-4">     {{-- kiri --}}
		                                    <div class="form-group">
		                                        <div class="col-md-12">
		                                            <div class="col-md-12">
		                                                {!! Form::label('Nama Kegiatan:', '') !!}
		                                                <div class="input-group">
		                                                    <span class="input-group-addon"><i class="fa fa-text-width"></i></span>
		                                                    <input type="text" class="form-control  has-feedback" value="" id="event_name" name="event_name" required>
		                                                </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                    <div class="form-group">
		                                        <div class="col-md-12">
		                                            <div class="col-md-12">
		                                                {!! Form::label('Tempat Kegiatan:', '') !!}
		                                                <div class="input-group">
		                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
		                                                    {!! Form::textarea('event_location', null, ['class'=>'form-control ','required','placeholder' => '','style'=>'width:40%','style'=>'height:50px' ]) !!}
		                                                    </span>
		                                                </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                </div>
		                                <div class="box-body col-md-4">     {{-- tengah --}}
		                                    <div class="form-group">
		                                        <div class="col-md-12">
		                                            <div class="col-md-12">
		                                                {!! Form::label('Tanggal:', '') !!}
		                                                <div class="input-group date">
		                                                	<div class="input-group-addon">
		                                                		<i class="fa fa-calendar"></i>
		                                                	</div>
		                                                	<input name="date" type="text" class="form-control pull-right" id="datepicker">
		                                                	<span class="fa  fa-calendar-plus-o form-control-feedback"></span>
		                                                </div>
		                                            </div>
		                                        </div>
		                                    </div>

		                                    <div class="form-group">
		                                        <div class="col-md-12">
		                                            <div class="col-md-12">
		                                                {!! Form::label('Yayasan:', '') !!}
		                                                <div class="input-group">
		                                                    <span class="input-group-addon"><i class="fa fa-bank"></i></span>
		                                                    <select class="form-control select2" name="yayasan_id" id="yayasan_id" style="width: 100%;" required> 
		                                                        <option value=""><b>pilih yayasan :</b></option>
		                                                        @foreach($yayasan as $yayasan)                   
		                                                          <option value="{{ $yayasan->id }}">{{ $yayasan->name }}</option>
		                                                        @endforeach              
		                                                    </select>
		                                                    </span>
		                                                </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                </div>
		                                <div class="box-body col-md-4">   

		                                 <div class="form-group">	{{-- kanan --}}
		                                        <div class="col-md-12" >
		                                            <div class="col-md-12 field_wrapper" >
		                                                {!! Form::label('Gambar Kegiatan:', '') !!}
		                                                <div class="input-group ">
		                                                    <span class="input-group-addon"><i class="fa fa-picture-o"></i></span>
		                                                    <input type="file" class="form-control has-feedback" value="" id="name_file[]" name="name_file[]" required>
		                                                    <span class="input-group-addon" style="background-color: #007fff;">
		                                                        <a href="javascript:void(0);" class="add_button" title="Add field"><i class="fa fa-plus" style="color:white;"></i></a>
		                                                    </span>
		                                                </div>
		                                            </div>
		                                        </div>
		                                </div>
		                                {{-- <!-- <center>
			                                <div class="col-md-12" >
			                                	<div class="col-md-12 field_wrappe" >
			                                		{!! Form::submit('Simpan', ['class'=>'btn btn-default','style'=>'background-color:#007fff;border-radius:5px;width:80px;color: white']) !!}
			                                		&nbsp;&nbsp;
			                                		&nbsp;&nbsp;
			                                		<a class="btn" href="{{ url('/event') }}" title="Back Event List" style="border-radius: 5px;width:80px;background-color:#c31818;color: white">
			                                			Kembali
			                                		</a>
			                                	</div>
			                                </div>
		                                </center> --> --}}
		                            </div>
		                        </div>

		                        <center>
		                        	<table class="table" style="width: 984px;border:0px solid #333;border-collapse:collapse;margin:0 auto;vertical-align: middle;text-align: center;background-color: #d5d5d5;">
		                        		<tr style="padding:10px;border:0px solid #333;width:100px;height: 20px;font-size: 20px;">
		                        			<td>
		                        				DATA WARGA
		                        			</td>
		                        		</tr>
		                        	</table>
		                        </center>
		                        <!-- <div class="box-body"> -->
		                            <div class="col-md-12">
		                                <div class="box-body col-md-4">     {{-- kiri --}}
		                                    <div class="form-group">
		                                        <div class="col-md-12">
		                                            <div class="col-md-12">
		                                                {!! Form::label('Nik:', '') !!}
		                                                <div class="input-group">
		                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-credit-card"></i></span>
		                                                    <input type="text" class="form-control  has-feedback" value="" id="nik" name="nik" required>
		                                                </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                    <div class="form-group">
		                                        <div class="col-md-12">
		                                            <div class="col-md-12">
		                                                {!! Form::label('Alamat:', '') !!}
		                                                <div class="input-group">
		                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-map-marker"></i></span>
		                                                    {!! Form::textarea('address', null, ['class'=>'form-control ','required','placeholder' => '','style'=>'width:40%','style'=>'height:50px' ]) !!}
		                                                    </span>
		                                                </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                </div>

		                                <div class="box-body col-md-4">     {{-- tengah --}}
		                                    <div class="form-group">
		                                        <div class="col-md-12">
		                                            <div class="col-md-12">
		                                                {!! Form::label('Nama:', '') !!}
		                                                <div class="input-group">
		                                                    <span class="input-group-addon"><i class="fa fa-text-width"></i></span>
		                                                    <input type="text" class="form-control  has-feedback" value="" id="name" name="name" required>
		                                                </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                    <div class="form-group">
		                                        <div class="col-md-12">
		                                            <div class="col-md-12">
		                                                {!! Form::label('TTL:', '') !!}
		                                                <div class="input-group">
		                                                    <span class="input-group-addon"><i class="fa fa-birthday-cake"></i></span>
		                                                    <input type="text" class="form-control  has-feedback" value="" id="ttl" name="ttl" required>
		                                                </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                </div>

		                                <div class="box-body col-md-4">   {{-- kanan --}}
		                                	<div class="form-group">
		                                			<div class="col-md-12">
		                                				<div class="col-md-12">
		                                					{!! Form::label('Jenis Kelamin:', '') !!}
		                                					<div class="radio">
		                                						<label style="margin-right: 12px">
		                                							<input type="radio" name="gender" id="gender" value="male" checked="">
		                                							male (pria)
		                                						</label>
		                                						<label>
		                                							<input type="radio" name="gender" id="gender" value="female" checked="">
		                                							female (wanita)
		                                						</label>
		                                					</div>
		                                				</div>
		                                			</div>
		                                	</div>
		                                	<div class="form-group">
		                                			<div class="col-md-12" >
		                                				<div class="col-md-12">
		                                					{!! Form::label('Lampiran:', '') !!}
		                                					<div class="input-group ">
		                                						<span class="input-group-addon"><i class="fa fa-picture-o"></i></span>
		                                						<input type="file" class="form-control has-feedback" id="lampiran" name="lampiran" required>
		                                					</div>
		                                				</div>
		                                			</div>
		                                	</div>

		                                	<div class="form-group">
	                                			<div class="col-md-12" >
	                                				<div class="col-md-12">
	                                					{!! Form::label('Nota Dinas:', '') !!}
	                                					<div class="input-group ">
	                                						<span class="input-group-addon"><i class="fa fa-picture-o"></i></span>
	                                						<input type="file" class="form-control has-feedback" id="file" name="file" required>
	                                					</div>
	                                				</div>
	                                			</div>
		                                	</div>
		                                	<center>
		                                		<div class="col-md-12">
		                                			<div class="col-md-12 field_wrappe" >
		                                				{!! Form::submit('Simpan', ['class'=>'btn btn-default','style'=>'background-color:#007fff;border-radius:5px;width:80px;color: white']) !!}
		                                				&nbsp;&nbsp;
		                                				&nbsp;&nbsp;
		                                				<a class="btn" href="{{ url('/event') }}" title="Back Event List" style="border-radius: 5px;width:80px;background-color:#c31818;color: white">
		                                					Kembali
		                                				</a>
		                                			</div>
		                                		</div>
		                                	</center>
		                                </div>
		                            </div>
		                        <!-- </div> -->
		                    </div>
		                </div>
		            </div>
		            {!! Form::close() !!}

		        </div>
		    </div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {

        var maxField = 3; // Total 5 product fields we add

        var addButton = $('.add_button'); // Add more button selector

        var wrapper = $('.field_wrapper'); // Input fields wrapper

        var fieldHTML = `<div class="input-group form-elements">
                            <span class="input-group-addon"><i class="fa fa-picture-o"></i></span>
                            <input type="file" class="form-control has-feedback" value="" id="name_file[]" name="name_file[]" required>
                            <span class="input-group-addon" style="background-color: #c31818;">
                                <a href="javascript:void(0);" class="remove_button" title="Remove field"><i class="fa fa-minus " style="color:white;"></i></a>
                            </span>
                        </div>`; //New input field html 

        var x = 1; //Initial field counter is 1

        $(addButton).click(function() {
            //Check maximum number of input fields
            if (x < maxField) {
                x++; //Increment field counter
                $(wrapper).append(fieldHTML);
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e) {
            e.preventDefault();
            $(this).parent().closest(".form-elements").remove();
            x--; //Decrement field counter
        });
    });

    $('#datepicker').datepicker({
      autoclose: true
    });
</script>
@endpush