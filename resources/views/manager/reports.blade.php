@extends('layouts.manager.managerApp')

@section('stylesheets')
@endsection

@section('content')
    <div class="container wrapper py-3 px-4">
        <h5 class="blue-text">Contracts <span class="fa fa-folder-open"></span></h5>
        <hr class="blue-line">
        <a href="{{route('contracts.create')}}" class="btn btn-sm btn-primary">Contracts Registration <span class="fa fa-folder-plus"></span></a>
        <div class="mt-4">
            <h5 class="text-center font-weight-bold" style="text-decoration: underline"> <span class="fa fa-tags"></span> Contracts Expiring in: {{date('F-Y')}}</h5>
            <div class="table-responsive-md">
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th>Company</th>
                        <th>Title</th>
                        <th>Created</th>
                        <th>Expires On</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($expiringContracts as $contract)
                        <tr>
                            <td>{{$contract->company}}</td>
                            <td>{{$contract->title}}</td>
                            <td>{{$contract->start_date}}</td>
                            <td>{{$contract->expiry_date}}</td>
                            <td>{{$contract->description}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
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
                    },
                    {
                        extend: 'pdf', className:'btn dt-btn',
                        title: 'Continental Contracts'
                    },   {
                        extend: 'print', className:'btn dt-btn',
                        title: 'Continental Contracts'
                    }
                ],
            });
        });
    </script>
@endsection
