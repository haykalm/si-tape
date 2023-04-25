<?php

namespace App\Http\Controllers\Penduduk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\KategoriPR;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;


class CategeoryPendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = KategoriPR::all();
        return view('kategori_pr.index', ['category'=>$category]);
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
        $save = KategoriPR::create([
            'name' => $request['name'],
        ]);

        if ($save) {
            $response = [
                'status' => true,
                'message' => 'success saved data',
                'data' => $save
            ];
            $http_code = 200;

            Alert::success('Success', 'kategori berhasil ditambahkan!');
            return back();
        } else {
            $response = [
                'status' => false,
                'message' => 'Failed to saved data'
            ];
            $http_code = 422;

            Alert::error('Failed', 'kategori gagal ditambahkan!');
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
       $data = KategoriPR::find($id);
       return view('kategori_pr.edit', ['data' => $data ]);
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
        $category = KategoriPR::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
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

        $save = $category->update($request->all()); 
        if ($save) {
            $response = [
                'status' => true,
                'message' => 'success updated data',
                'data' => $save
            ];
            $http_code = 200;

            Alert::success('Success', 'category berhasil diupdate!');
            return back();
        } else {
            $response = [
                'status' => false,
                'message' => 'Failed to updated data'
            ];
            $http_code = 422;

            Alert::error('Failed', 'category gagal diupdate!');
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
        $data = KategoriPR::find($id);
        if ($data) {
            $response = [
                'status' => true,
                'message' => 'success deleted data',
                'data' => $data
            ];
            $http_code = 200;

            $data->delete();

            Alert::success('Success', 'category berhasil dihapus!');
            return back();
        } else {
            $response = [
                'status' => false,
                'message' => 'Failed to delete data'
            ];
            $http_code = 422;

            Alert::error('Failed', 'category gagal dihapus!');
            return back();
        }
    }
}
