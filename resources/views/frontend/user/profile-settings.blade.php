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
@include('admin.alert')
<!-- ========= Profile Section Start -->
    <section class="profile-section">
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/my-profile')}}">Profile</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Settings</li>
                      </ol>
                    </nav>
                </div>
            </div>
            <div class="row justify-content-center">
                @include('frontend.user.userprofile')
                <div class="col-xl-8 col-lg-6">
                    <div class="profile-main-content">
      
                        <br>
                        @include('admin.alert')
                        @if ($errors->any())
                          <div class="alert alert-danger alert-dismissible">
                            <ul>
                                @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                          </div><br />
                        @endif

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-ask box-shadow">
                                    <div class="card-body p-4">
                                        <form enctype="multipart/form-data" method="POST" action="{{ url('/updateuserprofile') }}">
                                            {{ csrf_field() }}
                                            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Personal Info</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="firstname">Name</label>
                                                        <input type="text" value="{{ Auth::user()->name }}" class="form-control" placeholder="First Name" name="name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="lastname">Username</label>
                                                        <input onkeyup="checkusername(this.value)" type="text" value="{{ Auth::user()->username }}" class="form-control" placeholder="Username" name="username">
                                                    </div>
                                                    <div id="usernameerror"></div>
                                                </div> <!-- end col -->
                                            </div>
                                            <script type="text/javascript">
                                                function checkusername(id)
                                                {
                                                    var mainurl = '{{ url("") }}';
                                                    $.ajax({
                                                        type: "GET",
                                                        url: mainurl+"/checkusername/"+id,
                                                        success: function(resp) {
                                                            if(resp == 1)
                                                            {
                                                                $('#usernameerror').css('color' , 'red');
                                                                $('#usernameerror').html('This Username is not Available');
                                                                $('#submitbutton').prop('disabled' , true);
                                                            }else{
                                                                $('#usernameerror').css('color' , 'green');
                                                                $('#usernameerror').html('This Username Available');
                                                                $('#submitbutton').prop('disabled' , false);
                                                            }
                                                        }
                                                    });
                                                }
                                            </script>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="firstname">Email</label>
                                                        <input readonly="" type="text" value="{{ Auth::user()->email }}" class="form-control" placeholder="Email" name="email">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="lastname">Contact Number</label>
                                                        <input type="text" value="{{ Auth::user()->phonenumber }}" class="form-control" placeholder="Phone No" name="phonenumber">
                                                    </div>
                                                </div> <!-- end col -->
                                            </div> <!-- end row --> <!-- end row -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <br>
                                                        <span class="btn btn-theme" data-toggle="modal" data-target="#myModal">Click to Chose Avatar</span>
                                                    </div>
                                                </div>
                                                 <!-- end col -->
                                            </div> <!-- end row -->                                                             
                                            <div class="text-right">
                                                <button id="submitbutton" type="submit" class="btn btn-theme"> Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection