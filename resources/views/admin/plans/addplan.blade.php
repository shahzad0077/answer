@extends('layouts.admin-app')
@section('title','Add Plans')
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
                        <li class="breadcrumb-item"><a href="{{url('admin/blogs')}}">Plans</a></li>
                        <li class="breadcrumb-item active">Add Plans</li>
                    </ol>
                </div>
                <h4 class="page-title">Add Subscription Plans</h4>
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
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <form enctype="multipart/form-data" class="needs-validation" method="POST" action="{{ url('createnewplan') }}">
                        {{ csrf_field() }}
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Title</label>
                            <input type="text" class="form-control" name="title" id="validationCustom01"
                                placeholder="Title" required >
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom05">No of users</label>
                            <input type="text" class="form-control" name="noofusers" id="validationCustom05"
                                placeholder="" required >
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom02">Price</label>
                            <input type="text" class="form-control" name="price" id="validationCustom02"
                                placeholder="" required >
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom02">Space</label>
                            <input type="number" class="form-control" name="space" id="validationCustom02"
                                placeholder="" required >
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom04">Valid for Days</label>
                            <input type="number" class="form-control" name="valadity" id="validationCustom04"
                                placeholder="" required >
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Feature One</label>
                            <textarea name="lineone" class="form-control"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Feature Two</label>
                            <textarea name="linetwo" class="form-control"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Feature Three</label>
                            <textarea name="linethree" class="form-control"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Feature Four</label>
                            <textarea name="linefour" class="form-control"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Feature Five</label>
                            <textarea name="linefive" class="form-control"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Feature Six</label>
                            <textarea name="linesix" class="form-control"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Feature Seven</label>
                            <textarea name="lineseven" class="form-control"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Feature Eight</label>
                            <textarea name="lineeieght" class="form-control"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Feature Nine</label>
                            <textarea name="linenine" class="form-control"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Feature Ten</label>
                            <textarea name="lineten" class="form-control"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="validationCustom04">Icon </label>
                            <input type="file" class="form-control" name="image" id="validationCustom04">
                            <div class="invalid-feedback">
                                Please attach image file.
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit Now</button>
                    </form>   

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

    </div>
    <!-- end row -->
</div> <!-- container -->
@endsection