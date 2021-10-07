@extends('layouts.admin-app')
@section('title','Edit Blog Coment')
@section('content-admin')
<!-- Start Content-->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('admin/blogs-coments')}}">Blog Coments</a></li>
                        <li class="breadcrumb-item active">Edit Blog Coment</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Blog Coment</h4>
            </div>
        </div>
    </div>
    @include('admin.alert')

    <div class="row">
        
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    Edit Blog Coment
                </div>
                <form enctype="multipart/form-data" method="POST" action="{{ url('updateblogcoment') }}" class="needs-validation" novalidate>
        {{ csrf_field() }}
                <div class="card-body">
                    <input type="hidden" value="{{ $data->id }}" name="id">
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Comment</label>
                            <textarea class="form-control" name="coment" id="validationCustom02"
                                placeholder="Put something" required rows="4">{{ $data->coment }}</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div> 
                        <div class="form-group mb-2">
                        <input type="radio" @if($data->visible_status == 'Published') checked @endif value="Published" name="visible_status" id="active">
                        <label for="active">Published</label>
                        </div>
                        <div class="form-group mb-2">
                            <input @if($data->visible_status == 'Not Published') checked @endif type="radio" value="Not Published" name="visible_status" id="delete">
                            <label for="delete">Not Published</label>
                        </div>
                        <div class="col-md-12 text-right">
                    <button id="submitbutton" type="submit" class="btn btn-primary ">Save</button>
                </div>
                </div> <!-- end card-body-->
            </form>
            </div> <!-- end card-->
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ url('submitcomentreply') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $data->id }}">


                        <div class="form-group">
                            <label for="validationCustom01">Comment Reply</label>
                            <textarea rows="10" class="form-control" name="reply"></textarea>
                        </div>
                        <div class="col-md-12 text-right">
                    <button id="submitbutton" type="submit" class="btn btn-primary ">Save</button>
                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<div class="card">
    <div class="card-body">
        <table id="basic-datatable" class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Reply</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                 @foreach(DB::table('comentreply')->where('comentid'  ,$data->id)->get() as $c)
                <tr>
                    <td>
                        {{ DB::table('users')->where('id' , $c->userid)->get()->first()->name }}
                    </td>
                    <td>
                        {{ $c->reply }}
                    </td>
                    <td class="table-action text-center">
                        <a data-toggle="modal" data-target="#myModal{{ $c->id }}" class="action-icon" title="Edit Coment"> <i class="mdi mdi-pencil"></i></a>
                        <a onclick="return confirm('Are You Sure You want to Delete This')" href="{{url('admin/deleteblogcomentreply')}}/{{ $c->id }}" class="action-icon" title="Delte Category"> <i class="mdi mdi-delete"></i></a>
                    </td>
                </tr>
                <!-- The Modal -->
                    <div class="modal fade" id="myModal{{ $c->id }}">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                          <!-- Modal Header -->
                          <div class="modal-header">
                            <h4 class="modal-title">Edit Reply</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                          <form  method="POST" action="{{ url('updateblogcomentreply') }}" class="needs-validation" novalidate>
                            {{ csrf_field() }}
                            <input type="hidden" value="{{ $c->id  }}" name="id">
                              <!-- Modal body -->
                              <div class="modal-body">
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" name="reply">{{ $c->reply }}</textarea>
                                </div>
                                
                                <div class="form-group">
                                    <button class="btn btn-primary">Save</button>
                                </div>
                              </div>
                            </form>

                        </div>
                      </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div> <!-- end card body-->
</div> <!-- end card -->

</div> <!-- container -->
@endsection