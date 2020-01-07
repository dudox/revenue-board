@extends('layouts.admin')
@section('style')

@endsection
<style>
    .loading {
    border: 16px solid #f3f3f3; /* Light grey */
    border-top: 16px solid #3498db; /* Blue */
    border-radius: 50%;
    width: 120px;
    height: 120px;
    animation: spin 2s linear infinite;
    margin-left: auto;
    margin-right: auto;
    display: inline-block;
  }

  .overlay {
    z-index: 1000;
    width: 100%;
    height: 100%;
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
</style>
@section('content')
<div class="row">
    <div class="col">
      <div class="card shadow">
        <div class="card-header border-0">
          <h3 class="mb-0">{{$denomination->cost}}</h3>
          {{-- <h5 class="mb-0">Card Denominations</h5> --}}
          <br />
        </div>
        <div class="table-responsive"  id="t-content">
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Code</th>
                <th scope="col">Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                <?php
                    $count = 1 + $cards->currentPage() * $cards->perPage() - $cards->perPage();
                ?>
                @if($cards->count() > 0)
                    @foreach($cards as $card)
                        <tr>
                            <td>
                                {{$count++}}
                            </td>
                            <th scope="row">
                                <div class="media align-items-center">
                                  <div class="media-body">
                                    <span class="mb-0 text-sm">{{$card->code}}</span>
                                  </div>
                                </div>
                              </th>
                              {{-- <td>
                                <span class="badge badge-dot mr-4">
                                    @if($denomination->active)
                                        <i class='bg-success'></i> active
                                    @else
                                        <i class='bg-warning'></i> disabled
                                    @endif
                                </span>
                              </td> --}}
                              <td>
                                @if($card->status)
                                    <span class="mb-0 text-danger">Used</span>
                                @else
                                    <span class="mb-0 text-success">Valid</span>
                                @endif
                              </td>
                        </tr>
                    @endforeach
                    {{ $cards->appends(request()->input())->links() }}
                @endif

                @if($cards->count() < 1)
                    <tr> <td colspan="5" class="text-center"> No Cards Found </td> </tr>
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
@section('script')
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<script>
    function exports(id){
        document.getElementById('t-content').innerHTML =
            `<div class='col-md-6 offset-3 row justify-content-center'><div class='loading'></div><p class='text-center'> Exporting NGN${id} cards... </p></div>`;
        // document.getElementById('t-content').innerHTML = "";
    }
</script>
@endsection
