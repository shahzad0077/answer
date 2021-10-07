@extends('layouts.admin-app')
@section('title','Explainer Video')
@section('content-admin')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Modules</li>
                    </ol>
                </div>
                <h4 class="page-title">Modules</h4>
                
            </div>
        </div>
    </div>
<!-- 
    <div class="row">
        <div class="col-md-12 text-right">
            <a href="{{url('/admin/add-information')}}" class="btn btn-primary">Add Information</a> <br><br>
        </div>
    </div> -->

    <!-- end page title -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th class="w-30">Module Name</th>
                                <th>Explainer Video</th>
                                <th>Dummy Pictures</th>
                                <th>Published</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $r)
                            <tr>
                                <td>{{ $r->name }}</td>
                                <td>@if(!empty($r->video)) Available @else Not Added @endif</td>
                                <td>@if(!empty($r->image)) Available @else Not Added @endif</td>
                                <td>
                                    <div>
                                        <input onclick="publish({{$r->id}} ,  {{ $r->published }})" type="checkbox" id="switch{{ $r->id }}" <?php if($r->published == 1){echo 'checked'; } ?> data-switch="success"/>
                                        <label for="switch{{ $r->id }}" data-on-label="Yes" data-off-label="No" class="mb-0 d-block"></label>
                                    </div>
                                </td>
                                <td class="table-action text-center">
                                    <a href="{{ url('admin/editmodule') }}/{{ $r->id }}" class="action-icon" title="Edit Video"> 
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
</div>
<script type="text/javascript">
  function publish(one,two)
  {
    $.ajax({
      type: "GET",
      url: "{{ url('changetopublish') }}/"+one+'/'+two,
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
@endsection