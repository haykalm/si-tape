<?php

namespace App\Http\Controllers\Penduduk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    KategoriPR,
    P_Rentan,
    Yayasan,
};
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Exports\{
    PendudukExport,
    DisabilitasExport,
    NapiExport,
    TransgenderExport,
    OdgjExport,
    PantiAsuhanExport,
};
use App\Imports\PendudukImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Session;
use Throwable;

class ReportController extends Controller
{
    public function download_lampiran($id)
    {

      $path = P_Rentan::where('id', $id)->value('lampiran');

      if ($path) {
            $response = [
                'status' => true,
                'message' => 'success downloaded file',
                'data' => $path
            ];
            $http_code = 200;
            return Storage::download($path);

            Alert::success('Success', 'lampiran berhasil di download!');
            return back();
        } else {
            $response = [
                'status' => false,
                'message' => 'Failed to download file'
            ];
            $http_code = 422;

            Alert::error('Failed', 'lampiran belum di upload!');
            return back();
        }
    }

    public function export_excel()
    {

        return Excel::download(new PendudukExport, 'Penduduk_rentan.xlsx');
    }

    public function import_penduduk(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'import_excel' => 'required|mimes:csv,xls,xlsx|max:2000',
        ]);
        if ($validator->fails()) {
            $out = [
                "message" => $validator->messages()->all(),
            ];
            Alert::error('Failed!', $out);
            return back();
        }

        $file = $request->file('import_excel'); 
        $import = new PendudukImport;
        $import->import($file);
        // return $import->data;  //var data in file import

        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }
        return back()->withStatus('Data Berhasil Di Import.');
    }

    public function disablitas_excel()
    {
        return Excel::download(new DisabilitasExport, 'Penduduk_disablitas.xlsx');
    }

    public function napi_excel()
    {
        return Excel::download(new NapiExport, 'Penduduk_napi.xlsx');
    }

    public function transgender_excel()
    {
        return Excel::download(new TransgenderExport, 'Penduduk_transgender.xlsx');
    }

    public function odgj_excel()
    {
        return Excel::download(new OdgjExport, 'Penduduk_odgj.xlsx');
    } 
    public function panti_asuhan_excel()
    {
        return Excel::download(new PantiAsuhanExport, 'Penduduk_panti_asuhan.xlsx');
    }
}
