@extends('layouts.admin.AdminApp')

@section('stylesheets')
@endsection

@section('content')
    <div class="container wrapper py-3 px-4">
        <h5 class="blue-text">Asset - <strong>{{$asset->asset??''}}</strong></h5>
        <hr class="blue-line">
        <a href="{{route('users.create')}}" class="btn btn-dark">Back</a>
        <div class=" mt-3">
            <div class="p-5" style="font-size: 13px !important;">
                <form action="{{route('assets.update', $asset->id)}}" id="data-form" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="form-group row">
                        <label for="date" class="col-md-1">Asset</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control @error('asset') is-invalid @enderror" name="asset"
                                   value="{{$asset->asset}}">
                            @error('asset')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="date" class="col-md-1">serial</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control @error('serial') is-invalid @enderror" name="serial"
                                   value="{{$asset->serial_no}}">
                            @error('serial')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="date" class="col-md-1">Model</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control @error('model') is-invalid @enderror" name="model"
                                   value="{{$asset->model}}">
                            @error('model')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                </form>
            </div>

            <button class="btn btn-primary mt-2" id="update-btn">Update {{$asset->asset}}</button>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(() => {
            $('.table').dataTable();
            $('#update-btn').on('click', function () {
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
