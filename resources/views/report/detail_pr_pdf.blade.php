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
            width:700px;
            vertical-align: middle;
            text-align: center;
        }

        th{
            background-color: #f0f0f0;
        }

        td, tr, th{
            padding:10px;
            border:1px solid #333;
            height: 23px;
        }
    </style>
</head>
<body>
    <center>
        <h2>Laporan <i>detail</i> penduduk rentan</h2>
    </center>
    <br>
    <center>
        <table>
            <thead>
                <tr>
                    <th colspan="4" style="text-align: left;">Kode Pendataan</th>
                    <td>{{$detail_pr->kode_pendataan}}</td>
                </tr>
                <tr>
                    <th colspan="4" style="text-align: left;">Status</th>
                    <td>{{$detail_pr->name_category}}</td>
                </tr>

                @if($yayasan))
                    <tr>
                        <th colspan="4" style="text-align: left;">Yayasan</th>
                        <td>{{$yayasan->name}}</td>
                    </tr>
                @endif()   

                <tr style="text-align: center;">
                    <th style="vertical-align: middle;">NIK</th>
                    <th style="vertical-align: middle;">Name</th>
                    <th style="vertical-align: middle;">TTL</th>
                    <th style="vertical-align: middle;">Jenis Kelamin</th>
                    <th style="vertical-align: middle;">Alamat</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($detail_pr))
                    <tr style="text-align:center;">
                        <td style="vertical-align: middle;">{{$detail_pr->nik}}</td>
                        <td style="text-transform: uppercase; vertical-align: middle;">{{$detail_pr->name}}</td>
                        <td style="vertical-align: middle;">{{$detail_pr->ttl}}</td>
                        <td style="vertical-align: middle;">
                            @if($detail_pr->gender == 'male')
                                Pria
                            @else
                                Wanita
                            @endif()
                        </td>
                        <td style="vertical-align: middle;">{{$detail_pr->address}}</td>
                    </tr>
                @endif()   
            </tbody>
        </table>
    </center>
</body>
</html>