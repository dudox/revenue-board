@extends('layouts.admin')

@section('content')
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
                <th scope="col">User</th>
                <th scope="col">Type</th>
                <th scope="col">Batch</th>
                {{-- <th scope="col">Denomination</th> --}}
                <th scope="col">Status</th>
                <th scope="col"> Date</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
                <?php $count = 1 + $exports->currentPage() * $exports->perPage() - $exports->perPage(); ?>
                @if($exports->count() > 0)
                    @foreach($exports as $export)
                        <tr>
                            <td>
                                {{$count++}}
                            </td>
                            <td>
                                {{$export->user->name ?? '-'}}
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
                            <td>
                                @if($export->status)
                                    <a class="btn btn-primary btn-sm text-white disabled"> Completed </a>
                                @else
                                    @if($export->type == 'all')
                                        <a href="{{route('exports.state', $export->user->state->id)}}" class="btn btn-primary btn-sm text-white"> Export </a>
                                    @else
                                        <a href="{{route('exports.batch', ['state' => $export->user->state->id, 'batch' => $export->batch_id])}}" class="btn btn-primary btn-sm text-white"> Export </a>
                                    @endif
                                @endif
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
