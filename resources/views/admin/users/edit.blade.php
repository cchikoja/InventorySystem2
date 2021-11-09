@extends('layouts.admin.AdminApp')

@section('stylesheets')
@endsection

@section('content')
    <div class="container wrapper py-3 px-4">
        <h5 class="blue-text">Users - <strong>{{$user->name??''}}</strong></h5>
        <hr class="blue-line">
        <a href="{{route('users.create')}}" class="btn btn-dark">Back</a>
        <div class=" mt-5">
            <div class="edit-form">
                <h6>Update User Information</h6>
                <hr>
                <form action="{{route('users.update',$user->id)}}" id="data-form" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group row">
                                <label for="email" class="col-md-2">Email</label>
                                <div class="col-md-6">
                                    <input type="email" name="email" class="form-control  @error('email') is-invalid @enderror"
                                           value="{{$user->email}}">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-2">Name</label>
                                <div class="col-md-6">
                                    <input type="email" name="name" class="form-control  @error('name') is-invalid @enderror"
                                           value="{{$user->name}}">
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
                                    <input type="radio" name="gender" class="" value="F" {{$user->gender=='F'?'checked':''}}>
                                    Female
                                    <input type="radio" name="gender" class="" value="M" {{$user->gender=='M'?'checked':''}}>
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
                                <label for="email" class="col-md-2">Role</label>
                                <div class="col-md-6">
                                    <select name="role" id="" class="form-control">
                                        <option value="">select role</option>
                                        <option value="admin" {{$user->role=='admin'?'selected':''}}>Admin</option>
                                        <option value="employee" {{$user->role=='employee'?'selected':''}}>Accountant</option>
                                        <option value="legal" {{$user->role=='legal'?'selected':''}}>Legal</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <div class="form-group row">
                                <label for="email" class="col-md-2">Company</label>
                                <div class="col-md-6">
                                    <input type="email" name="company" class="form-control  @error('company') is-invalid @enderror"
                                           value="{{$user->company}}">
                                    @error('company')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-2">Designation</label>
                                <div class="col-md-6">
                                    <input type="email" name="designation" class="form-control  @error('designation') is-invalid @enderror"
                                           value="{{$user->designation}}">
                                    @error('designation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                            </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <button id="update-btn" class="btn btn-primary mt-2">Update {{$user->name}}</button>
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
                    content: 'Confirm Updating User?',
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
                                content: 'Update Aborted',
                                type: 'blue'
                            })
                        }
                    }
                })
            })
        });
    </script>
@endsection
