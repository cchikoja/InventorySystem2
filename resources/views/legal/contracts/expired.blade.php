@extends('layouts.legal.legalApp')

@section('stylesheets')
@endsection

@section('content')
    <div class="container wrapper py-3 px-4">
        <h5 class="blue-text">Contracts - Expired <span class="fa fa-exclamation-triangle"></span></h5>
        <hr class="blue-line">
        <a href="{{route('contracts.create')}}" class="btn btn-primary btn-sm">Contracts Registration <span class="fa fa-folder-plus"></span></a>

            <div class="table-responsive mt-3">
                <h6 class="alert alert-warning font-weight-bold">Expired Contracts</h6>
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
