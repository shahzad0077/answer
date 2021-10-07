@extends('layouts.admin-app')
@section('title','Edit Plan')
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
                        <li class="breadcrumb-item active">Edit Plans</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ $data->tittle }}</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <form enctype="multipart/form-data" class="needs-validation" method="POST" action="{{ url('updateplan') }}">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{ $data->id }}" name="id">
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Title</label>
                            <input type="text" class="form-control" value="{{ $data->tittle }}" name="title" id="validationCustom01"
                                placeholder="Title" required >
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom05">No of Users</label>
                            <input type="text" class="form-control" value="{{ $data->noofusers }}" name="noofusers" id="validationCustom05"
                                placeholder="" required >
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom02">Price</label>
                            <input type="text" class="form-control" value="{{ $data->price }}" name="price" id="validationCustom02"
                                placeholder="" required >
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom04">Valid for Days</label>
                            <input type="number" value="{{ $data->validity }}" class="form-control" name="valadity" id="validationCustom04"
                                placeholder="" required >
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom02">Space</label>
                            <input type="number" value="{{ $data->space }}" class="form-control" name="space" id="validationCustom02"
                                placeholder="" required >
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Line One</label>
                            <textarea name="lineone" class="form-control">{{ $data->lineone }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Line Two</label>
                            <textarea name="linetwo" class="form-control">{{ $data->linetwo }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Line Three</label>
                            <textarea name="linethree" class="form-control">{{ $data->linethree }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Line Four</label>
                            <textarea name="linefour" class="form-control">{{ $data->linefour }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Line Five</label>
                            <textarea name="linefive" class="form-control">{{ $data->linefive }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Line Six</label>
                            <textarea name="linesix" class="form-control">{{ $data->linesix }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Line Seven</label>
                            <textarea name="lineseven" class="form-control">{{ $data->lineseven }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Line Eight</label>
                            <textarea name="lineeieght" class="form-control">{{ $data->lineeieght }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Line Nine</label>
                            <textarea name="linenine" class="form-control">{{ $data->linenine }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Line Ten</label>
                            <textarea name="lineten" class="form-control">{{ $data->lineten }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom04">Icon </label>
                            <input type="file" class="form-control" name="image" id="validationCustom04">
                            <div class="invalid-feedback">
                                Please attach image file.
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Update Plan</button>
                    </form> 
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

    </div>
    <!-- end row -->
</div> <!-- container -->
@endsection