<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Denomination;
use App\Duration;
use App\Http\Requests\Admin\Batches\CreateBatch;
use App\Http\Requests\Admin\Batches\CreateDenomination;
use App\State;
use App\User;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(State $state)
    {
        //
        return view('admin.batches.addBatch')->with('state', $state);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBatch $request)
    {
        //
        Batch::create([
            'name' => $request->name,
            'description' => $request->description,
            'state_id' => $request->state,
        ]);
        return back()->with('message', 'Batch created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function show(Batch $batch)
    {
        $durations = Duration::all();
        return view('admin.batches.view')->with('batch', $batch)->with('durations', $durations);
    }

    public function storeDenominations(CreateDenomination $request)
    {
        $check = Denomination::where('cost', number_format($request->cost, 2))->where('description', $request->description)->first();
        if($check) return back();
        Denomination::create([
            'batch_id' => $request->batch,
            'cost' => $request->cost,
            'description' => $request->description,
            'duration_id' => $request->duration,
            'identifier' => strtoupper(substr(uniqid(), 0, 8)),
        ]);

        return back()->with('message', 'Denomination created successfully');
    }

    public function getDenominations(Batch $batch)
    {
        return response()->json(['success' => $batch->denominations]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function edit(Batch $batch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Batch $batch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Batch $batch)
    {
        //
    }

    public function make()
    {

    }

    public function registerToken()
    {
        if(Auth()->user() && Auth()->user()->token == null){
            $user = User::find(Auth()->user()->id);
            $user->update([
                'token' => $this->returnToken(Auth()->user())
            ]);
        }
    }

    protected function returnToken($user, $lifetime = 730)
    {

        // return \BDToken::make($user, $lifetime);
    }
}
