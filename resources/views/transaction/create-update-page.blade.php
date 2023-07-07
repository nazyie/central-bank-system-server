@extends('common.main-layout')

@section('main-content')
@include('common.form-error-alert')
<div class="row">
    <div class="col-12">
        <form action=@if($hasValue) {{ '/transaction/'.$transaction->id }} @else {{ '/transaction' }} @endif method="POST">
            @if ($hasValue) @method('PATCH') @endif
            @csrf
            <div class="mb-3">
                <label for="creditorInput" class="form-label">Creditor</label>
                <select name="creditor" class="form-control" id="creditorInput" @if($viewMode == 'view') disabled @endif>
                    @foreach ($creditorMemberCodeList as $memberCode)
                        <option value="{{ $memberCode->id }}" @if($hasValue && $transaction->creditor == $memberCode->id) selected @endif>{{ $memberCode->code }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="debitorInput" class="form-label">Receipient</label>
                <select name="debitor" class="form-control" id="debitorInput" @if($viewMode == 'view') disabled @endif>
                    @foreach ($memberCodeList as $memberCode)
                        <option value="{{ $memberCode->id }}" @if($hasValue && $transaction->depositor == $memberCode->id) selected @endif>{{ $memberCode->code }}</option>
                    @endforeach
                </select>
            </div>
            <hr>
            <!-- managing transaciton -->
            <div class="mb-3">
                <label for="currencyInput" class="form-label">Receipient</label>
                <select name="currency" class="form-control" id="currencyInput" @if($viewMode == 'view') disabled @endif>
                    <option value="MYR" @if($hasValue && $transaction->currency == 'MYR') selected @endif>Malaysia Ringgit - MYR</option>
                    <option value="USD" @if($hasValue && $transaction->currency == 'USD') selected @endif>United States Dollar - USD</option>
                </select>
            </div>
            <div class="input-group mb-3">
                <input type="input" id="amountInput" name="amount" class="form-control" aria-label="" value="{{ $hasValue ? $transaction->amount : '' }}" @if($viewMode == 'view')disabled @endif>
                <span class="input-group-text">.00</span>
            </div>
            <div class="mb-3">
                <label for="isCreditInput" class="form-label">Transaction Direction</label>
                <select name="is_credit" class="form-control" id="isCreditInput" @if($viewMode == 'view') disabled @endif>
                    @foreach ($transactionDirection as $data)
                        <option value="{{ $data['value'] }}" @if($hasValue && $transaction->is_credit == $data['value']) selected @endif>{{ $data['description'] }}</option>
                    @endforeach
                </select>
            </div>
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
