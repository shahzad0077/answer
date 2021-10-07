@extends('layouts.admin-app')
@section('title','Sitemap')
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
                        <li class="breadcrumb-item active">Sitemap</li>
                    </ol>
                </div>
                <h4 class="page-title">Sitemap</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    @include('admin.alert')


    @if(DB::table('blogs')->where('visible_status' , 'Published')->where('delete_status' , 'Active')->where('sitemap_done' , 0)->count() >  200)

    <div class="alert alert-danger">
        Some Url are Missing in Site Map Please Genrate Site Map of Blogs
    </div>

    @endif

    @if(session()->has('sitemapalert'))

    <div class="alert alert-danger">
        {{ session()->get('sitemapalert') }}
    </div>

    @endif

    

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form method="POST" action="{{ url('genratesitemap') }}">
                {{ csrf_field() }}
                <div class="card-body">

                    <div class="row mb-2">
                        <div class="col-md-12">
                            <b>Note:</b> You should select the module to generate the new sitemap
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-2">
                                    <label for="validationCustom01">Select Module</label>
                                    <select required="" name="sitemap" class="form-control">
                                        <option value="">Select Options</option>
                                        <option  value="singleblog">Blog Posts</option>
                                        <option  value="answerquestions">Answer & Questions</option>
                                        <option value="posts-tags">Post Tags</option>
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button  class="btn btn-primary" type="submit">Generate Sitemap</button>
                                </div>
                            </div>
                            
                        </div>
                        
                </div> <!-- end card-body-->
                </form>
            </div>
        </div> <!-- end col-->

    </div>
    <!-- end row -->
</div> <!-- container -->
@endsection