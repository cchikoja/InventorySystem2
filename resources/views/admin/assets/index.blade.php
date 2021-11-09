@extends('layouts.admin.AdminApp')

@section('stylesheets')
@endsection

@section('content')
    <div class="container wrapper py-3 px-4">
        <h5 class="blue-text">Assets</h5>
        <hr class="blue-line">
        <a href="{{route('assets.create')}}" style="font-size: 13px !important;" class="btn btn-primary">Assets Registration</a>
        <div class="table-responsive mt-3" style="font-size: 13px !important;">
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Asset</th>
                        <th>Serial</th>
                        <th>Model</th>
                        <th>Status</th>
                        <th>Assigned</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php $counter =1 ?>
                    @foreach($assets as $asset)
                        <tr>
                            <td>{{$counter}}</td>
                            <td>{{$asset->asset}}</td>
                            <td>{{$asset->serial_no}}</td>
                            <td>{{$asset->model}}</td>
                            <td>available</td>
                            <td>no</td>
                            <td><a href="#">Open</a></td>
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
        $(document).ready(()=>{
           $('.table').dataTable();
        });
    </script>
@endsection
