@extends('layouts.admin-app')
@section('title','File Upload')
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
                        <li class="breadcrumb-item active">File Upload</li>
                    </ol>
                </div>
                <h4 class="page-title">File Upload</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    @if(session()->has('uploadedcomplete'))
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" integrity="sha512-wJgJNTBBkLit7ymC6vvzM1EcSWeM9mmOu+1USHaRBbHkm6W9EgM0HY27+UtUaprntaYQJF75rc8gjxllKs5OIQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script type="text/javascript">
            $( document ).ready(function() {
                 $.toast({
                    heading: 'Success',
                    text: "{{ session()->get('message') }}",
                    position: 'top-right',
                    icon: 'success',
                    extendedTimeOut: 500000,
                    stack: true,
                    autohide: false
                })
                var id =  "{{ session()->get('uploadedcomplete') }}";
                importfile(id , 'createquestions');
            });
        </script>
    @endif


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Only for Question and Answers
                </div>
                <div class="card-body">
                    <p style="color: red;"><b>Notes:</b> File extention should be .CSV, Excell.</p>
                    <p style="color: red;">Make sure the file is formated this way, please see the template <a href="{{ url('/admin/images/question_answer.xlsx') }}" download="">Template.xlxs</a></p>
                    <form enctype="multipart/form-data" method="POST" action="{{ url('uploadfile') }}" class="needs-validation" novalidate>
                        {{ csrf_field() }}
                        <div class="form-group mb-3">
                            <label for="validationCustom03">Select File</label>
                            <input style="height:45px;" accept=".xlsx" type="file" class="form-control" name="uploadedfile" id="validationCustom09"
                                 required>
                            <input type="hidden" value="answerquestion"  name="filetype">     
                            <div class="invalid-feedback">
                                Please attach image file.
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </form>
                    <br>

                    <div class="row">
                        <div class="col-md-12">
                            <table id="basic-datatable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>File Name</th>
                                        <th>Uploaded Date</th>
                                        <th>Uploaded By</th>
                                        <th>File Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(DB::table('uploadedfiledatas')->where('filetype' , 'answerquestion')->get() as $r)
                                    <tr>
                                        <td><a href="{{ url('/images') }}/{{ $r->file }}">{{ $r->filename }}</a></td>
                                        <td>{{ $r->created_at }}</td>
                                        <td>{{ DB::table('users')->where('id' , $r->added_by)->get()->first()->name }}</td>
                                        <td style="text-transform:capitalize;">{{ $r->status }}</td>
                                        <td>
                                            
                                            @if($r->status == 'createquestions')
                                            <button id="createquestions{{ $r->id }}" onclick="importfile({{$r->id}},'createquestions')" class="btn btn-primary">Import Questions</button>
                                            @endif
                                            @if($r->status == 'createuser')
                                            <button id="createuser{{ $r->id }}" onclick="importfile({{$r->id}},'createuser')" class="btn btn-primary">Create Users</button>
                                            @endif
                                            @if($r->status == 'createsubject')
                                            <button id="createsubject{{ $r->id }}" onclick="importfile({{$r->id}},'createsubject')" class="btn btn-primary">Create Subjects</button>
                                            @endif
                                            @if($r->status == 'createurl')
                                            <button id="createurl{{ $r->id }}" onclick="importfile({{$r->id}},'createurl')" class="btn btn-primary">Create URl</button>
                                            @endif
                                            @if($r->status == 'createanswer')
                                            <button id="createanswer{{ $r->id }}" onclick="importfile({{$r->id}},'createanswer')" class="btn btn-primary">Create Answers</button>
                                            @endif
                                            @if($r->status == 'createimages')
                                            <button id="createimages{{ $r->id }}" onclick="importfile({{$r->id}},'createimages')" class="btn btn-primary">Create Images</button>
                                            @endif
                                            @if($r->status == 'importSuccessfully')
                                            <button onclick="importfile({{$r->id}},'createimages')" class="btn btn-success">Imported</button>
                                            @endif
                                            <button style="display:none;" id="createuser{{ $r->id }}" onclick="importfile({{$r->id}},'createuser')" class="btn btn-primary">Create Users</button>
                                            <button style="display:none;" id="createsubject{{ $r->id }}" onclick="importfile({{$r->id}},'createsubject')" class="btn btn-primary">Create Subjects</button>
                                            <button style="display:none;" id="createurl{{ $r->id }}" onclick="importfile({{$r->id}},'createurl')" class="btn btn-primary">Create URl</button>
                                            <button style="display:none;" id="createanswer{{ $r->id }}" onclick="importfile({{$r->id}},'createanswer')" class="btn btn-primary">Create Answers</button>
                                            <button style="display:none;" id="createimages{{ $r->id }}" onclick="importfile({{$r->id}},'createimages')" class="btn btn-primary">Create Images</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>



                </div> <!-- end card-body-->
            </div>
        </div> <!-- end col-->
    </div>
    <!-- end row -->
</div> <!-- container -->
<!-- The Modal -->
<div class="modal fade" id="myModal">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
  <div class="modal-body">
    <div class="row">
        <div id="pendingstatus" class="col-md-12 text-center">
            <h4>Please Wait...</h4>
            <i style="font-size: 140px;color: #727cf5;" class="mdi mdi-spin mdi-loading"></i>
            <table class="table table-bordered" style="text-align:left;">
                <thead>
                    <tr>
                        <th>Tasks</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tr>
                    <th>Import Questions</th>
                    <td id="questiondone">Loading...</td>
                </tr>
                <tr>
                    <th>Create Users</th>
                    <td id="userdone">Loading...</td>
                </tr>
                <tr>
                    <th>Create Subjects</th>
                    <td id="subjectsdone">Loading...</td>
                </tr>
                <tr>
                    <th>Import Answers</th>
                    <td id="answersdone">Loading...</td>
                </tr>
                <tr>
                    <th>Import Question Images</th>
                    <td id="questionimagesdone">Loading...</td>
                </tr>
            </table>
        </div>
        <div id="showdonediv" class="col-md-12 text-center" style="display: none;">
            <h4>Import Successfully...</h4>
            <i style="font-size: 140px;color: #727cf5;" class="mdi mdi-tooltip-check-outline"></i>
            <h4>Done</h4>
        </div>
    </div>
        
  </div>
</div>
</div>
<script type="text/javascript">
    function importfile(id,importfile)
    {
        $('#myModal').modal({backdrop: 'static', keyboard: false});
        var mainurl = '{{url("admin/createfile")}}';
        $.ajax({
            type: "GET",
            url: mainurl+'/'+id+'/'+importfile,
            success: function(resp) {
                $('#pendingstatus').hide();
                $('#showdonediv').show();
                setTimeout(function(){ 
                    location.reload();
                 }, 3000);
            }
        });
    }
</script>
@endsection