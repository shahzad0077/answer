@extends('layouts.app-landing-page')
@section('title')
<title>Answer Out - Get Your Query Answered Out</title>
<meta name="DC.Title" content="Answerout - Answer For Your Query | Certification &amp; Answers">
<meta name="rating" content="general">
<meta name="description" content="Answerout">
<meta property="og:type" content="website">
<meta property="og:image" content="">
<meta property="og:title" content="Answerout - Answer For Your Query | Certification &amp; Answers">
<meta property="og:description" content="Answerout">
<meta property="og:site_name" content="Answerout - Answer For Your Query | Certification &amp; Answers">
<meta property="og:url" content="{{ url('') }}">
<meta property="og:locale" content="it_IT">
@endsection
@section('content')
<section class="profile-section single-community pb-special-banner main-banner-mr-top" id="mt-banner-top">
    <div class="container-fluid p-0">
      <div class="bg-home-banner">
        <div class="row" style="margin-right: 0px !important; margin-left: 0px !important">
          <div class="col-lg-5 col-md-5 col-sm-7">

          </div>
          <div class="col-lg-6 col-md-7 col-sm-5">

            <div class="row mt-5 ml-1">
                <div class="col-lg-11 offset-lg-1 col-md-11 offset-md-1  ml-5 ml-xs-0">
                    <h4 class="nerdy-pen__text">Find Answers to Thousands of Questions from <span class="txt-rotate" data-period="2000"data-rotate='[ "Geography.", "Biology.", "Mathematics.", "Chemistry.", "Physics.", "Business.", "English.", "Computer & Technology.", "French.", "Geography.", "Health.", "Mathematics.", "SAT.", "Social Studies", "Spanish", "World Language" ]'> </span>
                    </h4>
                    <p class="banner-text mt-3">Every Month over a million users find answers to their questions. We hope you find yours too..</p>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12 ml-3 ml-xs-0 mt-5 mb-top-search">

                    <!-- <div class="icon-input">
                      <input placeholder="Type your question......" onkeyup="searchbanner()" class="icon-input__text-field main-search-banner ml-5" type="text">
                      <i class="icon-input__icon material-icons"> <img class="search-icon" alt="search" width="60px"> </i>
                    </div>
                    <div style="display: none;" id="livesearchbanner"></div> -->

                    <div class="input-group mb-3" id="main-search-field">
                      <input type="text" placeholder="Type your question......" class="form-control main-search-banner ml-5" onkeyup="searchbanner()" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                      <div class="input-group-prepend">
                        <span onclick="clickonsearch()" class="input-group-text" id="basic-addon1"><img class="search-icon" alt="search" width="80px"></span>
                      </div>
                    </div>

                    <div style="display: none;" id="livesearchbanner"></div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
<!-- ==========Features-Section========== -->
<section class="feature-section extra-feature pt-0 pb-mine mt-top--100">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12 text-center">
                <h3>Subjects</h3>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="registered-slider owl-carousel">
                    <div class="single-slider text-center">
                        <a href="{{url('/categories')}}" class="btn btn-theme btn-slider">All</a>
                    </div>
                    @foreach($categories as $r)
                    <div class="single-slider text-center">

                        <a href="{{url('')}}/{{ $r->url }}" class="btn btn-theme btn-slider">
                            <div class="row">
                                <div class="col-md-3 col-4">
                                    @if(!empty(Cmf::get_image_name('subjectimages' , 'subjectid' , $r->id)->first()->image_name))
                                    <img class="home-cat-icon" src="{{ url('/images/') }}/{{ Cmf::get_image_name('subjectimages' , 'subjectid' , $r->id)->first()->image_name }}">

                                    @endif
                                </div>
                                <div class="col-md-9 col-8"><span class="cat-text-limit">{!! Str::limit($r->name, 8) !!}</span></div>
                            </div>
                            </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==========Features-Section========== -->
<!-- ==========Update-profile-Section========== -->
<section class="update-profile-section">
    <div class="hero-body">
            <div class="container">

                <div class="row mb-4">
                    <div class="col-md-12 text-center">
                        <h3>Get the top rated result, in just a sec.</h3>
                    </div>
                </div>
                <br>
                <div class="row mb-5">
                    <div class="col-md-12 text-center">
                        <img width="230px" src="{{asset('/front/assets/images/shahzad/landing-ratings.svg')}}" alt="answerout">
                    </div>
                </div>
                <div id="customers-testimonials" class="owl-carousel mt-2">
                    @foreach(DB::table('testimonials')->where('status' , 'Published')->get() as $r)
                    <div class="box">
                        <div class="level-item">
                            <div>
                                <div class="heading">
                                    <img class="avatar" src="{{ url('/images/') }}/{{ $r->image }}" width="100px" height="100px">
                                </div>
                                <div class="row p-3">
                                    <div class="col-md-12 text-center">
                                        <p>“{{ $r->testimonial }}”</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach

                </div>
            </div>
        </div>
</section>
<!-- ==========Update-profile-Section========== -->
<section class="feature-section extra-feature pt-0 pb-mine mt-top--100">
    <div class="container">
        <div class="row mb-5 mt-3">
            <div class="col-md-12 text-center">
                <h3>Blog Categories</h3>
            </div>
        </div>


        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="registered-slider owl-carousel">


                    <div class="single-slider text-center">
                        <a href="{{url('/study-tools')}}" class="btn btn-theme btn-slider">
                            <div class="row">
                                <div class="col-md-12 col-12"><span class="cat-text-limit">Study Tools</span></div>
                            </div>
                            </a>
                    </div>

                    <div class="single-slider text-center">
                        <a href="{{url('/colleges-and-education')}}" class="btn btn-theme btn-slider">
                            <div class="row">
                                <div class="col-md-12 col-12"><span class="cat-text-limit">College & Education</span></div>
                            </div>
                            </a>
                    </div>

                    

                </div>
            </div>
        </div>
    </div>
</section>


<section style="margin-top:0px !important;" class="blog-page single-blog-page feature-section extra-feature pt-0 pb-mine mt-top--100">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12 text-center">
                <h3>Latest Blogs</h3>
            </div>
        </div>
        <div class="row">

          <?php $count = 0; ?>
          @foreach($blogs as $r)
          @if(!empty(Cmf::get_image_name('blogimages' , 'blogid' , $r->id)->first()->image_name))

            <div class="col-md-4">
              <div class="card card-blog-home">
                @if(!empty(Cmf::get_image_name('blogimages' , 'blogid' , $r->id)->first()->image_name))
                <img class="blog-card-img card-img-top pt-3 pl-3 pr-3" src="{{ url('/images/') }}/{{ Cmf::get_image_name('blogimages' , 'blogid' , $r->id)->first()->image_name }}" width="100%" height="230px" alt="" >
                @endif
                <div class="card-body">
                  <a href="{{ url('') }}/{{ $r->url }}">
                    <h1 class="blog-title">{!! Str::limit($r->name) !!}</h1>
                  </a>
                  <div class="row mt-2">
                    <div class="col-5">
                      @if(DB::table('wphj_term_relationships')->where('object_id' , $r->id)->count() > 0)

                      @foreach(DB::table('wphj_term_relationships')->where('object_id' , $r->id)->get() as $c)
                      @if(DB::table('blogcategories')->where('id' , $c->term_taxonomy_id)->count() > 0)
                      <a class="cat-title-limit" href="{{ url('') }}/{{ DB::table('blogcategories')->where('id' , $c->term_taxonomy_id)->get()->first()->slug }}">  <span class="text-muted"></span> {{DB::table('blogcategories')->where('id' , $c->term_taxonomy_id)->get()->first()->name}} </a>

                         @endif
                     @endforeach
                     @endif
                    </div>
                    <div class="col-7 text-right">
                      <a href="{{ url('') }}/{{ $r->url }}" type="button" class="btn btn-blog-home" name="button">
                        read more &nbsp; <img src="{{ url('/front/assets/images/shahzad/arrow-right.png') }}" width="20px" alt="">
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif
            @endforeach
        </div>
        <div class="row mt-3">
          <div class="col-md-12 text-center">
            <a href="{{url('/blogs')}}" class="btn btn-primary-blog" name="button">
              View More &nbsp;<img src="{{ url('/front/assets/images/shahzad/arrow-right-white.png') }}" width="20px" alt="">
            </a>
          </div>
        </div>
    </div>
</section>

<section class="profile-section single-community pb-special-banner" style="padding-bottom: 0px !important; margin-bottom: -110px;">
    <div class="container p-0">
        <div class="row mb-4">
            <div class="col-md-12 text-center">
                <h2 class="theme-text"><i>How To Use</i></h2>
            </div>
        </div>

      <div class="bg-second-banner">
      </div>
    </div>
</section>






<script type="text/javascript">
    function clickonsearch()
    {
        var value = $('.main-search-banner').val();
        if(value == '')
        {
            $('.main-search-banner').focus();
        }else{
            var mainurl = '{{ url('search') }}';
            var value = $('.main-search-banner').val();
            location.replace(mainurl+'/'+value);
        }
    }
    function searchbanner()
        {
            var mainurl = '{{ url('') }}';

            var value = $('.main-search-banner').val();
            if(value == '')
            {
                $('#livesearchbanner').hide();
            }else{
                $.ajax({
                    type: "GET",
                    url: mainurl+'/searchnavbar/'+value,
                    success: function(resp) {
                        $('#livesearchbanner').show();
                        $('#livesearchbanner').html(resp);
                    }
                });
            }
        }
        $(document).on('keypress',function(e) {
            if(e.which == 13) {
               var mainurl = '{{ url('search') }}';
               var value = $('.main-search-banner').val();
               location.replace(mainurl+'/'+value);
            }
        });
</script>

<script type="text/javascript">
    $(document).ready(function(){

          $('#carousel').owlCarousel( {
        loop: true,
        center: true,
        items: 3,
        margin: 50,
        autoplay: true,
        dots:true,
    nav:true,
        autoplayTimeout: 2500,
        smartSpeed: 450,
    navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 2
            },
            1170: {
                items: 3
            }
        }
    });
    });
</script>


    <script>
        var TxtRotate = function(el, toRotate, period) {
          this.toRotate = toRotate;
          this.el = el;
          this.loopNum = 0;
          this.period = parseInt(period, 10) || 2000;
          this.txt = '';
          this.tick();
          this.isDeleting = false;
        };

        TxtRotate.prototype.tick = function() {
          var i = this.loopNum % this.toRotate.length;
          var fullTxt = this.toRotate[i];

          if (this.isDeleting) {
            this.txt = fullTxt.substring(0, this.txt.length - 1);
          } else {
            this.txt = fullTxt.substring(0, this.txt.length + 1);
          }

          this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

          var that = this;
          var delta = 300 - Math.random() * 100;

          if (this.isDeleting) { delta /= 2; }

          if (!this.isDeleting && this.txt === fullTxt) {
            delta = this.period;
            this.isDeleting = true;
          } else if (this.isDeleting && this.txt === '') {
            this.isDeleting = false;
            this.loopNum++;
            delta = 500;
          }

          setTimeout(function() {
            that.tick();
          }, delta);
        };

        window.onload = function() {
          var elements = document.getElementsByClassName('txt-rotate');
          for (var i=0; i<elements.length; i++) {
            var toRotate = elements[i].getAttribute('data-rotate');
            var period = elements[i].getAttribute('data-period');
            if (toRotate) {
              new TxtRotate(elements[i], JSON.parse(toRotate), period);
            }
          }
          // INJECT CSS
          var css = document.createElement("style");
          css.type = "text/css";
          css.innerHTML = ".txt-rotate > .wrap { border-right: 0.08em solid #fff }";
          document.body.appendChild(css);
        };
    </script>



@endsection
