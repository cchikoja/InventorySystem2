@extends('layouts.admin.AdminApp')

@section('stylesheets')
@endsection

@section('content')
    <div class="container wrapper py-3 px-4">
        <h5 class="blue-text">Users - Registration</h5>
        <hr class="blue-line">
        <a href="{{route('users.index')}}" class=""> <span class="fa fa-arrow-circle-left"></span> Back</a>
        <div class=" mt-2" style="font-size: 13px !important;">
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
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-12">
                    <p>
                        <img src="{{asset('images/excel.png')}}" alt=""> <strong>Users</strong> are registered through importing an excel file.
                        <br> <br> Make sure the file is in .csv format.
                        <br> Download user registration template <a href="{{route('reg.sheet')}}">here</a>
                        <br><br>
                    <form action="{{route('upload.sheet')}}" id="data-form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="file" class="col-md-3">Registration File</label>
                            <div class="col-md-5">
                                <input type="file" class="form-control @error('sheet') is-invalid @enderror" name="sheet">
                                @error('sheet')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </form>
                    <div class="text-left">
                        <button id="upload-btn" type="submit" class="btn btn-primary">Upload File</button>
                    </div>
                </div>
                <div class="col-lg-5 col-lg-5 col-sm-12 ">
                    <div class="mt-0">
                        <form action="{{route('admin.user.register')}}" id="uni-form" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label for="email" class="col-md-2">Email</label>
                                <div class="col-md-6">
                                    <input type="email" name="email" class="form-control  @error('email') is-invalid @enderror"
                                           value="{{old('email')}}">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-2">Name</label>
                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control  @error('name') is-invalid @enderror"
                                           value="{{old('name')}}">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="gender" class="col-md-2">Gender</label>
                                <div class="col-md-6">
                                    <input type="radio" name="gender" class="" value="F" {{old('gender')=='F'?'checked':''}}>
                                    Female
                                    <input type="radio" name="gender" class="" value="M" {{old('gender')=='M'?'checked':''}}>
                                    Male
                                    <br>
                                    @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="role" class="col-md-2">Role</label>
                                <div class="col-md-6">
                                    <select name="role" id="" class="form-control">
                                        <option value="">select role</option>
                                        <option value="admin" {{old('role')=='admin'?'selected':''}}>Admin</option>
                                        <option value="employee" {{old('role')=='employee'?'selected':''}}>Accountant</option>
                                        <option value="legal" {{old('role')=='legal'?'selected':''}}>Legal</option>
                                        <option value="gfc" {{old('role')=='gfc'?'selected':''}}>GFC</option>
                                        <option value="manager" {{old('role')=='manager'?'selected':''}}>Manager</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="close" class="col-md-2">Company*</label>
                                <div class="col-md-6">
                                    <select name="company" class="form-control select" id="">
                                        <option value="">select company</option>
                                        @foreach($companies as $key => $company)
                                            <option
                                                value="{{$key}}" {{old('company')==$key?'selected':''}}>{{$company}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-2">Designation</label>
                                <div class="col-md-6">
                                    <input type="text" name="designation" class="form-control  @error('designation') is-invalid @enderror"
                                           value="{{old('designation')}}">
                                    @error('designation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                            </span>
                                    @enderror
                                </div>
                            </div>
                        </form>
                        <button class="btn btn-primary" id="upload-uni-btn">Add user</button>
                    </div>
                </div>
            </div>
            </p>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(()=>{
            $('.table').dataTable();
            $('.select').select2();
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
            $('#upload-uni-btn').on('click', function () {
                $.confirm({
                    title: 'Confirm',
                    content: 'Confirm Uploading Sheet?',
                    type: 'blue',
                    theme: 'modern',
                    icon: 'fa fa-file-upload',
                    columnClass: 'medium',
                    buttons: {
                        confirm: function () {
                            $('#uni-form').submit();
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
