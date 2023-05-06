@extends('common.main-layout')

@section('main-content')
    <div class="row">
        <div class="col-12">
            <div class="text-end">
                <a href="/"><button type="button" class="btn btn-primary px-4 font-weight-bold">+ Add</button></a>
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
                                        <th scope="col">Name</th>
                                        <th scope="col">Member Code</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Timestamp</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Maybank Sdn. Bhd</td>
                                        <td>BIMBMY</td>
                                        <td>Active</td>
                                        <td>12 January 2023</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn fw-bold" type="button" id="dropdownMenuButton1"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    ...
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item" href="#">Update</a></li>
                                                    <li><a class="dropdown-item" href="#">Delete</a></li>
                                                    <li><a class="dropdown-item" href="#">View</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <hr>
            <div class="fs-6 text-end fst-italic ">
                <small>Record updated as 12 January 2023</small>
            </div>
        </div>
    </div>
@endsection
