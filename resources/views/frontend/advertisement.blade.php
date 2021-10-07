@extends('layouts.app')
@section('title')
<title>Advertise with us</title>
<meta name="DC.Title" content="Advertisement">
<meta name="rating" content="general">
<meta name="description" content="Advertisement">
<meta property="og:type" content="website">
<meta property="og:image" content="">
<meta property="og:title" content="Advertisement">
<meta property="og:description" content="Advertisement">
<meta property="og:site_name" content="Advertisement">
<meta property="og:url" content="{{ url('') }}">
<meta property="og:locale" content="it_IT">
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [{
    "@type": "ListItem",
    "position": 1,
    "name": "Home",
    "item": "{{ url('') }}"
  },{
    "@type": "ListItem",
    "position": 2,
    "name": "Advertisement"
  }]
}
</script>
@endsection
@section('content')
<style type="text/css">
    /* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>
<div class="container">
        <div class="row mt-100">
          <div class="col-md-12">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Advertisement</li>
                </ol>
              </nav>
          </div>
      </div>
    </div>

    <!-- ==========Contact-Section========== -->
    <section class="contact-section pd-top-60">
        
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="content">
                        <div class="section-header text-left">
                            <h2 class="title theme-text mb-3">
                                Advertise with us
                            </h2>
                            <p class="text">
                                Answerout is one of the premium Online Learning communities that delivers free education to over a million and more users every month. High value visitors that signs-up, login and make full use of answerout everyday.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    @if(session()->has('message'))
                    <div style="text-align: center;" class="alert alert-success alert-dismissible">
                      <a  href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ session()->get('message') }}
                    </div>
                    @endif
                    <form method="post" action="{{ url('advertisementrequest') }}">
                        {{ csrf_field() }}
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <input type="text" required="" id="input-bg-light" class="form-control input-lg  shadow-light mb-3" placeholder="Name*" name="name">
                                <input type="text" required="" id="input-bg-light" class="form-control input-lg  shadow-light mb-3" placeholder="Company*" name="company">
                                <input type="email" required="" id="input-bg-light" class="form-control input-lg  shadow-light mb-3" placeholder="Email address*" name="email">
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <input pattern="[0-9]" id="phone" type="tel" class="form-control input-bg-light input-lg  shadow-light mb-3" placeholder="Phone number" >
                                        <input class="input-bg-light" id="exactphonenumber" type="hidden"  name="phonenumber">
                                    </div>
                                    
                                </div>
                                
                                <br>
                                <script>
                                    $( document ).ready(function() {
                                        $(".iti--separate-dial-code").css("width", "100%");
                                    });
                                    var input = document.querySelector("#phone");
                                    window.intlTelInput(input, {
                                        separateDialCode: true,
                                        customPlaceholder: function (
                                            selectedCountryPlaceholder,
                                            selectedCountryData
                                        ) {
                                            return "e.g. " + selectedCountryPlaceholder;
                                        },
                                    });

                                    
                                </script>
                                <textarea name="message" id="input-bg-light" class="form-control input-lg  mb-2" rows="6" placeholder="Message"></textarea>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-12">
                                <button class="btn btn-theme">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </section>
    <!-- ==========Contact-Sectionn========== -->
@endsection