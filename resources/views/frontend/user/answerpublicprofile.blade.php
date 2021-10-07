@extends('layouts.app')
@section('title')
<title>@if(!empty($user->name)) {{ $user->name }} @else {{ $user->username }} @endif | Answerout</title>
<meta name="DC.Title" content="@if(!empty($user->name)) {{ $user->name }} @else {{ $user->username }} @endif | Answerout">
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
<!-- ========= Profile Section Start -->
    <section class="profile-section">
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item" aria-current="page">User Profile</li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
                      </ol>
                    </nav>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-7">
                    <div class="left-profile-area">
                        <div class="profile-about-box">
                            <div class="top-bg"></div>
                            <div class="p-inner-content">
                                <div class="profile-img">
                                    @if(!empty($user->profileimage))
                                    <img src="{{ $user->profileimage }}" style="height:100%;width: 100%;" alt="">
                                    @else
                                    <img src="https://cdn3.iconfinder.com/data/icons/diversity-avatars-vol-2/64/man-avatar-blond-sweater-512.png" style="height:100%;width: 100%;" alt="">
                                    @endif
                                    <div class="active-online"></div>
                                </div>
                                <h5 class="name">
                                    @if(!empty($user->name))
                                    {{ $user->name }}
                                    @else
                                    {{ $user->username }}
                                    @endif
                                </h5>
                                @if($user->expert == 'on')
                                <div>
                                    <span style="text-transform:capitalize;" class="badge badge-pill badge-success">Expert</span>
                                </div>
                                @endif
                                <ul class="p-b-meta-one mt-3">
                                    <li>
                                        <div class="icon">
                                            {{ DB::table('onlyanswers')->where('users' , $user->id)->count() }}
                                        </div>
                                        <span>Answers</span>
                                    </li>
                                    <li>
                                        <div class="icon">
                                            {{ DB::table('onlyanswers')->where('users' , $user->username)->sum('likes') }}
                                        </div>
                                        <span>Likes</span>
                                    </li>
                                </ul>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-6">
                    <div class="profile-main-content">
                        <ul class="top-menu">
                            <li >
                                <a href="{{url('/user-profile')}}/{{ $user->username }}">
                                    Questions 
                                </a>
                            </li>
                            <li class="active-bottom">
                                <a href="{{url('/user-profile/answered/')}}/{{ $user->username }}">
                                    Answered 
                                </a>
                            </li>
                        </ul>
                        @foreach($data as $r)
                        @if(DB::table('answerquestions')->where('id' , $r->questionid)->count() == 1 )
                        <div style="margin-top:10px;" class="profile-single-post">
                            <div class="p-s-p-content">
                                <div class="row mt-minus-80">
                                    <div class="col-lg-12 text-right">
                                       <a href="{{ url('') }}/{{ DB::table('categories')->where('name' , DB::table('answerquestions')->where('id' , $r->questionid)->get()->first()->question_subject)->get()->first()->url }}"> <span style="{{ DB::table('categories')->where('name' , DB::table('answerquestions')->where('id' , $r->questionid)->get()->first()->question_subject)->get()->first()->backgroundcolor }} {{ DB::table('categories')->where('name' , DB::table('answerquestions')->where('id' , $r->questionid)->get()->first()->question_subject)->get()->first()->text_color }}" class="badge badge-pill badge-warning">{{ DB::table('answerquestions')->where('id' , $r->questionid)->get()->first()->question_subject }}</span></a>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <h1 class="question-title"><a href="{{url('question')}}/{{  DB::table('answerquestions')->where('id' , $r->questionid)->get()->first()->question_url }}">{{  DB::table('answerquestions')->where('id' , $r->questionid)->get()->first()->question_name }}</a></h1>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>
                                            {{  DB::table('answerquestions')->where('id' , $r->questionid)->get()->first()->question_content }}
                                        </p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 text-right">
                                        <a class="btn btn-theme-sm" href="{{url('question')}}/{{  DB::table('answerquestions')->where('id' , $r->questionid)->get()->first()->question_url }}">See answer</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @endif
                        @endforeach
                        <div class="row mt-2 mb-2">
                            {!! $data->links('frontend.pagination') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========= Profile Section Start -->
@endsection