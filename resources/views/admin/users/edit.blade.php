@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col">
      <div class="card shadow text-center">
        <div class="card-header border-0">
          <h3 class="mb-0">{{$user->name}}</h3>
          <p class="mb-0">Email: {{$user->email}}</p>
          <p class="mb-0">Pin: {{$user->pin}}</p>
          <p class="mb-0">Created On: {{date("D, d M Y h:i A", strtotime($user->created_at))}}</p>
        </div>
        <div class="card-header border-0">
            {{-- <a href="{{route('users.create')}}" class="btn btn-primary text-white">Create State</a> --}}
        </div>
        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
              <div class="card bg-secondary shadow border-0">
                <div class="card-header bg-transparent pb-5">
                    @if($user->state)
                        <a href="{{route('states.show', $user->state->id)}}" class="btn btn-info"> {{$user->state->name}} <span class="fa fa-arrow-right"> </span> </a>
                    @else
                        <p> No state assigned </p>
                    @endif
                </div>
                <div class="card-body px-lg-5 py-lg-5">
                    @if(session('message'))
                        <p class="text-success">{{session('message')}}</p>
                    @endif
                  <form role="form" method="POST" action="{{route('users.password.reset', $user->id)}}">
                      @csrf
                    <div class="text-center">
                      <button type="submit" class="btn btn-primary my-4">Set New Pin</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer py-4">
          <nav aria-label="...">

          </nav>
        </div>
      </div>
    </div>
  </div>

@endsection
