@extends('layouts.app')
@section('title')
<title>{{$search}}</title>
<meta name="DC.Title" content="Answerout">
<meta name="rating" content="general">
<meta name="description" content="Answerout">
<meta property="og:type" content="website">
<meta property="og:image" content="">
<meta property="og:title" content="Answerout">
<meta property="og:description" content="Answerout">
<meta property="og:site_name" content="Answerout">
<meta property="og:url" content="{{ url('') }}">
<meta property="og:locale" content="it_IT">
@endsection
@section('content')
<section class="profile-section single-community">
        <div class="container-fluid">
            <div class="row mt-100 mb-0">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">You Searched</li>
                        <li class="breadcrumb-item active" aria-current="page">{{$search}}</li>
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
            <div class="row justify-content-center">
                <div class="col-lg-3">
                    <div class="ads">
                        {!! Cmf::site_settings('left_add_1') !!}
                    </div>
                    <div class="ads" id="left-second-add">
                        {!! Cmf::site_settings('left_add_2') !!}
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4 col-12 mb-text-center">
                                    <h6><b class="text-theme">You searched for :</b></h6>
                                </div>
                                <div class="col-md-8 col-12 mb-text-center p-0">
                                    <h6><span class="text-lighter">“{{$search}}”</span></h6>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="profile-main-content">
                        @if($data->count() > 0)
                        @foreach($data as $r)
                        @php
                            $user = $r->question_auther;
                        @endphp
                        <div class="profile-single-post mb-4">
                            <div class="p-s-p-content">
                                <div class="row mt-minus-80 mb-2">
                                    <div class="col-lg-12 text-right">
                                        <span class="badge comment badge-pill @if(DB::table('onlyanswers')->where('questionid' , $r->id)->count() > 0) badge-success-mine @else badge-warning-mine @endif">@if(DB::table('onlyanswers')->where('questionid' , $r->id)->count() > 0) Answered Out @else Un Answered @endif</span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <a href="{{ url('question') }}/{{ $r->question_url }}"><h1 class="question-title"><b>{!! Str::limit($r->question_name, 160) !!}</b></h1></a>
                                        <div class="">
                                            <p>@if(!empty(DB::table('onlyanswers')->where('questionid' , $r->id)->get()->first()->answer)){{ DB::table('onlyanswers')->where('questionid' , $r->id)->get()->first()->answer }}@endif</p>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>
                                            {!! Str::limit($r->question_content, 370) !!}
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                       <a href="{{ url('') }}/{{ DB::table('categories')->where('name' , $r->question_subject)->get()->first()->url }}"> <span style="border-radius: 6px;  {{ DB::table('categories')->where('name' , $r->question_subject)->get()->first()->text_color  }}  {{ DB::table('categories')->where('name' , $r->question_subject)->get()->first()->backgroundcolor  }} " class="badge badge-pill badge-warning-mine">{{$r->question_subject}}</span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                              <div class="col-md-4 col-8">
                                <div class="p-s-p-header-area">
                                  @if (empty(Cmf::getuserdetailsbyid($user)->profileimage))
                                   <img src="https://cdn3.iconfinder.com/data/icons/diversity-avatars-vol-2/64/man-avatar-blond-sweater-512.png" alt="" class="explore-profile">
                                  @else
                                  <img src="{{ Cmf::getuserdetailsbyid($user)->profileimage }}" alt="" class="explore-profile">
                                  @endif
                                    <span class="name">
                                        Asked by <a href="{{url('user-profile')}}/{{ $r->question_auther }}" class="text-theme">
                                            @if(!empty(Cmf::getuserdetailsbyid($user)->name))
                                            @php
                                                $myvalue = Cmf::getuserdetailsbyid($user)->name;
                                                $arr = explode(' ',trim($myvalue));
                                            @endphp
                                            {{ $arr[0] }}

                                            @else

                                            {{ $user }}
                                            @endif
                                        </a>
                                    </span>
                                </div>
                              </div>
                              <div class="col-md-4" id="d-mobile-none">
                                <span class="post-time ml-4 f-13" >
                                      {{ date('d M Y, h:s a ', strtotime($r->created_at)) }}
                                </span>
                              </div>
                              <div class="col-md-4 col-4 text-right">
                                <a class="btn btn-theme-sm" href="{{ url('question') }}/{{ $r->question_url }}"><i><b>See answer</b></i></a>
                              </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="row">
                        @foreach($categories as $c)
                            <div class="col-lg-4 col-md-6">
                                <div style="padding: 10px;background-color: #dddd;border-radius: 10px;">
                                    <a href="{{ url('') }}/{{ $c->url }}">

                                            {{$c->name}}

                                    </a>
                                </div>

                            </div>
                        @endforeach
                        </div>
                        @else
                        <div class="profile-single-post mb-4">
                           <p style="text-align: center;">No Result Found</p>
                        </div>
                        @endif
                        <div class="row mt-2 mb-2">
                            {!! $data->links('frontend.pagination') !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="ads" >
                        {!! Cmf::site_settings('right_add_1') !!}
                    </div>
                    <div class="ads" id="right-second-add">
                      {!! Cmf::site_settings('right_add_2') !!}
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
