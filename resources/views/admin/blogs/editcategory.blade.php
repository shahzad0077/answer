@extends('layouts.admin-app')
@section('title','Edit Blog Category')
@section('content-admin')
<!-- Start Content-->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Blog</li>
                        <li class="breadcrumb-item active">Edit Blog Category</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Blog Category</h4>
            </div>
        </div>
    </div>
    @include('admin.alert')
<form enctype="multipart/form-data" method="POST" action="{{ url('updateblogcategory') }}" class="needs-validation" novalidate>
        {{ csrf_field() }}
        <input type="hidden" value="{{ $data->id }}" name="id">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    Blog Category Details
                </div>
                <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Blog Category Name</label>
                            <input onkeyup="createslug(this.value)" type="text" class="form-control" value="{{ $data->name }}" name="name" id="validationCustom01"
                                placeholder="Title" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label for="validationCustom02">Slug</label>
                            <input type="text" id="slug" value="{{ $data->slug }}" class="form-control" name="slug" onkeyup="checkslug()" 
                                 required >
                                 <small id="slugerror" class="mt-1 text-danger"></small>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Short Description</label>
                            <textarea class="form-control" name="blogshortdescription" id="validationCustom02"
                                placeholder="Put something" required rows="4">{{ $data->shortdescription }}</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    Blog Category Meta Tags
                </div>
                <div class="card-body">
                        <div class="form-group mb-2">
                            <label for="validationCustom03">Meta Title</label>
                            <input type="text" class="form-control" value="{{ $data->name }}" name="metta_tittle" id="meta_title">
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="validationCustom04">Meta Description</label>
                                    <textarea class="form-control" value="{{ $data->name }}" name="metta_description" id="meta_description"
                                        placeholder="Put something" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="validationCustom04">Meta Keywords</label>
                                    <textarea class="form-control" value="{{ $data->name }}" name="metta_keywords" id="meta_keywords"
                                        placeholder="Put something" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
        <div class="col-lg-2">
            <div class="card">
                <div class="card-header">
                    Blog Category Status
                </div>
                <div class="card-body">
                        <div class="form-group mb-2">
                        <input type="radio" @if($data->visible_status == 'Published') checked @endif value="Published" name="visible_status" id="active">
                        <label for="active">Published</label>
                        </div>
                        <div class="form-group mb-2">
                            <input @if($data->visible_status == 'Un Published') checked @endif type="radio" value="Un Published" name="visible_status" id="delete">
                            <label for="delete">Not Published</label>
                        </div>
                </div> <!-- end card-body-->
            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <button id="submitbutton" type="submit" class="btn btn-primary form-control">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
</div> <!-- container -->
@endsection