<div>
	@foreach($image as $data => $value)
		<div style="display: flex;justify-content:center;">
			<div style="width: 250px; height: 210px; border: 5px solid green">
				<table>
					<tr>
						<th>
							<img src="{{ url('/files/event/'.$value['name_file']) }}" alt="Image" style="width: 240px; height: 200px;">
							
						</th>
					</tr>
				</table>
			</div>
		</div>
	@endforeach()
</div>


