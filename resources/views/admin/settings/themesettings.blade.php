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
            <li class="nav-item ">
                <a class="nav-link" href="{{ url('admin/payement-gatewaysettings') }}">Payment Gateway</a>
            </li>
            <li class="nav-item activetab">
                <a class="nav-link" href="{{ url('admin/theme-settings') }}">Theme Color Change</a>
            </li>
        </ul>
    </div>
    <!-- end row-->
    <br><br><br>
     <div class="row">
            <div class="col-xl-9 col-lg-8 col-md-8">
                               <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Theme Color Change</h4>
                    </div>

                    <div class="card-body">

                        <form accept-charset="utf-8" id="admin_settings" action="{{ url('updatethemesettings') }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- checkbox -->
                                        <div class="form-group">
                                            <label><input type="radio" @if(Cmf::site_settings('theme_color') == 'light-green') checked @endif name="color" value="light-green" >
                                                <span >Light Green</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- checkbox -->
                                        <div class="form-group">
                                            <label><input type="radio" @if(Cmf::site_settings('theme_color') == 'dark-green') checked @endif name="color" value="dark-green" >
                                                <span >Dark Green</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- checkbox -->
                                        <div class="form-group">
                                            <label><input type="radio" @if(Cmf::site_settings('theme_color') == 'light-orange') checked @endif name="color" value="light-orange" >
                                                <span >Light Orange</span>
                                            </label>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6">
                                        <!-- checkbox -->
                                        <div class="form-group">
                                            <label><input type="radio" @if(Cmf::site_settings('theme_color') == 'dark-orange') checked @endif name="color" value="dark-orange" >
                                                <span >Dark Orange</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- checkbox -->
                                        <div class="form-group">
                                            <label><input type="radio" @if(Cmf::site_settings('theme_color') == 'light-blue') checked @endif name="color" value="light-blue" >
                                                <span >Light Blue</span>
                                            </label>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6">
                                        <!-- checkbox -->
                                        <div class="form-group">
                                            <label><input type="radio" @if(Cmf::site_settings('theme_color') == 'dark-blue') checked @endif name="color" value="dark-blue" >
                                                <span >Dark Blue</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- checkbox -->
                                        <div class="form-group">
                                            <label><input type="radio" @if(Cmf::site_settings('theme_color') == 'light-purple') checked @endif name="color" value="light-purple" >
                                                <span >Light Purple</span>
                                            </label>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6">
                                        <!-- checkbox -->
                                        <div class="form-group">
                                            <label><input type="radio" @if(Cmf::site_settings('theme_color') == 'dark-purple') checked @endif name="color" value="dark-purple" >
                                                <span >Dark Purple</span>
                                            </label>
                                        </div>
                                    </div> 
                                     <div class="col-sm-6">
                                        <!-- checkbox -->
                                        <div class="form-group">
                                            <label><input type="radio" @if(Cmf::site_settings('theme_color') == 'light-red') checked @endif name="color" value="light-red" >
                                                <span >Light Red</span>
                                            </label>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6">
                                        <!-- checkbox -->
                                        <div class="form-group">
                                            <label><input type="radio" @if(Cmf::site_settings('theme_color') == 'dark-red') checked @endif name="color" value="dark-red" >
                                                <span >Dark Red</span>
                                            </label>
                                        </div>
                                    </div> 
                                </div> 


                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-outline-primary" id="submitForm">Color Change</button>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
</div>
@endsection