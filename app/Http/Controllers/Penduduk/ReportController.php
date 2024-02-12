<?php

namespace App\Http\Controllers\Penduduk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    KategoriPR,
    P_Rentan,
    Yayasan,
    Event,
    EventImages,
    NotaDinas
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
    PantiAsuhanExport
};
use App\Imports\PendudukImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Session;
use Throwable;
use File;
use Response;
use PDF;
use Dompdf\Dompdf;
use DataTables;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->year = Carbon::now()->format('Y');
    }
    public function download_lampiran($id)
    {
        $id = base64_decode($id);
        $namefile = P_Rentan::where('id', $id)->value('lampiran');
        $filepath = public_path('/files/lampiran/'.$namefile);

        if (!empty($namefile)){
            $response = [
                'status' => true,
                'message' => 'success downloaded file',
                'data' => $filepath
            ];
            $http_code = 200;
            // return Storage::download($filepath);
            return Response::download($filepath);
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

    public function download_nota_dinas($id)
    {
        $id = base64_decode($id);
        $namefile = NotaDinas::where('p_rentan_id', $id)->value('file');
        $filepath = public_path('files/nota_dinas/'.$namefile);

        if (!empty($namefile)){
            $response = [
                'status' => true,
                'message' => 'success downloaded file',
                'data' => $filepath
            ];
            $http_code = 200;
            // return Storage::download($filepath);
            return Response::download($filepath);
        } else {
            $response = [
                'status' => false,
                'message' => 'Failed to download file'
            ];
            $http_code = 422;

            Alert::error('Failed', 'Nota Dinas belum di upload!');
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
            foreach ($out as $key => $value) {
                Alert::error('Failed!', $value);
                return back();
            }
        }

        $file = $request->file('import_excel');
        $import = new PendudukImport;
        $import->import($file);
        return $import->data;  //var data in file import

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

    public function all_pr_pdf()
    {
        $all_pr = DB::table('p_rentan as p')
                ->leftJoin('yayasan as y', 'y.id', '=', 'p.yayasan_id')
                ->leftJoin('kategori_pr as k', 'k.id', '=', 'p.kategori_pr_id')
                ->select('p.id','p.name','p.nik','p.ttl','p.address','p.gender','k.name as kategori_name','y.name as yayasan_name', DB::raw('COALESCE(p.yayasan_id, 0) as yayasan_id'))
                ->orderBy('p.id', 'DESC')
                ->whereYear('p.created_at', $this->year)
                ->get();

        $name_all = 'semua kategori';

        $namefile = 'all_penduduk_rentan';
        $pdf = PDF::loadView('report/pr_pdf',['all_pr'=>$all_pr,'name_all'=>$name_all])->setPaper('f4','portrait');
        return $pdf->stream(''. $namefile .'.pdf');
    }

    public function disabilitas_pdf()
    {
        $all_pr = DB::table('p_rentan as p')
                ->leftJoin('yayasan as y', 'y.id', '=', 'p.yayasan_id')
                ->leftJoin('kategori_pr as k', 'k.id', '=', 'p.kategori_pr_id')
                ->select('p.id','p.name','p.nik','p.ttl','p.address','p.gender','k.name as kategori_name','y.name as yayasan_name', DB::raw('COALESCE(p.yayasan_id, 0) as yayasan_id'))
                ->orderBy('p.id', 'DESC')
                ->where('p.kategori_pr_id', 3)
                ->whereYear('p.created_at', $this->year)
                ->get();

        $kategori_name = 'Disabilitas';

        $namefile = 'all_disabilitas';

            $pdf = PDF::loadView('report/pr_pdf',['all_pr'=>$all_pr,'kategori_name'=>$kategori_name])
                ->setPaper('f4', 'portrait');

            return $pdf->stream(''. $namefile .'.pdf');

    }

    public function napi_pdf()
    {
        $all_pr = DB::table('p_rentan as p')
                ->leftJoin('yayasan as y', 'y.id', '=', 'p.yayasan_id')
                ->leftJoin('kategori_pr as k', 'k.id', '=', 'p.kategori_pr_id')
                ->select('p.id','p.name','p.nik','p.ttl','p.address','p.gender','k.name as kategori_name','y.name as yayasan_name', DB::raw('COALESCE(p.yayasan_id, 0) as yayasan_id'))
                ->orderBy('p.id', 'DESC')
                ->where('p.kategori_pr_id', 4)
                ->whereYear('p.created_at', $this->year)
                ->get();

        $kategori_name = 'Napi';

        $namefile = 'all_napi';
        $pdf = PDF::loadView('report/pr_pdf',['all_pr'=>$all_pr,'kategori_name'=>$kategori_name])->setPaper('f4', 'portrait');
        return $pdf->stream(''. $namefile .'.pdf');
    }

    public function transgender_pdf()
    {
        $all_pr = DB::table('p_rentan as p')
                ->leftJoin('yayasan as y', 'y.id', '=', 'p.yayasan_id')
                ->leftJoin('kategori_pr as k', 'k.id', '=', 'p.kategori_pr_id')
                ->select('p.id','p.name','p.nik','p.ttl','p.address','p.gender','k.name as kategori_name','y.name as yayasan_name', DB::raw('COALESCE(p.yayasan_id, 0) as yayasan_id'))
                ->orderBy('p.id', 'DESC')
                ->where('p.kategori_pr_id', 5)
                ->whereYear('p.created_at', $this->year)
                ->get();

        $kategori_name = 'Transgender';

        $namefile = 'all_transgender';
        $pdf = PDF::loadView('report/pr_pdf',['all_pr'=>$all_pr,'kategori_name'=>$kategori_name])->setPaper('f4', 'portrait');
        return $pdf->stream(''. $namefile .'.pdf');
    }

    public function odgj_pdf()
    {
        $all_pr = DB::table('p_rentan as p')
                ->leftJoin('yayasan as y', 'y.id', '=', 'p.yayasan_id')
                ->leftJoin('kategori_pr as k', 'k.id', '=', 'p.kategori_pr_id')
                ->select('p.id','p.name','p.nik','p.ttl','p.address','p.gender','k.name as kategori_name','y.name as yayasan_name', DB::raw('COALESCE(p.yayasan_id, 0) as yayasan_id'))
                ->orderBy('p.id', 'DESC')
                ->where('p.kategori_pr_id', 1)
                ->whereYear('p.created_at', $this->year)
                ->get();

        $kategori_name = 'Odgj';

        $namefile = 'all_odgj';
        $pdf = PDF::loadView('report/pr_pdf',['all_pr'=>$all_pr,'kategori_name'=>$kategori_name])->setPaper('f4', 'portrait');
        return $pdf->stream(''. $namefile .'.pdf');
    }

    public function panti_asuhans_pdf()
    {
        $all_pr = DB::table('p_rentan as p')
                ->leftJoin('yayasan as y', 'y.id', '=', 'p.yayasan_id')
                ->leftJoin('kategori_pr as k', 'k.id', '=', 'p.kategori_pr_id')
                ->select('p.id','p.name','p.nik','p.ttl','p.address','p.gender','k.name as kategori_name','y.name as yayasan_name', DB::raw('COALESCE(p.yayasan_id, 0) as yayasan_id'))
                ->orderBy('p.id', 'DESC')
                ->where('p.kategori_pr_id', 2)
                ->whereYear('p.created_at', $this->year)
                ->get();

        $kategori_name = 'Panti Asuhan';

        $namefile = 'all_panti_asuhans';
        $pdf = PDF::loadView('report/pr_pdf',['all_pr'=>$all_pr,'kategori_name'=>$kategori_name])->setPaper('f4', 'portrait');
        return $pdf->stream(''. $namefile .'.pdf');
    }

    public function event_pdf($id)
    {
        $id = base64_decode($id);
        $data = Event::find($id);

        $datapr = Event::leftJoin('p_rentan', 'p_rentan.id', '=', 'events.p_rentan_id')
                    ->leftJoin('pendataan', 'pendataan.p_rentan_id', '=', 'events.p_rentan_id')
                    ->select('p_rentan.name', 'p_rentan.nik', 'pendataan.kode_pendataan')
                    ->where('events.p_rentan_id', $data->p_rentan_id)
                    ->first();

        $image = EventImages::select('name_file')->where('events_id',$id)->get();

        $yayasan = Yayasan::where('id',$data->yayasan_id)->first();

        $date = Carbon::parse($data->date)->format('d-M-Y');

        $namefile = $data->event_name . '_' . $date;
        $pdf = PDF::loadView('report/event_pdf',[
                'data'=>$data,
                'image'=>$image,
                'yayasan'=>$yayasan,
                'date'=>$date,
                'datapr'=>$datapr])
                ->setPaper('legal', 'portrait');

        return $pdf->stream(''. $namefile .'.pdf');
    }

    public function yayasan_pdf()
    {
        $yayasan = Yayasan::join('kategori_pr', 'kategori_pr.id', '=', 'yayasan.kategori_pr_id')
                    ->select('yayasan.*','kategori_pr.name as name_category')
                    ->get();

        $namefile = 'all_yayasan';
        $pdf = PDF::loadView('report/all_yayasan_pdf',['yayasan'=>$yayasan])->setPaper('f4', 'portrait');
        return $pdf->stream(''. $namefile .'.pdf');
    }

    public function detail_pr_pdf($id)
    {
        $id = base64_decode($id);
        $data =  P_Rentan::find($id);

        $detail_pr = P_Rentan::leftJoin('kategori_pr','kategori_pr.id', '=', 'p_rentan.kategori_pr_id')
                    ->leftJoin('pendataan','pendataan.p_rentan_id', '=', 'p_rentan.id')
                    ->select('p_rentan.*', 'kategori_pr.name as name_category', 'pendataan.kode_pendataan')
                    ->where('p_rentan.id',$id)
                    ->first();

        $yayasan = Yayasan::where('id',$data->yayasan_id)->first();

        $namefile = $data->name;

        $pdf = PDF::loadView('report/detail_pr_pdf',['yayasan'=>$yayasan,'detail_pr'=>$detail_pr])->setPaper('f4', 'portrait');
        return $pdf->stream(''. $namefile .'.pdf');
    }
}
