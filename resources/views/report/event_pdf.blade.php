<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>lampiran kegiatan</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style>
		body{
			font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
			color:#333;
			text-align:left;
			font-size:18px;
			margin:0;
		}
		.container{
		margin:0 auto;
		/*padding:40px;*/
		/*width:00px;*/
		height:auto;
		background-color:#fff;
		}
		/*caption{
			font-size:28px;
			margin-bottom:15px;
		}*/
		.table{
			border:1px solid #333;
			border-collapse:collapse;
			margin:0 auto;
			width:280px;
			vertical-align: middle;
			text-align: center;
		}
		.td, .tr, .th{
			padding:10px;
			border:1px solid #333;
			width:175px;
			height: 40px;
		}

		@if($yayasan)
		.td, .tr, .th{
			padding:10px;
			border:1px solid #333;
			width:140px;
			height: 40px;
		}
		@endif()

		.th{
			background-color: #f0f0f0;
		}

		.cuk{
			border:0px solid #333;
			margin-left: 65px;
		}

		@if($yayasan)
			.cuk{
				border:0px solid #333;
				margin-left: 35px;
			}
		@endif()

	</style>
</head>
<body>
	<center>
		<caption>
			Report Event <strong>SI-TANPAN</strong>
		</caption>
	</center>
	<br>
	<table width="60%" class="cuk">
		<tr>
			<td>Kode Pendataan</td>
			<td style="width: 3px;">:</td>
			<td> {{$datapr->kode_pendataan}}</td>
		</tr>
		<tr>
			<td>NIK</td>
			<td style="width: 3px;">:</td>
			<td>{{$datapr->nik}}</td>
		</tr>
		<tr>
			<td>Name</td>
			<td style="width: 3px;">:</td>
			<td>{{$datapr->name}}</td>
		</tr>
	</table>
	<br>
	<div class="container">
		<center>
			<table class="table">
				<thead>
					<tr class="tr">
						<th class="th">Nama Kegiatan</th>
						<th class="th">Tempat</th>
						<th class="th">Tanggal</th>
						@if($yayasan)
						<th class="th">Yayasan</th>
						@endif()
					</tr>
					<tr class="tr">
						<td class="td">{{$data->event_name}}</td>
						<td class="td">{{$data->event_location}}</td>
						<td class="td">{{ $date }}</td>
						@if($yayasan)
						<td class="td">{{$yayasan->name}}</td>
						@endif()
					</tr>
				</thead>
				<tbody>
					@if($yayasan)
						<tr class="tr">
							<th colspan="4" class="th">Gambar :</th>
						</tr>
						@foreach ($image as $key => $value) {
						<tr class="tr">
							<td colspan="4" class="td">
								<img src="{{ public_path('files/event/'.$value->name_file) }}" alt="Image" style="height: 260px;">
							</td>
						</tr>
						@endforeach
					@else
						<tr class="tr">
							<th colspan="3" class="th">Gambar :</th>
						</tr>
						@foreach ($image as $key => $value) {
						<tr class="tr">
							<td colspan="3" class="td">
								<img src="{{ public_path('files/event/'.$value->name_file) }}" alt="Image" style="height: 275px;">
							</td>
						</tr>
						@endforeach
					@endif()
				</tbody>
			</table>
		</center>
	</div>
</body>
</html>