@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col">
      <div class="card shadow">
        <div class="card-header border-0">
          <h3 class="mb-0">States</h3>
        </div>
        <div class="card-header border-0">
            {{-- <a href="{{route('users.create')}}" class="btn btn-primary text-white">Create State</a> --}}
        </div>
        <div class="table-responsive">
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col">No</th>
                <th scope="col">State</th>
                <th scope="col">User</th>
                {{-- <th scope="col">Status</th> --}}
                <th scope="col">Used Cards</th>
                <th scope="col">Total Cards</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
                <?php $count = 1 + $states->currentPage() * $states->perPage() - $states->perPage(); ?>
                @if($states->count() > 0)
                    @foreach($states as $state)
                        <?php
                            $cards = App\Http\Controllers\CardController::getStateUsedCards($state);
                            $entries = App\Http\Controllers\CardController::getStateCustomerEntries($state);

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
                                    <span class="mb-0 text-sm">{{$state->name}}</span>
                                  </div>
                                </div>
                              </th>
                              <td>
                                    @if($state->user)
                                        {{$state->user->name}}
                                    @else
                                        Not Assigned
                                    @endif
                              </td>
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
                                {{$entries}}
                              </td>
                              <td>
                                <div class="d-flex align-items-center">
                                  <span class="mr-2">{{$cards}}</span>
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
                                    <a class="dropdown-item text-info" href="#">View</a>
                                    <a class="dropdown-item text-warning" href="#">Ban</a>
                                    {{-- <a class="dropdown-item text-danger" href="#">Delete</a> --}}
                                  </div>
                                </div>
                              </td>
                        </tr>
                    @endforeach
                    {{ $states->appends(request()->input())->links() }}
                @endif

                @if($states->count() < 1)
                    <tr> <td colspan="5" class="text-center"> No States Found </td> </tr>
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
