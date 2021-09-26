@extends('frontend\layouts.app')
@section('title','Transfer')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <p class="mb-1"><strong>From</strong></p>
                        <p class="mb-1">{{ $user->name }}</p>
                        <p class="mb-1">{{ $user->phone}}</p>
                    </div>
                    <form action="{{ url('transfer/confirm')  }}" method="POST">
                        @csrf
                        @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                    <div class="form-group">
                        <label for=""><strong>To</strong><span class="account-info text-success"></span></label>
                        <div class="input-group">
                            <input type="text" name="tophone" value="{{ old('tophone') }}" id="tophone"  class="form-control @error('tophone') is-invalid @enderror">
                            <div class="input-group-append">
                                <span class="input-group-text verify-btn"><i class="fas fa-check-circle"></i></span>
                            </div>
                            @error('tophone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Amount (MMK)</strong></label>
                        <input type="text" name="amount" value="{{ old('amount') }}"  class="form-control @error('amount') is-invalid @enderror">
                        @error('amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Description</strong></label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mt-5">Continue</button>
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

        $('.verify-btn').on('click',function(){
        var phone = $('#tophone').val();
            $.ajax({
                url: "/to-account-verify?phone=" + phone ,
                type: 'GET',
                success:function(res){
                    console.log(res);
                    if(res.status == 'success'){
                        $('.account-info').text(" : (" + res.data['name'] + ")");
                    }else{
                        $('.account-info').addClass("text-danger");
                        $('.account-info').text(" : (" + res.message + ")");
                    }
                }
            });
        })
    })
</script>

@endsection
