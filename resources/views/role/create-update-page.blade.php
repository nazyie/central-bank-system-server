@extends('common.main-layout')

@section('main-content')
@include('common.form-error-alert')
<div class="row">
    <div class="col-12">
        <form action=@if($hasValue) {{ '/role/'.$role->id }} @else {{ '/role' }} @endif method="POST">
            @if ($hasValue) @method('PATCH') @endif
            @csrf
            <div class="mb-3">
                <label for="nameInput" class="form-label">Name</label>
                <input type="input" class="form-control" name="name" id="nameInput" value="{{ $hasValue ? $role->name : '' }}" @if($viewMode == 'view')disabled @endif>
            </div>
            <div class="mb-3">
                <label for="descriptionInput" class="form-label">Description</label>
                <input type="input" class="form-control" name="description" id="descriptionInput" value="{{ $hasValue ? $role->name : '' }}" @if($viewMode == 'view')disabled @endif>
            </div>
            <div class="mb-3">
                <label for="memberIdInput" class="form-label">Member Id</label>
                <select name="member_id" class="form-control" id="memberIdInput" @if($viewMode == 'view') disabled @endif>
                    @foreach ($memberCodeList as $memberCode)
                        <option value="{{ $memberCode->id }}" @if($hasValue && $role->member_id == $memberCode->id) selected @endif>{{ $memberCode->code }}</option>
                    @endforeach
                </select>
            </div>
            <!-- WIP -->
            <br />
            <p>Access Control</p>
            <hr>
            @foreach ($functions as $function)
                <div class="mb-3">
                    <div class="p-2 border">
                        <div class="pb-2">
                            <small><strong>{{ $function->function }}</strong></small>
                        </div>
                        <div class="px-2">
                            @foreach ($actions as $action)
                                @if ($action->function == $function->function)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" name="{{ $action->id }}" type="checkbox" id="{{ $action->id }}" value="true" @if($hasValue && $action->role_id != null) checked @endif @if($viewMode == 'view') disabled @endif>
                                        <label class="form-check-label" for="{{ $action->id }}">{{ $action->id }}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
            <!-- WIP -->
            <div class="mb-3 text-end">
                @if ($viewMode == 'edit')
                <button class="btn btn-primary" type="submit" value="submit">Submit</button>
            </form>
                    <a href="/role" class="btn btn-warning">Cancel</a>
                @else
                    <a href="/role" class="btn btn-primary">Back</a>
                @endif
            </div>
    </div>
</div>
@endsection
