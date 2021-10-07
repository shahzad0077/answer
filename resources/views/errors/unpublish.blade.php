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
<div class="container-fluid">
    <div class="row mt-100">
      <div class="col-md-12">
          <!-- <nav aria-label="breadcrumb"> -->
            <!-- <ol class="breadcrumb"> -->
              <!-- <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li> -->
              <!-- <li class="breadcrumb-item active" aria-current="page">Become an expert</li> -->
            <!-- </ol> -->
          </nav>
      </div>
  </div>
</div>
<!-- ==========Contact-Section========== -->
    <section class="contact-section pd-top-60">
        <br><br><br>
        <div class="container mb-5">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="title theme-text mb-3">
                        Oops! 
                    </h2>
                    <p>We couldn't find the page, maybe Bruno ate it.</p>  
                    <br>
                    <a href="{{ url('') }}" class="btn btn-theme"><b><i>Home Page</i></b></a>  
                     <a href="javascript:history.go(-1)" class="btn btn-theme"><b><i>Go Back</i></b></a>  
                </div>
            </div>
        </div>
        <br>
    </section>
    <!-- ==========Contact-Sectionn========== -->
@endsection