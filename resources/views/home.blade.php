@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h6 style="background: darkslateblue; color: orange; padding:15px; border-radius: 3px">Welcome {{Auth::user()->name}}</h6>

                    <div class="mt-3">
                        <div class="row">
                            <div class="col-md-12 col-lg-4 col-sm-12">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <a  href="{{route('home.allocations')}}">All Allocations</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a  href="{{route('home.allocations.create')}}">New Allocation</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
