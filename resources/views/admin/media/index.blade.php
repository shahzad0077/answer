@extends('layouts.admin-app')
@section('title','Media')
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
                        <li class="breadcrumb-item"><a href="{{url('categories')}}">Media</a></li>
                        <li class="breadcrumb-item active">Media</li>
                    </ol>
                </div>
                <h4 class="page-title">Media</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    @include('admin.alert')
<div class="row">

        <!-- Right Sidebar -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="app-search">
                                <button data-toggle="modal" data-target="#myModal" class="btn btn-primary">Add Multiple Images</button>
                            </div>
                        </div>
                        <div class="mt-3">
                            <h5 class="mb-2">All Image Folders</h5>

                            <div class="row mx-n1 no-gutters">
                                <div class="col-xl-2 col-lg-6">
                                    <div class="card m-1 shadow-none border" @if($active == 'questionimages') style="background-color: #0f4d8a;" @endif>
                                        <div class="p-2">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar-sm">
                                                        <span class="avatar-title bg-light text-secondary rounded">
                                                            <i class="mdi mdi-folder-zip font-16"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col pl-0">
                                                    <a @if($active == 'questionimages') style="color: white !important;" @endif href="{{ url('admin/media') }}" class="text-muted font-weight-bold">Questions</a>
                                                </div>
                                            </div> <!-- end row -->
                                        </div> <!-- end .p-2-->
                                    </div> <!-- end col -->
                                </div>
                                <div class="col-xl-2 col-lg-6">
                                    <div class="card m-1 shadow-none border" @if($active == 'answerimages') style="background-color: #0f4d8a;" @endif>
                                        <div class="p-2">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar-sm">
                                                        <span class="avatar-title bg-light text-secondary rounded">
                                                            <i class="mdi mdi-folder-zip font-16"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col pl-0">
                                                    <a @if($active == 'answerimages') style="color: white !important;" @endif href="{{ url('admin/getallimagesof/answerimages') }}" class="text-muted font-weight-bold">Answers</a>
                                                </div>
                                            </div> <!-- end row -->
                                        </div> <!-- end .p-2-->
                                    </div> <!-- end col -->
                                </div>
                                <div class="col-xl-2 col-lg-6">
                                    <div class="card m-1 shadow-none border" @if($active == 'blogimages') style="background-color: #0f4d8a;" @endif>
                                        <div class="p-2">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar-sm">
                                                        <span class="avatar-title bg-light text-secondary rounded">
                                                            <i class="mdi mdi-folder-zip font-16"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col pl-0">
                                                    <a @if($active == 'blogimages') style="color: white !important;" @endif href="{{ url('admin/getallimagesof/blogimages') }}" class="text-muted font-weight-bold">Blogs</a>
                                                </div>
                                            </div> <!-- end row -->
                                        </div> <!-- end .p-2-->
                                    </div> <!-- end col -->
                                </div>
                            
                                <div class="col-xl-2 col-lg-6">
                                    <div class="card m-1 shadow-none border"  @if($active == 'subjectimages') style="background-color: #0f4d8a;" @endif>
                                        <div class="p-2">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar-sm">
                                                        <span class="avatar-title bg-light text-secondary rounded">
                                                            <i class="mdi mdi-folder-zip font-16"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col pl-0">
                                                    <a @if($active == 'subjectimages') style="color: white !important;" @endif href="{{ url('admin/getallimagesof/subjectimages') }}" class="text-muted font-weight-bold">Subjects</a>
                                                </div>
                                            </div> <!-- end row -->
                                        </div> <!-- end .p-2-->
                                    </div> <!-- end col -->
                                </div>
                                <div class="col-xl-2 col-lg-6">
                                    <div class="card m-1 shadow-none border" @if($active == 'mediaimages') style="background-color: #0f4d8a;" @endif>
                                        <div class="p-2">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar-sm">
                                                        <span class="avatar-title bg-light text-secondary rounded">
                                                            <i class="mdi mdi-folder-zip font-16"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col pl-0">
                                                    <a @if($active == 'mediaimages') style="color: white !important;" @endif href="{{ url('admin/getallimagesof/mediaimages') }}" class="text-muted font-weight-bold">Other Images</a>
                                                </div>
                                            </div> <!-- end row -->
                                        </div> <!-- end .p-2-->
                                    </div> <!-- end col -->
                                </div>
                                <div class="col-xl-2 col-lg-6">
                                    <div class="card m-1 shadow-none border" @if($active == 'profileimages') style="background-color: #0f4d8a;" @endif>
                                        <div class="p-2">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar-sm">
                                                        <span class="avatar-title bg-light text-secondary rounded">
                                                            <i class="mdi mdi-folder-zip font-16"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col pl-0">
                                                    <a @if($active == 'mediaimages') style="color: white !important;" @endif href="{{ url('admin/getallimagesof/profileimages') }}" class="text-muted font-weight-bold">Profile Icons</a>
                                                </div>
                                            </div> <!-- end row -->
                                        </div> <!-- end .p-2-->
                                    </div> <!-- end col -->
                                </div>
                            </div>
                            <div class="row mx-n1 no-gutters">    
                                 <!-- end col-->
                            </div> <!-- end row-->
                        </div> <!-- end .mt-3-->
                        <div class="mt-3">
                             <!-- Gallery -->
                             <table id="basic-datatable" class="table">
                                <thead>
                                    <tr>
                                        <th>File</th>
                                        <th>Author</th>
                                        <th>Uploaded To</th>
                                        <th>Tittle</th>
                                        <th>Uploaded Date</th>
                                        <th style="width: 85px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $r)
                                        <tr>
                                            <td>
                                                <div style="width:40px;height:40px;">
                                                    <img style="height:100%;width: 100%;" src="{{ url('/images') }}/{{ $r->image_name }}"alt="" />
                                                </div>
                                            </td>
                                            <td>
                                                {{DB::table('users')->where('id' , $r->added_by)->get()->first()->name}}
                                            </td>
                                            <td>
                                                @if($active == 'mediaimages') 
                                                    Other Image
                                                @endif
                                                @if($active == 'questionimages') 
                                                   <a target="_blank" href="{{ url('') }}/{{ DB::table('answerquestions')->where('id' , $r->questionid)->get()->first()->question_url }}">{!! Str::limit(DB::table('answerquestions')->where('id' , $r->questionid)->get()->first()->question_name, 50) !!} 
                                                    </a>
                                                @endif
                                                @if($active == 'blogimages') 
                                                   <a target="_blank" href="{{ url('') }}/{{ DB::table('blogs')->where('id' , $r->blogid)->get()->first()->url }}">{!! Str::limit(DB::table('blogs')->where('id' , $r->blogid)->get()->first()->name, 50) !!} 
                                                    </a>
                                                @endif


                                            </td>
                                            <td>
                                                {{  $r->image_tittle }}
                                            </td>
                                            <td>
                                                {{ date('d M Y, h:s a ', strtotime($r->created_at)) }}
                                            </td>                                         
                                            <td class="table-action">
                                                <a onclick="showmodelforedit({{$r->id}},'{{ $r->image_tittle }}','{{ $active }}','{{ $r->image_name }}')" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                                <a onclick="return confirm('Are You Sure You want to Move Trash This Blog')" href="{{ url('deletemediaimage') }}/{{$active}}/{{ $r->id }}" class="action-icon" title="Delte Category"> <i class="mdi mdi-delete"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach  
                                </tbody>
                            </table>
                        </div> <!-- end .mt-3-->

                    <!-- end inbox-rightbar-->
                </div>
                <!-- end card-body -->
                <div class="clearfix"></div>
            </div> <!-- end card-box -->

        </div> <!-- end Col -->
    </div>
    <!-- end row -->
</div> <!-- container -->
<!-- The Modal -->
<script type="text/javascript">
    function showmodelforedit(id, imagetittle, active, image_name)
    {
        $('#mediaid').val(id);
        var tablename = '{{$active}}';
        $('#tablename').val(tablename);
        $('#imagename').val(imagetittle);
        var mainurl = "{{ url('/images/') }}";
        $('#imageurl').val(mainurl+'/'+image_name);
        var imagesource = 
        $('#showimagesource').attr("src", mainurl+'/'+image_name);
        $('#imageeditmodel').modal('show');
    }
    function changeimage(id,image_name)
    {
        $('#showimage').show();
        $('#mediaid').val(id);
        var tablename = '{{$active}}';
        $('#tablename').val(tablename);
        $('#imagename').val(image_name);
        var mainurl = "{{ url('/images/') }}";
        $('#imageurl').val(mainurl+'/'+image_name);
        var imagesource = 
        $('#showimagesource').attr("src", mainurl+'/'+image_name);
    }
    function imagename() {
          var copyText = document.getElementById("imagename");
          copyText.select();
          copyText.setSelectionRange(0, 99999); /* For mobile devices */
          document.execCommand("copy");
    }
    function imageurl() {
      var copyText = document.getElementById("imageurl");
      copyText.select();
      copyText.setSelectionRange(0, 99999); /* For mobile devices */
      document.execCommand("copy");
    }
</script>
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Multiple Image</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form enctype="multipart/form-data" method="POST" action="{{ url('addmultipleimages') }}" class="needs-validation" novalidate>
                {{ csrf_field() }}
      <!-- Modal body -->
      <div class="modal-body"> 
            <div class="form-group mb-3">
                <label  for="validationCustom03">Select Image Type</label>
                <select name="imagetype" class="form-control" required="">
                <option value="">Select Type</option>
                <option value="profileicon">Profile Icon</option>
                <option value="other">Other Images</option>
                </select>
            </div> 
            <div class="form-group mb-3">
                <label for="validationCustom03">Select Image</label>
                <input style="height: 44px;" type="file" class="form-control" name="image[]" multiple="" id="validationCustom09"
                     required>
                <div class="invalid-feedback">
                    Please attach image file.
                </div>
            </div>    
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button id="submitbutton" type="submit" class="btn btn-primary">Save</button>
      </div>
  </form>
    </div>
  </div>
</div>
<div class="modal fade" id="imageeditmodel">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Image</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form enctype="multipart/form-data" method="POST" action="{{ url('updatemediaimage') }}"> 
            {{ csrf_field() }}
      <!-- Modal body -->
      <div class="modal-body"> 
           <input type="hidden" id="mediaid" name="id"> 
             <input type="hidden" id="tablename" name="columname">
             <div style=" padding: 4px; height: 167px; ">
                <img id="showimagesource" style="height:100%;width: 100%;" src=""class="w-100 shadow-1-strong rounded media-image" alt="" />
            </div>
            <label>Image Name</label>
             <div class="input-group mb-3">
              <input type="text" id="imagename" name="image_tittle" class="form-control" placeholder="Image Tittle">
              <div class="input-group-append">
                <span onclick="imagename()" class="btn btn-success" type="submit"><i class="mdi mdi-content-copy"></i></span>
              </div>
            </div>
            <label>Complete Image URL</label>
            <div class="input-group mb-3">
              <input id="imageurl" type="text" class="form-control" placeholder="Search">
              <div class="input-group-append">
                <span onclick="imageurl()" class="btn btn-success" type="submit"><i class="mdi mdi-content-copy"></i></span>
              </div>
            </div>
            <label>Update Image</label>
            <div class="form-group">
                <input class="form-control" type="file" name="image">
            </div> 
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button id="submitbutton" type="submit" class="btn btn-primary">Save</button>
      </div>
  </form>
    </div>
  </div>
</div>
@endsection