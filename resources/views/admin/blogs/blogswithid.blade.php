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
                <h4 class="page-title" style="text-transform: capitalize;">{{$statusnavbar}} Blogs</h4>
            </div>
        </div>
    </div>
    <ul class="nav nav-tabs nav-bordered mb-3">
        <li class="nav-item">
            <a href="{{ url('admin/blogs') }}"  class="nav-link">
                <i class="mdi mdi-home-variant d-md-none d-block"></i>
                <span class="d-none d-md-block">All<span style="margin-left: 10px;" class="badge badge-pill badge-info">{{DB::table('blogs')->where('delete_status' , 'Active')->count()}}</span></span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('admin/blogs/published') }}"  class="nav-link @if($statusnavbar == 'published') active @endif ">
                <i class="mdi mdi-account-circle d-md-none d-block"></i>
                <span class="d-none d-md-block">Published<span style="margin-left: 10px;" class="badge badge-pill badge-success">{{DB::table('blogs')->where('visible_status' , 'Published')->where('delete_status' , 'Active')->count()}}</span></span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('admin/blogs/unpublished') }}"  class="nav-link @if($statusnavbar == 'unpublished') active @endif">
                <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                <span class="d-none d-md-block">Un Published<span style="margin-left: 10px;" class="badge badge-pill badge-warning">{{DB::table('blogs')->where('visible_status' , 'Not Published')->where('delete_status' , 'Active')->count()}}</span></span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('admin/blogs/trash') }}" class="nav-link @if($statusnavbar == 'trash') active @endif">
                <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                <span class="d-none d-md-block">Trash<span style="margin-left: 10px;" class="badge badge-pill badge-danger">{{DB::table('blogs')->where('visible_status' , 'Trash')->where('delete_status' , 'Active')->count()}}</span></span>
            </a>
        </li>
    </ul>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="basic-datatable" class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Dated</th>
                                <th>Published</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($data as $r)
                            <tr>
                                <td>{{ $r->name }}</td>
                                <td>{{ date('d M Y, h:s a ', strtotime($r->created_at)) }}</td>
                                <td>
                                    @if($statusnavbar == 'trash')
                                        <a class="btn btn-success" href="{{ url('changetopublishblog') }}/{{$r->id}}/trash">Restore</a>
                                    @else
                                    <div>
                                        <input type="checkbox" onclick="publish({{$r->id}} ,'{{ $r->visible_status }}')" id="switch1{{ $r->id }}" <?php if($r->visible_status == 'Published'){echo 'checked'; } ?> data-switch="success"/>
                                        <label for="switch1{{ $r->id }}" data-on-label="Yes" data-off-label="No" class="mb-0 d-block"></label>
                                    </div>
                                    @endif
                                </td>
                                <td class="table-action text-center">
                                    <a href="{{url('admin/edit/blog')}}/{{ $r->id }}" class="action-icon" title="Edit Category"> 
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                     @if($statusnavbar == 'trash')
                                        <a onclick="return confirm('Are You Sure You want to Delete This Permanently')" href="{{ url('deleteblog') }}/{{ $r->id }}" class="action-icon" title="Delte Category"> <i class="mdi mdi-delete"></i></a>
                                    @else
                                        <a onclick="return confirm('Are You Sure You want to Move Trash This Blog')" href="{{ url('deleteblogtrash') }}/{{ $r->id }}" class="action-icon" title="Delte Category"> <i class="mdi mdi-delete"></i></a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
@endsection