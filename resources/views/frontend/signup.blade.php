@extends('layouts.app-2')
@section('title')
<title>Signup</title>
<meta name="DC.Title" content="Login">
<meta name="rating" content="general">
<meta name="description" content="Answerout Login">
<meta property="og:type" content="website">
<meta property="og:image" content="">
<meta property="og:title" content="Answerout Login">
<meta property="og:description" content="Login">
<meta property="og:site_name" content="Answerout">
<meta property="og:url" content="{{ url('') }}">
<meta property="og:locale" content="it_IT">
@endsection
@section('content')
<!-- ========== Login & Registation Section ========== -->
<div class="bg-login">
    <div class="bg-white-login">
        <section class="log-reg">
    <div class="container">
      <div class="row justify-content-end">
        <div class="image image-log" style='z-index: 999999;background-image: url({{ asset("/front/assets/images/shahzad/login-sidebar.png")}});'>
        </div>
        <div class="col-lg-6">
          <div class="align-items-center">
            <div class="row mt-5 align-items-center">
              <div class="col-lg-8 offset-md-2 login-right-margin">

                <div class="row mb-5">
                  <div class="col-lg-12 text-center">
                    <!-- Logo -->
                    <a href="{{url('/')}}"><img src="{{ url('/front/assets/images/logo.svg') }}" class="logo-login" alt="logo"></a>
                  </div>
                </div>
                
                <div class="row mb-2">
                  <div class="col-lg-12">
                    <a href="{{ url('auth/google') }}" class="btn btn-primary btn-google"><img src="{{asset('/front/assets/images/shahzad/google-icon.svg')}}"> Signup with Google</a>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-lg-12">
                    <a href="{{ url('auth/facebook') }}" class="btn btn-primary btn-google"><img src="{{asset('/front/assets/images/shahzad/facebook-icon.svg')}}"> Signup with Facebook</a>
                  </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12 text-center">
                        <p class="f-14">Already have an account?</p>
                    </div>
                    <div class="col-md-12">
                      <a href="{{url('/signin')}}" class="btn btn-theme btn-block mb-2">Sign In</a>
                    </div>
                  </div>

                <!-- Privacy Policies -->
                <div class="row mb-2">
                  <div class="col-md-12 text-center">
                    <p class="f-14">By signing up, you agree to our <a href="{{ url('terms-and-conditions') }}" class="anchor-color">Terms , Data Policy</a> and <a href="{{ url('cookies-policy') }}" class="anchor-color">Cookies Policy</a> .</p>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
    </div>
</div>
  

  <!-- ========== Login & Registation Section ========== -->
@endsection