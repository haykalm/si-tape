<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{
    User,
    RoleUser,
};

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = user::all();
        $data = RoleUser::select('*','role_users.name as name_category','role_users.id as id_category')
                        ->join('users','users.role_id','=','role_users.id')
                        ->get();
        $role_user = RoleUser::all();
        return view('user.index', ['data' => $data, 'role_user' => $role_user]);
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
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required|unique:users|max:55',
            // 'password' => 'required',
            'role_id' => 'required',
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
        $save = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'] ?? 'disdukcapil'),
            'phone' => $request['phone'],
            'address' => $request['address'],
            'foto' => $request['foto'],
            'role_id' => $request['role_id'],
        ]);

        if ($save) {
            $response = [
                'status' => true,
                'message' => 'success saved data',
                'data' => $save
            ];
            $http_code = 200;

            Alert::success('Success', 'Admin berhasil ditambahkan!');
            return back();
        } else {
            $response = [
                'status' => false,
                'message' => 'Failed to saved data'
            ];
            $http_code = 422;

            Alert::error('Failed', 'Admin gagal ditambahkan!');
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
        $data = User::find($id);
        // $role_user = RoleUser::select('*','role_users.name as name_category','role_users.id as id_category')
        //                 ->join('users','users.role_id','=','role_users.id')
        //                 ->get();
        $role_user = RoleUser::all();
        return view('user.edit')->with([
            'data' => $data,
            'role_user' => $role_user
        ]);
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
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|max:55',
            'role_id' => 'required',
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

        $save = $user->update($request->all()); 
        if ($save) {
            $response = [
                'status' => true,
                'message' => 'success updated data',
                'data' => $save
            ];
            $http_code = 200;

            Alert::success('Success', 'Admin berhasil diupdate!');
            return back();
        } else {
            $response = [
                'status' => false,
                'message' => 'Failed to updated data'
            ];
            $http_code = 422;

            Alert::error('Failed', 'Admin gagal diupdate!');
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
        $data = User::find($id);
        if ($data) {
            $response = [
                'status' => true,
                'message' => 'success deleted data',
                'data' => $data
            ];
            $http_code = 200;

            $data->delete();

            Alert::success('Success', 'Admin berhasil dihapus!');
            return back();
        } else {
            $response = [
                'status' => false,
                'message' => 'Failed to delete data'
            ];
            $http_code = 422;

            Alert::error('Failed', 'Admin gagal dihapus!');
            return back();
        }
    }
}
