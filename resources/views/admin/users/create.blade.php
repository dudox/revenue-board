@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col">
            <div class="row justify-content-center">
              <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary shadow border-0">
                  <div class="card-header bg-transparent pb-5">
                    <div class="text-muted text-center mt-2 mb-3"><h4>Register a revenue commission</h4></div>
                  </div>
                  <div class="card-body px-lg-5 py-lg-5">
                    <form role="form" method="POST" action="{{route('users.store')}}">
                        @csrf
                        <div class="form-group mb-3">
                            <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-building"></i></span>
                            </div>
                            <input class="form-control" placeholder="Commission Name" type="text" name="name" required>
                            </div>
                        </div>
                      <div class="form-group mb-3">
                        <div class="input-group input-group-alternative">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                          </div>
                          <input class="form-control" placeholder="Email" type="email" name="email" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="input-group input-group-alternative">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-pin-3"></i></span>
                          </div>
                          <select class="form-control" name="state" required>
                            <option value="">
                                Select State
                            </option>
                            @if($states->count() > 0)
                                @foreach($states as $state)
                                    <option value="{{$state->id}}">
                                        {{$state->name}}
                                    </option>
                                @endforeach
                            @else
                            @endif
                          </select>
                        </div>
                      </div>
                      <div class="text-center">
                        <button type="submit" class="btn btn-primary my-4">Create Commission</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div>
@endsection
