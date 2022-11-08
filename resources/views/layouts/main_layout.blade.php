<!doctype html>
<html>
<head>
	<title>Moonshiner hoodie ordering app</title>
	<link rel="icon" href="https://moonshiner.at/wp-content/uploads/2022/07/moonshiner-logo-POS-1000x203px.png" type = "image/x-icon">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" crossorigin="anonymous"></script>
   @yield('head')
</head>
<body style="padding-top: 4.5rem;">
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img height="40" src="https://moonshiner.at/wp-content/uploads/2022/07/moonshiner-logo-POS-1000x203px.png" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{route('home')}}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('order_hoodies')}}">Order hoodies</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                @if (auth()->check())
                	<li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{route('home')}}"><b><i>Welcome, user</i></b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{route('my_orders')}}">My orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{route('logout')}}">Logout</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{route('login')}}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{route('register')}}">Register</a>
                    </li>
                @endif
                </ul>
            </div>
        </div>
    </nav>

@yield('content')

</body>