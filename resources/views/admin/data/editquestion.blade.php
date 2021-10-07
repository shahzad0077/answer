@extends('layouts.admin-app')
@section('title','Edit Question')
@section('content-admin')
<div class="container-fluid">
    <!-- start page title -->
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Question</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Question</h4>
            </div>
        </div>
    </div>     
    @include('admin.alert')
    <div class="tab-content">
        <div class="tab-pane show active" id="all">
    <form enctype="multipart/form-data" method="POST" action="{{ url('updatquestion') }}">
        {{ csrf_field() }}
            <!-- end page title -->
            <div class="row">
                
                <div class="col-8">
                    <div class="card">
                        <div class="card-body">
                                      <input type="hidden" id="answerid" value="{{ $data->id }}" name="id">
                                       <div class="form-group mb-2">
                                            <label for="validationCustom01">Question</label>
                                            <input onkeyup="createslug(this.value)" type="text" class="form-control" value="{{ $data->question_name }}" name="question_name" placeholder="Enter Question Likes">
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="validationCustom02">Slug</label>
                                            <input type="text" value="{{ $data->question_url }}" id="slug" class="form-control" name="slug" onkeyup="checkslug()" 
                                                 required >
                                                 <small id="slugerror" class="mt-1 text-danger"></small>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="validationCustom01">Question Content</label>
                                            <textarea id="summernote-basic" rows="8" name="question_content" class="form-control">{{ $data->question_content }}</textarea>
                                        </div>
                                       <div class="form-group mb-2">
                                            <label for="validationCustom01">Select Subject</label>
                                            <select required="" id="useranswer" class="form-control" name="question_subject">
                                                <option value="">Select Subject</option>
                                                @foreach(DB::table('categories')->where('status' , 'Active')->get() as $r)
                                                <option @if($data->question_subject == $r->name) selected @endif value="{{ $r->name }}">{{ $r->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="validationCustom01">Visible Status</label>
                                            <select id="visiblestatus" class="form-control" name="visible_status">
                                                <option value="">Select User</option>
                                                <option @if($data->visible_status == 'Published') selected @endif value="Published">Published</option>
                                                <option @if($data->visible_status == 'Trash') selected @endif value="Trash">Trash</option>
                                                <option @if($data->visible_status == 'Under Review') selected @endif value="Under Review">Under Review</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="validationCustom01">Question Image</label>
                                            <input type="file" class="form-control" style="height: 45px;" name="image" placeholder="Enter Question Likes">
                                        </div>                                       
                              
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div>
                <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    Qestion Meta Tags
                </div>
                <div class="card-body">
                        <div class="form-group mb-2">
                            <label for="validationCustom03">Meta Title</label>
                            <input type="text" class="form-control" value="{{ $data->metta_tittle }}" name="metta_tittle" id="meta_title">
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="validationCustom04">Meta Description</label>
                                    <textarea class="form-control" name="metta_description" id="meta_description"
                                        placeholder="Put something"  rows="4">{{ $data->metta_description }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="validationCustom04">Meta Keywords</label>
                                    <textarea class="form-control" name="metta_keywords" id="meta_keywords"
                                        placeholder="Put something" rows="4">{{ $data->metta_keywords }}</textarea>
                                </div>
                            </div>
                        </div>
                </div> <!-- end card-body-->
            </div>
            <br>
            @if(DB::table('questionimages')->where('questionid'  ,$data->id)->count() > 0)
            <div class="card">
                <div class="card-header">
                    Question Images
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach(DB::table('questionimages')->where('questionid'  ,$data->id)->get() as $r)
                        <div class="col-md-4">
                            <div style="border:1px solid #ddd;">
                                <div style="margin:0px;" class="row">
                                    <div class="col-md-12 text-right" style="background-color:silver;">
                                        <a target="_blank" href="{{ url('/images') }}/{{ $r->image_name }}" class="action-icon" title="Edit Category"> 
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    <a href="{{ url('admin/deleteimagequestionadmin') }}/{{ $r->id }}" onclick="return confirm('Are You Sure You want to Move Trash This Blog')"  class="action-icon" title="Delte Image"> <i class="mdi mdi-delete"></i></a>
                                    </div>
                                </div>
                                <img style="width:100%;height:100%;" src="{{ url('/images') }}/{{ $r->image_name }}">
                            </div>
                            
                        </div>
                        @endforeach
                    </div>
                </div> <!-- end card-body-->
            </div>
            @endif
             <div class="form-group mb-2">
                <button type="submit" class="btn btn-primary form-control">Save</button>
            </div> <!-- end card-->
        </div> <!-- end col -->
            </div>
            <!-- end row --> 
        </div>
    </div> 
</div>
  <link rel="stylesheet" href="{{ asset('/front/assets/summernote/summernote-bs4.css') }}">
<script src="{{ asset('/front/assets/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('/front/assets/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('/front/assets/summernote/lang/summernote-ar-AR.js') }}"></script>
<script src="{{ asset('/front/assets/summernote/summernote-ext-rtl.js') }}"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
@endsection