
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('/images') }}/{!! Cmf::site_settings('favicon') !!}">
    <title>Answerout | Login</title>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,900&amp;display=swap" rel="stylesheet" />
    <link href="{{ asset('/admin/css/icons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/admin/css/app.min.css') }}" rel="stylesheet" />
    <!-- <link href="{{ asset('/admin/css/app-dark.min.css') }}" rel="stylesheet" /> -->
    <link href="{{ asset('/admin/css/vendor/dataTables.bootstrap4.css') }}" rel="stylesheet" />
    <link href="{{ asset('/admin/css/vendor/responsive.bootstrap4.css') }}" rel="stylesheet" />
    <link href="{{ asset('/admin/css/vendor/buttons.bootstrap4.css') }}" rel="stylesheet" />
    <link href="{{ asset('/admin/css/vendor/select.bootstrap4.css') }}" rel="stylesheet" />
    <link href="{{ asset('/admin/css/my-custom.css') }}" rel="stylesheet" />
    <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
    <script src="{{ asset('/admin/js/vendor.min.js') }}" type="text/javascript"></script>
    <link rel="stylesheet" href="{{ asset('/admin/css/loginpage.css') }}">
</head>

<body>
    <div class="main-wrapper">
<div class="login-page">
    <div class="login-body container">
        <div class="loginbox">
            <div class="login-right-wrap">
                <div class="account-header">
                    <div class="account-logo text-center mb-4">
                        <a href="{{ url('admin') }}">
                            <img src="{{ url('/images') }}/{!! Cmf::site_settings('logo_front') !!}" alt="" class="img-fluid">
                        </a>
                    </div>
                </div>
                <div class="login-header">
                    <h3 style="color:white !important;">Login <span>{!! Cmf::site_settings('website_name') !!}</span></h3>
                    <p class="text-muted">Access to our dashboard</p>
                </div>
                @if(session()->has('error'))
                    <div style="text-align: center;color: red;" id="result">{{ session()->get('error') }}</div>
                @endif
                <form id="adminform" action="{{ route('adminlogin') }}" method="POST" id="form">
                                    @csrf
                    <div class="form-group">
                        <label style="color:white !important;" class="control-label">Email</label>
                        <input name="email" placeholder="Enter Email" required class="form-control" value="@if(session()->has('email')){{ session()->get('email') }}  @endif" />
                        @error('email')
                            <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label style="color:white !important;" class="control-label">Password</label>
                        <input class="form-control"  type="password" name="password" placeholder="Enter Password" required />
                        @error('password')
                            <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="">
                        <button class="btn btn-primary btn-block account-btn mb-3" type="submit">Login</button>
                        <a href="{{url('forgot-password')}}" class="text-primary float-right">Forget Password?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
  <script src="{{ asset('/admin/js/app.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('/admin/js/vendor/apexcharts.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('/admin/js/vendor/jquery-jvectormap-1.2.2.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('/admin/js/vendor/jquery-jvectormap-world-mill-en.js') }}" type="text/javascript"></script>
  <script src="{{ asset('/admin/js/pages/demo.dashboard-analytics.js') }}" type="text/javascript"></script>
  <script src="{{ asset('/admin/js/app.min.js')}}"></script>
  <script src="{{ asset('/admin/js/vendor/jquery.dataTables.min.js')}}"></script>
  <script src="{{ asset('/admin/js/vendor/dataTables.bootstrap4.js')}}"></script>
  <script src="{{ asset('/admin/js/vendor/dataTables.responsive.min.js')}}"></script>
  <script src="{{ asset('/admin/js/vendor/responsive.bootstrap4.min.js')}}"></script>
  <script src="{{ asset('/admin/js/vendor/dataTables.buttons.min.js')}}"></script>
  <script src="{{ asset('/admin/js/vendor/buttons.bootstrap4.min.js')}}"></script>
  <script src="{{ asset('/admin/js/vendor/buttons.html5.min.js')}}"></script>
  <script src="{{ asset('/admin/js/vendor/buttons.flash.min.js')}}"></script>
  <script src="{{ asset('/admin/js/vendor/buttons.print.min.js')}}"></script>
  <script src="{{ asset('/admin/js/vendor/dataTables.keyTable.min.js')}}"></script>
  <script src="{{ asset('/admin/js/vendor/dataTables.select.min.js')}}"></script>
  <script src="{{ asset('/admin/js/pages/demo.datatable-init.js')}}"></script>
    </body>
</html>