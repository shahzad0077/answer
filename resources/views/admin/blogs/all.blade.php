@extends('layouts.admin-app')
@section('title','Blogs')
@section('content-admin')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Blgos</li>
                    </ol>
                </div>
                <h4 class="page-title">All Blogs</h4>
            </div>
        </div>
    </div>
    <ul class="nav nav-tabs nav-bordered mb-3">
        <li class="nav-item">
            <a href="{{ url('admin/blogs') }}"  class="nav-link active">
                <i class="mdi mdi-home-variant d-md-none d-block"></i>
                <span class="d-none d-md-block">All<span style="margin-left: 10px;" class="badge badge-pill badge-info">{{DB::table('blogs')->where('delete_status' , 'Active')->count()}}</span></span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('admin/blogs/published') }}"  class="nav-link ">
                <i class="mdi mdi-account-circle d-md-none d-block"></i>
                <span class="d-none d-md-block">Published<span style="margin-left: 10px;" class="badge badge-pill badge-success">{{DB::table('blogs')->where('visible_status' , 'Published')->where('delete_status' , 'Active')->count()}}</span></span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('admin/blogs/unpublished') }}"  class="nav-link ">
                <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                <span class="d-none d-md-block">Un Published<span style="margin-left: 10px;" class="badge badge-pill badge-warning">{{DB::table('blogs')->where('visible_status' , 'Not Published')->where('delete_status' , 'Active')->count()}}</span></span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('admin/blogs/trash') }}" class="nav-link">
                <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                <span class="d-none d-md-block">Trash<span style="margin-left: 10px;" class="badge badge-pill badge-danger">{{DB::table('blogs')->where('visible_status' , 'Trash')->where('delete_status' , 'Active')->count()}}</span></span>
            </a>
        </li>
    </ul>
    <div class="row mb-2">
        <div class="col-md-2 col-2">
            <select onchange="location = this.value;" class="form-control text-left">
                <option @if(Cmf::site_settings('datashowlimit') == 10) selected @endif value="{{ url('changenoofrecordsperpage/10') }}">10 Records Per Page</option>
                <option @if(Cmf::site_settings('datashowlimit') == 20) selected @endif value="{{ url('changenoofrecordsperpage/20') }}">20 Records Per Page</option>
                <option @if(Cmf::site_settings('datashowlimit') == 30) selected @endif value="{{ url('changenoofrecordsperpage/30') }}">30 Records Per Page</option>
                <option @if(Cmf::site_settings('datashowlimit') == 50) selected @endif value="{{ url('changenoofrecordsperpage/50') }}">50 Records Per Page</option>
                <option @if(Cmf::site_settings('datashowlimit') == 100) selected @endif value="{{ url('changenoofrecordsperpage/100') }}">100 Records Per Page</option>
                <option @if(Cmf::site_settings('datashowlimit') == 200) selected @endif value="{{ url('changenoofrecordsperpage/200') }}">200 Records Per Page</option>
                <option @if(Cmf::site_settings('datashowlimit') == 300) selected @endif value="{{ url('changenoofrecordsperpage/300') }}">300 Records Per Page</option>
            </select>
        </div>
        <div class="col-md-8">
            <form method="POST" action="{{ url('searchblog') }}">
                {{ csrf_field() }}
                <input required="" @if(isset($searchword)) value="{{ $searchword }}" @endif type="text" class="form-control" placeholder="Search With Name and Press Enter" name="searchword">
            </form>
        </div>
        <div class="col-md-2 text-right">
            <div class="dropdown text-right">
                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a onclick="showmodal()" class="dropdown-item" href="javascript:void(0);">Change Blog User</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-12">
 
            
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 20px;">
                                    <div class="custom-control custom-checkbox">
                                        <input  type="checkbox" class="custom-control-input" id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1">&nbsp;</label>
                                    </div>
                                </th>
                                <th>Blog Auther</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <form id="completeform" method="POST" action="{{ url('changebulkusersofall') }}">
                            {{ csrf_field() }} 

                            <div class="modal" id="myModal">
                              <div class="modal-dialog">
                                <div class="modal-content">

                                  <!-- Modal Header -->
                                  <div class="modal-header">
                                    <h4 class="modal-title">Select User</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  </div>

                                  <!-- Modal body -->
                                  <div class="modal-body">
                                    
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Search User</label>
                                                <input placeholder="Search User By User Name" id="target" type="text" class="form-control" >
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Select User</label>
                                                <select class="form-control" name="user" id="showusers" >
                                                    <option value="">Select User</option>
                                                </select>
                                            </div>
                                        </div>
                                        


                                        <script type="text/javascript">
                                            $('#target').keyup(function(e) {
                                              
                                                $('#livesearchbanner').show();
                                                var mainurl = '{{ url('') }}';
                                                if(e.target.value == '')
                                                {
                                                    $('#saveusersbutton').attr('disabled' , true);
                                                }else{
                                                    $('#saveusersbutton').attr('disabled' , false);
                                                    $.ajax({
                                                        type: "GET",
                                                        url: mainurl+'/searchusers/'+e.target.value,
                                                        success: function(resp) {
                                                            $('#showusers').html(resp);
                                                        }
                                                    });
                                                } 

                                            });
                                            function checkuserselectornot()
                                            {
                                                if($('#showusers').val() == '')
                                                {
                                                    $('#saveusersbutton').attr('disabled' , true);
                                                    alert('please Select Any User');
                                                }else{
                                                    $('#saveusersbutton').attr('disabled' , false);
                                                    $('#completeform').submit();
                                                }
                                            }
                                        </script>
                                  </div>

                                  <!-- Modal footer -->
                                  <div class="modal-footer">
                                    <button id="saveusersbutton" onclick="checkuserselectornot()" type="button" class="btn btn-success">Save</button>
                                  </div>

                                </div>
                              </div>
                            </div>

                            @foreach($data as $r)
                            <tr>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input value="{{ $r->id }}" name="allid[]" type="checkbox" class="custom-control-input" id="customCheck{{ $r->id }}">
                                        <label class="custom-control-label" for="customCheck{{ $r->id }}">&nbsp;</label>
                                    </div>
                                </td>
                                <td>
                                    @if(!empty(DB::table('users')->where('id' , $r->added_by)->get()->first()->username))

                                    {{ DB::table('users')->where('id' , $r->added_by)->get()->first()->username }}
                                    @else

                                    Answerout

                                    @endif

                                </td>
                                <td>{{ $r->name }}</td>
                                <td>{{ $r->visible_status }}</td>
                                <td>{{ $r->created_at }}</td>
                                <td><a href="{{ url('admin/edit/blog')}}/{{$r->id}}" class="action-icon" title="Edit Category"><i class="mdi mdi-pencil"></i></a><a onclick="return confirm("Are You Sure You want to Move Trash This Blog")" href="{{ url('deleteblogtrash')}}/{{$r->id}}" class="action-icon" title="Delte Category"> <i class="mdi mdi-delete"></i></a></td>
                            </tr>
                            @endforeach
                            </form>   
                        </tbody>
                    </table>
                    @if($statusnavbar == 'search')
                    @else
                     <div id="pagination" style="margin-top: 50px;">
                        {!! $data->links('frontend.pagination') !!}
                    </div>
                    @endif
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->
</div> <!-- container -->
<script type="text/javascript">
  function publish(one,two)
  {
    $.ajax({
      type: "GET",
      url: "{{ url('changetopublishblog') }}/"+one+'/'+two,
      success: function(resp) {
         if(resp == 'error'){
          location.reload();
         }else{
          location.reload();
         } 
      }
    });
  }
</script>
<script type="text/javascript">
  $("#customCheck1").click(function(){
      $('input:checkbox').not(this).prop('checked', this.checked);
  });

  function showmodal()
  {
    $('#myModal').modal("show");
  }
</script>
@endsection