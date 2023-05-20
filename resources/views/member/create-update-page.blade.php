@extends('common.main-layout')

@section('main-content')
@include('common.form-error-alert')
<div class="row">
    <div class="col-12">
        <form action=@if($hasValue) {{ '/member/'.$member->id }} @else {{ '/member' }} @endif method="POST">
            @if ($hasValue) @method('PATCH') @endif
            @csrf
            <div class="mb-3">
                <label for="nameInput" class="form-label">Name</label>
                <input type="input" class="form-control" name="name" id="nameInput" value="{{ $hasValue ? $member->name : '' }}" @if($viewMode == 'view')disabled @endif>
            </div>
            <div class="mb-3">
                <label for="memberCodeInput" class="form-label">Member Code</label>
                <input type="input" class="form-control" name="code" id="memberCodeInput" value="{{ $hasValue ? $member->code : '' }}" @if($viewMode == 'view')disabled @endif >
            </div>
            <div class="mb-3">
                <label for="descriptionInput" class="form-label">Description</label>
                <input type="input" class="form-control" name="description" id="addressInput" value="{{ $hasValue ? $member->description : '' }}" @if($viewMode == 'view')disabled @endif >
            </div>
            <div class="mb-3">
                <label for="statusInput" class="form-label">Member Status</label>
                <select name="status" class="form-control" id="statusInput" @if($viewMode == 'view') disabled @endif>
                    <option value="ACTIVE" @if($hasValue && $member->status == 'ACTIVE') selected @endif>Active</option>
                    <option value="DEACTIVE" @if($hasValue && $member->status == 'DEACTIVE') selected @endif>Deactive</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="memberTypeInput" class="form-label">Member Type</label>
                <select name="member_type" class="form-control" id="memberTypeInput" @if($viewMode == 'view')disabled @endif >
                    <option value="PTT" @if($hasValue && $member->member_type == 'PTT') selected @endif>Participant</option>
                    <option value="CBK" @if($hasValue && $member->member_type == 'CBK') selected @endif>Central Bank</option>
                    <option value="OPR" @if($hasValue && $member->member_type == 'OPR') selected @endif>Operator</option>
                </select>
            </div>
            <div class="mb-3 text-end">
                @if ($viewMode == 'edit')
                <button class="btn btn-primary" value="submit">Submit</button>
            </form>
                    <a href="/member" class="btn btn-warning">Cancel</a>
                @else
                    <a href="/member" class="btn btn-primary">Back</a>
                @endif
            </div>
    </div>
</div>
@endsection
