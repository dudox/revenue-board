<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;
use App\User;
class UserController extends Controller
{
    //
    public function create()
    {
        $states = State::where('user_id', null)->get();
        return view('admin.users.create')->with('states', $states);
    }

    public function store(Request $request)
    {
        $pin = rand(122256, 999999);

        $create = User::create([
           'name'  => $request->name,
           'email'  => $request->email,
           'pin'  => $pin,
           'password'  => \Hash::make($pin),
           'active' => 1,
        ]);

        $state = State::find($request->state);

        $state->update([
            'user_id' => $create->id,
        ]);

        return redirect()->route('users');
    }

    public function show(User $user)
    {
        return view('admin.users.edit')->with('user', $user);
    }

    public function resetPassword(User $user)
    {
        $pin = rand(122256, 999999);

        $user->update([
           'pin'  => $pin,
           'password'  => \Hash::make($pin),
        ]);

        return redirect()->route('users.show', $user->id)->with('message', 'New user Pin ' . $pin);
    }

    public function activate(User $user)
    {
        $user->update([
           'active'  => 1,
        ]);

        return redirect()->route('users.show', $user->id)->with('message', 'User Activated ');
    }

    public function ban(User $user)
    {
        $user->update([
           'active'  => 0,
        ]);

        return redirect()->route('users.show', $user->id)->with('message', 'User disabled');
    }
}
