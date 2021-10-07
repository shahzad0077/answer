@extends('layouts.app')
@section('title')
<title>Blog</title>
<meta name="DC.Title" content="Blog">
<meta name="rating" content="general">
<meta name="description" content="Blog">
<meta property="og:type" content="website">
<meta property="og:image" content="">
<meta property="og:title" content="Blog">
<meta property="og:description" content="Blog">
<meta property="og:site_name" content="Blog">
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
    "name": "Blog"
  }]
}
</script>
@endsection
@section('content')
<!-- ==========Blog-Page========== -->
    <section class="blog-page single-blog-page">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/blogs')}}">Blog</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $termid->name }}</li>
                      </ol>
                    </nav>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="top-question-banner">
                        {!! Cmf::site_settings('question_detail_page_top') !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        @foreach($getrelationship as $r)

                        @php

                            $blog = DB::table('blogs')->where('id' , $r->object_id)->get()->first();

                        @endphp

                        <div class="col-lg-6 custom-padd">
                            <div class="single-blog">
                                @if(!empty(Cmf::get_image_name('blogimages' , 'blogid' , $blog->id)->first()->image_name))
                                <div class="img">
                                    <img src="{{ url('/images/') }}/{{ Cmf::get_image_name('blogimages' , 'blogid' , $blog->id)->first()->image_name }}" alt="">
                                </div>
                                @endif
                                <div class="content">
                                    <div class="right">
                                        <a href="{{ url('') }}/{{ $blog->url }}">
                                            <h1 class="title">
                                               {!! Str::limit($blog->name, 50) !!}
                                            </h1>
                                        </a>

                                    </div>
                                </div>
                                <div class="post-footer">
                                    <div class="left">
                                        <p>
                                            @if(DB::table('wphj_term_relationships')->where('object_id' , $blog->id)->count() > 0)
                                            <b>Category:</b>
                                            @foreach(DB::table('wphj_term_relationships')->where('object_id' , $blog->id)->get() as $c)
                                            @if(DB::table('blogcategories')->where('id' , $c->term_taxonomy_id)->count() > 0)
                                               <a href="{{ url('') }}/{{ DB::table('blogcategories')->where('id' , $c->term_taxonomy_id)->get()->first()->slug }}"> {{DB::table('blogcategories')->where('id' , $c->term_taxonomy_id)->get()->first()->name}} </a>,

                                            @endif
                                        @endforeach
                                        @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget widget-search">
                        <h5 class="title">search</h5>
                        <form class="search-form" method="POST" action="{{ url('blogsearch') }}">
                            {{ csrf_field() }}
                            <input name="search" type="text" placeholder="Enter your Search Content" required>
                            <button type="submit"><i class="flaticon-loupe"></i>Search</button>
                        </form>
                    </div>
                  <div class="widget widget-categories">
                        <h5 class="title">categories</h5>
                        <ul id="loadmorepagedata">
                            @foreach($blogcategories as $r)
                            <li>
                                <a href="{{ url('') }}/{{ $r->slug }}">
                                    <span>{{ $r->name }}</span><span>

                                        {{ DB::table('wphj_term_relationships')->where('term_taxonomy_id' , $r->id)->count() }}

                                    </span>
                                </a>
                            </li>
                                @if($loop->last)
                                    @php
                                        $loadmorepageid = $r->loadmoreid;

                                    @endphp
                                @endif
                            @endforeach
                            <input type="hidden" value="{{ $loadmorepageid }}" id="loadmorepage" name="">


                        </ul>
                        <div>
                            <button id="loadmorebutton" onclick="loadmore()" class="btn btn-theme">Load More</button>
                        </div>
                    </div>
                    <div class="ads">
                        {!! Cmf::site_settings('right_add_1') !!}

                    </div>
                    <div class="ads">
                      {!! Cmf::site_settings('right_add_2') !!}
                    </div>
                    <div class="widget widget-newsletter">
                        <h5 class="title">Newsletter</h5>
                            <input style="margin-bottom:0px;" id="email" type="text" placeholder="Enter your Email Address" required>
                            <p class="error" style="color: red;font-size: 14px;"></p>
                            <button id="submitnewsletterbutton" onclick="submitbutton()" type="submit"><i class="far fa-envelope"></i> Send</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Blog-Page========== -->
<script type="text/javascript">
    function submitbutton()
    {
        var mainurl = '{{ url('') }}';
        var email = $('#email').val();
        if(email == '')
        {
            $('.error').html('Email is Required');
        }else{
        $('.error').hide();
        $('#newsleetter').submit();
         $.ajax({
            type: "GET",
            url: mainurl+'/addemailfornewsletter/'+email,
            success: function(resp) {
                if(resp == 'success')
                {
                    $('.error').show();
                    $('.error').html('Subscribed Successfully');
                    $('.error').css('color' , 'green');
                }else{
                    $('.error').show();
                    $('.error').html('This Email is Already Subscribed');
                    $('.error').css('color' , 'red');
                }
            }
        });
     }

    }
    function loadmore()
    {
        var mainurl = '{{ url('') }}';
        var loadmorepage = $('#loadmorepage').val();
        $('#loadmorebutton').html('<i class="fa fa-spinner fa-spin"></i>');
        $.ajax({
            type: "GET",
            url: mainurl+'/loadmorepage/'+loadmorepage,
            success: function(resp) {

                $('#loadmorepagedata').append(resp);
                $('#loadmorebutton').html('Load More');

                $('#loadmorepage').val(parseInt(loadmorepage)+parseInt(10))

            }
        });
    }
</script>
@endsection
