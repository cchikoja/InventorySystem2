@extends('layouts.admin.AdminApp')

@section('stylesheets')
@endsection

@section('content')
    <div class="container wrapper py-3 px-4">
        <h5 class="blue-text">Contracts</h5>
        <hr class="blue-line">
        <a href="{{route('contracts.create')}}" style="font-size: 13px !important;" class="btn btn-primary">Contracts Registration</a>

        <div class="table-responsive mt-3" style="font-size: 13px !important;">
            <h6 class="alert alert-info font-weight-bold">Contracts for all companies</h6>
            <table class="table table-sm table-bordered">
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
                            <a href="{{route('contracts.open',$contract->id)}}" target="_blank">Open</a> &nbsp;
                            <a href="{{route('contracts.download',$contract->id)}}" target="_blank">Download</a>
                        </td>
                        <td>
                            @if($contract->status == 'active')
                                <a href="{{route('contracts.cancel', $contract->id)}}"> Cancel</a>
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
