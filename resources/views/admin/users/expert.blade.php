@extends('layouts.admin-app')
@section('title','Experts')
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
                        <li class="breadcrumb-item active">Experts</li>
                    </ol>
                </div>
                <h4 class="page-title">Experts</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 
    <!-- end page title -->
    @include('admin.alert')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatable" class="table">
                            <thead  class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Country</th>
                                    <th>Qualifications</th>
                                    <th>Specialization</th>
                                    <th>Make Expert</th>
                                    <th style="width: 130px;">View Attached</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach($data as $r)
                                <tr>
                                    <td>
                                        {{ $r->name }}
                                    </td>
                                    <td>
                                       <a href="{{ url('admin/user/detail/') }}/{{ DB::table('users')->where('email' , $r->email)->get()->first()->id }}"> {{ $r->email }} </a>
                                    </td>
                                    <td>
                                        {{ $r->phonenumber }}
                                    </td>
                                    <td>
                                        {{ $r->country }}
                                    </td>
                                    <td>
                                        {{ $r->qualification }}
                                         
                                    </td>
                                    
                                    <td>
                                        {{ $r->specialisation }}
                                    </td>
                                    <td>
                                       @if(DB::table('users')->where('email' , $r->email)->get()->first()->expert == 'on')
                                        <a href="{{ url('removeexpert') }}/{{ DB::table('users')->where('email' , $r->email)->get()->first()->id }}">
                                        <button type="button" class="btn btn-primary">
                                            Make Simple User
                                        </button>
                                        </a>
                                        @else
                                       <a href="{{ url('makeexpert') }}/{{ DB::table('users')->where('email' , $r->email)->get()->first()->id }}"> <button type="button" class="btn btn-success">
                                            Make Expert
                                        </button></a>
                                        @endif
                                    </td>
                                    <td class="table-action text-center">
                                        @if(!empty($r->document))
                                        <a href="{{url('/images')}}/{{ $r->document }}" target="_blank" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                                        @else
                                        No any Document
                                        @endif
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