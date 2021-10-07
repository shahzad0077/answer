@extends('layouts.app')
@section('title')
<title>Answers to all {{ $category->name }} Questions</title>
<meta name="DC.Title" content="Answers to all {{ $category->metta_tittle }} Questions">
<meta name="rating" content="general">
<meta name="description" content="{{ $category->metta_description }}">
<meta property="og:type" content="website">
<meta property="og:image" content="">
<meta property="og:title" content="{{ $category->metta_tittle }}">
<meta property="og:description" content="Answerout">
<meta property="og:site_name" content="Answerout">
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
    "name": "Explore",
    "item": "{{url('/categories')}}"
  },{
    "@type": "ListItem",
    "position": 3,
    "name": "{{ $category->name }}"
  }]
}
</script>
@endsection
@section('content')
<section class="profile-section single-community">
        <div class="container">
            <div class="row mt-100 mb-2">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb mt-mobile">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/categories')}}">Explore</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                      </ol>
                    </nav>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="mobile-banner">
                        {!! Cmf::site_settings('question_detail_page_top') !!}
                    </div>
                </div>
            </div>

            <div class="row mt-2 mb-4">
                <div class="col-md-12 text-center">
                    <h3 class="f-22"><span class="text-theme">exploring</span> &nbsp;&nbsp;&nbsp; <u> <span class="f-light">{{ $category->name }}</span></u></h3>
                </div>
            </div>

            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        @foreach($data as $r)
                        @php
                            $user = $r->question_auther;
                        @endphp
                        <div class="col-xl-4 col-lg-4 col-md-6 custom-padd">
                            <div style="height: 295px;" class="card card-explore">
                                <div class="card-body d-flex flex-column">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a style="width: 100%" href="{{ url('question') }}/{{ $r->question_url }}"><h1 class="question-title">{!! Str::limit($r->question_name) !!}</h1></a>
                                        </div>
                                    </div><hr class="custom-hr-line">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="f-15 text-content-question">
                                                @if(DB::table('onlyanswers')->where('delete_status' , 'Active')->where('visible_status' , 'Published')->where('questionid' , $r->id)->count() > 0)

                                                @php

                                                    $firstanswer = DB::table('onlyanswers')->where('delete_status' , 'Active')->where('visible_status' , 'Published')->where('questionid' , $r->id)->get()->first()->answer;
                                                    preg_match_all('/(<img .*?>)/', $firstanswer, $img_tag);
                                                @endphp



                                                @if(empty($img_tag[1]))
                                                    {!! Str::limit($firstanswer) !!}
                                                @endif





                                               @else

                                               @if(Auth::check())

                                               @if(Auth::user()->username == $r->question_auther)
                                               <div style="text-align: left;">
                                                   Waiting for answers
                                               </div>
                                               @else
                                               <div style="text-align: left;">
                                                   <a class="f-13" href="{{ url('addanswer') }}/{{ $r->question_url }}">Be the first to answer</a>
                                               </div>
                                               @endif

                                               @else

                                                <div style="text-align: left;">
                                                   <a class="f-13" href="{{ url('addanswer') }}/{{ $r->question_url }}">Be the first to answer</a>
                                               </div>

                                               @endif


                                               @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row mt-auto">
                                        <div class="col-md-2 col-2">
                                            <div class="img img-user-cs">
                                                @if (empty(Cmf::getuserdetailsbyid($user)->profileimage))
                                                 <img src="{{url('images')}}/{{ DB::table('profileimages')->inRandomOrder()->get()->first()->image_name }}" class="explore-profile">
                                                @else
                                                <img src="{{ Cmf::getuserdetailsbyid($user)->profileimage }}" alt="" class="explore-profile">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-10 col-8">
                                            <div class="row">
                                                <div class="col-md-4 col-8 p-m-0">
                                                    <span class="name f-13">
                                                        <a href="{{url('user-profile')}}/{{ $r->question_auther }}" class="text-theme">
                                                           {!! Str::limit($user, 7) !!}
                                                        </a>
                                                        @if(DB::table('users')->where('username' , $user)->get()->first()->expert == 'on')
                                                        <span class="badge badge-pill badge-success">Expert</span>
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="col-md-8 col-4 text-right p-0">
                                                    <span class="badge comment badge-pill @if(DB::table('onlyanswers')->where('questionid' , $r->id)->count() > 0) badge-success-mine @else badge-warning-mine @endif">@if(DB::table('onlyanswers')->where('questionid' , $r->id)->count() > 0) Answered Out @else Un Answered @endif</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="row mt-2 mb-2">
                        {!! $data->links('frontend.pagination') !!}
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
@endsection
