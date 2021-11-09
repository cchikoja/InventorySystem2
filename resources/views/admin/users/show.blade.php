@extends('layouts.admin.AdminApp')

@section('stylesheets')
@endsection

@section('content')
    <div class="container wrapper py-3 px-4">
        <h5 class="blue-text">Users - <strong>{{$user->name??''}}</strong></h5>
        <hr class="blue-line">
        <a href="{{route('users.create')}}" class="btn btn-dark">Back</a>
        <div class=" mt-5">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="">
                        <h6>Demographic Info</h6>
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-info"><strong>Name </strong>{{$user->name}}</li>
                            <li class="list-group-item list-group-item-info"><strong>Gender </strong>{{$user->gender??'N/A'}}</li>
                            <li class="list-group-item list-group-item-info"><strong>Email </strong>{{$user->email}}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="">
                        <h6>Work Info</h6>
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-info"><strong>Position </strong>{{$user->designation??'N/A'}}</li>
                            <li class="list-group-item list-group-item-info"><strong>Company </strong>{{$user->company??'N/A'}}</li>
                            <li class="list-group-item list-group-item-info"><strong>Email </strong>{{$user->email}}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="">
                        <h6>User Account Info</h6>
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-info"><strong>Email </strong>{{$user->email}}</li>
                            <li class="list-group-item list-group-item-info"><strong>Status </strong>{{$user->status?'active':'disabled'}}</li>
                            <li class="list-group-item list-group-item-info"><strong>Role </strong>{{$user->role}}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <a href="{{route('users.edit', $user->id)}}" class="btn btn-primary mt-2">Edit user {{$user->name}}</a>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(() => {
            $('.table').dataTable();
            $('#upload-btn').on('click', function () {
                $.confirm({
                    title: 'Confirm',
                    content: 'Confirm Uploading Sheet?',
                    type: 'blue',
                    theme: 'modern',
                    icon: 'fa fa-file-upload',
                    columnClass: 'medium',
                    buttons: {
                        confirm: function () {
                            $('#data-form').submit();
                        },
                        cancel: function () {
                            $.alert({
                                title: 'Notice',
                                content: 'Upload Aborted',
                                type: 'blue'
                            })
                        }
                    }
                })
            })
        });
    </script>
@endsection
