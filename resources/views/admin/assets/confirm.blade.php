@extends('layouts.admin.AdminApp')

@section('stylesheets')
@endsection

@section('content')
    <div class="container wrapper py-3 px-4">
        <h5 class="blue-text">Users - Registration</h5>
        <hr class="blue-line">
        <a href="{{route('assets.create')}}" class="btn btn-dark">Back</a>
        <div class=" mt-5">
            <div class="table-responsive mt-3">
                <table class="table table-sm table-bordered">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Asset</th>
                        <th>Serial No</th>
                        <th>Model</th>
                        <th>Company</th>
                        <th>Bought</th>
                        <th>Expires</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $counter = 1 ?>
                    @foreach($generic as $asset)
                        <tr>
                            <td>{{$counter}}</td>
                            @for($key=0; $key<6; $key++)
                                <td>{{$asset[$key]??'null'}}</td>
                            @endfor
                            <td>{{(\App\Models\Asset::checkAsset($asset[3])?'error':'success')}}</td>
                        </tr>
                        <?php ++$counter ?>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <form action="{{route('assets.store')}}" method="POST">
                @csrf
                <?php $counter = 0 ?>
                @foreach($generic as $asset)
                    <input type="hidden" value="{{$asset[0]}}" name="asset[{{$counter}}][asset]">
                    <input type="hidden" value="{{$asset[1]}}" name="asset[{{$counter}}][serial]">
                    <input type="hidden" value="{{$asset[2]}}" name="asset[{{$counter}}][model]">
                    <input type="hidden" value="{{$asset[3]}}" name="asset[{{$counter}}][company]">
                    <input type="hidden" value="{{$asset[4]}}" name="asset[{{$counter}}][bought]">
                    <input type="hidden" value="{{$asset[5]}}" name="asset[{{$counter}}][expires]">
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
