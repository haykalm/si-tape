<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{
    KategoriPR,
    Yayasan,
};
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class YayasanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $yayasan = Yayasan::all();
        $kategori_pr = KategoriPR::all();
        // return $yayasan;
        return view('yayasan.index', ['yayasan' => $yayasan,'kategori_pr'=>$kategori_pr]);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'kategori_pr_id' => 'required',
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
        $save = Yayasan::create($request->all());

        if ($save) {
            $response = [
                'status' => true,
                'message' => 'success saved data',
                'data' => $save
            ];
            $http_code = 200;

            Alert::success('Success', 'Yayasan berhasil ditambahkan!');
            return back();
        } else {
            $response = [
                'status' => false,
                'message' => 'Failed to saved data'
            ];
            $http_code = 422;

            Alert::error('Failed', 'Yayasan gagal ditambahkan!');
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
        $data = Yayasan::find($id);
        $kategori_pr = KategoriPR::all();
        return view('yayasan.edit', ['data' => $data,'kategori_pr' => $kategori_pr]);
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
        $yayasan = Yayasan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'kategori_pr_id' => 'required',
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

        $save = $yayasan->update($request->all()); 
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
        $data = Yayasan::find($id);
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

    public function yayasan_odgj()
    {
        $ysn_odgj = Yayasan::where('kategori_pr_id', 1)->get();
        $kategori_pr = KategoriPR::all();
        // return $ysn_odgj;
        return view('yayasan.odgj.index', ['ysn_odgj' => $ysn_odgj,'kategori_pr'=>$kategori_pr]);
    }

    public function yayasan_p_asuhan()
    {
        $p_asuhan = Yayasan::where('kategori_pr_id', 2)->get();
        $kategori_pr = KategoriPR::all();
        // return $p_asuhan;
        return view('yayasan.p_asuhan.index', ['p_asuhan' => $p_asuhan,'kategori_pr'=>$kategori_pr]);
    }


}
