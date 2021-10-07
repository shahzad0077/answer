@extends('layouts.admin-app')
@section('title','Add Blog')
@section('content-admin')
<!-- Start Content-->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('admin/blogs')}}">Blog</a></li>
                        <li class="breadcrumb-item active">Edit Blog</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Blog</h4>
            </div>
        </div>
    </div>
    @include('admin.alert')
<form enctype="multipart/form-data" method="POST" action="{{ url('createblog') }}" class="needs-validation" novalidate>
        {{ csrf_field() }}
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    Blog Details
                </div>
                <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Blog Name</label>
                            <input onkeyup="createslug(this.value)" type="text" class="form-control" name="name" id="validationCustom01"
                                placeholder="Title" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
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
                            <label for="validationCustom01">Detailed Content</label>
                            <textarea id="summernote-basic" required="" name="content" class="form-control" rows="8"></textarea>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="validationCustom03">Main Image</label>
                            <input style="height: 44px;" type="file" class="form-control" name="image" id="validationCustom09"
                                 >
                            <div class="invalid-feedback">
                                Please attach image file.
                            </div>
                        </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    Blog Categories
                </div>
                <div class="card-body">
                    <div style="height: 300px;overflow: auto;overflow-x: hidden;">
                        @foreach(DB::table('blogcategories')->where('delete_status' , 'Active')->get() as $r)
                        <div class="row">
                            <div class="col-md-1">
                                <input id="label{{$r->id}}" value="{{ $r->id }}" type="checkbox" name="blogcategory[]">
                            </div>
                            <div class="col-md-11">
                               <label style="width:350px;" for="label{{$r->id}}"> {{ $r->name }} </label>
                            </div>
                           
                        </div>
                         @endforeach
                    </div>
                    
                </div> <!-- end card-body-->
            </div>
            <div class="card">
                <div class="card-header">
                    Blog Meta Tags
                </div>
                <div class="card-body">
                        <div class="form-group mb-2">
                            <label for="validationCustom03">Meta Title</label>
                            <input type="text" class="form-control" name="metta_tittle" id="meta_title">
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="validationCustom04">Meta Description</label>
                                    <textarea class="form-control" name="metta_description" id="meta_description"
                                        placeholder="Put something" rows="4"></textarea>
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
                        <div class="form-group mb-2">
                        <input type="radio" checked="" value="Published" name="visible_status" id="active">
                        <label for="active">Published</label>
                        </div>
                        <div class="form-group mb-2">
                            <input type="radio" value="Not Published" name="visible_status" id="delete">
                            <label for="delete">Not Published</label>
                        </div>
                </div> <!-- end card-body-->
            </div> 
            <div class="row">
                <div class="col-md-12 text-right">
                    <button id="submitbutton" type="submit" class="btn btn-primary form-control">Save</button>
                </div>
            </div><!-- end card-->
        </div> <!-- end col-->
    </div>
</form>
</div> <!-- container -->
@endsection