@extends('layouts.app')
@section('title')
<title>@if(!empty($data->metta_tittle)){{ $data->metta_tittle }} @endif</title>
<meta name="DC.Title" content="@if(!empty($data->metta_tittle)){{ $data->metta_tittle }} @endif">
<meta name="rating" content="general">
<meta name="description" content="@if(!empty($data->metta_description)){{ $data->mettametta_description_tittle }} @endif">
<meta property="og:type" content="website">
<meta property="og:image" content="">
<meta property="og:title" content="@if(!empty($data->metta_tittle)){{ $data->metta_tittle }} @endif">
<meta property="og:description" content="@if(!empty($data->metta_description)){{ $data->metta_description }} @endif">
<meta property="og:site_name" content="Answerout">
<meta property="og:url" content="{{ Request::url() }}">
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
    "name": "{{ $data->name }}"
  }]
}
</script>
@endsection
@section('content')
<div class="main-wrapper bg-other-pages">
    <div class="container">
    <div class="row mt-100">
      <div class="col-md-12">
          <nav aria-label="breadcrumb" class="mt-4">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{ $data->name }}</li>
            </ol>
          </nav>
      </div>
  </div>
</div>
<!-- ==========Contact-Section========== -->
<section class="contact-section pd-top-30">
    <div class="container mb-5">
        <div class="card p-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 text-center mt-2">
                        <div class="content">
                            <div class="section-header text-center">
                                <h2 class="title theme-text mb-3">
                                    {{ $data->name }}
                                </h2>
                                
                            </div>
                        </div>
                    </div>
                <div class="col-lg-12">
                    {!! $data->content  !!}
                </div>
            </div>
            </div>
        </div>
    </div>

</section>
<!-- ==========Contact-Sectionn========== -->
</div>

@endsection