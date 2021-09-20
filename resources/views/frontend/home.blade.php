@extends('frontend\layouts.app')
@section('title','Magic Pay')
@section('content')
<div class="home">
    <div class="row">
        <div class="col-12">
            <div class="profile-img mb-3">
                <img src="https://ui-avatars.com/api/?background=0D8ABC&color=fff&name={{ $user->name }}" alt="">
                <h6>{{ $user->name }}</h6>
                <p>{{ number_format($user->wallet? $user->wallet->amount : '-' )}} MMK</p>
            </div>
        </div>
        <div class="col-6">
            <div class="card scan-box">
                <div class="card-body">
                   <img src="{{ asset('img/qr-code1.png') }}" width="20" height="20" alt="">
                   <span>Scan QR</span>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card scan-box">
                <div class="card-body">
                   <img src="{{ asset('img/qr-code.png') }}" width="20" height="20" alt="">
                   <span>Receive QR</span>
                </div>
            </div>
        </div>
    </div>
@endsection
