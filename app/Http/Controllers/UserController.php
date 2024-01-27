<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{
    User,
    RoleUser,
};

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class UserController extends Controller
{

    public function index()
    {
        $data = RoleUser::select('*','role_users.name as name_category','role_users.id as id_category')
        ->join('users','users.role_id','=','role_users.id')
        ->orderBy('users.id', 'DESC')
        ->get();

        $role_user = RoleUser::all();
        return view('user.index', ['data' => $data, 'role_user' => $role_user]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required','min:3','max:100','string'],
            'email' => 'required|unique:users|max:55',
            'phone' => 'min:8|max:14',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2000',
            'role_id' => 'required',
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

        if ($request->hasfile('foto')) {

            $imageName = time().'_'.$request->foto->getClientOriginalName();
            $request->foto->move(public_path('files/users'), $imageName);
        }

        $save = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'] ?? 'disdukcapil'),
            'phone' => $request['phone'],
            'address' => $request['address'],
            'foto' => $imageName ?? NULL,
            'role_id' => $request['role_id'],
        ]);

        if ($save) {

            Alert::success('Success', 'User berhasil ditambahkan!');
            return back();
        } else {

            Alert::error('Failed', 'User gagal ditambahkan!');
            return back();
        }
    }

    public function show($id)
    {
        $data = User::find($id);

        $role_user = RoleUser::all();
        return view('user.edit')->with([
            'data' => $data,
            'role_user' => $role_user
        ]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => ['required','min:3','max:80','string'],
            'email' => 'required|max:55',
            'phone' => 'numeric',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2000',
            'role_id' => 'required',
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

        if ($request->hasfile('foto')) {
            File::delete(public_path().'/files/users/'. $user->foto);

            $imageName = time().'_'.$request->foto->getClientOriginalName();
            $request->foto->move(public_path('files/users'), $imageName);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password) ?? $user->password;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->foto = $imageName ?? $user->foto;
        $user->role_id = $request->role_id;
        $user->save();

        if ($user) {

            Alert::success('Success', 'User berhasil diupdate!');
            return back();
        } else {

            Alert::error('Failed', 'User gagal diupdate!');
            return back();
        }
    }

    public function destroy($id)
    {
        $id = base64_decode($id);
        $data = User::find($id);

        $namefile = User::where('id', $id)->value('foto');

        if ($namefile) {
            File::delete(public_path().'/files/users/'. $namefile);
        }

        if ($data) {

            $data->delete();

            Alert::success('Success', 'Admin berhasil dihapus!');
            return back();

        } else {

            Alert::error('Failed', 'Admin gagal dihapus!');
            return back();

        }
    }
}
