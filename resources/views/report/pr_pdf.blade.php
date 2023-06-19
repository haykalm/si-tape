<!DOCTYPE html>
<html>
<head>
    <title>Report Penduduk Rentan</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
        table{
            border:1px solid #333;
            border-collapse:collapse;
            margin:0 auto;
            /*width:600px;*/
            vertical-align: middle;
            text-align: center;
        }

        th{
            background-color: #f0f0f0;
        }

        td, tr, th{
            padding:10px;
            border:1px solid #333;
            /*height: 40px;*/
        }
    </style>
</head>
<body>
    <center>
        <h5>Laporan penduduk rentan<i> {{request()->is('disabilitas_pdf','napi_pdf','transgender_pdf','odgj_pdf','panti_asuhans_pdf') ? $kategori_name : ''}} {{request()->is('all_pr_pdf') ? $name_all : ''}} </i> </h4>
    </center>
    <br>
    <center>
        <table>
            <thead>
                <tr style="text-align: center;font-size: 11px;">
                    <th style="vertical-align: middle; width: 3px;">No</th>
                    <th style="vertical-align: middle;">Nik</th>
                    <th style="vertical-align: middle;">Name</th>
                    <th style="vertical-align: middle;">TTL</th>
                    <th style="vertical-align: middle; width: 40px;">Alamat</th>
                    <th style="vertical-align: middle; width: 5px;">jenis kelamin</th>
                    <th style="vertical-align: middle; width: 5px;">Yayasan</th>
                    <th style="vertical-align: middle; width: 5px;">Status</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($all_pr))

                    @foreach($all_pr as $data => $value)
                    <tr style="text-align:center;font-size: 11px;">
                        <td style="vertical-align: middle;">{{ $data +1 }}</td>
                        <td style="vertical-align: middle;">{{ $value->nik }}</td>
                        <td style="text-transform: uppercase;vertical-align: middle;">{{ $value->name }}</td>
                        <td style="vertical-align: middle;">{{ $value->ttl }}</td>
                        <td style="vertical-align: middle;">{{ $value->address }}</td>
                        <td style="vertical-align: middle;">{{ $value->gender }}</td>
                        <td style="vertical-align: middle;">{{ $value->yayasan_name }}</td>
                        <td style="vertical-align: middle;">{{ $value->kategori_name }}</td>
                    </tr>
                    @endforeach()

                @endif()   
            </tbody>
        </table>
    </center>
</body>
</html>