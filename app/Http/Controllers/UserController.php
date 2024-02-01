<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $listUsers = User::all();
        return view('kelolauser.index', compact('listUsers'));
    }

    public function add(Request $request)
    {
        $user = $request->post();
        return view('kelolauser.add', compact('user'));
    }

    public function save(Request $request)
    {
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;

        $user->save();

        return Redirect::route('kelolauser')->with('success', 'Sukses menambahkan Data!');
    }

    public function edit($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            return Redirect::route('kelolauser')->with('error', 'Gagal Mendapatkan Data!');
        }
        return view('kelolauser.edit', compact('user'));
    }

    public function update($id, Request $request)
    {
        $user = User::find($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password =  Hash::make($request->password);
        $user->role = $request->role;

        $user->save();

        return Redirect::route('kelolauser')->with('success', 'Sukses update Data!');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();

        return Redirect::route('kelolauser')->with('success', 'Sukses Hapus Data!');
    }
}
