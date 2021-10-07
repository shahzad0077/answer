@extends('layouts.admin-app')
@section('title','All Answers')
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
                        <li class="breadcrumb-item active">Answers</li>
                    </ol>
                </div>
                <h4 class="page-title">Answers ( Total: {{ Cmf::getalldatacount('onlyanswers') }} )</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 
    <ul class="nav nav-tabs nav-bordered mb-3">
        <li class="nav-item">
            <a href="{{ url('admin/answers') }}"  class="nav-link ">
                <i class="mdi mdi-home-variant d-md-none d-block"></i>
                <span class="d-none d-md-block">All <span style="margin-left: 10px;" class="badge badge-pill badge-info">{{DB::table('onlyanswers')->where('delete_status' , 'Active')->count()}}</span></span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('admin/answers/published') }}"  class="nav-link ">
                <i class="mdi mdi-account-circle d-md-none d-block"></i>
                <span class="d-none d-md-block">Published <span style="margin-left: 10px;" class="badge badge-pill badge-success">{{DB::table('onlyanswers')->where('visible_status' , 'Published')->where('delete_status' , 'Active')->count()}}</span></span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('admin/answers/underreview') }}"  class="nav-link active">
                <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                <span class="d-none d-md-block">Under Review <span style="margin-left: 10px;" class="badge badge-pill badge-warning">{{DB::table('onlyanswers')->where('visible_status' , 'Under Review')->where('delete_status' , 'Active')->count()}}</span></span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('admin/answers/trash') }}"  class="nav-link">
                <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                <span class="d-none d-md-block">Trash <span style="margin-left: 10px;" class="badge badge-pill badge-danger">{{DB::table('onlyanswers')->where('visible_status' , 'Trash')->where('delete_status' , 'Active')->count()}}</span></span>
            </a>
        </li>
    </ul>
    @include('admin.alert')
    <div class="tab-content">
        <div class="tab-pane show active" id="all">
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    @include('admin.answerheader')
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
                                            <th>Answer</th>
                                            <th>User</th>
                                            <th>Dated</th>
                                            <th>Visible Status</th>
                                            <th>View Answer</th>
                                            <th style="width: 85px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_data">
                                       <form id="completeform" method="POST" action="">
                                            {{ csrf_field() }} 
                                        @foreach($data as $r)
                                        <tr @if(DB::table('abusivealerts')->where('answerid' , $r->id)->where('status' , 'Active')->count() == 1) style="background-color:#ffbc00;" @endif>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input value="{{ $r->id }}" name="allid[]" type="checkbox" class="custom-control-input" id="customCheck{{ $r->id }}">
                                                    <label class="custom-control-label" for="customCheck{{ $r->id }}">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td><a onclick="answerview({{ $r->id }})" href="javascript:void(0)">A-{{ $r->id }}</a></td>
                                            <td>
                                                {!! Str::limit($r->answer  , 30) !!}
                                            </td>
                                            <td>
                                               <a href="{{ url('admin/user/detail/') }}/{{ DB::table('users')->where('username' , $r->users)->get()->first()->id }}"> {{$r->users}} </a>
                                            </td>
                                            <td>
                                                {{ date('d M Y, h:s a ', strtotime($r->created_at)) }}
                                            </td>
                                            <td>
                                                <div class="badge badge-pill @if($r->visible_status == 'Published') badge-success @endif @if($r->visible_status == 'Trash') badge-danger @endif @if($r->visible_status == 'Under Review') badge-warning @endif" style="font-size: 15px;">{{  $r->visible_status }}</div>
                                            </td>
                                            <td>
                                                <span onclick="answerview({{ $r->id }})" class="btn btn-primary">View Complete</span>
                                            </td>                                            
                                            <td class="table-action">
                                                <a href="{{ url('admin/question/') }}/{{ $r->questionid }}/{{ $r->id }}" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                                <a onclick="return confirm('Are You Sure You want to Delete This')" href="{{url('admin/deleteanswertrash')}}/{{ $r->id }}"  class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach  
                                        </form>                                     
                                    </tbody>
                                </table>
                                @if(isset($search))
                                @else
                                <div id="pagination" style="margin-top: 50px;">
                                    {!! $data->links('frontend.pagination') !!}
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