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
use App\Exports\PendudukExport;
use App\Imports\PendudukImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Session;
use Throwable;



class PendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $disabilitas = P_Rentan::where('kategori_pr_id', 3)
                    ->orderBy('id', 'DESC')
                    ->get();
        $kategori_pr = KategoriPR::all();
        $yayasan = yayasan::all();

        return view('pr.disabilitas.index',['disabilitas'=>$disabilitas,'kategori_pr'=>$kategori_pr,'yayasan'=>$yayasan]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        date_default_timezone_set('Asia/Jakarta');

        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'nik' => 'required|unique:p_Rentan|max:16',
            ]);
            if ($validator->fails()) {
                $out = [
                    "message" => $validator->messages()->all(),
                ];
                foreach ($out as $key => $value) {
                    Alert::error('Failed!', $value);
                    return back();
                }
                Alert::error('Failed!', $out);
                return back();
            }
            if ($request->hasfile('lampiran')) {
                $validator = Validator::make($request->all(), [
                    'lampiran' => 'required|mimes:png,jpg,jpeg,csv,xlx,xls,pdf|max:1000',
                ]);
                if ($validator->fails()) {
                    $out = [
                        "message" => $validator->messages()->all(),
                    ];
                    Alert::error('Failed!', $out);
                    return back();
                }
            }

            $save = New P_Rentan;        
            $save->yayasan_id   = $request->yayasan_id;
            $save->kategori_pr_id   = $request->kategori_pr_id;
            $save->nik   = $request->nik;
            $save->name   = $request->name;
            $save->gender   = $request->gender;
            $save->ttl   = $request->ttl;
            $save->phone   = $request->phone;
            if ($request->hasfile('lampiran')) {
                $save->lampiran   = $request->file('lampiran')->store('files/lampiran');
            }
            $save->save();

            $save->where('id', $save->id)->update(['lampiran'=>$save->lampiran]);

        // $save = P_Rentan::create([
        //     'name' => $request['name'],
        // ]);
        // $save = P_Rentan::create($request->all());

            if ($save) {
                $response = [
                    'status' => true,
                    'message' => 'success saved data',
                    'data' => $save
                ];
                $http_code = 200;

                Alert::success('Success', 'Data berhasil ditambahkan!');
                return back();
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Failed to saved data'
                ];
                $http_code = 422;

                Alert::error('Failed', 'Data gagal ditambahkan!');
                return back();
            }
        }catch (Throwable $e) {
            Alert::error('Failed', $e, 'Data gagal ditambahkan!');
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = P_Rentan::find($id);
        $kategori_pr = KategoriPR::all();
        $yayasan = Yayasan::all();
        return view('pr.disabilitas.edit', ['data' => $data,'kategori_pr' => $kategori_pr,'yayasan' => $yayasan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $p_Rentan = P_Rentan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'nik' => 'required|max:16',
        ]);
        
        if ($validator->fails()) {
            $out = [
            "message" => $validator->messages()->all(),
            ];
            // return response()->json($out, 422);
            foreach ($out as $key => $value) {
                Alert::error('Failed!', $value);
                return back();
            }

            Alert::error('Failed!', $out);
            return back();

        }

        $save = $p_Rentan->update($request->all()); 
        if ($save) {
            $response = [
                'status' => true,
                'message' => 'success updated data',
                'data' => $save
            ];
            $http_code = 200;

            Alert::success('Success', 'Data berhasil diupdate!');
            return back();
        } else {
            $response = [
                'status' => false,
                'message' => 'Failed to updated data'
            ];
            $http_code = 422;

            Alert::error('Failed', 'Data gagal diupdate!');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = base64_decode($id);
        $data = P_Rentan::find($id);
        if ($data) {
            $response = [
                'status' => true,
                'message' => 'success deleted data',
                'data' => $data
            ];
            $http_code = 200;

            $data->delete();

            Alert::success('Success', 'Data berhasil dihapus!');
            return back();
        } else {
            $response = [
                'status' => false,
                'message' => 'Failed to delete data'
            ];
            $http_code = 422;

            Alert::error('Failed', 'Data gagal dihapus!');
            return back();
        }
    }

    public function list_napi()
    {
        
        $napi = P_Rentan::where('kategori_pr_id', 4)
                ->orderBy('id', 'DESC')
                ->get();
        $kategori_pr = KategoriPR::all();
        $yayasan = Yayasan::all();

        return view('pr.napi.index',['napi'=>$napi,'kategori_pr'=>$kategori_pr,'yayasan'=>$yayasan]);
    }

    public function list_transgender()
    {
        
        $transgender = P_Rentan::where('kategori_pr_id', 5)
                ->orderBy('id', 'DESC')
                ->get();
        $kategori_pr = KategoriPR::all();
        $yayasan = Yayasan::all();

        return view('pr.transgender.index',['transgender'=>$transgender,'kategori_pr'=>$kategori_pr,'yayasan'=>$yayasan]);
    }

     public function list_odgj()
    {
        $odgj = P_Rentan::select('p_rentan.*','yayasan.name as yayasan_name')
                ->join('yayasan','yayasan.id','=','p_rentan.yayasan_id')
                ->where('p_rentan.kategori_pr_id', 1)
                ->orderBy('id', 'DESC')
                ->get();;
                // return $odgj;  
        $kategori_pr = KategoriPR::all();
        $yayasan = Yayasan::all();

        return view('pr.odgj.index',['odgj'=>$odgj,'kategori_pr'=>$kategori_pr,'yayasan'=>$yayasan]);
    }

    public function list_panti_asuhan()
    {
        $panti_asuhan = P_Rentan::select('p_rentan.*','yayasan.name as yayasan_name')
                ->join('yayasan','yayasan.id','=','p_rentan.yayasan_id')
                ->where('p_rentan.kategori_pr_id', 2)
                ->orderBy('id', 'DESC')
                ->get();;
        $kategori_pr = KategoriPR::all();
        $yayasan = Yayasan::all();

        return view('pr.panti_asuhan.index',['panti_asuhan'=>$panti_asuhan,'kategori_pr'=>$kategori_pr,'yayasan'=>$yayasan]);
    }

    public function all_pr()
    {
        // $data = P_Rentan::where('name', 'HaYkAL')->first();
        // $data = $data->id;
        // $data = [["a","b","c"],["d","e","f"]];
        // return $data[1][2];
        $all_pr = DB::table('p_rentan as p')
                ->leftJoin('yayasan as y', 'y.id', '=', 'p.yayasan_id')
                ->leftJoin('kategori_pr as k', 'k.id', '=', 'p.kategori_pr_id')
                ->select('p.id','p.name','p.nik','p.ttl','p.address','p.gender','k.name as kategori_name','y.name as yayasan_name', DB::raw('COALESCE(p.yayasan_id, 0) as yayasan_id'))
                ->orderBy('p.id', 'DESC')
                ->get();
        // return $all_pr;  
        // $all_pr_join = P_Rentan::select('*','yayasan.*','yayasan.name as name_ysn','yayasan.id as id_ysn')
        //         ->rightjoin('yayasan','yayasan.id','=','p_rentan.yayasan_id')
        //         ->get();
        // $data = array_merge($all_pr_join->toArray(),$data_pr->toArray()); 

        $kategori_pr = KategoriPR::all();
        $yayasan = Yayasan::all();

        return view('pr.all_pr.index',['all_pr'=>$all_pr,'kategori_pr'=>$kategori_pr,'yayasan'=>$yayasan]);
    }

    // public function download_lampiran($id){

    //   $path = P_Rentan::where('id', $id)->value('lampiran');

    //   if ($path) {
    //         $response = [
    //             'status' => true,
    //             'message' => 'success downloaded file',
    //             'data' => $path
    //         ];
    //         $http_code = 200;
    //         return Storage::download($path);

    //         Alert::success('Success', 'lampiran berhasil di download!');
    //         return back();
    //     } else {
    //         $response = [
    //             'status' => false,
    //             'message' => 'Failed to download file'
    //         ];
    //         $http_code = 422;

    //         Alert::error('Failed', 'lampiran belum di upload!');
    //         return back();
    //     }

      
    // }
    // public function export_excel()
    // {

    //     return Excel::download(new PendudukExport, 'Penduduk_rentan.xlsx');
    // }

    // public function import_penduduk(Request $request) 
    // {
        
    //     $validator = Validator::make($request->all(), [
    //         'import_excel' => 'required|mimes:csv,xls,xlsx|max:2000',
    //     ]);
    //     if ($validator->fails()) {
    //         $out = [
    //         "message" => $validator->messages()->all(),
    //         ];
    //         Alert::error('Failed!', $out);
    //         return back();
    //     }
    //     // $import = Excel::import(new PendudukImport,$file);
    //     // dd('Row count: ' . $import->getRowCount());
    //     // try {
    //         $file = $request->file('import_excel')->store('files/import'); 
    //         $import = new PendudukImport;
    //         $import->import($file);
    //         // Excel::import($import, $file);
    //         // return $import->data;
    //         // return $import->failure;

    //         if ($import->failures()->isNotEmpty()) {
    //             return back()->withFailures($import->failures());
    //         }
    //         return back()->withStatus('Data Berhasil Di Import.');
    // }
}
