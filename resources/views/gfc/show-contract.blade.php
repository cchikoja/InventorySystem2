@extends('layouts.gfc.gfcApp')

@section('stylesheets')
@endsection

@section('content')
    <div class="container wrapper py-3 px-4">
        <h6 class="blue-text">Contracts - <strong>{{$contract->title??''}} <span
                    class="fa fa-handshake"></span></strong></h6>
        <hr class="blue-line">
        <div class="mt-3">
            <div class="row">
                <div class="col-md-5">
                    <div class="card rounded-0 wrapper">
                        <div class="card-header bg-white">
                            <h6 style="font-weight: bold"><span class="fa fa-tags"></span>Contract Details </h6>
                        </div>
                        <div class="card-body">
                            <p>Title: <strong>{{$contract->title}}</strong></p>
                            <p>Company: <strong>{{$contract->company}}</strong></p>
                            <p>
                                Start Date: <strong>{{$contract->start_date}}</strong> <br>
                                Expiry Date: <strong>{{$contract->start_date}}</strong>
                            </p>
                            <p>
                                Description: {{$contract->description}}
                            </p>
                            <p class="mt-3">
                                <hr>
                                <h6 class="font-weight-bold">Actions</h6>
                                <a href="{{route('contracts.open', $contract->id)}}" target="_blank">open <span
                                        class="fa fa-folder-open"></span></a> &nbsp;&nbsp;&nbsp;
                                <a href="{{route('contracts.download', $contract->id)}}">Download <span
                                        class="fa fa-cloud-download-alt"></span></a>
                            </p>

                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card rounded-0 wrapper">
                        <div class="card-body">
                            <h6>Linked Contracts <span class="fa fa-link"></span></h6>
                            <hr>
                            <table class="table table-sm table-bordered">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbdody>
                                    <?php $counter = 1 ?>
                                    @foreach($linkedContracts as $links)
                                        <tr>
                                            <td>{{$counter}}</td>
                                            <td>{{\App\Models\Contract::getContract($links->object)->title}}</td>
                                            <td>
                                                <a href="{{route('gfc.contracts.open', $links->object)}}" target="_blank">Open <span
                                                        class="fa fa-folder-open"></span></a> &nbsp;
                                                <a href="{{route('contracts.download', $links->object)}}">Download <span
                                                        class="fa fa-cloud-download-alt"></span></a> &nbsp;
                                            </td>
                                        </tr>
                                        <?php $counter++ ?>
                                    @endforeach
                                </tbdody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(() => {
            // $('.table').dataTable();
            $('.select').select2();
            $('#register-btn').on('click', function () {
                $.confirm({
                    title: 'Confirm',
                    content: 'Confirm Saving Contract?',
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

