@extends('common.main-layout')

@section('main-content')
@include('common.form-error-alert')
<div class="row">
    <div class="col-12">
        <form action=@if($hasValue) {{ '/user/'.$user->id }} @else {{ '/user' }} @endif method="POST">
            @if ($hasValue) @method('PATCH') @endif
            @csrf
            <div class="mb-3">
                <label for="nameInput" class="form-label">Name</label>
                <input type="input" class="form-control" name="name" id="nameInput" value="{{ $hasValue ? $user->name : '' }}" @if($viewMode == 'view')disabled @endif>
            </div>
            <div class="mb-3">
                <label for="usernameInput" class="form-label">Username</label>
                <input type="input" class="form-control" name="username" id="usernameInput" value="{{ $hasValue ? $user->username : '' }}" @if($viewMode == 'view')disabled @endif >
            </div>
            <div class="mb-3">
                <label for="emailInput" class="form-label">Email</label>
                <input type="input" class="form-control" name="email" id="emailInput" value="{{ $hasValue ? $user->email : '' }}" @if($viewMode == 'view')disabled @endif >
            </div>
            <div class="mb-3">
                <label for="passwordInput" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="passwordInput" value="password" @if($viewMode == 'view')disabled @endif >
                <small id="emailHelp" class="form-text text-muted">Default value for password is <code>password</code></small>
            </div>
            <div class="mb-3">
                <label for="memberIdInput" class="form-label">Member Id</label>
                <select name="member_id" class="form-control" id="memberIdInput" @if($viewMode == 'view') disabled @endif>
                    @foreach($members as $member)
                    <option value="{{ $member->id }}" @if($hasValue && $user->member_id == $member->id) selected @endif>{{ $member->code }} - {{ $member->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="roleInput" class="form-label">Role</label>
                <select name="role_id" class="form-control" id="roleInput" @if($viewMode == 'view') disabled @endif>
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}" @if($hasValue && $user->role_id == $role->id) selected @endif>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3 text-end">
                @if ($viewMode == 'edit')
                <button class="btn btn-primary" value="submit">Submit</button>
            </form>
                    <a href="/user" class="btn btn-warning">Cancel</a>
                @else
                    <a href="/user" class="btn btn-primary">Back</a>
                @endif
            </div>
    </div>
</div>
@endsection
