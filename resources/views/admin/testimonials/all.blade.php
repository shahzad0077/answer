@extends('layouts.admin-app')
@section('title','All Testimonials')
@section('content-admin') 
<!-- /.content-wrapper -->
<div class="container-fluid">
    <!-- start page title -->
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">All Testimonials</li>
                    </ol>
                </div>
                <h4 class="page-title">All Testimonials</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 
    <!-- end page title -->
    <div class="row">
        <div class="col-8">
            <div class="card">
            <div class="card-header card-success">
                All Testimonials
            </div>
            <div class="card-body">
                <table id="basic-datatable" class="table table-bordered">
                  <thead>
                    <tr>
                       <th>Image</th>
                       <th>Name</th>
                       <th>Visible Status</th>
                       <th>Action</th>
                    </tr>
                    </thead>
                  <tbody>
                    <?php foreach(DB::table('testimonials')->get() as $r){ ?>
                    <tr>
                        <td class="w-30">
                            <img src="{{asset('/images/')}}/{{ $r->image }}" width="30xp" alt="table-user" class="mr-2 img thumbnail" />
                        </td>
                        <td>{{$r->name}}</td>.
                        <td>{{$r->status}}</td>
                        <td style="text-align: center;">
                          <a href="{{url('admin/edittestimonial')}}/{{ $r->id }}" class="action-icon" title="Edit Category"> 
                                    <i class="mdi mdi-pencil"></i>
                          </a>
                          <a onclick="return confirm('Are You Sure You want to Delete This')" href="{{ url('deletetestimonial') }}/{{ $r->id }}" class="action-icon" title="Delte Category"> <i class="mdi mdi-delete"></i></a>
                        </td>
                    </tr>
                    <?php }  ?>
                  </tbody>
                </table>
            </div>
          </div>
           <!-- end card-->
        </div>
        <div class="col-4">
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
                          <label>Enter Testimonial</label>
                          <textarea required="" class="form-control" name="testimonials"></textarea>
                      </div>
                      <div style="text-align: right;" class="form-group">
                          <input type="submit" class="btn btn-primary" value="Add New Testimonial" name="">
                      </div>
                    </form>
                  </div>
              </div>
           <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->  
</div>
@endsection