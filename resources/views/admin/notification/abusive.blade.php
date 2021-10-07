@extends('layouts.admin-app')
@section('title','Abusive Words')
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
                        <li class="breadcrumb-item active">Abusive Alerts</li>
                    </ol>
                </div>
                <h4 class="page-title">Abusive Alerts</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="basic-datatable" class="table" >
                            <thead  class="thead-light">
                                <tr>
                                    <th>Question ID</th>
                                    <th>Answer ID</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as  $r)
                                <tr>
                                    <td>
                                        <a href="{{ url('admin/editquestion') }}/{{ $r->questionid }}">Q-{{ $r->questionid }}</a>
                                    </td>
                                    <td>
                                        @if($r->answerid > 0)
                                        <a href="{{ url('admin/question') }}/{{ $r->questionid }}/{{ $r->answerid }}">A-{{ $r->answerid }}</a>
                                        @endif
                                    </td>
             
                                    <td>
                                        {{ $r->status }}
                                    </td>
                                </tr>
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

@endsection