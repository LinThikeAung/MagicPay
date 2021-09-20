@extends('frontend.layouts.app')
@section('title','Profile')
@section('content')
<div class="account">
    <div class="profile-img">
        <img src="https://ui-avatars.com/api/?background=0D8ABC&color=fff&name={{ auth()->user()->name }}" alt="">
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <span>Username</span>
                <span>{{ $user->name }}</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between">
                <span>Phone Number</span>
                <span>{{ $user->phone }} </span>
            </div>
            <hr>
            <div class="d-flex justify-content-between">
                <span>Email</span>
                <span>{{ $user->email }}</span>
            </div>
        </div>
    </div>
    <div class="card mt-5">
        <div class="card-body">
            <a href="{{ route('update-password') }}" class="update-password">
                <div class="d-flex justify-content-between">
                    <span>Update Password</span>
                    <span><i class="fas fa-angle-right"></i></span>
                </div>
            </a>
            <hr>
            <div class="d-flex justify-content-between logout">
                <span>Logout</span>
                <span><i class="fas fa-angle-right"></i></span>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $(document).on('click','.logout',function(e){
            e.preventDefault();
            //sweetalert2
            Swal.fire({
            title: 'Do you want to logout?',
            showCancelButton: true,
            confirmButtonText: 'Confirm',
            }).then((result) => {
            if (result.isConfirmed)
                {
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') ,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });
                    $.ajax({
                        url: "{{ route('logout') }}",
                        type: 'POST',
                        success:function(res){
                           window.location.replace("{{ route('profile') }}");
                        }
                    });
                }
            });
        });
    });
</script>
@endsection


