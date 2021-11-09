@extends('layouts.admin.AdminApp')

@section('layouts')
@endsection

@section('content')
    <div class="container wrapper p-4">
        <h6>Dashboard</h6>
        <hr class="blue-line">
        <div class="mt-3">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="p-2 mb-2 wrapper text-center font-weight-bold">
                        <h3>Admins</h3>
                        <p>{{$summary['admin']??''}}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="p-2 mb-2 wrapper text-center font-weight-bold">
                        <h3>Accounts</h3>
                        <p>{{$summary['accountants']}}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="p-2 mb-2 wrapper text-center font-weight-bold">
                        <h3>Assets</h3>
                        <p>{{$summary['assets']}}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="p-2 mb-2 wrapper text-center font-weight-bold">
                        <h3>Allocations</h3>
                        <p>{{$summary['active-allocations']}}</p>
                    </div>
                </div>
                </div>

            <div class="mt-2">
                <h6>News and Notices</h6>
                <hr>
                @foreach($attentionItems as $item)
                    <div class="alert alert-warning alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Warning!</strong> {{$item}}
                    </div>
                @endforeach

                @foreach($expiringAllocations as $item)
                    <div class="alert alert-info alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Warning!</strong> {{$allocation->asset->asset??''}}
                    </div>
                @endforeach
            </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
