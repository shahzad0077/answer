@extends('layouts.admin-app')
@section('title','Add Question')
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
                        <li class="breadcrumb-item active">Add Question</li>
                    </ol>
                </div>
                <h4 class="page-title">Add Question</h4>
            </div>
        </div>
    </div>     
    @include('admin.alert')
    <div class="tab-content">
        <div class="tab-pane show active" id="all">
    <form enctype="multipart/form-data" method="POST" action="{{ url('createquestion') }}">
        {{ csrf_field() }}
            <!-- end page title -->
            <div class="row">
                
                <div class="col-8">
                    <div class="card">
                        <div class="card-body">
                                       <div class="form-group mb-2">
                                            <label for="validationCustom01">Question</label>
                                            <input onkeyup="createslug(this.value)" required="" type="text" class="form-control"  name="question_name" placeholder="Enter Question">
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="validationCustom02">Slug</label>
                                            <input type="text" id="slug" class="form-control" name="slug" onkeyup="checkslug()" 
                                                 required >
                                                 <small id="slugerror" class="mt-1 text-danger"></small>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="validationCustom01">Question Content</label>
                                            <textarea id="summernote-basic" class="form-control" name="question_content"></textarea>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="validationCustom01">Select Subject</label>
                                            <select required="" id="useranswer" class="form-control" name="question_subject">
                                                <option value="">Select Subject</option>
                                                @foreach(DB::table('categories')->where('status' , 'Active')->get() as $r)
                                                <option  value="{{ $r->name }}">{{ $r->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="validationCustom01">Question Image</label>
                                            <input type="file" class="form-control" style="height: 45px;" name="image" placeholder="Enter Question Likes">
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="validationCustom01">Visible Status</label>
                                            <select required="" id="visiblestatus" class="form-control" name="visible_status">
                                                <option value="">Select Status</option>
                                                <option value="Published">Published</option>
                                                <option value="Trash">Trash</option>
                                                <option value="Under Review">Under Review</option>
                                            </select>
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
                            <input type="text" class="form-control"  name="metta_tittle" id="meta_title">
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="validationCustom04">Meta Description</label>
                                    <textarea class="form-control" name="metta_description" id="meta_description"
                                        placeholder="Put something"  rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="validationCustom04">Meta Keywords</label>
                                    <textarea class="form-control" name="metta_keywords" id="meta_keywords"
                                        placeholder="Put something" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                </div> <!-- end card-body-->
            </div>
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