@extends('layouts.admin')

@section('content')

  <div class="row mt-5">
    <div class="col-xl-12 mb-5 mb-xl-0" style="margin-bottom: 2em;">
      <div class="card shadow">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col">
              <h3 class="mb-0">Manage Welcome Screen</h3>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          {{-- Form to manage welcome screen --}}
          <div class="row justify-content-center">
            <div class="col-lg-10 col-md-10">
              <div class="card bg-secondary shadow border-0">
                <div class="card-header bg-transparent pb-5">
                  <div class="text-muted text-center mt-2 mb-3"><h4>Manage Welcome Screen Messages</h4></div>
                </div>
                <div class="card-body px-lg-5 py-lg-5">
                  <form role="form" method="POST" action="{{route('settings.welcome.update')}}">
                      @csrf
                      <div class="form-group mb-3">
                          <div class="input-group input-group-alternative">
                          <div class="input-group-prepend">
                              <span class="input-group-text"><i>1</i></span>
                          </div>
                          <input class="form-control" placeholder="First Option" type="text" name="first" value="{{$screenOne->message}}" required>
                          </div>
                      </div>
                    <div class="form-group mb-3">
                      <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i>2</i></span>
                        </div>
                        <input class="form-control" placeholder="Second option" type="text" name="second" value="{{$screenTwo->message}}" required>
                      </div>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-primary my-4">Update Start Screens</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br />
    <br />
    <div class="col-xl-12">
      <div class="card shadow">
        <div class="card-header border-0">
          <div class="row align-items-center">
            <div class="col">
              <h3 class="mb-0">States Revenue Performance</h3>
            </div>
            {{-- <div class="col text-right">
              <a href="#!" class="btn btn-sm btn-primary">See all</a>
            </div> --}}
          </div>
        </div>
        <div class="table-responsive">
          <!-- Projects table -->
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col">No</th>
                <th scope="col">State</th>
                <th scope="col">Revenue</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
                <?php $entries = \App\Entry::sum('cost'); $count = 1;?>
            @if($earners->count() > 0)
              @foreach($earners as $earner)
              <?php
                if($earner->entries()->sum('cost') > 0) {
                    $percent = ($earner->entries()->sum('cost') / $entries) * 100;
                }
                else {
                    $percent = 0;
                }
                ?>
              <tr>
                <th scope="row">
                    {{$count}}
                </th>
                <th scope="row">
                  {{$earner->name}}
                </th>
                <td>
                  {{number_format($earner->entries()->sum('cost'), 2)}}
                </td>
                <td>
                  <div class="d-flex align-items-center">
                    <span class="mr-2">{{number_format($percent)}}%</span>
                    <div>
                      <div class="progress">
                        <div class="progress-bar bg-gradient-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{$percent}}%;"></div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              <?php $count++; ?>
              @endforeach
            @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
