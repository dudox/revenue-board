@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col">
            <div class="row justify-content-center">
              <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary shadow border-0">
                  <div class="card-header bg-transparent pb-5">
                    <div class="text-muted text-center mt-2 mb-3"><h4>Create new cards batch</h4></div>
                  </div>
                  <div class="card-body px-lg-5 py-lg-5">
                    <form role="form" method="POST" action="{{route('batches.store')}}">
                        @if(session('message'))
                            <p class="text-center text-success">{{session('message')}}</p>
                        @endif
                        @csrf
                        <div class="form-group mb-3">
                            <div class="input-group input-group-alternative">
                            <input class="form-control" placeholder="Batch Name" type="text" name="name" required>
                            <input type="hidden" name="state" value="{{$state->id}}" required>
                            </div>
                        </div>
                      <div class="form-group mb-3">
                        <div class="input-group input-group-alternative">
                          <textarea class="form-control" placeholder="Batch Description" name="description" required></textarea>
                        </div>
                      </div>
                      <div class="text-center">
                        <button type="submit" class="btn btn-primary my-4">Create Batch</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div>
@endsection
