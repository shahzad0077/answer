@extends('layouts.admin-app')
@section('title','User Roles')
@section('content-admin')
<div class="container-fluid">
    <!-- start page title -->
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">User Roles</li>
                    </ol>
                </div>
                <h4 class="page-title">User Roles</h4>
            </div>
        </div>
    </div> 
    @include('admin.alert')   
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#edit-user" class="btn btn-danger mb-2"><i class="mdi mdi-plus-circle mr-2"></i> Add New User</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="basic-datatable" class="table" >
                            <thead  class="thead-light">
                                <tr>
                                    <th>Profile Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th style="width: 85px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(DB::table('users')->where('is_admin' , 1)->get() as $r)
                                <tr>
                                    <td class="w-30">
                                        <img src="{{ $r->profileimage }}" width="30xp" alt="table-user" class="mr-2 img rounded-circle" />
                                    </td>
                                    <td>{{ $r->name }}</td>
                                    <td>{{ $r->email }}</td>
                                    <td>{{ date('d M Y, h:s a ', strtotime($r->created_at)) }}</td>
                                    <td>
                                        {{ DB::table('userroles')->where('id' , $r->userroleid)->get()->first()->name  }}
                                    </td>
                                    <td>
                                        <div>
                                            <input type="checkbox" onclick="publish({{$r->id}} ,  {{ $r->active }})" id="switch1{{ $r->id }}" <?php if($r->active == 1){echo 'checked'; } ?> data-switch="success"/>
                                            <label for="switch1{{ $r->id }}" data-on-label="Yes" data-off-label="No" class="mb-0 d-block"></label>
                                        </div>
                                    </td>
                                    <td class="table-action text-center">  
                                        <a data-toggle="modal" data-target="#edit-user-role{{ $r->id }}" href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                    </td>
                                </tr>
                                <div class="modal fade" id="edit-user-role{{ $r->id }}" tabindex="-1" role="dialog" aria-labelledby="edit-modalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="edit-modalLabel">User Role</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <form enctype="multipart/form-data" method="POST" action="{{ url('updateadminuser') }}" class="needs-validation" novalidate>
                                                            {{ csrf_field() }}
                                                            <input type="hidden" value="{{ $r->id }}" name="id">
                                          <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group mb-2">
                                                        <label for="validationCustom01">Full Name</label>
                                                        <input type="text" class="form-control" value="{{ $r->name }}" name="name" id="validationCustom01"
                                                             required >
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <label for="validationCustom01">Email</label>
                                                        <input readonly="" type="text" value="{{ $r->email }}" class="form-control" name="email" id="validationCustom01"
                                                             required >
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <label for="validationCustom01">Phone Number</label>
                                                        <input type="text" class="form-control" name="phonenumber" id="validationCustom01"
                                                             required >
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                    </div>

                                                    <div class="form-group mb-2">
                                                        <label for="validationCustom01">User Role</label>
                                                        <select name="userroleid" class="form-control">
                                                            <option value="">Select Role</option>
                                                            @foreach(DB::table('userroles')->get() as $u)
                                                            <option @if($r->userroleid == $u->id) selected @endif value="{{ $u->id }}">{{ $u->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="valid-feedback">
                                                            Looks good!
                                                        </div>
                                                    </div>              
                                                </div>
                                            </div>
                                          </div>
                                          <div class="modal-footer">
                                            <a type="button" class="btn btn-secondary" data-dismiss="modal">Close</a>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                          </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->  
</div>
<script type="text/javascript">
    function deleteusers(id)
    {
        var url = '{{ url("deleteuser") }}/'+id;
        $("#deletehref").attr("href", url);
        $('#deletelikedislike').modal('show');
    }
    function publish(one,two)
    {
        $.ajax({
          type: "GET",
          url: "{{ url('changetopublishuser') }}/"+one+'/'+two,
          success: function(resp) {
             if(resp == 'error'){
              location.reload();
             }else{
              location.reload();
             } 
          }
        });
    }
</script>
<!-- Modal -->
<div class="modal fade" id="edit-user" tabindex="-1" role="dialog" aria-labelledby="edit-modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit-modalLabel">User Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form enctype="multipart/form-data" method="POST" action="{{ url('createadminuser') }}" class="needs-validation" novalidate>
                        {{ csrf_field() }}
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group mb-2">
                    <label for="validationCustom01">Full Name</label>
                    <input type="text" class="form-control" name="name" id="validationCustom01"
                         required >
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="validationCustom01">Email</label>
                    <input type="text" class="form-control" name="email" id="validationCustom01"
                         required >
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="validationCustom01">Phone Number</label>
                    <input type="text" class="form-control" name="phonenumber" id="validationCustom01"
                         required >
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label for="validationCustom01">User Role</label>
                    <select name="userroleid" class="form-control">
                        <option value="">Select Role</option>
                        @foreach(DB::table('userroles')->get() as $r)
                        <option value="{{ $r->id }}">{{ $r->name }}</option>
                        @endforeach
                    </select>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label for="validationCustom01">Password</label>
                    <input type="password" class="form-control" name="password" id="validationCustom01"
                         required >
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>               
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <a type="button" class="btn btn-secondary" data-dismiss="modal">Close</a>
        <button type="submit" class="btn btn-primary">Add New User</button>
      </div>
  </form>
    </div>
  </div>
</div>

@endsection