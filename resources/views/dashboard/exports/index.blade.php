@extends('layouts.state')

@section('content')
<br />
<br />
<br />
<br />
@if(!$check)
<div class="row">
    <div class="col">
        <div class="row justify-content-center">
          <div class="col-lg-5 col-md-7">
            <div class="card bg-secondary shadow border-0">
              <div class="card-header bg-transparent">
                <div class="text-muted text-center"><h4>Request Analytics export</h4></div>
              </div>
              <div class="text-center">
                <a href="{{route('commission.exports.make')}}" class="btn btn-primary my-4 text-white">Export All Analytics</a>
              </div>
              <div class="card-body px-lg-5 py-lg-5">
                <form role="form" method="POST" action="{{route('users.store')}}">
                    @csrf
                  <div class="form-group">
                    <div class="input-group input-group-alternative">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-pin-3"></i></span>
                      </div>
                      <select class="form-control" name="state" required>
                        <option value="">
                            Select Batch
                        </option>
                        @if($batches->count() > 0)
                            @foreach($batches as $batch)
                                <option value="{{$batch->id}}">
                                    {{$batch->name}}
                                </option>
                            @endforeach
                        @else
                        @endif
                      </select>
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary my-4">Request Batch Export</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
@else
<br />
<div class="text-center">

    <h4> Pending Export Request </h4>
</div>
@endif

<br />
<div class="row">
    <div class="col">
      <div class="card shadow">
        <div class="card-header border-0">
          <h3 class="mb-0">Export Requests</h3>
        </div>
        <div class="card-header border-0">
            {{-- <a href="{{route('users.create')}}" class="btn btn-primary text-white">Create export</a> --}}
        </div>
        <div class="table-responsive">
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Type</th>
                <th scope="col">Batch</th>
                {{-- <th scope="col">Denomination</th> --}}
                <th scope="col">Status</th>
                <th scope="col"> Date</th>
              </tr>
            </thead>
            <tbody>
                <?php $count = 1 + $exports->currentPage() * $exports->perPage() - $exports->perPage(); ?>
                @if($exports->count() > 0)
                    @foreach($exports as $export)
                        <?php
                            $cards = App\Http\Controllers\CardController::getStateUsedCards($export);
                            $entries = App\Http\Controllers\CardController::getStateCustomerEntries($export);

                            if ( in_array($cards, range(0, 39)) ) {
                                $style = 'warning';
                            }

                            if ( in_array($cards, range(40, 49)) ) {
                                $style = 'primary';
                            }

                            if ( in_array($cards, range(50, 69)) ) {
                                $style = 'info';
                            }

                            if ( in_array($cards, range(70, 100)) ) {
                                $style = 'success';
                            }
                        ?>

                        <tr>
                            <td>
                                {{$count++}}
                            </td>
                            <th scope="row">
                                <div class="media align-items-center">
                                  <div class="media-body">
                                    @if($export->type == 'all')
                                    <button class="btn btn-white text-success btn-sm">All</button>
                                    @else
                                    <button class="btn btn-white text-info btn-sm">Batch</button>
                                    @endif
                                  </div>
                                </div>
                              </th>
                              <td>
                                    {{$export->batch->name ?? '-'}}
                              </td>
                              <td>
                                  @if($export->status)
                                  <span class="text-success">Completed</span>
                                  @else
                                  <span class="text-warning">Pending</span>
                                  @endif
                              </td>
                              <td>
                                <div class="d-flex align-items-center">
                                  <span class="mr-2">{{date("D, d M, Y, h:i A", strtotime($export->created_at))}}</span>
                                  <div>
                                  </div>
                                </div>
                              </td>
                        </tr>
                    @endforeach
                    {{ $exports->appends(request()->input())->links() }}
                @endif

                @if($exports->count() < 1)
                    <tr> <td colspan="5" class="text-center"> No Exports Found </td> </tr>
                @endif
            </tbody>
          </table>
        </div>
        <div class="card-footer py-4">
          <nav aria-label="...">

          </nav>
        </div>
      </div>
    </div>
  </div>

@endsection
