@extends('layouts.admin.AdminApp')

@section('stylesheets')
@endsection

@section('content')
    <div class="container wrapper py-3 px-4">
        <h5 class="blue-text">Users - Registration</h5>
        <hr class="blue-line">
        <a href="{{route('users.create')}}" class="btn btn-dark">Back</a>
        <div class=" mt-5">
            <div class="table-responsive mt-3">
                <table class="table table-sm table-bordered">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Designation</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $counter = 1 ?>
                    @foreach($generic as $user)
                        <tr>
                            <td>{{$counter}}</td>
                            @for($key=0; $key<6; $key++)
                                <td>{{$user[$key]??'null'}}</td>
                            @endfor
                            <td>{{(\App\Models\User::checkEmail($user[3])?'error':'success')}}</td>
                        </tr>
                        <?php ++$counter ?>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <form action="{{route('users.store')}}" method="POST">
                @csrf
                <?php $counter = 0 ?>
                @foreach($generic as $user)
                    <input type="hidden" value="{{$user[0]}}" name="user[{{$counter}}][name]">
                    <input type="hidden" value="{{$user[1]}}" name="user[{{$counter}}][surname]">
                    <input type="hidden" value="{{$user[2]}}" name="user[{{$counter}}][gender]">
                    <input type="hidden" value="{{$user[3]}}" name="user[{{$counter}}][email]">
                    <input type="hidden" value="{{$user[4]}}" name="user[{{$counter}}][company]">
                    <input type="hidden" value="{{$user[5]}}" name="user[{{$counter}}][designation]">
                    <?php $counter++ ?>
                @endforeach

                <button class="btn btn-primary"
                        onclick="return confirm('Proceed Saving?')" {{$counter<1?'disabled':''}}>Save
                </button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(() => {
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
