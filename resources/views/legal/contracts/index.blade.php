@extends('layouts.legal.legalApp')

@section('stylesheets')
@endsection

@section('content')
    <div class="container wrapper py-3 px-4">
        <a href="{{ URL::previous() }}" class="my-2" style="margin-top: 5px"><span class="fa fa-arrow-circle-left"></span>Go Back</a>
        <br><br>
        <h5 class="blue-text">Contracts</h5>
        <hr class="blue-line">
        <a href="{{route('contracts.create')}}" class="btn btn-primary btn-sm">Contracts Registration <span class="fa fa-folder-plus"></span></a>
        <a href="{{route('contracts.expired')}}" class="btn btn-danger btn-sm">Expired Contracts <span class="fa fa-exclamation-circle"></span></a>
        <div class="mt-3">
            <div class="row">
                <div class="col-md-4 col-ld-4 col-sm-12">
                    <h6 class="text-left font-weight-bold"> <span class="fa fa-tags"></span>Select Company</h6>
                    <ul style="list-style: none; padding-left: 0; font-size: 14px">
                        <li><a href="{{route('contracts.index').'?flag=CCL'}}" class="list-group-item">Continental Capital Limited</a></li>
                        <li><a href="{{route('contracts.index').'?flag=CAM'}}" class="list-group-item">Continental Asset Management</a></li>
                        <li><a href="{{route('contracts.index').'?flag=CPS'}}" class="list-group-item">Continental Pension Services</a></li>
                        <li><a href="{{route('contracts.index').'?flag=CHL'}}" class="list-group-item">Continental Holdings Limited</a></li>
                        <li><a href="{{route('contracts.index').'?flag=CPL'}}" class="list-group-item">Continental Properties Limited</a></li>
                    </ul>
                </div>
                <div class="col-md-4"></div>

            </div>
        </div>

        @if($flag)
        <div class="table-responsive mt-3">
            <h6 class="alert alert-info font-weight-bold">Contracts for company: {{$flag}}</h6>
            <table class="table table-sm table-bordered" style="font-size: 13px">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Title</th>
                    <th>Starts</th>
                    <th>Expires</th>
                    <th>Description</th>
                    <th>Document</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $counter = 1 ?>
                @foreach($contracts as $contract)
                    <tr>
                        <td>{{$counter}}</td>
                        <td>{{$contract->title}}</td>
                        <td>{{$contract->start_date}}</td>
                        <td>{{$contract->expiry_date}}</td>
                        <td>{{$contract->description}}</td>
                        <td>
                            <a href="{{route('contracts.show',$contract->id)}}" target="">Open</a> &nbsp;
                            <a href="{{route('contracts.download',$contract->id)}}" target="_blank">Download</a>
                        </td>
                        <td>
                            @if($contract->status == 'active')
                                <a href="{{route('contracts.cancel', $contract->id)}}" onclick="return confirm('Proceed Cancelling Contract?')"> Cancel</a>
                            @else
                                None
                            @endif
                        </td>
                    </tr>
                    <?php ++$counter ?>
                @endforeach
                </tbody>
            </table>
        </div>
        @else
            <h6 class="alert alert-warning font-weight-bold">Please select a company to view contracts from</h6>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(() => {
            $('.table').dataTable({
                dom: 'Bfrtip',
                buttons:[
                    {
                        extend: 'excel', className:'btn dt-btn',
                        title: 'Continental Contracts'
                    },
                    {
                        extend: 'csv', className:'btn dt-btn',
                        title: 'Continental Contracts'
                    }
                ],
            });
        });
    </script>
@endsection
