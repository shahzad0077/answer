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
                        <li class="breadcrumb-item active">Genral Settings</li>
                    </ol>
                </div>
                <h4 class="page-title">Genral Settings</h4>
            </div>
        </div>
    </div>     
    <!-- end row-->
    <br><br><br>
    @include('admin.alert')
     <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-4 settings-tab">
                <div style="border-radius: 10px;" class="card">
                    <div class="card-body">
                        <div  class="nav flex-column">
                            <a class="nav-link active" data-toggle="tab"href="#general">General</a>
                            <a class="nav-link mb-0" data-toggle="tab" href="#socialmedia">Social Media Links</a>
                            <a class="nav-link mb-0" data-toggle="tab" href="#seo">SEO</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 col-md-8">

                <div class="card">
                    <div class="card-body p-0">
                        <form accept-charset="utf-8" id="admin_settings" action="{{ url('updategenralsettings') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="tab-content pt-0">
                                <div id="general" class="tab-pane active">
                                    <div class="card mb-0">
                                        <div class="card-header">
                                            <h4 class="card-title">General Settings</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" required="" class="form-control" id="email_address" name="email_address" placeholder="Pets Store" value="{!! Cmf::site_settings('email_address') !!}">
                                            </div>
                                            <div class="form-group">
                                                <label>Phone Number</label>
                                                <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="{!! Cmf::site_settings('mobile_number') !!}" required="">
                                            </div><br>
                                            <div class="form-group">
                                                <label>Footer Text</label>
                                                <textarea name="footer_text" class="form-control">{!! Cmf::site_settings('footer_text') !!}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>No Of Records Show Per Page</label>
                                                <input type="number" required="" class="form-control" id="frontenddatashowlimit" name="frontenddatashowlimit" placeholder="Pets Store" value="{!! Cmf::site_settings('frontenddatashowlimit') !!}">
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div id="socialmedia" class="tab-pane">
                                    <div class="card mb-0">
                                        <div class="card-header">
                                            <h4 class="card-title">Social Media Links</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                  <input value="{!! Cmf::site_settings('facebook_link') !!}" type="text" class="form-control" placeholder="Enter Facebook Link" name="facebook_link" >
                                            </div>
                                            <div class="form-group">
                                                  <input value="{!! Cmf::site_settings('twitter_link') !!}" type="text" class="form-control" placeholder="Enter twitter Link" name="twitter_link">
                                            </div>
                                            <div class="form-group">
                                                  <input value="{!! Cmf::site_settings('instagram_link') !!}" type="text" class="form-control" placeholder="Enter instagram Link" name="instagram_link" >
                                            </div>
                                            <div class="form-group">
                                                  <input value="{!! Cmf::site_settings('linkdlin_link') !!}" type="text" class="form-control" placeholder="Enter linkdlin Link" name="linkdlin_link">
                                            </div>
                                            <div class="form-group">
                                                  <input value="{!! Cmf::site_settings('pintrest_link') !!}" type="text" class="form-control" placeholder="Enter Pintrest Link" name="pintrest_link">
                                            </div>
                                            <div class="form-group">
                                                  <input value="{!! Cmf::site_settings('youtube_link') !!}" type="text" class="form-control" placeholder="Enter Pintrest Link" name="youtube_link">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="seo" class="tab-pane">
                                    <div class="card mb-0">
                                        <div class="card-header">
                                            <h4 class="card-title">SEO</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="meta_title">Meta Title</label>
                                                    <input type="text" class="form-control" name="meta_title" id="meta_title" value="{{ Cmf::site_settings('meta_title') }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="meta_description">Meta Description</label>
                                                    <textarea rows="5" class="form-control" name="meta_description" id="meta_description">{{ Cmf::site_settings('meta_keywords') }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="meta_keywords">Meta Keywords</label>
                                                    <textarea class="form-control" name="meta_keywords" id="meta_keywords">{{ Cmf::site_settings('meta_description') }}</textarea>
                                                </div>
                                                <div class="clearlist">&nbsp;</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <button name="form_submit" type="submit" class="btn btn-primary" value="true">Save Changes</button>
                                </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection