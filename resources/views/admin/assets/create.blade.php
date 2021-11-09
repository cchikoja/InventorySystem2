@extends('layouts.admin.AdminApp')

@section('stylesheets')
@endsection

@section('content')
    <div class="container wrapper py-3 px-4">
        <h5 class="blue-text">Assets - Registration</h5>
        <hr class="blue-line">
        <a href="#" class="btn btn-dark">Back</a>
        <div class=" mt-5" style="font-size: 13px !important;">
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-12">
                    <p>
                        <img src="{{asset('images/excel.png')}}" alt=""> <strong>Assets</strong> are registered through importing an excel file.
                        <br> <br> Make sure the file is in .csv format.
                        <br> Download user registration template <a href="{{route('assets.sheet')}}">here</a>
                        <br><br>
                    <form action="{{route('upload.assets.sheet')}}" id="data-form" method="POST" enctype="multipart/form-data">
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
                {{--                <div class="col-lg-5 col-lg-5 col-sm-12 ">--}}
                {{--                    <div class="table-responsive mt-3">--}}
                {{--                        <table class="table table-sm table-bordered">--}}
                {{--                            <thead>--}}
                {{--                            <tr>--}}
                {{--                                <th>No</th>--}}
                {{--                                <th>User</th>--}}
                {{--                                <th>Action</th>--}}
                {{--                            </tr>--}}
                {{--                            </thead>--}}
                {{--                        </table>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>


            </p>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(()=>{
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
