@extends('layouts.app')
@section('title')
<title>Categories</title>
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
    "name": "Categories"
  }]
}
</script>
@endsection
@section('content')
<section class="profile-section single-community">
        <div class="container">
            <div class="row mt-100">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Categories</li>
                      </ol>
                    </nav>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="top-question-banner">
                        {!! Cmf::site_settings('question_detail_page_top') !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        @foreach($data as $r)
                        <div class="col-xl-4 col-md-4 col-lg-4 col-md-6 col-6">
                            <a style="width: 100%;" href="{{ url('') }}/{{ $r->url }}">
                                <div class="card card-explore card-category" style="{{ $r->backgroundcolor  }} ">
                                    <div class="card-body text-center">
                                        @if(!empty(Cmf::get_image_name('subjectimages' , 'subjectid' , $r->id)->first()->image_name))
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <img class="category-img" src="{{ url('/images/') }}/{{ Cmf::get_image_name('subjectimages' , 'subjectid' , $r->id)->first()->image_name }}">
                                            </div>
                                        </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h1 style="{{ $r->text_color }}" class="categories-title">{{ $r->name }}</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
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
