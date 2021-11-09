@extends('layouts.app')

@section('stylesheets')
@endsection

@section('content')
    <div class="container wrapper py-3 px-4">
        <h5 class="blue-text">Assets - Registration</h5>
        <hr class="blue-line">
        <div class="mt-3">
            <a href="{{route('home.assets')}}" class="">Back</a>
            <div class="row mt-3">
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <form action="{{route('home.assets.save')}}" method="POST" id="data-form">
                        @csrf
                        <div class="form-group row">
                            <label for="" class="col-md-3">Asset</label>
                            <div class="col-md-5">
                                <select name="asset" id="" class="form-control select">
                                    <option value="">asset</option>
                                    @foreach($assets as $asset)
                                        <option value="{{$asset}}">{{$asset}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="serial" class="col-md-3">Serial No</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control @error('serial') is-invalid @enderror"
                                       name="serial" value="{{old('serial')}}">
                                @error('serial')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="serial" class="col-md-3">Model</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control @error('model') is-invalid @enderror"
                                       name="model" value="{{old('model')}}">
                                @error('model')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="serial" class="col-md-3">D.O.P</label>
                            <div class="col-md-5">
                                <input type="date" class="form-control @error('dop') is-invalid @enderror" name="dop"
                                       value="{{old('dop')}}" placeholder="date of purchase">
                                @error('dop')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
{{--                        <div class="form-group row">--}}
{{--                            <label for="" class="col-md-3">User (optional)</label>--}}
{{--                            <div class="col-md-5">--}}
{{--                                <select name="user" id="" class="form-control select">--}}
{{--                                    <option value="">select user</option>--}}
{{--                                    @foreach($users as $user)--}}
{{--                                        <option value="{{$user->id}}">{{$user->name}} ({{strtoupper($user->company)}})</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </form>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-5">
                            <button class="btn btn-primary" id="register-btn">Register</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12 col-sm-12">
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
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(() => {
            $('.table').dataTable();
            $('.select').select2();
            $('#register-btn').on('click', function () {
                $.confirm({
                    title: 'Confirm',
                    content: 'Confirm Saving Asset?',
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
