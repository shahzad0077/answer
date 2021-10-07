@extends('layouts.app')
@section('title')
<?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
<title>{{$data->name}}</title>
<meta name="DC.Title" content="{{$data->name}} - Answer Out">
<meta name="rating" content="general">
<meta name="description" content="Here is the answer to the question {!! Str::limit($data->name, 118) !!} ">
<link rel="canonical" href="{{ $actual_link }}" />
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="article" />

<meta property="og:site_name" content="Answer Out" />
@if(!empty(Cmf::get_image_name('blogimages' , 'blogid' , $data->id)->first()->image_name))
<meta property="og:image" content="{{ url('/images/') }}/{{ Cmf::get_image_name('blogimages' , 'blogid' , $data->id)->first()->image_name }}" alt="{{$data->name}}">
@endif
<meta property="og:title" content="{{$data->name}} - Answer Out">
<meta property="og:description" content="Here is the answer to the question {!! Str::limit($data->name, 118) !!} ">
<meta property="og:url" content="{{ $actual_link }}" />

<meta property="og:site_name" content="Answerout">
<meta property="og:url" content="{{ $actual_link }}">
<meta property="og:locale" content="it_IT">
@include('frontend.googleschemaforblogs')
<style type="text/css">
    h3{
        font-weight: bold;
    font-size: 21px !important;
    }
    .has-background{
        padding: 1.25em 2.375em;
    }
    .has-vivid-green-cyan-color{
        color: #00d084 !important;
    }
</style>
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
    "name": "Blogs",
    "item": "{{url('/blogs')}}"
  },{
    "@type": "ListItem",
    "position": 3,
    "name": "{{ DB::table('blogcategories')->where('id' , DB::table('wphj_term_relationships')->where('object_id' , $data->id)->get()->first()->term_taxonomy_id)->get()->first()->name }}",
    "item": "{{url('/')}}/{{ DB::table('blogcategories')->where('id' , DB::table('wphj_term_relationships')->where('object_id' , $data->id)->get()->first()->term_taxonomy_id)->get()->first()->slug }}"
  },{
    "@type": "ListItem",
    "position": 4,
    "name": "{{$data->name}}"
  }]
}
</script>
@endsection
@section('content')
<!-- ==========Blog-Page========== -->
    <section class="blog-page single-blog-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/blogs')}}">Blog</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/')}}/{{ DB::table('blogcategories')->where('id' , DB::table('wphj_term_relationships')->where('object_id' , $data->id)->get()->first()->term_taxonomy_id)->get()->first()->slug }}">{{ DB::table('blogcategories')->where('id' , DB::table('wphj_term_relationships')->where('object_id' , $data->id)->get()->first()->term_taxonomy_id)->get()->first()->name }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$data->name}}</li>
                      </ol>
                    </nav>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="top-question-banner" style="height:auto !important;">
                        {!! Cmf::site_settings('question_detail_page_top') !!}
                    </div>
                </div>
            </div>
            @include('admin.alert')
            <div class="row">
                <div class="col-md-3">
                    <div class="ads">
                        {!! Cmf::site_settings('left_add_1') !!}
                    </div>
                    <div class="ads">
                        {!! Cmf::site_settings('left_add_2') !!}
                    </div>
                </div>


                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="single-blog">
                                @if(!empty(Cmf::get_image_name('blogimages' , 'blogid' , $data->id)->first()->image_name))
                                <div class="img">
                                    <img display="none" style="height:350px !important; object-fit:contain !important; display:none !important" src="{{ url('/images/') }}/{{ Cmf::get_image_name('blogimages' , 'blogid' , $data->id)->first()->image_name }}" alt="{{$data->name}}">
                                </div>
                                @endif
                                <div class="content">
                                    <div class="right">
                                        <!-- <p class="date">
                                           {{ date('M d, Y', strtotime($data->created_at)) }}
                                        </p> -->
                                        <h1 class="title">
                                            {{$data->name}}
                                        </h1>
                                        <b>By:</b>
                                        <span>
                                            @if(!empty(DB::table('users')->where('id' , $data->added_by)->get()->first()->username))

                                            <a href="{{ url('user-profile') }}/{{ DB::table('users')->where('id' , $data->added_by)->get()->first()->username }}">

                                                {{ DB::table('users')->where('id' , $data->added_by)->get()->first()->username }}
                                            </a>

                                                @else

                                                Answerout

                                                @endif
                                        </span>
                                        <p class="text">

                                               <br>

                                              <?php
                                               function prefix_insert_after_paragraph2( $ads, $content ) {
                                                    if ( ! is_array( $ads ) ) {
                                                        return $content;
                                                    }

                                                    $closing_p = '</p>';
                                                    $paragraphs = explode( $closing_p, $content );

                                                    foreach ($paragraphs as $index => $paragraph) {
                                                        if ( trim( $paragraph ) ) {
                                                            $paragraphs[$index] .= $closing_p;
                                                        }

                                                        $n = $index + 1;
                                                        if ( isset( $ads[ $n ] ) ) {
                                                            $paragraphs[$index] .= $ads[ $n ];
                                                        }
                                                    }

                                                    return implode( '', $paragraphs );
                                                }

                                                function prefix_insert_post_ads( $content ) {
                                                        $content = prefix_insert_after_paragraph2( array(
                                                            // The format is: '{PARAGRAPH_NUMBER}' => 'AD_CODE',
                                                            '1' => '<div id="protag-in_article_video"></div>
                                                                    <script type="text/javascript">
                                                                        window.googletag = window.googletag || { cmd: [] };
                                                                        window.protag = window.protag || { cmd: [] };
                                                                        window.protag.cmd.push(function () {
                                                                            window.protag.display("protag-in_article_video");
                                                                        });
                                                                    </script>',
                                                        ), $content );

                                                    return $content;
                                                }


                                              ?>


                                              <?php echo  prefix_insert_post_ads($data->blog) ?>

                                        </p>
                                    </div>
                                </div>
                                <div class="post-footer">
                                    <div class="left">
                                        <p>
                                            <b>Category:</b>
                                            @foreach(DB::table('wphj_term_relationships')->where('object_id' , $data->id)->get() as $c)
                                            @if(DB::table('blogcategories')->where('id' , $c->term_taxonomy_id)->count() > 0)
                                               <a href="{{ url('') }}/{{ DB::table('blogcategories')->where('id' , $c->term_taxonomy_id)->get()->first()->slug }}"> {{DB::table('blogcategories')->where('id' , $c->term_taxonomy_id)->get()->first()->name}} </a>

                                            @endif
                                            @endforeach
                                        </p>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    @foreach(DB::table('wphj_term_relationships')->where('object_id' , $data->id)->get() as $r)
                                    @if(!empty(DB::table('wphj_term_taxonomy')->where('term_id' , $r->term_taxonomy_id)->get()->first()->taxonomy))
                                    @if(DB::table('wphj_term_taxonomy')->where('term_id' , $r->term_taxonomy_id)->get()->first()->taxonomy == 'post_tag')
                                    <a class="badge badge-pill blogtag" href="{{ url('tag') }}/{{ DB::table('wphj_terms')->where('term_id' , $r->term_taxonomy_id)->get()->first()->slug }}">{{ DB::table('wphj_terms')->where('term_id' , $r->term_taxonomy_id)->get()->first()->name }}</a>
                                    @endif
                                    @endif
                                    @endforeach
                                </div>

                            </div>

                            @if(!empty($relatedblogs))
                            <div class="row mt-5 mb-5">
                                <div class="col-md-12">
                                    <h3 class="f-20">Related Blogs</h3>
                                    <ul class="mt-2 reated-question-ul">
                                        @foreach($relatedblogs as $r)
                                        <li><a href="{{url('')}}/{{ $r->url }}">{!! Str::limit($r->name, 70) !!}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif

                            <div class="blog-comment">
                            <h5 class="title">comments</h5>
                            <ul class="comment-area">
                                @foreach($blogcoments as $r)
                                <li>
                                    <!-- blog avatars -->
                                    <div class="blog-thumb-info">
                                        @if(!empty($r->users))
                                        <h6 class="title"><a href="#">{{ DB::table('users')->where('id' , $r->users)->get()->first()->name }}</a></h6>
                                        @else
                                        <h6 class="title"><a href="#">{{ $r->name }}</a></h6>
                                        @endif
                                    </div>
                                    <div class="blog-content">
                                        <p class="more" style="text-align: justify;">
                                            {{$r->coment}}
                                        </p>
                                    </div>
                                </li>

                                <div style="padding-left: 80px;">
                                    @foreach(DB::table('comentreply')->where('comentid'  ,$r->id)->get() as $c)
                                    <li>
                                        <!-- Blog avatars -->
                                        <div class="blog-thumb-info">
                                            <h6 class="title"><a href="#">@if(!empty($c->userid)){{ DB::table('users')->where('id' , $c->userid)->get()->first()->name }}@else {{ $c->name }}@endif</a></h6>
                                        </div>
                                        <div class="blog-content">
                                            <p class="more" style="text-align: justify;">
                                                {!! $c->reply !!}
                                            </p>
                                        </div>
                                    </li>
                                    @endforeach
                                </div>
                                @endforeach
                            </ul>
                            <style type="text/css">
                                .morecontent span {
                                        display: none;
                                    }
                                    .morelink {
                                        display: block;
                                        color: blue;
                                    }
                            </style>
                            <script>
                                $(document).ready(function() {
                                        // Configure/customize these variables.
                                        var showChar = 150;  // How many characters are shown by default
                                        var ellipsestext = "";
                                        var moretext = "Read More";
                                        var lesstext = "Read Less";


                                        $('.more').each(function() {
                                            var content = $(this).html();

                                            if(content.length > showChar) {

                                                var c = content.substr(0, showChar);
                                                var h = content.substr(showChar, content.length - showChar);

                                                var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

                                                $(this).html(html);
                                            }

                                        });

                                        $(".morelink").click(function(){
                                            if($(this).hasClass("less")) {
                                                $(this).removeClass("less");
                                                $(this).html(moretext);
                                            } else {
                                                $(this).addClass("less");
                                                $(this).html(lesstext);
                                            }
                                            $(this).parent().prev().toggle();
                                            $(this).prev().toggle();
                                            return false;
                                        });
                                    });
                                </script>
                            <div class="leave-comment">
                                <h5 class="title">leave comment</h5>
                                <form id="blogcomentform" class="blog-form" method="POST" action="{{ url('saveblogcoment') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $data->id }}" name="blogid">
                                    <div class="form-group">
                                        <input required="" name="name" @if(Auth::check()) value="{{ Auth::user()->name }}" @endif type="text" class="form-control" placeholder="Enter Your Full Name" required>
                                    </div>
                                    <div class="form-group">
                                        <input required="" name="email" @if(Auth::check()) value="{{ Auth::user()->email }}" @endif type="email" class="form-control" placeholder="Enter Your Email Address" required>
                                    </div>
                                    <div class="form-group">
                                        <textarea id="comment" name="coment" placeholder="Write A Message" class="form-control" required></textarea>
                                        <label id="characterLeft" class="mt-3"></label>
                                    </div>

                                    <div class="form-group">
                                        <div class="g-recaptcha"
                                            data-sitekey="{{config('services.recaptcha.key')}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button id="disabledcomentbutton" class="custom-button" type="submit">Submit Now</button>
                                    </div>
                                </form>
                            </div>
                            <script type="text/javascript">

                                $('#blogcomentform').on('submit', function(e) {
                                  if(grecaptcha.getResponse() == "") {
                                    e.preventDefault();
                                    $('#rc-anchor-container').css('border-color' , 'red');
                                    $('#recaptcha-checkbox-border').css('border-color' , 'red');
                                  }
                                });


                                /* JQuery Code from:
 http://www.findsourcecode.com/jquery/how-to-count-number-of-characters-in-textarea-jquery/ */

$( document ).ready(function() {
  var maxChars = 300;
  var textLength = 0;
  var comment = "";
  var outOfChars = 'You have reached the limit of ' + maxChars + ' characters';

  /* initalize for when no data is in localStorage */
  var count = maxChars;
  $('#characterLeft').text(count + ' characters left');

  /* fix val so it counts carriage returns */
  $.valHooks.textarea = {
    get: function(e) {
      return e.value.replace(/\r?\n/g, "\r\n");
    }
  };

  function checkCount() {
    textLength = $('#comment').val().length;
    if (textLength >= maxChars) {
      $('#characterLeft').text(outOfChars);
      $("#characterLeft").css("color", "red");
      $('#disabledcomentbutton').attr('disabled' , true);
    }
    else {
      count = maxChars - textLength;
      $('#characterLeft').text(count + ' characters left');
      $("#characterLeft").css("color", "green");
      $('#disabledcomentbutton').attr('disabled' , false);
    }
  }

  /* on keyUp: update #characterLeft as well as count & comment in localStorage */
  $('#comment').keyup(function() {
    checkCount();
    comment = $(this).val();
    localStorage.setItem("comment", comment);
  });

  /* on pageload: get check for comment text in localStorage, if found update comment & count */
  if (localStorage.getItem("comment") != null) {
    $('#comment').text(localStorage.getItem("comment"));
    checkCount();
  }
});
          </script>
      </div>
      </div>
  </div>

                </div>

                <div class="col-md-3">
                    <div class="ads">
                        {!! Cmf::site_settings('right_add_1') !!}
                    </div>
                    <div class="ads">
                        {!! Cmf::site_settings('right_add_2') !!}
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- ==========Blog-Page========== -->
@endsection
