@extends('layouts.admin-app')
@section('title','Add New Testimonials')
@section('content-admin')
<div id="content-wrapper">

      <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add New Testimonital</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Add New Testimonital</h4>
                    
                </div>
            </div>
        </div>
        <h4 style="margin-left:13px;"></h4>
        @if(session()->has('message'))
            <div class="alert alert-success alert-dismissible">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="row">
          <div class="col-md-12">
              <div class="card">
                  <div class="card-header card-success">
                      Add New Testimonial
                  </div>
                  <div class="card-body">
                    <form method="post" action="{{ url('createtestimonial') }}" enctype="multipart/form-data">
                       {{ csrf_field() }}
                       <div class="form-group">
                          <label>Chose Image</label>
                          <input required="" class="form-control" type="file" name="image" style="height: 45px;">
                      </div>
                      <div class="form-group">
                          <label>Enter Client Name</label>
                          <input required="" class="form-control" type="text" name="name">
                      </div>
                      <div class="form-group">
                          <label>Rattings</label>
                          <input required="" class="form-control" type="number" name="rattings">
                      </div>
                      <div class="form-group">
                          <label>Enter Client Designation</label>
                          <input required="" class="form-control" type="text" name="subline">
                      </div>
                      <div class="form-group">
                          <label>Enter Testimonial</label>
                          <textarea required="" class="form-control" name="testimonials"></textarea>
                      </div>
                      <div style="text-align: right;" class="form-group">
                          <input type="submit" class="btn btn-primary" value="Add New Testimonial" name="">
                      </div>
                    </form>
                  </div>
              </div>
          </div>
        </div>
        

      </div>
      <!-- /.container-fluid -->

    </div>
    <!-- /.content-wrapper -->
    @endsection