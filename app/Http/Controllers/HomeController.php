<?php

namespace App\Http\Controllers;

use App\Entry;
use App\Export;
use App\Http\Filters\FilterEntries;
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
        // $earners = State::with('entries')->get()->sortBy(function($earner)
        // {
        //     return $earner->entries->count();
        // },  $options = SORT_REGULAR, $descending = true);

        $earners = State::with('entries')->orderBy('name', 'ASC')->get();
        // dd($earners);

        $screenOne = Screen::where('type', 1)->first();
        $screenTwo = Screen::where('type', 2)->first();
        return view('admin.index')
            ->with('screenOne', $screenOne)
            ->with('screenTwo', $screenTwo)
            ->with('earners', $earners);
    }

    public function commission(FilterEntries $filter)
    {
        $entryPerMonth= array();
        for ($i=1; $i<=12; $i++){
            if(strlen($i) < 2) {
                $a = '0'.$i;
            }
            else {
                $a = $i;
            }
            $entryPerMonth[] = Entry::filter($filter)->where('state_id', auth()->user()->state->id)->whereMonth('created_at', (string)$a)->sum('cost');
        }


        $entries = Entry::filter($filter)->where('state_id', auth()->user()->state->id)->paginate(20);

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
