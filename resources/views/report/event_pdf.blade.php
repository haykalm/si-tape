<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Report Event</title>
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
		caption{
			font-size:28px;
			margin-bottom:15px;
		}
		table{
			border:1px solid #333;
			border-collapse:collapse;
			margin:0 auto;
			width:400px;
			vertical-align: middle;
			text-align: center;
		}
		td, tr, th{
			padding:10px;
			border:1px solid #333;
			width:175px;
			height: 40px;
		}

		@if($yayasan)
		td, tr, th{
			padding:10px;
			border:1px solid #333;
			width:140px;
			height: 40px;
		}
		@endif()

		th{
			background-color: #f0f0f0;
		}
		h4, p{
			margin:0px;
		}
	</style>
</head>
<body>
	<div class="container">
		<center>
			<table>
				<caption>
					Report Event <strong>SI-TANPAN</strong>
				</caption>
				<thead>
					<tr>
						<th>Nama Acara</th>
						<th>Tempat</th>
						<th>Tanggal</th>
						@if($yayasan)
						<th>Yayasan</th>
						@endif()
					</tr>
					<tr>
						<td>{{$data->event_name}}</td>
						<td>{{$data->event_location}}</td>
						<td>{{ $date }}</td>
						@if($yayasan)
						<td>{{$yayasan->name}}</td>
						@endif()
					</tr>
				</thead>
				<tbody>
					@if($yayasan)
						<tr>
							<th colspan="4">Gambar :</th>
						</tr>
						<tr>
							@foreach ($image as $key => $value) {
								@if(count($image) == 4 || count($image) == 3)
									<td>
										<img src="{{ public_path('files/event/'.$value->name_file) }}" alt="Image" style="width: 163px; height: 120px;">
									</td>
								@elseif(count($image) == 2)
									<td colspan="2">
										<img src="{{ public_path('files/event/'.$value->name_file) }}" alt="Image" style="width: 360px; height: 180px;">
									</td>
								@elseif(count($image) == 1)
									<td colspan="4">
										<img src="{{ public_path('files/event/'.$value->name_file) }}" alt="Image" style="width: 550px; height: 390px;">
									</td>
								@else
									<td>
										<img src="{{ public_path('files/event/'.$value->name_file) }}" alt="Image" style="width: 163px; height: 120px;">
									</td>
								@endif()
							@endforeach
						</tr>
					@else
						<tr>
							<th colspan="3">Gambar :</th>
						</tr>
						<tr>
							@foreach ($image as $key => $value) {
								@if(count($image) == 3)
									<td>
										<img src="{{ public_path('files/event/'.$value->name_file) }}" alt="Image" style="width: 180px; height: 120px;">
									</td>
								@elseif(count($image) == 2)
									<tr>
										<td colspan="3">
											<img src="{{ public_path('files/event/'.$value->name_file) }}" alt="Image" style="width: 470px; height: 330px;">
										</td>
									</tr>
								@elseif(count($image) == 1)
									<td colspan="3">
										<img src="{{ public_path('files/event/'.$value->name_file) }}" alt="Image" style="width: 460px; height: 330px;">
									</td>
								@else
									<tr>
										<td colspan="3">
											<img src="{{ public_path('files/event/'.$value->name_file) }}" alt="Image" style="width: 470px; height: 330px;">
										</td>
									</tr>
								@endif()
							@endforeach
						</tr>
					@endif()

				</tbody>
			</table>
		</center>
	</div>
</body>
</html>