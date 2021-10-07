@extends('layouts.admin-app')
@section('title','User')
@section('content-admin')
<style type="text/css">
    .activeicon{
        cursor: pointer;
        border: 1px solid #DDD;
        background-color: #9a6afa;
        border-radius: 35px;
        padding: 12px;
    }
      .edit{
       width:100%;
       height: 0px;
       z-index:1;
       bottom:0;
       font-weight: bold;
       color:white;
       background-color: rgba(10, 175, 241, 0.781);
       transition: all 1s;
       padding-top: 0px;
        text-align: center;
      }



      .avatar{
          font-family: 'Lato', sans-serif;
          width: 100px;
          height: 100px;
          display:block;
          border-radius: 50%;
          overflow:hidden;
          position:relative;
          transition: border .15s ease-in;
        }

      .avatar:hover {
         border: 2px solid #0AAFF1;
         cursor: pointer;
      } 

      .edit:hover {
          padding-top: 10px;
          height: 40px;
        }
         .avatar-img .edit{
    position:absolute;
  };
</style>
<div class="container-fluid">
    <!-- start page title -->
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/admin/users')}}">Users</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
                <h4 class="page-title">

                    @if(!empty($data->name))
                    {{ $data->name }}
                    @else
                    {{$data->username}}
                    @endif
                </h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 
     <div class="row">
        <div class="col-sm-12">
            <!-- Profile -->
            <div class="card bg-primary">
                <div class="card-body profile-user-box">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="media">
                                <span title="Click to change the Avatar" style="cursor:pointer;" data-toggle="modal" data-target="#myModal" class="float-left m-2 mr-4 avatar">
                                     <div class="edit">Edit</div>
                                    <img src="
                                    @if(!empty($data->profileimage))
                                    {{ $data->profileimage }}
                                    @else
                                    https://cdn3.iconfinder.com/data/icons/diversity-avatars-vol-2/64/man-avatar-blond-sweater-512.png
                                    @endif
                                    " style="height: 100px;width: 100px;" alt="" class="rounded-circle img-thumbnail"></span>
                                <div class="media-body">
                                    <h4 class="mt-1 mb-1 text-white">@if(!empty($data->name))
                                                {{ $data->name }}
                                                @else
                                                {{$data->username}}
                                                @endif</h4>
                                    @if($data->expert == 'on')
                                    <p class="font-13 text-white-50">@if(!empty(DB::table('expertrequests')->where('email' , $data->email)->get()->first()->specialisation)) {{ DB::table('expertrequests')->where('email' , $data->email)->get()->first()->specialisation }} @endif Expert</p>
                                    @endif
                                    <ul class="mb-0 list-inline text-light">
                                        <li class="list-inline-item mr-3">
                                            <h5 class="mb-1">{{ DB::table('answerquestions')->where('question_auther' , $data->username)->count() }}</h5>
                                            <p class="mb-0 font-13 text-white-50">Asked Questions</p>
                                        </li>
                                        <li class="list-inline-item">
                                            <h5 class="mb-1">{{ DB::table('onlyanswers')->where('users' , $data->username)->count() }}</h5>
                                            <p class="mb-0 font-13 text-white-50">Answers</p>
                                        </li>
                                    </ul>
                                </div> <!-- end media-body-->
                            </div>
                        </div> <!-- end col-->

                        <div class="col-sm-4">
                            <div class="text-center mt-sm-0 mt-3 text-sm-right">
                                @if($data->expert == 'on')
                                <a href="{{ url('removeexpert') }}/{{ $data->id }}">
                                <button type="button" class="btn btn-light">
                                    <i class="mdi mdi-account-edit mr-1"></i>Make Simple User
                                </button>
                                </a>
                                @else
                               <a href="{{ url('makeexpert') }}/{{ $data->id }}"> <button type="button" class="btn btn-light">
                                    <i class="mdi mdi-account-edit mr-1"></i>Make Expert
                                </button></a>
                                @endif
                            </div>
                        </div> <!-- end col-->
                    </div> <!-- end row -->

                </div> <!-- end card-body/ profile-user-box-->
            </div><!--end profile/ card -->
        </div> <!-- end col-->
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-lg-4">
            <!-- Personal-Information -->
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-3">User Information</h4>
                    <div class="text-left">
                        <p class="text-muted"><strong>Name :</strong> <span class="ml-2">{{ $data->name }}</span></p>

                        <p class="text-muted"><strong>Email :</strong><span class="ml-2">{{ $data->email }}</span></p>
                        @if($data->expert == 'on')
                        <p class="text-muted"><strong>Phone :</strong> <span class="ml-2">@if(!empty(DB::table('expertrequests')->where('email' , $data->email)->get()->first()->phonenumber)) {{ DB::table('expertrequests')->where('email' , $data->email)->get()->first()->phonenumber }} @endif</span></p>

                        <p class="text-muted"><strong>Qualification :</strong> <span class="ml-2">@if(!empty(DB::table('expertrequests')->where('email' , $data->email)->get()->first()->qualification)) {{ DB::table('expertrequests')->where('email' , $data->email)->get()->first()->qualification }} @endif</span></p>

                        <p class="text-muted"><strong>Specialization :</strong>
                            <span class="ml-2"> @if(!empty(DB::table('expertrequests')->where('email' , $data->email)->get()->first()->specialisation)) {{ DB::table('expertrequests')->where('email' , $data->email)->get()->first()->specialisation }} @endif</span>
                        </p>

                        <p class="text-muted"><strong>Documents :</strong>
                            <span class="ml-2"> <a download="" target="_blank" href="@if(!empty(DB::table('expertrequests')->where('email' , $data->email)->get()->first()->document)) {{ DB::table('expertrequests')->where('email' , $data->email)->get()->first()->document }} @endif">Download Attached File</a> </span>
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Recent Activities</h4>
                    <div class="accordion custom-accordion" id="custom-accordion-one">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>IP Address</th>
                                    <th>Activity</th>
                                    <th>Date and Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($useractivities as $r)
                                <tr>
                                    <td><a target="_blank" href="https://whatismyipaddress.com/ip/{{ $r->ipaddress }}">{{ $r->ipaddress }}</a></td>
                                    <td>{!! $r->activity !!}</td>
                                    <td>{{ date('d M Y, h:s a ', strtotime($r->created_at)) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                {!! $useractivities->links('frontend.pagination') !!}
                            </div>
                        </div>
                    </div>
               </div>
            </div>
            <!-- Personal-Information -->

        </div> <!-- end col-->

        <div class="col-lg-8">

            <!-- Chart-->
                <div class="card">
                    <div class="card-body">
                        
                        <ul class="nav nav-tabs nav-bordered mb-3">
                            <li class="nav-item">
                                <a href="{{ url('admin/user/detail/') }}/{{$data->id}}"  class="nav-link active">
                                    <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                    <span class="d-none d-md-block">All Questions</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('admin/user/detail/') }}/{{$data->id}}/answered"  class="nav-link ">
                                    <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                    <span class="d-none d-md-block">All Answers</span>
                                </a>
                            </li>
                        </ul>

                        <div class="accordion custom-accordion" id="custom-accordion-one">
                            <table id="basic-datatable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Question Title</th>
                                        <th>Status</th>
                                        <th>Answers Count</th>
                                        <th>Visible Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @foreach($questiondata as $r)
                                        <tr>
                                            <td><a target="_blank" href="{{ url('admin/viewquestion') }}/{{ $r->id }}">Q-{{ $r->id }}</a></td>
                                            <td>
                                                {{ Str::limit($r->question_name  , 10) }}
                                            </td>
                                            <td>
                                                @if(!empty($r->accepted_answer))
                                                <span class="badge badge-success-lighten"><i class="mdi mdi-timer-sand"></i>Answered</span>
                                                @else
                                                <span class="badge badge-warning-lighten"><i class="mdi mdi-timer-sand"></i>Unanswered</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ DB::table('onlyanswers')->where('delete_status' , 'Active')->where('questionid' , $r->id)->count() }}
                                            </td>
                                            <td>
                                                <div class="badge badge-pill @if($r->visible_status == 'Published') badge-success @endif @if($r->visible_status == 'Trash') badge-danger @endif @if($r->visible_status == 'Under Review') badge-warning @endif" style="font-size: 15px;">{{  $r->visible_status }}</div>
                                            </td>
                                            <td>
                                                <a href="{{ url('admin/editquestion/') }}/{{ $r->id }}" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                                <a onclick="return confirm('Are You Sure You want to Delete This')" href="{{url('admin/deletequestion')}}/{{ $r->id }}" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach 
                                </tbody>
                            </table>
                        </div>
                   </div>
                </div>
            <!-- End Chart-->

        </div>
        <!-- end col -->

    </div>
    <!-- end row -->

</div>
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
            <input type="hidden" value="{{ $data->id }}" name="userid">
            <button type="submit" class="btn btn-primary" >Save</button>
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

<!-- Modal -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit-modalLabel">Edit Reply</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <textarea class="form-control" rows="5"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endsection