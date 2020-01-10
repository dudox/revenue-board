@extends('layouts.state')

@section('data')
<?php
$weeklyEntries = \App\Http\Controllers\CardController::allWeeklyEntries()->where('state_id', auth()->user()->state->id)->count();
$agencies = \App\User::where('admin', false)->count();
$totalEntries = auth()->user()->state->entries->count();
$totalCards = \App\Http\Controllers\CardController::getUsedCards(auth()->user());
$weeklyCards = \App\Http\Controllers\CardController::userWeeklyCards(auth()->user());
$weeklyRevenue = \App\Http\Controllers\CardController::allWeeklyEntries()->where('state_id', auth()->user()->state->id)->sum('cost');
$totalRevenue = auth()->user()->state->entries->sum('cost');
?>
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
<div class="container-fluid">
<div class="header-body">
  <!-- Card stats -->
  <div class="row">
    <div class="col-xl-3 col-lg-6">
      <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <h5 class="card-title text-uppercase text-muted mb-0">Total Entries</h5>
              <span class="h2 font-weight-bold mb-0">{{number_format($totalEntries)}}</span>
            </div>
            <div class="col-auto">
              <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                <i class="fas fa-chart-bar"></i>
              </div>
            </div>
          </div>
          <p class="mt-3 mb-0 text-muted text-sm">
            <span class="text-success mr-2">{{number_format($weeklyEntries)}}</span>
            <span class="text-nowrap">This week</span>
          </p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-6">
      <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <h5 class="card-title text-uppercase text-muted mb-0">Batches</h5>
                <span class="h2 font-weight-bold mb-0">{{number_format(auth()->user()->state->batches()->count())}}</span>
            </div>
            <div class="col-auto">
              <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                <i class="fas fa-bell"></i>
              </div>
            </div>
          </div>
          <p class="mt-3 mb-0 text-muted text-sm">
            {{-- <span class="text-primary mr-2">{{number_format(\App\User::where('admin', true)->count())}}</span>
            <span class="text-nowrap">Administrators</span> --}}
            {{-- <a class="btn btn-primary btn-sm text-white disabled"> Request All Analytics Export</a> --}}
          </p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-6">
      <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <h5 class="card-title text-uppercase text-muted mb-0">Generated Cards</h5>
              <span class="h2 font-weight-bold mb-0">{{number_format($totalCards)}}</span>
            </div>
            <div class="col-auto">
              <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                <i class="fas fa-users"></i>
              </div>
            </div>
          </div>
          <p class="mt-3 mb-0 text-muted text-sm">
            <span class="text-info mr-2">{{number_format($weeklyCards)}}</span>
            <span class="text-nowrap">This week</span>
          </p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-6">
      <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <h5 class="card-title text-uppercase text-muted mb-0">Total Revenue</h5>
              <span class="h2 font-weight-bold mb-0">NGN{{number_format($totalRevenue, 2)}}</span>
            </div>
            <div class="col-auto">
              <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                <i class="fas fa-percent"></i>
              </div>
            </div>
          </div>
          <p class="mt-3 mb-0 text-muted text-sm">
            <span class="text-primary mr-2">NGN{{number_format($weeklyRevenue, 2)}}</span>
            <span class="text-nowrap">This week</span>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
@endsection

@section('content')
@include('dashboard.partials.search')
<div class="row">
    <div class="col-xl-12 mb-5 mb-xl-0">
      <div class="card bg-gradient-default shadow">
        <div class="card-header bg-transparent">
          <div class="row align-items-center">
            <div class="col">
              <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6>
              <h2 class="text-white mb-0">Revenue Performance</h2>
            </div>
          </div>
        </div>
        <div class="card-body">
          <!-- Chart -->
          <div class="chart">
            <!-- Chart wrapper -->
            <canvas id="chart-revenue" class="chart-canvas"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br />
  <div class="col">
    <div class="card shadow">
      <div class="card-header border-0">
        <h3 class="mb-0">Entries</h3>
      </div>
      <div class="card-header border-0">
          {{-- <a href="{{route('users.create')}}" class="btn btn-primary text-white">Create State</a> --}}
      </div>
      <div class="table-responsive">
        <table class="table align-items-center table-flush">
          <thead class="thead-light">
            <tr>
              <th scope="col">No</th>
              <th scope="col">Code</th>
              <th scope="col">Value</th>
              {{-- <th scope="col">Status</th> --}}
              <th scope="col">User</th>
              <th scope="col">Phone Number</th>
              <th scope="col">Expiry</th>
            </tr>
          </thead>
          <tbody>
              <?php $count = 1 + $entries->currentPage() * $entries->perPage() - $entries->perPage(); ?>

              @if($entries->count() > 0)
                  @foreach($entries as $entry)

                      <tr>
                          <td>
                              {{$count++}}
                          </td>
                          <th scope="row">
                              <div class="media align-items-center">
                                <div class="media-body">
                                  <span class="mb-0 text-sm">{{$entry->code}}</span>
                                </div>
                              </div>
                            </th>
                            <td>
                                  {{$entry->cost}}
                            </td>
                            {{-- <td>
                              <span class="badge badge-dot mr-4">
                                  @if($entry->active)
                                      <i class='bg-success'></i> active
                                  @else
                                      <i class='bg-warning'></i> disabled
                                  @endif
                              </span>
                            </td> --}}
                            <td>
                              {{$entry->customer_name}}
                            </td>
                            <td>
                              <div class="d-flex align-items-center">
                                {{$entry->customer_phone}}
                                <div>
                                </div>
                              </div>
                            </td>
                            <td class="{{strtotime($entry->expires) < time() ? 'text-danger' : 'text-success'}}">
                                {{date("D, d M Y, h:i A", strtotime($entry->expires))}} ({{strtotime($entry->expires) < time() ? 'Expired' : 'Valid'}})
                            </td>
                      </tr>
                  @endforeach
                  {{ $entries->appends(request()->input())->links() }}
              @endif

              @if($entries->count() < 1)
                  <tr> <td colspan="5" class="text-center"> No Entries Found </td> </tr>
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
  @endsection
  @section('script')
    <script>

        var SalesChart = (function() {

        // Variables

        var $chart = $('#chart-revenue');


        // Methods

        function init($chart) {
        var message = {!! json_encode($entryPerMonth) !!};
        var salesChart = new Chart($chart, {
            type: 'line',
            options: {
            scales: {
                yAxes: [{
                gridLines: {
                    lineWidth: 1,
                    color: Charts.colors.gray[900],
                    zeroLineColor: Charts.colors.gray[900]
                },
                ticks: {
                    callback: function(value) {
                    if (!(value % 10)) {
                        return 'NGN' + value;
                    }
                    }
                }
                }]
            },
            tooltips: {
                callbacks: {
                label: function(item, data) {
                    var label = data.datasets[item.datasetIndex].label || '';
                    var yLabel = item.yLabel;
                    var content = '';

                    if (data.datasets.length > 1) {
                    content += '<span class="popover-body-label mr-auto">' + label + '</span>';
                    }

                    content += '<span class="popover-body-value">NGN' + yLabel + '</span>';
                    return content;
                }
                }
            }
            },
            data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Performance',
                data: message
            }]
            }
        });

        // Save to jQuery object

        $chart.data('chart', salesChart);

        };


        // Events

        if ($chart.length) {
        init($chart);
        }

        })();
    </script>
  @endsection
