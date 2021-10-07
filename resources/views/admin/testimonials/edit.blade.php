@extends('layouts.admin-app')
@section('title','Edit Testimonial')
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
                        <li class="breadcrumb-item active"><a href="{{url('admin/alltestimonials')}}">Testimonials</a></li>
                        <li class="breadcrumb-item active">Edit Testimonial</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Testimonial</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    @include('admin.alert')
<form enctype="multipart/form-data" method="POST" action="{{ url('updatetestimonials') }}" class="needs-validation" novalidate>
        {{ csrf_field() }}
        <input type="hidden" value="{{ $data->id }}" name="id">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    Testimonilas Details
                </div>
                <div class="card-body">
                        <div class="form-group">
                          <label>Update Client Name</label>
                          <input required="" class="form-control" type="text" value="{{$data->name}}" name="name">
                      </div>
                      <div class="form-group">
                          <label>Update Testimonial</label>
                          <textarea required="" class="form-control" rows="8" name="testimonial">{{$data->testimonial}}</textarea>
                      </div>
                      <div class="form-group">
                          <label>Change Image</label>
                          <input class="form-control" type="file" style="height: 45px;" name="image">
                      </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
        <div class="col-lg-2">
            <div class="card">
                <div class="card-header">
                    Testimonilas Status
                </div>
                <div class="card-body">
                        <div class="form-group mb-2">
                        <input type="radio" @if($data->status == 'Published') checked @endif value="Published" name="status" id="active">
                        <label for="active">Published</label>
                        </div>
                        <div class="form-group mb-2">
                            <input @if($data->status == 'Not Published') checked @endif type="radio" value="Not Published" name="status" id="delete">
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
    <!-- end row -->
</div> <!-- container -->
@endsection