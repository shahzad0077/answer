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
            <div class="row mb-3">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/my-profile')}}">Profile</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Notifications</li>
                      </ol>
                    </nav>
                </div>
            </div>
            <div class="row justify-content-center">
                @include('frontend.user.userprofile')
                <div class="col-xl-8 col-lg-6">
                    <div class="profile-main-content">
                        <ul class="top-menu">
                            <li class="active-bottom">
                                <a href="{{url('/profile/notifications')}}">
                                    Notifications  
                                  @if(DB::table('usernotification')->where('users',Auth::user()->id)->where('status' , 1)->count() > 0)  <div class="num">{{DB::table('usernotification')->where('users',Auth::user()->id)->where('status' , 1)->count()}}</div> @endif
                                </a>
                            </li>
                            <li>
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
                        
                        @foreach($notifications as $r)

                        <div style="margin-top: 10px;" class="profile-single-post">
                            <div class="p-s-p-content">
                                <div class="row">
                                    <div class="col-md-11">
                                        <p>
                                            {!! $r->notification !!}
                                        </p>
                                    </div>
                                    <div class="col-md-1 text-right">
                                        <a href="{{ url('deleteusernotification') }}/{{ $r->id }}"> <span class="fa fa-times"></span> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========= Profile Section Start -->
@endsection