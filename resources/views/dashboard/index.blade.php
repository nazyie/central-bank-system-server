@extends('common.main-layout')

@section('main-content')
<div class="row">
    <div class="col-12">
        @include('dashboard.main-card')
    </div>
    <div class="col-4">
        @include('dashboard.pie-account-balance')
    </div>
    <div class="col-4">
        @include('dashboard.pie-account-transaction')
    </div>
    <div class="col-4">
        @include('dashboard.pie-failed-balance')
    </div>
    <div>
        @include('dashboard.table-latest-transaction')
    </div>
    <div>
        @include('dashboard.table-latest-activities')
    </div>
</div>
@endsection
