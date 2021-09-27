@extends('frontend\layouts.app')
@section('title','Transaction Detail')
@section('content')
    <div class="transaction-detail">
        <div class="card mycard">
            <div class="card-body">
                <div class="text-center mb-3">
                    <img src="{{ asset('img/checked.png') }}" width="60" height="60" alt="">
                </div>
                @if($transactions->type == 1)
                    <h6 class="text-center text-success"> +{{number_format($transactions->amount) }}MMK</h6>
                @elseif($transactions->type == 2)
                    <h6 class="text-center text-danger"> -{{number_format($transactions->amount) }}MMK</h6>
                @endif
                <hr>
                <div class="d-flex justify-content-between mb-3">
                    <p class="mb-0 text-muted">Transaction Id</p>
                    <p class="mb-0">{{ $transactions->trx_id }}</p>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-3">
                    <p class="mb-0 text-muted">Refer Number</p>
                    <p class="mb-0">{{ $transactions->ref_no }}</p>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-3">
                    <p class="mb-0 text-muted">Type</p>
                    @if($transactions->type == 1)
                    <p class="mb-0 badge badge-pill badge-success">Income</p>
                    @elseif($transactions->type == 2)
                    <p class="mb-0 badge badge-pill badge-danger">Expense</p>
                    @endif
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-3">
                    <p class="mb-0 text-muted">Amount</p>
                    @if($transactions->type == 1)
                        <p class="text-center text-success"> +{{number_format($transactions->amount) }}MMK</p>
                    @elseif($transactions->type == 2)
                        <p class="text-center text-danger"> -{{number_format($transactions->amount) }}MMK</p>
                    @endif
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <p class="mb-0 text-muted">Date And Time</p>
                    <p class="mb-0">{{ $transactions->created_at }}</p>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-3">
                    @if($transactions->type == 1)
                        <p class="mb-0 text-muted">From</p>
                    @elseif($transactions->type == 2)
                    <p class="mb-0 text-muted">To</p>
                    @endif
                    <p class="mb-0">{{ $transactions->source->name }}</p>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-3">
                    <p class="mb-0 text-muted">Description</p>
                    <p class="mb-0">{{ $transactions->description }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
