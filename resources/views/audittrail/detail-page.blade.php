@extends('common.main-layout')

@section('main-content')
@include('common.form-error-alert')
<div class="row">
    <div class="col-12">
            <div class="row">
                <div class="mb-3 col-6">
                    <label for="nameInput" class="form-label">Identification Number</label>
                    <input type="input" value="{{ $auditTrail->id }}" class="form-control" id="nameInput" disabled>
                </div>
                <div class="mb-3 col-6">
                    <label for="nameInput" class="form-label">Domain</label>
                    <input type="input" value="{{ $auditTrail->domain }}" class="form-control" id="nameInput" disabled>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-6">
                    <label for="nameInput" class="form-label">Action</label>
                    <input type="input" value="{{ $auditTrail->action }}" class="form-control" id="nameInput" disabled>
                </div>
                <div class="mb-3 col-6">
                    <label for="nameInput" class="form-label">Created By</label>
                    <input type="input" value="{{ $auditTrail->name }}" class="form-control" id="nameInput" disabled>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-6">
                    <label for="nameInput" class="form-label">Member Code</label>
                    <input type="input" value="{{ $auditTrail->code }}" class="form-control" id="nameInput" disabled>
                </div>
                <div class="mb-3 col-6">
                    <label for="nameInput" class="form-label">Created At</label>
                    <input type="input" value="{{ $auditTrail->created_at }}" class="form-control" id="nameInput" disabled>
                </div>
            </div>
            <div class="pt-2">
                <p>Detail Changes</p>
                <hr>
            </div>
            <!-- Table looping -->
            <table class="table">
                <tbody>
                    <thead>
                        <tr>
                            <th class="col">Key</th>
                            @if ($currentRecordArray != null)
                                <th class="col">Current Value</th>
                                <th class="col">New Value</th>
                            @else
                                <th class="col">Value</th>
                            @endif
                        </tr>
                    </thead>
                    @foreach ($prevRecordArray as $key => $value)
                        <tr>
                            <td @if ($currentRecordArray != null && $currentRecordArray[$key] != $value) {{ 'class=bg-secondary' }} @endif>{{ $key }}</td>
                            <td @if ($currentRecordArray != null && $currentRecordArray[$key] != $value) {{ 'class=bg-secondary' }} @endif>{{ $value }}</td>
                            @if ($currentRecordArray != null)
                                <td @if ($currentRecordArray[$key] != $value) {{ 'class=bg-secondary' }} @endif>{{ $currentRecordArray[$key] }}
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mb-3 text-end">
                <a href="/audit-trail" class="btn btn-primary">Back</a>
            </div>
    </div>
</div>
@endsection
