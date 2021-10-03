@extends('frontend\layouts.app')
@section('title','Transfer Confirm')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                    <form action="{{ url('/transfer/complete') }}" method="POST" id="sendComplete">
                        @csrf
                        <input type="hidden" name="hashVal" value="{{ $hashValue }}">
                        <input type="hidden" name="tophone" value="{{ $to_account->phone }}">
                        <input type="hidden" name="amount" value="{{ $amount }}">
                        <input type="hidden" name="description" value="{{ $description }}">

                        <div class="form-group">
                            <p class="mb-1"><strong>From</strong></p>
                            <p class="mb-1">{{ $from_account->name }}</p>
                            <p class="mb-1">{{ $from_account->phone}}</p>
                        </div>
                        <div class="form-group">
                            <label for=""><strong>To</strong></label>
                            <p class="text-muted">{{ $to_account->phone }}</p>
                        </div>
                        <div class="form-group">
                            <label for=""><strong>Amount (MMK)</strong></label>
                            <p class="text-muted">{{ $amount }}</p>
                        </div>
                        <div class="form-group">
                            <label for=""><strong>Description</strong></label>
                            <p class="text-muted">{{ $description }}</p>
                        </div>

                        <button class="btn btn-primary mt-5 btn-block btn-confirm">Continue</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function(){
    $('.btn-confirm').on('click',function(e){
        e.preventDefault();
        Swal.fire({
        title: 'Please enter your password',
        icon: 'info',
        html:'<input type="password" name="password" class="form-control text-center check-password" autofocus>',
        showCancelButton: true,
        confirmButtonText: "Confirm",
        cancelButtonText: "Cancel"
        }).then((result) => {
                if (result.isConfirmed) {
                    var password = $('.check-password').val();
                    $.ajax({
                        url: "/transfer/confirm/password?password=" + password ,
                        type: 'GET',
                        success:function(res){
                            if(res.status == 'success'){
                                $('#sendComplete').submit();
                            }else{
                                Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: res.message,
                            })
                        }
                    }
                });
            }
        });
    });
})
</script>
@endsection
