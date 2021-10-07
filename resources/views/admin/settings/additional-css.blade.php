@extends('layouts.admin-app')
@section('title','Additional CSS')
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
                        <li class="breadcrumb-item"><a href="{{url('admin/pages')}}">Pages</a></li>
                        <li class="breadcrumb-item active">Additional CSS</li>
                    </ol>
                </div>
                <h4 class="page-title">Additional CSS</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    @include('admin.alert')


    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <form enctype="multipart/form-data" method="POST" action="{{ url('saveadditionalcss') }}" class="needs-validation" novalidate>
                        {{ csrf_field() }}
                        <div class="row">
                            
                            <div class="col-md-12">
                                <div class="form-group mb-2">
                                    <label for="validationCustom04">Put your CSS</label>
                                    <textarea name="aditional_css" class="form-control" rows="20">{!! Cmf::site_settings('aditional_css') !!}</textarea>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Save Now</button>
                    </form>   

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

    </div>
    <!-- end row -->
</div> <!-- container -->
@endsection