<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forget Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('/frontend/font/iconsmind/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('/frontend/font/simple-line-icons/css/simple-line-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('/frontend/css/vendor/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/frontend/css/vendor/bootstrap-float-label.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/frontend/css/main.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ url('/frontend/css/dore.light.blue.min.css') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/frontend/img/PetProtect-Logo.ico') }}">
</head>

<body class="background">
    <div class="fixed-background"></div>
    <main>
        <div class="container">
            <div class="row h-100">
                <div class="col-12 col-md-10 mx-auto my-auto">
                    <div class="card auth-card">
                        <div class="position-relative image-side ">
                            <!-- <p class=" text-white h2">MAGIC IS IN THE DETAILS</p>
                            <p class="white mb-0">
                                Please use your credentials to login.
                                <br>If you are not a member, please
                                <a href="#" class="white">register</a>.
                            </p> -->
                        </div>
                        <div class="form-side">
                            <a href="{{url('/')}}">
                                <span class="logo-single logo-mine"></span>
                            </a>
                            <h3>Forgot Password</h3>
                            <p>Please provide your registerd email and we'll forward you the details</p>
                            @if(session()->has('error'))
                                <div style="text-align: center;color: red;" id="result">{{ session()->get('error') }}</div>
                            @endif
                                <form method="POST" action="{{ route('password.email') }}">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Enter Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        </div>
                                        @error('email')
                                            <strong style="color: red;">{{ $message }}</strong>
                                        @enderror
                                        @if (session('status'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                            </div>
                                        @endif
                                        <br><br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary">Recover</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('/frontend/js/vendor/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/frontend/js/vendor/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/frontend/js/dore.script.js') }}" type="text/javascript"></script>
  <script src="{{ asset('/frontend/js/scripts.js') }}" type="text/javascript"></script>
</body>
</html>
