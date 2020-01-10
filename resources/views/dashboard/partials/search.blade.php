<?php
$states = auth()->user()->state->batches;
// dd($states);
?>

<div class="row pb-1">
    <div class="col-xl-6 col-lg-6 offset-3">
        <div class="card card-stats mb-4">
        <div class="card-body">
            {{-- <div class="row col-xl-12"> --}}
                <form>
                    <div class="row">
                        <h4 class="">
                            Filter Analytics
                        </h4>
                    </div>
                    <div class="row">
                        <input type="date" class="form-control col-md-5" name="from"  style="margin: 1.5em;" placeholder=""/>
                        <input type="date" class="form-control col-md-5" name="to"  style="margin: 1.5em;" placeholder=""/>
                    </div>
                    <div class="row">
                        <select class="form-control col-md-5" name="batch"  style="margin: 1.5em;">
                            <option value="">
                                Select Batch
                            </option>

                            @if($states->count() > 0)
                                @foreach($states as $state)
                                    <option value="{{$state->id}}">
                                        {{$state->name}}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <select class="form-control col-md-5" name="denomination"  style="margin: 1.5em;">
                            <option value="">
                                Select Denomination
                            </option>
                        </select>
                    </div>
                    <div class="row text-center" style="margin-top: 1em; margin-left: 12em;">
                        <button class="btn btn-primary mb-2">
                            Filter Analytics
                        </button>
                    </div>
                </form>
            {{-- </div> --}}
        </div>
        </div>
    </div>
</div>
