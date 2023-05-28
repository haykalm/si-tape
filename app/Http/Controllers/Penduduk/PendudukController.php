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
use File;
// use Illuminate\Support\Facades\Auth;


class PendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $disabilitas = P_Rentan::where('kategori_pr_id', 3)
        //             ->orderBy('id', 'DESC')
        //             ->get();
        $disabilitas = DB::table('p_rentan as p')
                ->leftJoin('yayasan as y', 'y.id', '=', 'p.yayasan_id')
                ->leftJoin('kategori_pr as k', 'k.id', '=', 'p.kategori_pr_id')
                ->select('p.id','p.name','p.nik','p.ttl','p.address','p.gender','k.name as kategori_name','y.name as yayasan_name', DB::raw('COALESCE(p.yayasan_id, 0) as yayasan_id'))
                ->orderBy('p.id', 'DESC')
                ->where('p.kategori_pr_id', 3)
                ->get();
        // return $disabilitas;
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
        }
        if ($request->hasfile('lampiran')) {
            $validator = Validator::make($request->all(), [
                'lampiran' => 'required|mimes:png,jpg,jpeg,pdf|max:1000',
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
        }

        /*Add New Image*/
        $imageName = time().'_'.$request->lampiran->getClientOriginalName();  
        $request->lampiran->move(public_path('files/lampiran'), $imageName);

        // insert data
        $save_pr = New P_Rentan;
        $save_pr->yayasan_id   = $request->yayasan_id;
        $save_pr->kategori_pr_id   = $request->kategori_pr_id;
        $save_pr->nik   = $request->nik;
        $save_pr->name   = $request->name;
        $save_pr->gender   = $request->gender;
        $save_pr->ttl   = $request->ttl;
        $save_pr->phone   = $request->phone;        
        $save_pr->lampiran   = $imageName;
        $save_pr->save();

        if ($save_pr) {
            $response = [
                'status' => true,
                'message' => 'success saved data',
                'data' => $save_pr
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
        }
        if ($request->hasfile('lampiran')) {
            $validator = Validator::make($request->all(), [
                'lampiran' => 'required|mimes:png,jpg,jpeg,pdf|max:2000',
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
        }

        $penduduk = P_Rentan::where('id', $id)->first();

        if ($request->hasfile('lampiran')) {
            /*Delete Image*/
            File::delete(public_path().'/files/lampiran/'. $penduduk->lampiran);
            /*Add New Image*/
            $imageName = time().'_'.$request->lampiran->getClientOriginalName();  
            $request->lampiran->move(public_path('files/lampiran'), $imageName);
            /*Modify Bank Code*/
            $penduduk->yayasan_id = $request->yayasan_id ?? NULL;
            $penduduk->kategori_pr_id = $request->kategori_pr_id;
            $penduduk->nik = $request->nik;
            $penduduk->name = $request->name;
            $penduduk->gender = $request->gender;
            $penduduk->ttl = $request->ttl;
            $penduduk->phone = $request->phone;        
            $penduduk->lampiran = $imageName;
            $penduduk->save();
        } else {
            /*Modify Bank Code*/
            $penduduk->yayasan_id = $request->yayasan_id ?? NULL;
            $penduduk->kategori_pr_id = $request->kategori_pr_id;
            $penduduk->nik = $request->nik;
            $penduduk->name = $request->name;
            $penduduk->gender = $request->gender;
            $penduduk->ttl = $request->ttl;
            $penduduk->phone = $request->phone;        
            // $penduduk->lampiran = $imageName;
            $penduduk->save();
        }
        // $save = $p_Rentan->update($request->all()); 
        // $save->where('id', $save->id)->update(['lampiran'=>$save->lampiran]);
        if ($penduduk) {
            $response = [
                'status' => true,
                'message' => 'success updated data',
                'data' => $penduduk
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
        
        // $napi = P_Rentan::where('kategori_pr_id', 4)
        //         ->orderBy('id', 'DESC')
        //         ->get();
        $napi = DB::table('p_rentan as p')
                ->leftJoin('yayasan as y', 'y.id', '=', 'p.yayasan_id')
                ->leftJoin('kategori_pr as k', 'k.id', '=', 'p.kategori_pr_id')
                ->select('p.id','p.name','p.nik','p.ttl','p.address','p.gender','k.name as kategori_name','y.name as yayasan_name', DB::raw('COALESCE(p.yayasan_id, 0) as yayasan_id'))
                ->orderBy('p.id', 'DESC')
                ->where('p.kategori_pr_id', 4)
                ->get();
        $kategori_pr = KategoriPR::all();
        $yayasan = Yayasan::all();

        return view('pr.napi.index',['napi'=>$napi,'kategori_pr'=>$kategori_pr,'yayasan'=>$yayasan]);
    }

    public function list_transgender()
    {
        // $transgender = P_Rentan::where('kategori_pr_id', 5)
        //         ->orderBy('id', 'DESC')
        //         ->get();
        $transgender = DB::table('p_rentan as p')
                ->leftJoin('yayasan as y', 'y.id', '=', 'p.yayasan_id')
                ->leftJoin('kategori_pr as k', 'k.id', '=', 'p.kategori_pr_id')
                ->select('p.id','p.name','p.nik','p.ttl','p.address','p.gender','k.name as kategori_name','y.name as yayasan_name', DB::raw('COALESCE(p.yayasan_id, 0) as yayasan_id'))
                ->orderBy('p.id', 'DESC')
                ->where('p.kategori_pr_id', 5)
                ->get(); 
        $kategori_pr = KategoriPR::all();
        $yayasan = Yayasan::all();

        return view('pr.transgender.index',['transgender'=>$transgender,'kategori_pr'=>$kategori_pr,'yayasan'=>$yayasan]);
    }

     public function list_odgj()
    {
        // $odgj = P_Rentan::select('p_rentan.*','yayasan.name as yayasan_name')
        //         ->join('yayasan','yayasan.id','=','p_rentan.yayasan_id')
        //         ->where('p_rentan.kategori_pr_id', 1)
        //         ->orderBy('id', 'DESC')
        //         ->get();
        $odgj = DB::table('p_rentan as p')
                ->leftJoin('yayasan as y', 'y.id', '=', 'p.yayasan_id')
                ->leftJoin('kategori_pr as k', 'k.id', '=', 'p.kategori_pr_id')
                ->select('p.id','p.name','p.nik','p.ttl','p.address','p.gender','k.name as kategori_name','y.name as yayasan_name', DB::raw('COALESCE(p.yayasan_id, 0) as yayasan_id'))
                ->orderBy('p.id', 'DESC')
                ->where('p.kategori_pr_id', 1)
                ->get(); 
        $kategori_pr = KategoriPR::all();
        $yayasan = Yayasan::all();

        return view('pr.odgj.index',['odgj'=>$odgj,'kategori_pr'=>$kategori_pr,'yayasan'=>$yayasan]);
    }

    public function list_panti_asuhan()
    {
        // $panti_asuhan = P_Rentan::select('p_rentan.*','yayasan.name as yayasan_name')
        //         ->join('yayasan','yayasan.id','=','p_rentan.yayasan_id')
        //         ->where('p_rentan.kategori_pr_id', 2)
        //         ->orderBy('id', 'DESC')
        //         ->get();

        $panti_asuhan = DB::table('p_rentan as p')
                ->leftJoin('yayasan as y', 'y.id', '=', 'p.yayasan_id')
                ->leftJoin('kategori_pr as k', 'k.id', '=', 'p.kategori_pr_id')
                ->select('p.id','p.name','p.nik','p.ttl','p.address','p.gender','k.name as kategori_name','y.name as yayasan_name', DB::raw('COALESCE(p.yayasan_id, 0) as yayasan_id'))
                ->orderBy('p.id', 'DESC')
                ->where('p.kategori_pr_id', 2)
                ->get();

        $kategori_pr = KategoriPR::all();
        $yayasan = Yayasan::all();

        return view('pr.panti_asuhan.index',['panti_asuhan'=>$panti_asuhan,'kategori_pr'=>$kategori_pr,'yayasan'=>$yayasan]);
    }

    public function all_pr()
    {
        // $data = [["a","b","c"],["d","e","f"]];
        // return $data[1][2];
        $all_pr = DB::table('p_rentan as p')
                ->leftJoin('yayasan as y', 'y.id', '=', 'p.yayasan_id')
                ->leftJoin('kategori_pr as k', 'k.id', '=', 'p.kategori_pr_id')
                ->select('p.id','p.name','p.nik','p.ttl','p.address','p.gender','k.name as kategori_name','y.name as yayasan_name', DB::raw('COALESCE(p.yayasan_id, 0) as yayasan_id'))
                ->orderBy('p.id', 'DESC')
                ->get();

        $kategori_pr = KategoriPR::all();
        $yayasan = Yayasan::all();

        return view('pr.all_pr.index',['all_pr'=>$all_pr,'kategori_pr'=>$kategori_pr,'yayasan'=>$yayasan]);
    }
}
