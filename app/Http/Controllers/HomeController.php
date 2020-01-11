<?php

namespace App\Http\Controllers;

use App\Entry;
use App\Export;
use App\Screen;
use App\State;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $earners = State::with('entries')->get()->sortBy(function($earner)
        {
            return $earner->entries->count();
        },  $options = SORT_REGULAR, $descending = true);

        // dd($earners);

        $screenOne = Screen::where('type', 1)->first();
        $screenTwo = Screen::where('type', 2)->first();
        return view('admin.index')
            ->with('screenOne', $screenOne)
            ->with('screenTwo', $screenTwo)
            ->with('earners', $earners);
    }

    public function commission()
    {

        $inputs = auth()->user()->state->entries();
        $john = auth()->user()->state->entries();

        if(request('from') && request('to')) {
            $now = new Carbon(request('from'));
            $later = new Carbon(request('to'));
            $inputs->whereBetween('created_at', [$now->format('Y-m-d')." 00:00:00", $later->format('Y-m-d')." 23:59:59"]);
            $john->whereBetween('created_at', [$now->format('Y-m-d')." 00:00:00", $later->format('Y-m-d')." 23:59:59"]);
        }

        if(request('batch')) {
            $inputs->where('batch_id', request('batch'));
            $john->where('batch_id', request('batch'));
        }

        if(request('denomination')) {
            $inputs->where('denomination_id', request('denomination'));
            $john->where('denomination_id', request('denomination'));
        }

        $entryPerMonth= array();
        // dd($inputs->whereMonth('created_at', "12")->sum("cost"));
        for ($i=1; $i<=12; $i++){
            $h[] = (string)$i;
            $entryPerMonth[] = $inputs->whereMonth('created_at', (string)$i)->sum("cost");
        }
        dd($entryPerMonth, $h);


        $entries = $john->paginate(20);

        return view('dashboard.index')
            ->with('entryPerMonth', $entryPerMonth)
            ->with('entries', $entries);
    }

    public function users()
    {
        $users = User::where('admin', 0)->paginate(10);
        return view('admin.users.index')
            ->with('users', $users);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }

    public function exports()
    {
        $exports = auth()->user()->exports()->paginate(20);
        $check = auth()->user()->exports()->where('status', 0)->first();
        $batches = auth()->user()->state->batches;
        return view('dashboard.exports.index')->with('exports', $exports)->with('batches', $batches)->with('check', $check);
    }

    public function requestAllExport()
    {
        $check = auth()->user()->exports()->where('status', 0)->first();
        if($check) return back()->with('error', 'Pending export exists');
        Export::create([
            'type' => 'all',
            'user_id' => auth()->user()->id,
        ]);

        return back()->with('message', 'Export requested successfully');
    }
}
