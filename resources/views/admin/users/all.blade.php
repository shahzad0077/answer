
@extends('layouts.admin-app')
@section('title','Users')
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
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
                <h4 class="page-title">Users</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-2 col-2">
                            <select onchange="location = this.value;" class="form-control text-left">
                                <option @if(Cmf::site_settings('datashowlimit') == 10) selected @endif value="{{ url('changenoofrecordsperpage/10') }}">10 Records Per Page</option>
                                <option @if(Cmf::site_settings('datashowlimit') == 20) selected @endif value="{{ url('changenoofrecordsperpage/20') }}">20 Records Per Page</option>
                                <option @if(Cmf::site_settings('datashowlimit') == 30) selected @endif value="{{ url('changenoofrecordsperpage/30') }}">30 Records Per Page</option>
                                <option @if(Cmf::site_settings('datashowlimit') == 50) selected @endif value="{{ url('changenoofrecordsperpage/50') }}">50 Records Per Page</option>
                                <option @if(Cmf::site_settings('datashowlimit') == 100) selected @endif value="{{ url('changenoofrecordsperpage/100') }}">100 Records Per Page</option>
                                <option @if(Cmf::site_settings('datashowlimit') == 200) selected @endif value="{{ url('changenoofrecordsperpage/200') }}">200 Records Per Page</option>
                                <option @if(Cmf::site_settings('datashowlimit') == 300) selected @endif value="{{ url('changenoofrecordsperpage/300') }}">300 Records Per Page</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" onkeyup="searchusername(this.value)" class="form-control" placeholder="Search With Username" name="">
                        </div>
                        <div id="spinnerloader" class="col-md-1 col-2 text-left">
        
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-centered w-100 dt-responsive nowrap" >
                            <thead  class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>User Id</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Expert</th>
                                    <th>Status</th>
                                    <th style="width: 120px;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="table_data">
                            @foreach($data as $r)
                                <tr >
                                    <td>{{ $r->name }}</td>
                                    <td onclick="copyToClipboard({{$r->id}})"><a target="_blank" href="{{url('/admin/user/detail')}}/{{ $r->id }}">{{ $r->username }}</a>
                                        <input type="hidden" value="{{ $r->username }}" id="username{{ $r->id }}" name="">
                                    </td>
                                    <td>{{ $r->email }}</td>
                                    <td>{{ $r->phonenumber }}</td>
                                    <td>@if($r->expert == 'on') Expert @else Simple User @endif</td>
                                    <td>
                                        @if($r->email == 'info@sarcksolution.com')
                                           Super Admin
                                        @else 
                                        <div>
                                            <input type="checkbox" onclick="publish({{$r->id}} ,  {{ $r->active }})" id="switch1{{ $r->id }}" <?php if($r->active == 1){echo 'checked'; } ?> data-switch="success"/>
                                            <label for="switch1{{ $r->id }}" data-on-label="Yes" data-off-label="No" class="mb-0 d-block"></label>
                                        </div>
                                        @endif
                                    </td>
                                    <td class="table-action text-center">
                                        @if($r->email == 'info@sarcksolution.com')
                                            Super Admin
                                        @else    
                                        <a onclick="return confirm('Are You Sure You want this User I you Delete This user then Automaticaly Delete All Records Against This User')" href="{{ url('deleteuser') }}/{{ $r->username }}" class="action-icon" title="Delte User"> <i class="mdi mdi-delete"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            
                        </table>
                        <div id="pagination" class="row">
                            <div class="col-md-12 text-right">
                                {!! $data->links('frontend.pagination') !!}
                            </div>
                        </div>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->  
</div>
<script>
function copyToClipboard(text) {
  /* Get the text field */
  var copyText = $("#username"+text).val();
  /* Select the text field */
  copyText.select();

  /* Copy the text inside the text field */
  document.execCommand("copy");

  /* Alert the copied text */
  alert("Copied the text: " + copyText.value);
}



function searchusername(value)
{
    if(value == '')
    {

    }else{
        $('#spinnerloader').html('<i style="font-size: 24px;color: red;" class="mdi mdi-spin mdi-loading"></i>');
        $.ajax({
          type: "GET",
          url: "{{ url('searchusername') }}/"+value,
          success: function(resp) {
            $('#table_data').html(resp);
            $('#pagination').hide();
            $('#spinnerloader').html('');
          }
        });
    }
}
</script>
<div class="modal fade" id="deletelikedislike" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
              <div class="row mb-1 mt-2">
                <div class="col-md-12 text-center">
                  <h1><span class="simple-icon-trash text-danger"></span></h1>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-md-12 text-center">
                  <h3>Are you Sure you want to Delete This User</h3>
                  <p>
                          If you Delete This User All Data Will be Deleted Automaticaly Against This user</p>

                </div>
              </div>
              <div class="row mb-2">
                <div class="col-md-6 text-center">
                 <a href="https://www.w3schools.com" id="deletehref"> <button class="btn btn-danger btn-block mr-2">Confirm</button></a>
                </div>
                <div class="col-md-6">
                  <button class="btn btn-primary btn-block mr-2" class="close" data-dismiss="modal" aria-label="Close">Cancle</button>
                </div>
              </div>
            </div>
        </div>
    </div>
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
@endsection