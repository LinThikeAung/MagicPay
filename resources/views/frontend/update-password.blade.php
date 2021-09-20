@extends('frontend.layouts.app')
@section('title','Update Password')
@section('content')
<div class="account">
    <div class="card">
        <div class="card-body">
            <div class="img  d-flex justify-content-center">
                <img src="{{ asset('img/undraw-illustruction.png') }}" width="200" alt="">
            </div>
            <form action="{{ route('update-password.store') }}" method="POST">
                @csrf
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif
                <div class="form-group">
                    <label for="">Old Password</label>
                    <input type="password" name="oldpassword"  class="form-control @error('oldpassword') is-invalid @enderror">
                    @error('oldpassword')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">New Password</label>
                    <input type="password" name="newpassword" class="form-control @error('newpassword') is-invalid @enderror">
                    @error('newpassword')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                    <button type="submit" class="btn btn-primary btn-block mt-5">Confirm</button>
            </form>
        </div>
    </div>
</div>
@endsection



