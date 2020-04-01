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

    public function deleteAnalytics(State $state)
    {
        if(!request('confirm') || request('confirm') !== 'confirm') return back()->with('error', 'Please input confirm to acknowledge action');
        $this->deleteRecords($state);
        return back()->with('message', 'All analytics cleared');
    }

    public function deleteRecords($state) {
        foreach($state->batches as $batch) {
            $batch->denominations()->delete();
            $batch->entries()->delete();
            $batch->cards()->delete();
            $batch->delete();
        }
        if($state->user) {
            if($state->user->exports) {
                $state->user->exports()->delete();
            }
        }
    }

    public function clearAllAnalytics()
    {
        if(!request('confirm') || request('confirm') !== 'confirm') return back()->with('error', 'Please input confirm to acknowledge action');
        $allStates = State::all();
        foreach($allStates as $state) {
            $this->deleteRecords($state);
        }
        User::where('admin', 0)->delete();
        State::whereNotNull('user_id')->update(['user_id' =>  null]);
        return back()->with('message', 'All Records cleared');
    }
}
