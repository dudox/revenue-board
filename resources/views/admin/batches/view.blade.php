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
          <h3 class="mb-0">{{$batch->name}}</h3>
          {{-- <h5 class="mb-0">Card Denominations</h5> --}}
          <p>{{$batch->description}}</p>
          <br />
          <div class="row">
            <form class="col-md-6" role="form" method="POST" action="{{route('denominations.store')}}">
                @csrf
                @if(session('message'))
                    <p class="text-success">{{session('message')}}</p>
                @endif
                <div class="form-group mb-3">
                <div class="input-group input-group-alternative">
                  <input class="form-control" placeholder="Enter Cost Value" type="number" name="cost" required>
                  <input value="{{$batch->id}}" type="hidden" name="batch" required>
                </div>
                <div class="input-group input-group-alternative">
                    <select class="form-control" name="duration" required>
                        <option value="">
                            Select Duration
                        </option>
                        @if($durations->count() > 0)
                            @foreach($durations as $duration)
                                <option value="{{$duration->id}}">
                                    {{$duration->name}}
                                </option>
                            @endforeach
                        @else
                        @endif
                    </select>
                </div>
                <div class="input-group input-group-alternative">
                    <textarea class="form-control" placeholder="Enter Description" name="description" required></textarea>
                </div>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary my-4">Create Denomination</button>
              </div>
            </form>
            <div class="col-md-6 row justify-content-center" id='cardsgenerator' data-batch="{{ $batch->id }}" data-url="{{ env('APP_URL') }}" >

            </div>
          </div>
        </div>
        <div class="table-responsive"  id="t-content">
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Cost</th>
                <th scope="col">Validity Period</th>
                <th scope="col">Used Cards</th>
                <th scope="col">Total Cards</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                <?php
                    $batches = $batch->denominations()->paginate(20);
                    $count = 1 + $batches->currentPage() * $batches->perPage() - $batches->perPage();
                ?>
                @if($batches->count() > 0)
                    @foreach($batches as $denomination)
                        <tr>
                            <td>
                                {{$count++}}
                            </td>
                            <th scope="row">
                                <div class="media align-items-center">
                                  <div class="media-body">
                                    <span class="mb-0 text-sm">{{$denomination->cost}}</span>
                                  </div>
                                </div>
                              </th>
                              <td>
                                {{$denomination->duration->name}}
                              </td>
                              <td>
                                {{number_format($denomination->entries()->count())}}
                              </td>
                              <td>
                                <div class="d-flex align-items-center">
                                  <span class="mr-2">{{number_format($denomination->cards()->count())}}</span>
                                  <div>
                                  </div>
                                </div>
                              </td>
                              <td class="text-right">
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-info" href="{{route('cards.show', $denomination->id)}}">View</a>
                                    {{-- Export component here --}}
                                    {{-- <span class="exportcards btn btn-sm btn-primary" onclick="exports({{$denomination->id}})">
                                        Export
                                    </span> --}}
                                    <a class="btn btn-sm btn-primary" onclick="exports({{$denomination->cost}})" href="{{url('/api/denominations/export')}}/{{$batch->id}}/{{$denomination->id}}">Export</a>
                                    {{-- <a class="dropdown-item text-danger" href="#">Delete</a> --}}
                                </div>
                              </td>
                        </tr>
                    @endforeach
                    {{ $batches->appends(request()->input())->links() }}
                @endif

                @if($batches->count() < 1)
                    <tr> <td colspan="5" class="text-center"> No Denominations Found </td> </tr>
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
