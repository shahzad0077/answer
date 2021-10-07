<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
    <!-- Meta -->

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#5352ed">
      @yield('title')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/jpg" href="{{ asset('/front/assets/images/fav.png')}}"/>
    <link rel="stylesheet" href="{{ asset('/front/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/front/assets/css/all.min.css')}}">
    <!-- <link rel="stylesheet" href="{{ asset('/front/assets/css/animate.css')}}"> -->
    <!-- <link rel="stylesheet" href="{{ asset('/front/assets/css/flaticon.css')}}"> -->
    <!-- <link rel="stylesheet" href="{{ asset('/front/assets/css/magnific-popup.css')}}"> -->
    <!-- <link rel="stylesheet" href="{{ asset('/front/assets/css/odometer.css')}}"> -->
    <link rel="stylesheet" href="{{ asset('/front/assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/front/assets/css/owl.theme.default.min.css')}}">
    <!-- <link rel="stylesheet" href="{{ asset('/front/assets/css/nice-select.css')}}">
    <link rel="stylesheet" href="{{ asset('/front/assets/css/jquery.animatedheadline.css')}}"> -->
    <link rel="stylesheet" href="{{ asset('/front/assets/css/main.css')}}">
    <link rel="stylesheet" href="{{ asset('/front/assets/css/switch.css')}}">
    <!-- <link rel="stylesheet" href="{{ asset('/front/assets/css/additional.css')}}"> -->
    <link rel="stylesheet" href="{{ asset('/front/assets/css/responsive.css')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('/front/assets/images/logo.png') }}">
    <script src="{{ asset('/front/assets/js/jquery-3.3.1.min.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('/front/assets/summernote/summernote-bs4.css') }}">

    <script src="{{ asset('/front/assets/summernote/summernote-bs4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js" integrity="sha512-DNeDhsl+FWnx5B1EQzsayHMyP6Xl/Mg+vcnFPXGNjUZrW28hQaa1+A4qL9M+AiOMmkAhKAWYHh1a+t6qxthzUw=="
    crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css"
    integrity="sha512-yye/u0ehQsrVrfSd6biT17t39Rg9kNc+vENcCXZuMz2a+LWFGvXUnYuWUW6pbfYj1jcBb/C39UZw2ciQvwDDvg=="
    crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
    integrity="sha512-BNZ1x39RMH+UYylOW419beaGO0wqdSkO7pi1rYDYco9OL3uvXaC/GTqA5O4CVK2j4K9ZkoDNSSHVkEQKkgwdiw=="
    crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {!! Cmf::site_settings('header_script') !!}
    @if(!empty(Cmf::site_settings('aditional_css')))
    @include('frontend.additionalcss')
    @endif
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '915550249016502',
      cookie     : true,
      xfbml      : true,
      version    : 'v10.0'
    });

    FB.AppEvents.logPageView();

  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
  $(document).mouseup(function(e)
  {
      var container = $("#livesearch");
      if (!container.is(e.target) && container.has(e.target).length === 0)
      {
          container.hide();
      }
  });
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "url": "{{ url('') }}",
  "potentialAction": [{
    "@type": "SearchAction",
    "target": {
      "@type": "EntryPoint",
      "urlTemplate": "{{url('search/')}}/{search_term_string}"
    },
    "query-input": "required name=search_term_string"
  },{
    "@type": "SearchAction",
    "target": {
      "@type": "EntryPoint",
      "urlTemplate": "android-app://com.example/https/query.example.com/search/?q={search_term_string}"
    },
    "query-input": "required name=search_term_string"
  }]
}
</script>
<script type="application/ld+json">
{
 "@context": "https://schema.org/",
 "@type": "WebPage",
 "name": "Quick Brown Fox",
 "speakable":
 {
  "@type": "SpeakableSpecification",
  "xpath": [
    "/html/head/title",
    "/html/head/meta[@name='description']/@content"
    ]
  },
 "url": "{{url()->current()}}"
 }
</script>
</head>
  <body>
    <div class="caption" id="d-none">
      <h1>Questions and answers on subjects</h1>
    </div>
    @include('includes.front-navbar-landing')
    @yield('content')
    @include('includes.front-footer')
  </body>
  <script src="{{ asset('/front/assets/js/modernizr-3.6.0.min.js')}}"></script>
  <script src="{{ asset('/front/assets/js/plugins.js')}}"></script>
  <script src="{{ asset('/front/assets/js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('/front/assets/js/heandline.js')}}"></script>
  <script src="{{ asset('/front/assets/js/isotope.pkgd.min.js')}}"></script>
  <script src="{{ asset('/front/assets/js/magnific-popup.min.js')}}"></script>
  <script src="{{ asset('/front/assets/js/owl.carousel.min.js')}}"></script>
  <script src="{{ asset('/front/assets/js/wow.min.js')}}"></script>
  <script src="{{ asset('/front/assets/js/countdown.min.js')}}"></script>
  <script src="{{ asset('/front/assets/js/odometer.min.js')}}"></script>
  <script src="{{ asset('/front/assets/js/viewport.jquery.js')}}"></script>
  <script src="{{ asset('/front/assets/js/nice-select.js')}}"></script>
  <script src="{{ asset('/front/assets/js/main.js')}}"></script>
  <script  type="text/javascript" src="https://unpkg.com/typeahead.js@0.11.1/dist/typeahead.bundle.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- <script src="{{ asset('/front/assets/js/core.js')}}"></script> -->

<script type="text/javascript">
const toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
const currentTheme = localStorage.getItem('theme');

if (currentTheme) {
    document.documentElement.setAttribute('data-theme', currentTheme);

    if (currentTheme === 'dark') {
        toggleSwitch.checked = true;
    }
}

function switchTheme(e) {
    if (e.target.checked) {
        document.documentElement.setAttribute('data-theme', 'dark');
        localStorage.setItem('theme', 'dark');
    } else {
        document.documentElement.setAttribute('data-theme', 'light');
        localStorage.setItem('theme', 'light');
    }
}

toggleSwitch.addEventListener('change', switchTheme, false);
</script>

<script type="text/javascript">
  jQuery(document).ready(function($) {

            $('#customers-testimonials').owlCarousel({
                loop: true,
                center: true,
                items: 3,
                autoplay: true,
                dots:false,
                nav:true,
                 autoplayTimeout: 100000,
                responsive: {
                  100: { items: 1 },
                  768: { items: 2 },
                  1170: { items: 3 }
                }
            });
          });
</script>

</html>
