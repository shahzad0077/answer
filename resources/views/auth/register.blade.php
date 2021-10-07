<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('/frontend/font/iconsmind/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('/frontend/font/simple-line-icons/css/simple-line-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('/frontend/css/vendor/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/frontend/css/vendor/bootstrap-float-label.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/frontend/css/main.css') }}" rel="stylesheet" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/frontend/img/PetProtect-Logo.ico') }}">
</head>

<body class="background show-spinner">
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
                            <h6 class="mb-4">Register your account</h6>
                                <form id="regForm" method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <label class="form-group has-float-label mb-4">
                                        <input value="{{ old('name') }}" type="text" class="form-control" name="name" placeholder="Full Name" >
                                        <span>Full name</span>
                                    </label>
                                    @error('name')
                                        <div style="color: red">{{ $message }}</div>
                                    @enderror
                                    <label class="form-group has-float-label mb-4">
                                        <input value="{{ old('email') }}" type="email" class="form-control" name="email" placeholder="Email Address" >
                                        <span>E-mail</span>
                                    </label>
                                    @error('email')
                                        <div style="color: red">{{ $message }}</div>
                                    @enderror
                                    <label class="form-group has-float-label mb-4">
                                        <input type="password" class="form-control" name="password" placeholder="Create a Password">
                                        <span>Password</span>
                                    </label>
                                    @error('password')
                                        <div style="color: red">{{ $message }}</div>
                                    @enderror
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a  href="{{url('/login')}}">Already have an account?  </a>
                                        <button type="submit" class="btn btn-primary btn-lg btn-shadow">Signup</button>
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