@extends('layouts.legal.legalApp')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10" style="font-size: 13px">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h6 style="background: darkslateblue; color: orange; padding:15px; border-radius: 3px">Welcome {{Auth::user()->name}} <span class="fa fa-user-circle"></span></h6>
                        <div class="mt-4">
                            <div class="row">
                                <div class="col-md-7">
                                    <h6 class="font-weight-bold"> <span class="fa fa-tags"></span>News and Notices</h6>
                                    <hr>
                                    @foreach($attentionItems as $item)
                                        <div class="alert alert-warning alert-dismissible">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <strong>Warning!</strong> {{$item}}
                                        </div>
                                    @endforeach
                                </div>
{{--                                <div class="col-md-5">--}}
{{--                                    <h6 class="text-center"> <span class="fa fa-tags"></span>Contracts Outlook</h6>--}}
{{--                                    <hr>--}}
{{--                                    <div class="text-center" style="width: 250px; height: 250px; text-align: center !important;">--}}
{{--                                        <canvas id="contracts-overview" width="350"></canvas>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>

                        </div>

                        <div class="mt-4">
                            @if(count($expiringContracts) > 0)
                            <h6 class="font-weight-bold"> <span class="fa fa-tags"></span>Expiring Contracts</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Title</th>
                                        <th>Expires on</th>
                                        <th>Action</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php $counter =1 ?>
                                            @foreach($expiringContracts as $contract)
                                                    <tr>
                                                        <td>{{$counter}}</td>
                                                        <td>{{$contract->title}}</td>
                                                        <td>
                                                            {{date('d-F-Y', strtotime($contract->expiry_date))}} ({{\App\Models\Contract::getExpiredDays($contract->id)}} days)
                                                        </td>
                                                        <td>
                                                            <a href="{{route('contracts.show',$contract->id)}}" class="" >Open</a> &nbsp;
                                                            <a href="{{route('contracts.download',$contract->id)}}" class="" target="_blank">Download</a>
                                                        </td>
                                                        @if(\App\Models\Contract::getExpiredDays($contract->id) < 7)
                                                            <td class="text-danger"> <span class="fa fa-exclamation-circle"></span></td>
                                                        @else
                                                            <td class="text-warning"> <span class="fa fa-exclamation-circle"></span></td>
                                                        @endif
                                                    </tr>
                                                <?php ++$counter ?>
                                            @endforeach

                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        new Chart(document.getElementById("contracts-overview"), {
            type: 'pie',
            data: {
                labels: ["CAM", "CCL", "CPS", "CHL"],
                datasets: [{
                    label: "Population (millions)",
                    backgroundColor: ["#FAA916", "#8e5ea2","#3cba9f","#e8c3b9"],
                    data: [{{$summary['CAM']??0}},{{$summary['CCL']??0}},{{$summary['CPS']??0}},{{$summary['CHL']??0}}]
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Continental Pension Services',
                    padding:{
                        top: 10,
                        bottom:30
                    }
                }
            }
        });
    </script>
@endsection
