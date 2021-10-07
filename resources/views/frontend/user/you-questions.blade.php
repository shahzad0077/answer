@extends('layouts.app')
@section('title')
<title>Answerout</title>
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
<!-- ========= Profile Section Start -->
    <section class="profile-section">
        <div class="container">
            <div class="row mb-3 mt-3">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/my-profile')}}">Profile</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Your Questions</li>
                      </ol>
                    </nav>
                </div>
            </div>
            <div class="row justify-content-center">
                @include('frontend.user.userprofile')
                <div class="col-xl-8 col-lg-6">
                    <div class="profile-main-content">
                        <ul class="top-menu">
                            <li>
                                <a href="{{url('/profile/notifications')}}">
                                    Notifications
                                    @if(DB::table('usernotification')->where('users',Auth::user()->id)->where('status' , 1)->count() > 0)  <div class="num">{{DB::table('usernotification')->where('users',Auth::user()->id)->where('status' , 1)->count()}}</div> @endif
                                </a>
                            </li>
                            <li class="active-bottom">
                                <a href="{{url('/my-profile')}}">
                                    Your Questions
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/profile/answered')}}">
                                    Answered
                                </a>
                            </li>

                            <li>
                                <a href="{{url('/profile/unanswered')}}">
                                    Unanswered
                                </a>
                            </li>

                            <li>
                                <a href="{{url('/profile/saved')}}">
                                    Saved  &nbsp;<img src="{{asset('/front/assets/images/shahzad/tag-filled.svg')}}" width="14px">
                                </a>
                            </li>
                        </ul>
                        @foreach($data as $r)
                        <div style="margin-top:10px;" class="profile-single-post">
                            <img src="{{asset('/front/assets/images/shahzad/question.svg')}}" class="question-tag">
                            <div class="p-s-p-content">
                                <div class="row mt-minus-80">
                                    <div class="col-lg-12 text-right">
                                        @if($r->visible_status == 'Under Review')
                                            <span class="badge badge-pill badge-danger mr-2">{{ $r->visible_status }}</span>
                                        @endif
                                        

                                        <a href="{{ url('editquestion') }}/{{ $r->question_url }}" class="btn btn-white-mine-edit btn-sm ml-2">edit <img class="float-right pt-1" src="{{asset('/front/assets/images/shahzad/edit-icon.svg')}}"></a>
                                    </div>

                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <h1 class="question-title"><a href="{{url('question')}}/{{ $r->question_url }}">{{ $r->question_name }}</a></h1>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>
                                            {!! $r->question_content !!}
                                        </p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 text-right">
                                        <a class="btn btn-theme-sm" href="{{url('question')}}/{{ $r->question_url }}">See answer</a>
                                    </div>
                                </div>

                            </div>
                        </div>
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
