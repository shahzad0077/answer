@extends('layouts.admin-app')
@section('title','CMS-Real Stories')
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
                        <li class="breadcrumb-item active">Real Stories</li>
                    </ol>
                </div>
                <h4 class="page-title">Real Stories</h4>
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
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th class="w-30">Image / Icon</th>
                                <th>Name</th>
                                <th>Subtittle</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($data as $r)
                            <tr>
                                <td class="w-30">
                                    <img src="{{asset('/images/')}}/{{ $r->image }}" width="30xp" alt="table-user" class="mr-2 img thumbnail" />
                                </td>
                                <td>{{ $r->name }}</td>
                                <td>{{ $r->subtittle }}</td>
                                <td class="table-action text-center">
                                    <a href="javascript:void(0)" onclick="editfunction({{ $r->id }})" class="action-icon" title="Edit Category"> 
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <a onclick="return confirm('Are You Sure You want to Delete This')" href="{{ url('deleterealstories') }}/{{ $r->id }}" class="action-icon" title="Delte Category"> <i class="mdi mdi-delete"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <form enctype="multipart/form-data" method="POST" action="{{ url('createrealstories') }}" class="needs-validation" novalidate>
                        {{ csrf_field() }}
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Name</label>
                            <input type="text" class="form-control" name="name" id="validationCustom01"
                                placeholder="Name" required >
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Subtittle</label>
                            <input type="text" class="form-control" name="subtittle" id="validationCustom01"
                                placeholder="Subtittle" required >
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Rattings</label>
                            <input type="number" min="0" max="5" class="form-control" name="rattings" id="validationCustom01"
                                placeholder="Min 0 and Max 5" required >
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Description</label>
                            <textarea class="form-control" name="description" id="validationCustom02"
                                placeholder="Put something" required rows="4"></textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom03">Image</label>
                            <input style="height: 44px;" type="file" class="form-control" name="image" id="validationCustom09"
                                 required>
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
                <form id="comment" method="POST" action="{{ url('updaterealstories') }}">
                    {{ csrf_field() }}
                    <div id="formdata">
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function editfunction(id)
    {
        $.ajax({
            type: "GET",
            url: "{{ url('getrealstories') }}/"+id,
            success: function(resp) {
                $('#formdata').html(resp);

                $('#updatemodel').modal('show');
            }
        });
    }
</script>
@endsection