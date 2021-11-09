@extends('layouts.manager.managerApp')

@section('stylesheets')
@endsection

@section('content')
    <div class="container wrapper py-3 px-4">
        <h6 class="blue-text">Contracts - All Contracts</h6>
        <hr class="blue-line">

        @if($flag == null)
            <a href="{{route('manager.contracts').'?flag=expired'}}" class="btn btn-primary btn-sm">Expired Contracts <span class="fa fa-exclamation-circle"></span></a>
        @else
            <a href="{{route('manager.contracts')}}" class="btn btn-primary btn-sm">Active Contracts <span class="fa fa-exclamation-circle"></span></a>
        @endif
        <div class="table-responsive mt-3">
            @if($flag == 'expired')
                <h6 class="alert alert-info font-weight-bold">Expired Contracts</h6>
            @else
                <h6 class="alert alert-info font-weight-bold">All Active Contracts</h6>
            @endif

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
                            <a href="{{route('manager.contracts.open',$contract->id)}}" target="">Open</a> &nbsp;
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
