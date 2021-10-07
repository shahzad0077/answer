@extends('layouts.app')
@section('title')
<title>Contact Us</title>
<meta name="DC.Title" content="Contact Us">
<meta name="rating" content="general">
<meta name="description" content="Contact Us">
<meta property="og:type" content="website">
<meta property="og:image" content="">
<meta property="og:title" content="Contact Us">
<meta property="og:description" content="Contact Us">
<meta property="og:site_name" content="Contact Us">
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
    "name": "Contact Us"
  }]
}
</script>
@endsection
@section('content')


<!-- ==========Contact-Section========== -->
<section class="contact-section">
    <div class="container">
        <div class="row">
          <div class="col-md-12">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                </ol>
              </nav>
          </div>
      </div>
    </div>
    <!-- <img class="img-left" src="assets/images/contact/img-left.png" alt=""> -->
    <img class="img-right" src="{{asset('/front/assets/images/contact/img-right.png')}}" alt="">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="content">
                    <div class="section-header">
                        <h6 class="sub-title">
                            Contact Us
                        </h6>
                        <h2 class="title">
                            Get in Touch
                        </h2>
                        <p class="text">
                            We'd love to hear from you! Let us know how we can help.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7">
                <div class="contact-form-wrapper">
                    <div class="single-input">
                        <i class="far fa-user"></i>
                        <input type="text" id="name" placeholder="Full Name">
                    </div>
                    <div class="single-input">
                        <i class="far fa-envelope"></i>
                        <input type="text" id="email" placeholder="Enter Your Email ID">
                    </div>
                    <div class="single-input">
                        <i class="far fa-comments"></i>
                        <textarea id="message" placeholder="Type Your Text" ></textarea>
                    </div>
                    <div id="error"></div>
                    <a onclick="contactus()" href="javascript:void(0)" class="custom-button">Submit</a>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    function contactus()
    {
        $('#error').show();
        var name = $('#name').val();
        var email = $('#email').val();
        var message = $('#message').val();
        if(name == '' && message == '' && email == '')
        {   
            $("#error").css("color", "red");
            $("#error").css("margin-bottom", "10px");
            $('#error').html('All Fields are Required');
        }else{
            $.ajax({
                type: "GET",
                url: "{{ url('submitcontactus') }}/"+name+"/"+email+"/"+message,
                success: function(resp) {
                    if(resp == 'string')
                    {
                        $('#name').val('');
                        $('#email').val('');
                        $('#message').val('');
                        $("#error").css("color", "green");
                        $("#error").css("margin-bottom", "10px");
                        $('#error').html('Your Message Submitted Succssfully. We Will Contact you Soon');
                    }
                    setTimeout(function(){ 
                        $('#error').fadeOut();
                     }, 3000);
                }
            });
        } 
    }
</script>
<!-- ==========Contact-Sectionn========== -->
@endsection