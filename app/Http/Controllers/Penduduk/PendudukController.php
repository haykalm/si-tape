<?php

namespace App\Http\Controllers\Penduduk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{
    KategoriPR,
    P_Rentan,
};
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $disabilitas = P_Rentan::where('kategori_pr_id', 4)->get();
        $kategori_pr = KategoriPR::all();

        return view('pr.disabilitas.index',['disabilitas'=>$disabilitas,'kategori_pr'=>$kategori_pr]);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'nik' => 'required|unique:p_Rentan|max:16',
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
        // $save = P_Rentan::create([
        //     'name' => $request['name'],
        // ]);
        $save = P_Rentan::create($request->all());

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
       return view('pr.disabilitas.edit', ['data' => $data,'kategori_pr' => $kategori_pr]);
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
        
        $napi = P_Rentan::where('kategori_pr_id', 5)->get();
        $kategori_pr = KategoriPR::all();
        // return $napi;


        return view('pr.napi.index',['napi'=>$napi,'kategori_pr'=>$kategori_pr]);
    }

    public function list_transgender()
    {
        
        $transgender = P_Rentan::where('kategori_pr_id', 6)->get();
        $kategori_pr = KategoriPR::all();
        // return $transgender;

        return view('pr.transgender.index',['transgender'=>$transgender,'kategori_pr'=>$kategori_pr]);
    }

     public function list_odgj()
    {
        
        $odgj = P_Rentan::where('kategori_pr_id', 1)->get();
        $kategori_pr = KategoriPR::all();
        // return $odgj;

        return view('pr.odgj.index',['odgj'=>$odgj,'kategori_pr'=>$kategori_pr]);
    }

    public function list_panti_asuhan()
    {
        
        $panti_asuhan = P_Rentan::where('kategori_pr_id', 2)->get();
        $kategori_pr = KategoriPR::all();
        // return $panti_asuhan;

        return view('pr.panti_asuhan.index',['panti_asuhan'=>$panti_asuhan,'kategori_pr'=>$kategori_pr]);
    }

    public function all_pr()
    {
        
        $all_pr = P_Rentan::all();
        $kategori_pr = KategoriPR::all();
        // return $all_pr;

        return view('pr.all_pr.index',['all_pr'=>$all_pr,'kategori_pr'=>$kategori_pr]);
    }
}
