@extends('layouts.legal.legalApp')

@section('stylesheets')
@endsection

@section('content')
    <div class="container wrapper py-3 px-4">
        <h5 class="blue-text">Contracts - Contract Registration</h5>
        <hr class="blue-line">
        <a href="{{route('contracts.index')}}" class=""> <span class="fa fa-arrow-circle-left"></span> Contracts Listing</a>
        <div class="mt-3">
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
            <form action="{{route('contracts.update',$contract->id)}}" style="margin-top: 10px" method="POST" id="data-form"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="PATCH">
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-12">
                        <div class="form-group row">
                            <label for="title" class="col-md-3">Title*</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                       name="title" value="{{$contract->title}}">
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="start" class="col-md-3">Start Date *</label>
                            <div class="col-md-5">
                                <input type="date" class="form-control @error('start') is-invalid @enderror"
                                       name="start"
                                       value="{{$contract->start_date}}" placeholder="date of purchase">
                                @error('start')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="close" class="col-md-3">Closing Date*</label>
                            <div class="col-md-5">
                                <input type="date" class="form-control @error('close') is-invalid @enderror"
                                       name="close"
                                       value="{{$contract->expiry_date}}" placeholder="date of purchase">
                                @error('close')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="close" class="col-md-3">Company*</label>
                            <div class="col-md-9">
                                <select name="company" class="form-control select" id="">
                                    <option value="">select company</option>
                                    @foreach($companies as $key => $company)
                                        <option
                                            value="{{$key}}" {{$contract->company==$key?'selected':''}}>{{$company}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="close" class="col-md-3">Link to</label>
                            <div class="col-md-9">
                                <select name="link" class="form-control select" id="">
                                    <option value="">select company</option>
                                    @foreach($contracts as $key => $contract)
                                        <option
                                            value="{{$contract->id}}" {{old('link')==$key?'selected':''}}>{{$contract->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-lg-5 col-sm-12">
                        <div class="form-group row">
                            <label for="close" class="col-md-4">Document (PDF)*</label>
                            <div class="col-md-8">
                                <input type="file" class="form-control @error('document') is-invalid @enderror"
                                       name="document"
                                       value="{{old('document')}}" placeholder="date of purchase">
                                @error('document')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-md-4">Description*</label>
                            <div class="col-md-8">
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          name="description" id="description" cols="2" rows="5">{{$contract->description}}</textarea>
                                <span class="invalid-feedback" role="alert">
                                @error('description')
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="">
                <button class="btn btn-primary btn-sm" id="register-btn">Update Contract <span class="fa fa-save"></span></button>
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
                    content: 'Confirm Updating Contract?',
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
