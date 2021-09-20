 <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    @yield('custom_css')
</head>
<body>
    <div id="app">
        {{-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav> --}}
                {{-- Header Menu --}}
                <div class="header_menu">
                    <div class="d-flex justify-content-center">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    {{-- how to check domain link will not appear --}}
                                    @if(!request()->is('/'))
                                        <a href="" class="back-btn">
                                            <i class="fas fa-angle-left"></i>
                                        </a>
                                    @endif
                                </div>
                                <div class="col-md-4 text-center">
                                    <a href="">
                                        <h3>Magic Pay</h3>
                                    </a>
                                </div>
                                <div class="col-md-4 text-center">
                                    <a href="">
                                        <i class="fas fa-bell"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <div class="content">
            <div class="d-flex justify-content-center">
                <div class="col-md-8">
                    @yield('content')
                </div>
            </div>
        </div>
        {{-- Bottom Menu --}}
        <div class="bottom_menu">
            <a href="" class="scan-tab">
                <div class="inside">
                    <i class="fas fa-qrcode"></i>
                </div>
            </a>
            <div class="d-flex justify-content-center">
                <div class="col-md-8">
                    <div class="d-flex">
                        <div class="col-md-3 text-center">
                            <a href="{{ route('home') }}">
                                <i class="fas fa-home"></i>
                                <p class="mb-5">Home</p>
                            </a>
                        </div>
                        <div class="col-md-3 text-center">
                            <a href="{{ route('wallet') }}">
                                <i class="fas fa-wallet"></i>
                                <p class="mb-5">Wallet</p>
                            </a>
                        </div>
                        <div class="col-md-3 text-center">
                            <a href="">
                                <i class="fas fa-exchange-alt"></i>
                                <p class="mb-5">Transaction</p>
                            </a>
                        </div>
                        <div class="col-md-3 text-center">
                            <a href="{{ route('profile') }}">
                                <i class="fas fa-user"></i>
                                <p class="mb-5">Profile</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ url('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    <!--SweetAlert2-->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    //common for GET and POST CSRF field
    // $(document).ready(function(){
    //     let token = document.head.querySelector('meta[name="csrf-token"]');
    //     if(token){
    //         $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': token.content,
    //                 'Content-Type': 'application/json',
    //                 'Accept': 'application/json'
    //             }
    //         });
    //     }
    // })
  const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

@if(session('updated'))//session will come from backend redirect with() function
    Toast.fire({
    icon: 'success',
    title: "{{ session('updated') }}",
    });
@endif

$('.back-btn').on('click',function(e){
    e.preventDefault();
    window.history.go(-1);

})
    </script>
    @yield('scripts')
</body>
</html>
