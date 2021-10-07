@extends('layouts.admin-app')
@section('title','Profile')
@section('content-admin')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
                <h4 class="page-title">Profile</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 

    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card text-center">
                <div class="card-body">
                    <img src="{{asset('/admin/images/users/avatar-1.jpg')}}" class="rounded-circle avatar-lg img-thumbnail"
                    alt="profile-image">

                    <h4 class="mb-0 mt-2">Dominic Keller</h4>
                    <p class="text-muted font-14">Founder</p>

                    <div class="text-left mt-3">
                        <h4 class="font-13 text-uppercase">About Me :</h4>
                        <p class="text-muted font-13 mb-3">
                            Hi I'm Johnathn Deo,has been the industry's standard dummy text ever since the
                            1500s, when an unknown printer took a galley of type.
                        </p>
                        <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ml-2">Geneva
                                D. McKnight</span></p>

                        <p class="text-muted mb-2 font-13"><strong>Mobile :</strong><span class="ml-2">(123)
                                123 1234</span></p>

                        <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ml-2 ">user@email.domain</span></p>

                    </div>
                </div> <!-- end card-body -->
            </div> <!-- end card -->

            <!-- Messages-->

        </div> <!-- end col-->

        <div class="col-xl-8 col-lg-7">
            
            <div class="card">
                <div class="card-body">
                    <form>
                        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Personal Info</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firstname">First Name</label>
                                    <input type="text" class="form-control" id="firstname" placeholder="Enter first name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" class="form-control" id="lastname" placeholder="Enter last name">
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="userbio">Bio</label>
                                    <textarea class="form-control" id="userbio" rows="4" placeholder="Write something..."></textarea>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="useremail">Profile Picture</label>
                                    <span class="btn btn-primary" data-toggle="modal" data-target="#myModal">Click to Chose Avatar</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="useremail">Email Address</label>
                                    <input type="email" class="form-control" id="useremail" placeholder="Enter email">
                                </div>
                            </div>
                            
                        </div> <!-- end row -->
                        
                        <div class="text-right">
                            <button type="submit" class="btn btn-success mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                        </div>
                    </form>
                    
                </div> <!-- end card body -->
            </div> <!-- end card --> <br>
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Security Info</h5>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="userpassword">Old Password</label>
                                <input type="password" class="form-control" id="userpassword" placeholder="Enter password">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="userpassword">New Password</label>
                                <input type="password" class="form-control" id="userpassword" placeholder="Enter password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="userpassword">Repeat Password</label>
                                <input type="password" class="form-control" id="userpassword" placeholder="Enter password">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row-->
</div>
<!-- container -->
<!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <!-- Modal body -->
      <div class="modal-body">
        <div class="row">
            @foreach(DB::table('profileimages')->get() as $r)
            <div style="cursor:pointer;margin-top:10px;" onclick="addurlofimage({{$r->id}},'{{$r->image_name}}')" id="iconid{{ $r->id }}"  class="col-md-2 iconremoveactive">
                <img style="width:100%;height:100%;" src="{{ url('/images') }}/{{ $r->image_name }}">
            </div>
            @endforeach
        </div>
      </div>
      <div class="modal-footer">
        <form method="POST" action="{{ url('profilepicturechange') }}">
            {{ csrf_field() }}
            <input type="hidden" id="imageurl" name="imageurl">
            <input type="hidden" value="{{ Auth::user()->id }}" name="userid">
            <button type="submit" class="btn btn-theme-sm" >Save</button>
        </form>
        
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    function addurlofimage(iconid , id)
    {
        $('.iconremoveactive').removeClass('activeicon');
        $('#iconid'+iconid).addClass('activeicon');
        var mainurl = '{{ url("/images") }}';
        $('#imageurl').val(mainurl+'/'+id);

    }
</script>
@endsection