<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Two Factor Authentication</title>
  <!-- Stylesheets -->
  <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,900&amp;display=swap" rel="stylesheet" />
  <link href="{{ asset('/admin/css/icons.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('/admin/css/app.min.css') }}" rel="stylesheet" />
  <!-- <link href="{{ asset('/admin/css/app-dark.min.css') }}" rel="stylesheet" /> -->


</head>
  <body class="loading authentication-bg" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card">

                            <!-- Logo -->
                            <div class="card-header pt-4 pb-4 text-center bg-white">
                                <a href="index.html">
                                    <span><img src="{{asset('/admin/images/logo.png')}}" alt="" height="40"></span>
                                </a>
                            </div>

                            <div class="card-body p-4">
                                
                                <div class="text-center m-auto">
                                    <img src="{{asset('/admin/images/mail_sent.svg')}}" alt="mail sent image" height="64" />
                                    <h4 class="text-dark-50 text-center mt-4 font-weight-bold">Please check your email</h4>
                                    <p class="text-muted mb-4">
                                        A email has been send to <b>{{ Auth::user()->email }}</b>.
                                        Please check for an email for Authentication Code. 
                                    </p>
                                </div>

                                <form action="{{ route('twofactor') }}" method="POST" >
                                    @csrf
                                    <div class="form-group">
                                        <label style="color:white !important;" class="control-label">6 Digits Code</label>
                                        <input name="code" placeholder="Please Enter Code" required class="form-control"/>
                                        @if(session()->has('message'))
                                            <div style="color: red;" id="result">{{ session()->get('message') }}</div>
                                        @endif 
                                    </div>
                                    <div class="">
                                        <button type="submit" class="btn btn-primary btn-block account-btn mb-3">Login</button>
                                        <a href="{{url('admin/resendcode')}}" class="text-primary float-right">Resend Code</a>
                                    </div>
                                </form>
                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->


                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->
        
    </body>

    <!-- bundle -->
    <script src="{{ asset('/admin/js/vendor.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/admin/js/app.min.js') }}" type="text/javascript"></script>

</html>


<!-- Delete Modal -->

