@extends('frontend\layouts.app')
@section('title','Wallet')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="wallet">
                <div class="card mycard">
                    <div class="card-body">
                        <div class="mb-4">
                            <span>Balance</span>
                            {{-- wallet come from model --}}
                            <h3>{{ number_format($user->wallet? $user->wallet->amount : '-' )}} MMK</h3>
                        </div>
                        <div class="mb-4">
                            <span>Account Number</span>
                            <h4>{{ $user->wallet ? $user->wallet->account_number : '-' }}</h4>
                        </div>
                        <div>
                            <p>{{ $user->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
