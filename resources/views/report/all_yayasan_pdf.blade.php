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
            width:650px;
            vertical-align: middle;
            text-align: center;
        }

        th{
            background-color: #f0f0f0;
        }

        td, tr, th{
            padding:10px;
            border:1px solid #333;
            height: 30px;
        }
    </style>
</head>
<body>
    <center>
        <h5>Laporan data <i>semua Yayasan</i> </h4>
    </center>
    <br>
    <center>
        <table>
            <thead>
                <tr style="text-align: center;font-size: 12px;">
                    <th style="vertical-align: middle; width: 3px;">No</th>
                    <th style="vertical-align: middle;">Name</th>
                    <th style="vertical-align: middle;width: 75px">Phone</th>
                    <th style="vertical-align: middle; width: 150px;">Alamat</th>
                    <th style="vertical-align: middle; width: 5px;">Kategori</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($yayasan))

                    @foreach($yayasan as $data => $value)
                    <tr style="text-align:center;font-size: 12px;">
                        <td style="vertical-align: middle;">{{ $data +1 }}</td>
                        <td style="text-transform: uppercase; vertical-align: middle;">{{ $value->name }}</td>
                        <td style="text-transform: uppercase;vertical-align: middle;">{{ $value->phone }}</td>
                        <td style="vertical-align: middle;">{{ $value->address }}</td>
                        <td style="vertical-align: middle;">{{ $value->name_category }}</td>
                    </tr>
                    @endforeach()

                @endif()   
            </tbody>
        </table>
    </center>
</body>
</html>