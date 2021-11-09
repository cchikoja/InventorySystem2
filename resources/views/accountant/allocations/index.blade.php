@extends('layouts.app')

@section('stylesheets')
@endsection

@section('content')
    <div class="container wrapper py-3 px-4">
        <h5 class="blue-text">Assets Allocations</h5>
        <hr class="blue-line">
        <div class=" mt-5">
            <a href="{{route('home.allocations.create')}}" class="">New Allocation</a> <br>
            <div class="table-responsive mt-3">
                <table class="table table-sm table-bordered">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Asset</th>
                        <th>User</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $counter =1 ?>
                    @foreach($allocations as $allocation)
                        <tr>
                            <td>{{$counter}}</td>
                            <td><a href="{{route('assets.show', $allocation->asset_id)}}">{{$allocation->asset->asset}} ({{$allocation->asset->model}})</a></td>
                            <td><a href="{{route('users.show',$allocation->user_id)}}">{{$allocation->user->name??''}}</a> </td>
                            <td>{{$allocation->date}}</td>
                            <td>{{$allocation->status}}</td>
                        </tr>
                        <?php ++$counter ?>
                    @endforeach
                    </tbody>
                </table>
            </div>
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
