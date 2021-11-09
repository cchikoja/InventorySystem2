@extends('layouts.legal.legalApp')

@section('content')
    <div class="container">
        <div class="">
            <h5>Change Password</h5>
            <hr class="blue-line">
            <div class="mt-3">
                <div class="row">
                    <div class="col-lg-5">
                        <form action="{{route('legal.password.change')}}" method="POST" id="data-form">
                            @csrf
                            <div class="form-group row">
                                <label for="old" class="col-md-4">Old Password</label>
                                <div class="col-md-8">
                                    <input type="password" name="old" class="form-control  @error('old') is-invalid @enderror"
                                           value="{{old('old')}}">
                                    @error('old')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="old" class="col-md-4">Password</label>
                                <div class="col-md-8">
                                    <input type="password" name="password" class="form-control  @error('password') is-invalid @enderror"
                                           value="{{old('password')}}">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="old" class="col-md-4">Confirm Password</label>
                                <div class="col-md-8">
                                    <input type="password" name="password_confirmation" class="form-control  @error('old') is-invalid @enderror"
                                           value="{{old('password_confirmation')}}">
                                    @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-8">
                                <button class="btn btn-primary" id="cp-btn">Change Password</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(()=>{
            $('#cp-btn').on('click', function () {
                $.confirm({
                    title: 'Confirm',
                    content: 'Confirm Password Change?',
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
