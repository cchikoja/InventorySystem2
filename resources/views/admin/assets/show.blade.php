@extends('layouts.admin.AdminApp')

@section('stylesheets')
@endsection

@section('content')
    <div class="container wrapper py-3 px-4">
        <h5 class="blue-text">Users - <strong>{{$asset->asset??''}}</strong></h5>
        <hr class="blue-line">
        <a href="{{route('users.create')}}" class="btn btn-dark">Back</a>
        <div class=" mt-3" style="font-size: 13px !important;">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="">
                        <h6>Demographic Info</h6>
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-info"><strong>Asset </strong>{{$asset->asset}}</li>
                            <li class="list-group-item list-group-item-info"><strong>Serial No </strong>{{$asset->serial_no??'N/A'}}</li>
                            <li class="list-group-item list-group-item-info"><strong>Model </strong>{{$asset->model}}</li>
                            <li class="list-group-item list-group-item-info"><strong>Bought On </strong>{{$asset->bought}}</li>
                            <li class="list-group-item list-group-item-info"><strong>Expires On </strong>{{$asset->expires}}</li>
                            <li class="list-group-item list-group-item-info"><strong>Assigned </strong>{{$asset->assigned?'Yes':'No'}}</li>
                        </ul>
                    </div>
                </div>

            </div>

            <a href="{{route('assets.edit', $asset->id)}}" class="btn btn-primary mt-2">Edit {{$asset->asset}}</a>
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
