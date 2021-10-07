@extends('layouts.admin-app')
@section('title','CMS-Frequestly Asked Question')
@section('content-admin')
<!-- Start Content-->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">CMS</li>
                        <li class="breadcrumb-item active">Frequestly Asked Question</li>
                    </ol>
                </div>
                <h4 class="page-title">Frequestly Asked Question</h4>
            </div>
        </div>
    </div>
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
                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Question</th>
                                <th>View Answer</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($data as $r)
                            <tr>
                                <td>{{ $r->question }}</td>
                                <td><button data-toggle="modal" data-target="#editmodel{{ $r->id }}" class="btn btn-primary">View Answer</button>
                                   <div id="editmodel{{ $r->id }}" class="modal fade" role="dialog">
                                      <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h4 class="modal-title">{{ $r->question  }}</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>
                                          <div class="modal-body">
                                                <form enctype="multipart/form-data" method="POST" action="{{ url('updatefaq') }}" class="needs-validation" novalidate>
                                                    {{ csrf_field() }}
                                                    <input type="hidden" value="{{ $r->id }}" name="id">
                                                    <div class="form-group mb-3">
                                                        <label for="validationCustom01">Question</label>
                                                        <input value="{{ $r->question }}" type="text" class="form-control" name="question" id="validationCustom01"
                                                            placeholder="What is Pet Protect???" required >
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="validationCustom01">Answer</label>
                                                        <textarea class="form-control" name="answer" id="validationCustom02"
                                                            placeholder="Put something" required rows="15">{{ $r->answer }}</textarea>
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary" type="submit">Submit Now</button>
                                                </form>
                                          </div>
                                        </div>

                                      </div>
                                    </div>
                                </td>
                                <td class="table-action text-center">
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#editmodel{{ $r->id }}" class="action-icon" title="Edit Category"> 
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <a onclick="return confirm('Are You Sure You want to Delete This')" href="{{ url('deletefaq') }}/{{ $r->id }}" class="action-icon" title="Delte Category"> <i class="mdi mdi-delete"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <form enctype="multipart/form-data" method="POST" action="{{ url('createfaq') }}" class="needs-validation" novalidate>
                        {{ csrf_field() }}
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Question</label>
                            <input type="text" class="form-control" name="question" id="validationCustom01"
                                placeholder="What is Pet Protect???" required >
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Answer</label>
                            <textarea class="form-control" name="answer" id="validationCustom02"
                                placeholder="Put something" required rows="15"></textarea>
                            <div class="valid-feedback">
                                Looks good!
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
<div class="modal fade" id="updatemodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="comment" method="POST" action="{{ url('updatecmshomepage') }}">
                    {{ csrf_field() }}
                    <div id="formdata">
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection