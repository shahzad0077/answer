<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
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
                            <h3>Create New Password</h3>
                            @if(session()->has('error'))
                                <div style="text-align: center;color: red;" id="result">{{ session()->get('error') }}</div>
                            @endif
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group">
                                    <label>{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                                <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Reset Password') }}
                                        </button>
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
