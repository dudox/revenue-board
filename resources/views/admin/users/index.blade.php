@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col">
      <div class="card shadow">
        <div class="card-header border-0">
          <h3 class="mb-0">State Revenue Boards</h3>
        </div>
        <div class="card-header border-0">
            <a href="{{route('users.create')}}" class="btn btn-primary text-white">Create User</a>
        </div>
        <div class="table-responsive">
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Revenue Board</th>
                {{-- <th scope="col">State</th> --}}
                <th scope="col">Status</th>
                <th scope="col">Used Cards</th>
                {{-- <th scope="col">Total Cards</th> --}}
                <th scope="col">Revenue Generated</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
                <?php $count = 1 + $users->currentPage() * $users->perPage() - $users->perPage(); ?>
                @if($users->count() > 0)
                    @foreach($users as $user)
                        <?php
                            $cards = App\Http\Controllers\CardController::getUsedCards($user);
                            $entries = App\Http\Controllers\CardController::getCustomerEntries($user);

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
                                    <span class="mb-0 text-sm">{{$user->name}}</span>
                                  </div>
                                </div>
                              </th>
                              {{-- <td>
                                    @if($user->state)
                                        {{$user->state->name}}
                                    @else
                                        Not Assigned
                                    @endif
                              </td> --}}
                              <td>
                                <span class="badge badge-dot mr-4">
                                    @if($user->active)
                                        <i class='bg-success'></i> active
                                    @else
                                        <i class='bg-warning'></i> disabled
                                    @endif
                                </span>
                              </td>
                              <td>
                                {{number_format($entries)}}
                              </td>
                              {{-- <td>
                                <div class="d-flex align-items-center">
                                  <span class="mr-2">{{number_format($cards)}}</span>
                                  <div>
                                  </div>
                                </div>
                              </td> --}}
                              <td>
                                <div class="d-flex align-items-center">
                                  <span class="mr-2">NGN {{number_format($user->state->entries()->sum('cost'), 2)}}</span>
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
                                    <a class="dropdown-item text-info" href="{{route('users.show', $user->id)}}">View</a>
                                    @if($user->active)
                                        <a class="dropdown-item text-warning" href="{{route('users.ban', $user->id)}}">Ban</a>
                                    @else
                                        <a class="dropdown-item text-success" href="{{route('users.activate', $user->id)}}">Activate</a>
                                    @endif
                                  </div>
                                </div>
                              </td>
                        </tr>
                    @endforeach
                    {{ $users->appends(request()->input())->links() }}
                @endif

                @if($users->count() < 1)
                    <tr> <td colspan="5" class="text-center"> No Users Found </td> </tr>
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
