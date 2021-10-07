@extends('layouts.admin-app')
@section('title','Published Questions')
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
                        <li class="breadcrumb-item active">Questions</li>
                    </ol>
                </div>
                <h4 class="page-title">Questions</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 
    <ul class="nav nav-tabs nav-bordered mb-3">
        <li class="nav-item">
            <a href="{{ url('admin/questions') }}"  class="nav-link ">
                <i class="mdi mdi-home-variant d-md-none d-block"></i>
                <span class="d-none d-md-block">All<span style="margin-left: 10px;" class="badge badge-pill badge-info">{{DB::table('answerquestions')->where('delete_status' , 'Active')->count()}}</span></span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('admin/questions/published') }}"  class="nav-link active">
                <i class="mdi mdi-account-circle d-md-none d-block"></i>
                <span class="d-none d-md-block">Published<span style="margin-left: 10px;" class="badge badge-pill badge-success">{{DB::table('answerquestions')->where('visible_status' , 'Published')->where('delete_status' , 'Active')->count()}}</span></span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('admin/questions/underreview') }}"  class="nav-link ">
                <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                <span class="d-none d-md-block">Under Review<span style="margin-left: 10px;" class="badge badge-pill badge-warning">{{DB::table('answerquestions')->where('visible_status' , 'Under Review')->where('delete_status' , 'Active')->count()}}</span></span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('admin/questions/trash') }}" class="nav-link">
                <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                <span class="d-none d-md-block">Trash<span style="margin-left: 10px;" class="badge badge-pill badge-danger">{{DB::table('answerquestions')->where('visible_status' , 'Trash')->where('delete_status' , 'Active')->count()}}</span></span>
            </a>
        </li>
    </ul>
    @include('admin.alert')
    <div class="tab-content">
        <div class="tab-pane show active" id="all">
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    @include('admin.data.questionfilderheader')
                    <script type="text/javascript">
                        function changeurlofform(id)
                        {
                            if($('.custom-control-input').prop("checked") == true){
                                var mainurl = $('#mainurl').val();
                                var url = mainurl+'/'+id;
                                $('#completeform').attr('action', url).submit();
                            }
                            else if($('.custom-control-input').prop("checked") == false){
                                
                                swal("Error", "Please Select Any Row", "error");
                            }
                        }
                    </script>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-centered w-100 dt-responsive nowrap">
                                    <thead  class="thead-light">
                                        <tr>
                                            <th style="width: 20px;">
                                                <div class="custom-control custom-checkbox">
                                                    <input  type="checkbox" class="custom-control-input" id="customCheck1">
                                                    <label class="custom-control-label" for="customCheck1">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th>ID</th>
                                            <th>Question Title</th>
                                            <th>Subject</th>
                                            <th>Status</th>
                                            <th>Answers Count</th>
                                            <th>Dated</th>
                                            <th>Visible Status</th>
                                            <th style="width: 85px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <form id="completeform" method="POST" action="">
                                            {{ csrf_field() }} 
                                        @foreach($data as $r)
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input value="{{ $r->id }}" name="allid[]" type="checkbox" class="custom-control-input" id="customCheck{{ $r->id }}">
                                                    <label class="custom-control-label" for="customCheck{{ $r->id }}">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td><a href="{{ url('admin/viewquestion') }}/{{ $r->id }}">Q-{{ $r->id }}</a></td>
                                            <td>
                                                {{ Str::limit($r->question_name  , 30) }}
                                            </td>
                                            <td>
                                                {{ $r->question_subject }}
                                            </td>
                                            <td>
                                                @if(!empty($r->accepted_answer))
                                                <span class="badge badge-success-lighten"><i class="mdi mdi-timer-sand"></i>Answered</span>
                                                @else
                                                <span class="badge badge-warning-lighten"><i class="mdi mdi-timer-sand"></i>Unanswered</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ DB::table('onlyanswers')->where('delete_status' , 'Active')->where('questionid' , $r->id)->count() }}
                                            </td>
                                            <td>
                                                {{ date('d M Y, h:s a ', strtotime($r->created_at)) }}
                                            </td>
                                            <td>
                                                <div class="badge badge-pill @if($r->visible_status == 'Published') badge-success @endif @if($r->visible_status == 'Trash') badge-danger @endif @if($r->visible_status == 'Under Review') badge-warning @endif" style="font-size: 15px;">{{  $r->visible_status }}</div>
                                            </td>
                                            
                                            <td class="table-action">
                                                <a href="{{ url('admin/editquestion/') }}/{{ $r->id }}" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                                <a data-toggle="modal" data-target="#danger-alert-modal" href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach  
                                        </form>                                     
                                    </tbody>
                                </table>
                                @if(isset($search))
                                @else
                                <div id="pagination" style="margin-top: 50px;">
                                    {!! $data->links('admin.pagination') !!}
                                </div>
                                @endif
                            </div>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col -->
            </div>
            <!-- end row --> 
        </div>
    </div> 
</div>
@include('admin.data.modalsection')
@endsection