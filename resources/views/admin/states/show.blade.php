@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col">
      <div class="card shadow">
        <div class="card-header border-0">
          <h3 class="mb-0">{{$state->name}}</h3>
          <h5 class="mb-0">Card Batches</h5>
          <br />
          <a href="{{route('batches.create', $state->id)}}" class="btn btn-primary text-white">Add Batch </a>
        </div>
        <div class="card-header border-0">
            {{-- <a href="{{route('users.create')}}" class="btn btn-primary text-white">Create State</a> --}}
        </div>
        <div class="table-responsive">
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Name</th>
                <th scope="col">Used Cards</th>
                <th scope="col">Total Cards</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                <?php
                    $batches = $state->batches()->paginate(20);
                    $count = 1 + $batches->currentPage() * $batches->perPage() - $batches->perPage();
                ?>
                @if($batches->count() > 0)
                    @foreach($batches as $batch)
                        <tr>
                            <td>
                                {{$count++}}
                            </td>
                            <th scope="row">
                                <div class="media align-items-center">
                                  <div class="media-body">
                                    <span class="mb-0 text-sm">{{$batch->name}}</span>
                                  </div>
                                </div>
                              </th>
                              {{-- <td>
                                <span class="badge badge-dot mr-4">
                                    @if($state->active)
                                        <i class='bg-success'></i> active
                                    @else
                                        <i class='bg-warning'></i> disabled
                                    @endif
                                </span>
                              </td> --}}
                              <td>
                                {{$batch->entries()->count()}}
                              </td>
                              <td>
                                <div class="d-flex align-items-center">
                                  <span class="mr-2">{{$batch->cards()->count()}}</span>
                                  <div>
                                  </div>
                                </div>
                              </td>
                              <td class="text-right">
                                <div class="dropdown">
                                  <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                  </a>
                                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item text-info" href="{{route('batches.show', $batch->id)}}">View</a>
                                    {{-- <a class="dropdown-item text-warning" href="#">Ban</a> --}}
                                    {{-- <a class="dropdown-item text-danger" href="#">Delete</a> --}}
                                  </div>
                                </div>
                              </td>
                        </tr>
                    @endforeach
                    {{ $batches->appends(request()->input())->links() }}
                @endif

                @if($batches->count() < 1)
                    <tr> <td colspan="5" class="text-center"> No Batches Found </td> </tr>
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
