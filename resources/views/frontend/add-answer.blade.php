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
<style type="text/css">
    select, input, textarea, button{
        width: unset !important;
    }
</style>
<section class="profile-section single-community">
        <div class="container-fluid">
            <div class="row mt-100">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $data->question_name }}</li>
                      </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <div class="ads">
                        {!! Cmf::site_settings('left_add_1') !!}
                    </div>
                </div>
                
                @php 
                    $userquestion = $data->question_auther;
                @endphp
                
                <div class="col-lg-6">
                    @include('admin.alert')
                    @if(Auth::user()->username == $userquestion)
                 
                            <div class="alert alert-warning alert-dismissible">
                                You are the Owner of this Question and you can't answer this Question
                            </div>
            
                    @endif 
                    <div class="profile-main-content">
                        <div class="profile-single-post">
                            <div class="p-s-p-content">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="p-s-p-header-area">
                                            <div class="img">
                                                @if(!empty(Cmf::getuserdetailsbyid($userquestion)->profileimage))
                                                <img src="{{ Cmf::getuserdetailsbyid($userquestion)->profileimage }}" alt="">
                                                @else
                                                <img src="https://cdn3.iconfinder.com/data/icons/diversity-avatars-vol-2/64/man-avatar-blond-sweater-512.png" >
                                                @endif
                                            </div>
                                            <h6 class="name">
                                                Asked by <a href="{{ url('user-profile') }}/{{ $userquestion }}" class="text-theme">
                                                    {{$userquestion}}
                                                </a>
                                            </h6>
                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                       <a  href="{{ url('question') }}/{{ $data->question_url }}"> <h1 style="color:#5352ed !important;" class="f-24 f-weight-600">{{ $data->question_name }}</h1></a>                                      
                                    </div>
                                    
                                </div>

                            </div>
                            <div style="display: unset;" class="p-s-p-content-footer">
                                <form id="formsubmitaddanswer" enctype="multipart/form-data" method="POST" action="{{ url('addanswer') }}">
                                    {{ csrf_field() }}
                                  <input type="hidden" value="{{ $data->id }}" name="id">
                                    <div class="form-group">
                                        <label for="validationCustom01">Detailed Answer</label>
                                        <textarea id="summernote" placeholder="Type the content here!" required="" name="answer" class="form-control" rows="8"></textarea>
                                    </div>
                                    <!-- div class="form-group">
                                        <label for="validationCustom01">Any Image</label>
                                        <input accept="image/png, image/gif, image/jpeg" style="width: 100% !important;height: 45px;" type="file" class="form-control" name="image[]" >
                                    </div> -->
                                    <div class="form-group">
                                        <div class="g-recaptcha"
                                            data-sitekey="{{config('services.recaptcha.key')}}">
                                        </div>
                                    </div>

                                    
                                    @if(Auth::user()->username != $data->question_auther)
                                        <div class="form-group">
                                            <div class="text-right">
                                                <button type="submit" class="btn btn-theme">Save</button>
                                            </div>
                                        </div>
                                    @endif                                
                                </form>                           
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="ads">
                        {!! Cmf::site_settings('right_add_1') !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
        $('#formsubmitaddanswer').on('submit', function(e) {
          if(grecaptcha.getResponse() == "") {
            e.preventDefault();
            $('#rc-anchor-container').css('border-color' , 'red');
            $('#recaptcha-checkbox-border').css('border-color' , 'red');
          }
        });
    </script>
@endsection