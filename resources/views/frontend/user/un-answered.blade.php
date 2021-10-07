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
                        <li class="breadcrumb-item active" aria-current="page">Unanswered</li>
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
                            <li >
                                <a href="{{url('/my-profile')}}">
                                    Your Questions 
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/profile/answered')}}">
                                    Answered 
                                </a>
                            </li>

                            <li class="active-bottom">
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
                        @if(DB::table('onlyanswers')->where('delete_status' , 'Active')->where('visible_status' , 'Published')->where('questionid' , $r->id)->count() == 0)
                            <div style="margin-top:10px;" class="profile-single-post">
                                <div class="p-s-p-content">
                                    <div class="row mt-minus-80">
                                        <div class="col-lg-12 text-right">
                                            @if($r->visible_status == 'Under Review') 
                                                <span class="badge badge-pill badge-danger mr-2">{{ $r->visible_status }}</span>
                                            @endif
                                            <a style="border-radius: 6px;  {{ DB::table('categories')->where('name' , $r->question_subject)->get()->first()->text_color  }} {{ DB::table('categories')->where('name' , $r->question_subject)->get()->first()->backgroundcolor  }} !important;" href="{{ url('') }}/{{ DB::table('categories')->where('name' , $r->question_subject)->get()->first()->url }}"><span class="badge badge-pill">{{ $r->question_subject }}</span></a>

                                            <a href="{{ url('editquestion') }}/{{ $r->question_url }}" class="btn btn-white-mine-edit btn-sm ml-2">edit <img class="float-right pt-1" src="{{asset('/front/assets/images/shahzad/edit-icon.svg')}}"></a>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-11">
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
                                            <a class="btn btn-theme-sm" href="{{url('question')}}/{{ $r->question_url }}">View Question</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            @endif
                        @endforeach
              




                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========= Profile Section Start -->
@endsection