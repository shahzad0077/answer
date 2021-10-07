@extends('layouts.admin-app')
@section('title','All Site URLS')
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
                        <li class="breadcrumb-item active">Redirect URL</li>
                    </ol>
                </div>
                <h4 class="page-title">All Redirect URL</h4>
            </div>
        </div>
    </div>
    @include('admin.alert')
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-12 text-right">
                    <button data-toggle="modal" data-target="#myModal" class="btn btn-primary">Add Redirect URL</button>
                   
                </div>
            </div>
             <!-- The Modal -->
                    <div class="modal fade" id="myModal">
                      <div class="modal-dialog">
                        <div class="modal-content">

                          <!-- Modal Header -->
                          <div class="modal-header">
                            <h4 class="modal-title">Add Redirect</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>

                          <form method="POST" action="{{ url('addnewredirect') }}">
                            {{ csrf_field() }}
                          <!-- Modal body -->
                          <div class="modal-body">
                                
                                <div class="form-group">
                                                                         
                                    <label>From URL</label>
                                    <textarea required="" class="form-control" name="fromurl"></textarea>
                                </div>
                                <div class="form-group">
                                                                         
                                    <label>To URL</label>
                                    <textarea required="" class="form-control" name="tourl"></textarea>
                                </div>

                          </div>

                          <!-- Modal footer -->
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-success" >Submit</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                          </div>
                          </form>
                        </div>
                      </div>
                    </div>
            <div class="card">
                <div class="card-body">
                    <br>
                    <table id="basic-datatable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>From URL</th>
                                <th>To URL</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $r)
                            <tr>
                                <td>{{ $r->from }}</td>
                                <td>{{ $r->to }}</td>
                                <td>{{ date('d M Y, h:s a ', strtotime($r->created_at)) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->
</div> <!-- container -->
@endsection