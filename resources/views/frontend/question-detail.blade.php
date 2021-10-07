@extends('layouts.app')
@section('title')
<title>{{$data->metta_tittle}}</title>
<meta name="DC.Title" content="{{$data->metta_tittle}}">
<meta name="rating" content="general">
<meta name="description" content="{{$data->metta_description}}">
<meta property="og:type" content="website">
<meta property="og:image" content="">
<meta property="og:title" content="{{$data->metta_tittle}}">
<meta property="og:description" content="{{$data->metta_description}}">
<meta property="og:site_name" content="Answerout">
<meta property="og:url" content="{{ Request::url() }}">
<meta property="og:locale" content="it_IT">
@include('frontend.googlevoicescript')
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
    "name": "{{ $data->question_name }}"
  }]
}
</script>
@endsection
@section('content')
@include('frontend.questiondetail.questionpageextension')
@include('admin.alert')
<section class="profile-section single-community">
        <div class="container-fluid">
            <div class="row mt-100">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $data->question_name, 130 }}</li>
                      </ol>
                    </nav>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="top-question-banner" style="height:auto !important;">
                        {!! Cmf::site_settings('question_detail_page_top') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <div class="ads">
                        {!! Cmf::site_settings('left_add_1') !!}
                    </div>
                    <div class="ads">
                        {!! Cmf::site_settings('left_add_2') !!}
                    </div>
                </div>

                @php
                    $userquestion = $data->question_auther;
                @endphp

                <div class="col-lg-6">
                    <div class="profile-main-content">
                        <div class="profile-single-post">
                            <img src="{{asset('/front/assets/images/shahzad/question.svg')}}" class="question-tag" id="d-mobile-none">
                            <img src="{{asset('/front/assets/images/shahzad/question.svg')}}" class="d-lg-none question-tag-mobile">
                            <div class="p-s-p-content">

                                <div class="row mb-3">
                                    <div class="col-md-6 col-8">
                                        <div class="p-s-p-header-area">
                                            <div class="img">
                                                @if(!empty(Cmf::getuserdetailsbyid($userquestion)->profileimage))
                                                <img src="{{ Cmf::getuserdetailsbyid($userquestion)->profileimage }}" alt="">
                                                @else
                                                <img src="https://cdn3.iconfinder.com/data/icons/diversity-avatars-vol-2/64/man-avatar-blond-sweater-512.png" >
                                                @endif
                                            </div>
                                            <h6 class="name">

                                                Asked by <a href="{{url('user-profile')}}/{{ $data->question_auther }}" class="text-theme">
                                                    {{$userquestion}}
                                                </a>
                                                @if(DB::table('users')->where('username' , $data->question_auther)->get()->first()->expert == 'on')
                                                <span class="badge badge-pill badge-success">Expert</span>
                                                @endif
                                            </h6>

                                        </div>
                                        <div class="row mt-2 d-lg-none">
                                            <div class="col-md-12">
                                                <a href="{{ url('') }}/{{ DB::table('categories')->where('name' , $data->question_subject)->get()->first()->url }}"><span class="badge badge-pill" style="border-radius: 6px;  {{ DB::table('categories')->where('name' , $data->question_subject)->get()->first()->text_color  }}  {{ DB::table('categories')->where('name' , $data->question_subject)->get()->first()->backgroundcolor  }} ">{{ $data->question_subject }}</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-4 text-right p-left-mobile">
                                        @if(Auth::check())
                                        @if(Auth::user()->username == $data->question_auther)

                                            @if($data->visible_status == 'Under Review')
                                                <span class="badge badge-pill badge-danger">{{ $data->visible_status }}</span>
                                            @endif

                                        @endif
                                        @endif
                                        <span class="badge comment badge-pill @if(DB::table('onlyanswers')->where('questionid' , $data->id)->count() > 0) badge-success-mine @else badge-warning-mine @endif ">@if(DB::table('onlyanswers')->where('questionid' , $data->id)->count() > 0) Answered Out @else Un Answered @endif</span>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <h1 class="f-24 f-weight-600 mb-4">{{ $data->question_name }}</h1>

                                        <p>{!! nl2br($data->question_content) !!}</p>
                                        @if(!empty(Cmf::get_image_name('questionimages' , 'questionid' , $data->id)))
                                        <div class="preview">
                                            <div class="preview-pic tab-content">
                                                @foreach (Cmf::get_image_name('questionimages' , 'questionid' , $data->id) as $i)

                                                <?php if(file_exists( asset('/images').'/'.$i->image_name )){ ?>

                                                <div class="tab-pane @if ($loop->first) active  @endif" id="slide{{ $loop->iteration }}"><img style="height: 500px; background-color:transparent !important " class="slide-img"  src="{{ asset('/images') }}/{{ $i->image_name }}" /></div>

                                                <?php }  ?>

                                                @endforeach
                                            </div>
                                            @if(Cmf::get_image_name('questionimages' , 'questionid' , $data->id)->count() > 1)
                                            <ul class="preview-thumbnail nav nav-tabs">
                                                @foreach (Cmf::get_image_name('questionimages' , 'questionid' , $data->id) as $i)
                                                <?php if(file_exists( asset('/images').'/'.$i->image_name )){ ?>
                                                <li style="margin-bottom: 10px;cursor: pointer;" class="active"><a data-target="#slide{{ $loop->iteration }}" data-toggle="tab"><img style="height: 150px;" class="img-thumb" src="{{asset('/images')}}/{{ $i->image_name }}" /></a></li>
                                                <?php }  ?>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </div>
                                        @endif
                                    </div>

                                </div>

                            </div>
                            @include('frontend.questiondetail.questionright')
                        </div>

                        <div class="row mb-4 mt-3">
                            <div class="col-md-12">
                                <div class="top-question-banner" style="height:auto !important;">
                                    {!! Cmf::site_settings('question_card_advertisement') !!}
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3 mt-4 mb-mb-30">
                            <div class="col-md-12">
                                <h6>Answers</h6>
                            </div>
                        </div>
                        <?php $i = 0; ?>
                        @foreach($answers as $r)
                        <?php $i++; ?>
                        @php
                            $user = $r->users;
                        @endphp
                        <div id="{{ $r->id }}" class="profile-single-post mb-4">
                            <img id="d-mobile-none" src="{{asset('/front/assets/images/shahzad/answer.svg')}}" class="question-tag">
                            <img src="{{asset('/front/assets/images/shahzad/answer.svg')}}" class="d-lg-none question-tag-mobile">
                            <div class="p-s-p-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>
                                          {!! nl2br($r->answer) !!}
                                        </p>
                                        @if(!empty(Cmf::get_image_name('answerimages' , 'answerid' , $r->id)))
                                        <div class="preview">
                                            <div class="preview-pic tab-content">
                                                @foreach (Cmf::get_image_name('answerimages' , 'answerid' , $r->id) as $i)
                                                <div class="tab-pane @if ($loop->first) active  @endif" id="slide{{ $loop->iteration }}"><img style="height: 500px; background-color:transparent !important" class="slide-img"  src="{{ asset('/images') }}/{{ $i->image_name }}" /></div>
                                                @endforeach
                                            </div>
                                            <ul class="preview-thumbnail nav nav-tabs">
                                                @foreach (Cmf::get_image_name('answerimages' , 'answerid' , $r->id) as $i)
                                                <li style="margin-bottom: 10px;cursor: pointer;" class="active"><a data-target="#slide{{ $loop->iteration }}" data-toggle="tab"><img style="height: 150px;" class="img-thumb" src="{{asset('/images')}}/{{ $i->image_name }}" /></a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                           @include('frontend.questiondetail.answerfooter')
                        </div>



                            <div class="row mb-3 mt-3">
                                <div class="col-md-12">
                                    <div class="top-question-banner-2">
                                        {!! Cmf::site_settings('answercard_advertisement') !!}
                                    </div>
                                </div>
                            </div>

                        @endforeach

                        <div class="row mt-2 mb-2">
                            {!! $answers->links('frontend.pagination') !!}
                        </div>
                        @if(!empty($relatedquestion))
                        <div class="row mt-5 mb-5">
                            <div class="col-md-12">
                                <h3 class="f-20">Related Questions</h3>
                                <ul class="mt-2 reated-question-ul">
                                    @foreach($relatedquestion as $r)
                                    <li><a href="{{url('question')}}/{{ $r->question_url }}">{!! Str::limit($r->question_name, 70) !!}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif

                        <div class="row mb-2 mt-2">
                            <div class="col-md-12">
                                <div class="top-question-banner" style="height:auto !important;">
                                    {!! Cmf::site_settings('question_detail_page_top') !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
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
