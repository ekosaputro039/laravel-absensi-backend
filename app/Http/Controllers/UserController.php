<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //index
    public function index()
    {
        $users = User::where('name', 'like', '%'. request('name') . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.users.index', compact('users'));
        // $users = DB::table('users')
        // ->when($request->input('name'), function($query, $name) {
        //     return $query->where('name', 'like', '%' . $name . '%');
        // })
        // ->orderBy('id', 'desc');
        // ->paginate(10);
        // return view('pages.users.index', compact('users'));
    }

    //create
    public function create()
    {
        return view('pages.users.create');
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'role' => 'required',
            'password' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password'=> Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'user create is successfully');
    }

    //show
    public function show(User $user)
    {
        // $user = User::find($user);
        return view('pages.users.show', compact('user'));
    }

    //edit
    public function edit(User $user)
    {
        // $user = User::find($user);
        return view('pages.users.edit', compact('user'));
    }

    //update
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'role' => 'required',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        if ($request->password) {
            $user->update([
                'password' =>Hash::make($request->password),
            ]);
        }
        return redirect()->route('users.index')->with('success', 'user update is successfully');
    }

    //desrtoy
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted is successfully');
    }
}
