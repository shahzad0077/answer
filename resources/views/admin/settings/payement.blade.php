@extends('layouts.admin-app')
@section('title','Settings')
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
                        <li class="breadcrumb-item active">Payment Gateway Settings</li>
                    </ol>
                </div>
                <h4 class="page-title">Payment Gateway Settings</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 

    <div class="row">
        <ul class="nav nav-tabs menu-tabs">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('admin/settings') }}">General Settings</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="{{ url('admin/email-settings') }}">Email Settings</a>
            </li>
            <li class="nav-item activetab">
                <a class="nav-link" href="{{ url('admin/payement-gatewaysettings') }}">Payment Gateway</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('admin/theme-settings') }}">Theme Color Change</a>
            </li>
        </ul>
    </div>
    <!-- end row-->
    <br><br><br>
     <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form id="form_emailsetting" action="{{ url('updatepayementsettings') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <h4 class="text-primary">Stripe</h4>
                            <div class="form-group">
                                <label>Published Key</label>
                                <input type="text" id="api_key" name="publishable_key" value="{!! Cmf::site_settings('publishable_key') !!}" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Secret Key</label>
                                <input type="text" id="value" name="secret_key" value="{!! Cmf::site_settings('secret_key') !!}" required class="form-control">
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
<!--             <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="post">
                            {{ csrf_field() }}
                            <h4 class="text-primary">Stripe</h4>
                            <div class="form-group">
                                <label>Payepal App ID</label>
                                <input type="text" id="api_key" name="api_key" value="{!! Cmf::site_settings('publishable_key') !!}" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Secret Key</label>
                                <input type="text" id="value" name="value" value="{!! Cmf::site_settings('secret_key') !!}" required class="form-control">
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> -->
        </div>
</div>
@endsection