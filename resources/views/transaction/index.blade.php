@extends('common.main-layout')

@section('main-content')
    <div class="row">
        <div id="notification-alert" style="position: fixed; top: 10px; left:0; z-index: 9999; width: 100%;" class="px-5">
            @if(Session::has('successAlert'))
                <div class="d-flex flex-column justify-content-center pt-2 px-5">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <div>{{ Session::get('successAlert') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            <script>
                // to trigger the notification removal from the timer
                setTimeout(() => {
                    const notificationAlert = document.getElementById('notification-alert');
                    notificationAlert.style.display = 'none';
                }, 3000);
            </script>
            @endif
        </div>
        <div class="col-12">
            <div class="text-end">
                <a href="/transaction/create"><button type="button" class="btn btn-primary px-4 font-weight-bold">+ Add</button></a>
            </div>
        </div>
        <div>
            <div class="p-2">
                <div class="">
                    <div class="">
                        <div style="overflow-x: scroll; overflow-y: unset; height: auto; min-height: 400px">
                            <table class="table rounded text-nowrap">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Creditor</th>
                                        <th scope="col">Debitor</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Timestamp</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($transactions as $data)
                                    <tr>
                                        <th scope="row">{{ $data->id }}</th>
                                        <td>{{ $data->creditor_member_code }}</td>
                                        <td>{{ $data->depositor_member_code }}</td>
                                        <td>@if($data->is_credit == true) + @else - @endif {{ $data->amount }} ({{  $data->currency }})</td>
                                        <td>{{ $data->created_at }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn fw-bold" type="button" id="dropdownMenuButton1"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    ...
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item" href="/transaction/{{ $data->id }}">View</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="text-end">
                <button onclick="location.href='{{ $previousPageUrl }}'" type="button" @if( $previousPageUrl == null) disabled @endIf><</button>
                <button onclick="location.href='{{ $nextPageUrl }}'" type="button" @if( $nextPageUrl == null) disabled @endIf>></button>
            </div>
            <hr>
            <div class="fs-6 text-end fst-italic">
                <small>Record updated as {{ date("Y-m-d",time()) }}</small>
            </div>
        </div>
    </div>
@endsection
