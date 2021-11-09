@extends('layouts.admin.AdminApp')

@section('stylesheets')
@endsection

@section('content')
    <div class="container wrapper py-3 px-4">
        <h5 class="blue-text">Users</h5>
        <hr class="blue-line">
        <a href="{{route('users.create')}}" style="font-size: 13px !important;" class="btn btn-primary">Users Registration</a>
        @if($exceptions)
            <div class="alert alert-danger mt-3">
                <p><strong>Something went wrong</strong></p>
            </div>
        @endif
        <div class="table-responsive mt-3" style="font-size: 13px !important;">
            <table class="table table-sm table-bordered">
                <thead>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Company</th>
                    <th>Designation</th>
                    <th>Role</th>
                    <th>PWD</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $counter =1 ?>
                @foreach($users as $user)
                    <tr>
                        <td>{{$counter}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{strtoupper($user->company)}}</td>
                        <td>{{$user->designation}}</td>
                        <td>{{$user->role}}</td>
                        @if($user->force_passwd_change == true)
                            <td>{{$user->force_passwd_change == true?'expired':'valid'}}</td>
                        @else
                            <td>valid (<a href="{{route('admin.user.expire', $user->id)}}" onclick="return confirm('Proceed Expiring Password For:  {{$user->name}}')">expire</a>)</td>
                        @endif

                        <td>{{$user->status?'active':'inactive'}}</td>
                        <td>
                            <a href="{{route('users.show', $user->id)}}">open</a> &nbsp;

                            @if($user->id != Auth::user()->id)
                                @if($user->status)
                                    <a href="{{route('users.manage', $user->id).'?flag=disable'}}" onclick="return confirm('Disable User: {{$user->name}}')">disable</a>
                                @else
                                    <a href="{{route('users.manage',$user->id).'?flag=enable'}}" onclick="return confirm('Enable User: {{$user->name}}')" >enable</a>
                                @endif
                            @else
                                No action
                            @endif
                        </td>
                        <?php $counter++ ?>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(()=>{
            $('.table').dataTable();
        });
    </script>
@endsection
