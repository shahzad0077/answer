@extends('layouts.admin-app')
@section('title','Edit Category')
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
                        <li class="breadcrumb-item"><a href="{{url('categories')}}">Categories</a></li>
                        <li class="breadcrumb-item active">Edit Category</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Category : {{ $data->name }}</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    @include('admin.alert')
<form enctype="multipart/form-data" method="POST" action="{{ url('updatecategory') }}" class="needs-validation" novalidate>
        {{ csrf_field() }}
        <input type="hidden" value="{{ $data->id }}" name="id">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    Subject Details
                </div>
                <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Category Name</label>
                            <input onkeyup="createslug(this.value)" type="text" class="form-control" value="{{ $data->name }}" name="name" id="validationCustom01"
                                placeholder="Title" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label for="validationCustom02">Slug</label>
                            <input type="text" id="slug" value="{{ $data->url }}" class="form-control" name="slug" onkeyup="checkslug()" 
                                 required >
                                 <small id="slugerror" class="mt-1 text-danger"></small>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Category Background Color</label>
                            <input type="text" class="form-control" value="{{ $data->backgroundcolor }}" name="color" id="validationCustom01"
                                placeholder="Title" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Category Text Color</label>
                            <input type="text" class="form-control" value="{{ $data->text_color }}" name="text_color" id="validationCustom01"
                                placeholder="Title" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom03">Icon / Image</label>
                            <input type="file" class="form-control" name="icon" id="validationCustom09">
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
                    Subject Meta Tags
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
                         <div class="form-group mb-2">
                            <input type="radio" @if($data->status == 'Active') checked @endif value="Active" name="status" id="active">
                            <label for="active">Published</label>
                            </div>
                            <div class="form-group mb-2">
                                <input @if($data->status == 'delete') checked @endif type="radio" value="delete" name="status" id="delete">
                                <label for="delete">Not Published</label>
                            </div>
                            <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="order">Category Order</label>
                                    <input value="{{ $data->order }}" class="form-control" id="order"  type="number"  name="order">
                                </div>
                            </div>
                        </div>
                </div> <!-- end card-body-->
            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <button id="submitbutton" type="submit" class="btn btn-primary form-control">Save</button>
                </div>
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
</form>
    <!-- end row -->
</div> <!-- container -->
@endsection