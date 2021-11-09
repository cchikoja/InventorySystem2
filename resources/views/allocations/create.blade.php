@extends('layouts.admin.AdminApp')

@section('stylesheets')
@endsection

@section('content')
    <div class="container wrapper py-3 px-4">
        <h5 class="blue-text" style="font-size: 13px !important;">Assets Allocations</h5>
        <hr class="blue-line">
        <div class=" mt-5">
            <a href="{{route('allocations.index')}}" class="pl-5">Back</a> <br>
            <div class="p-5" style="font-size: 13px !important;">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <p><strong>Opps Something went wrong</strong></p>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{route('allocations.store')}}" id="data-form" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="" class="col-md-1">Asset</label>
                        <div class="col-md-5">
                            <select name="asset" id="" class="form-control select">
                                <option value="">select asset</option>
                                @foreach($assets as $asset)
                                    <option {{$asset->assigned?'disabled':''}} value="{{$asset->id}}">{{$asset->asset}} ({{strtoupper($asset->model)}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-1">User</label>
                        <div class="col-md-5">
                            <select name="user" id="" class="form-control select">
                                <option value="">select user</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}} ({{strtoupper($user->company)}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="date" class="col-md-1">Date</label>
                        <div class="col-md-5">
                            <input type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{old('date')}}">
                            @error('date')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-lg-1 col-md-1"></div>
                    <div class="col-lg-5 col-md-5">
                        <button class="btn btn-primary" id="save-btn">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(()=>{
            $('.table').dataTable();
            $('.select').select2();
            $('#save-btn').on('click', function () {
                $.confirm({
                    title: 'Confirm',
                    content: 'Confirm Saving Allocation?',
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
                                content: 'Operation Aborted',
                                type: 'blue'
                            })
                        }
                    }
                })
            })
        });
    </script>
@endsection
