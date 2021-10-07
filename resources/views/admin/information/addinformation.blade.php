@extends('layouts.admin-app')
@section('title','Add Video')
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
                        <li class="breadcrumb-item"><a href="{{url('admin/blogs')}}">Explainer Videos</a></li>
                        <li class="breadcrumb-item active">Add Video</li>
                    </ol>
                </div>
                <h4 class="page-title">Module Name : {{ $data->name }}</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
@if(session()->has('message'))
    <div class="alert alert-success alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ session()->get('message') }}
    </div>
@endif
    <div class="row">

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form enctype="multipart/form-data" method="POST" action="{{ url('updatemodule') }}" class="needs-validation" novalidate>
                        <input type="hidden" value="{{ $data->id }}" name="id">
                         {{ csrf_field() }}
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Title</label>
                            <input type="text" value="{{ $data->name }}" class="form-control" name="name" id="validationCustom01"
                                placeholder="Enter the title" required >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom03">Video Link</label>
                            <input type="url" value="{{ $data->video }}" class="form-control" name="video" id="validationCustom03"
                                placeholder="Place complete URL" required >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom03">Instructions</label>
                                <textarea name="description" class="form-control">{{ $data->instructions }}</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom03">Banner Picture / Placeholder</label>
                            <input type="file" class="form-control" name="image">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom03">Icon</label>
                            <input type="file" class="form-control" name="icon">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit Now</button>
                    </form>   

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="form-group mb-3">
                        <img style="width: 100%;" src="{{ url('/images') }}/{{ $data->image }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="form-group mb-3">
                        <img style="width: 100%;" src="{{ url('/images') }}/{{ $data->icon }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</div> <!-- container -->


@endsection