@extends('layouts.admin-app')
@section('title','Advertisements Requests')
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
                        <li class="breadcrumb-item active">Advertisements Requests</li>
                    </ol>
                </div>
                <h4 class="page-title">Advertisements Requests</h4>
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
                                    <th>Company Name</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach($data as $r)
                                <tr @if($r->newstatus == 'new') style="background-color:#d0f2d0;" @endif>
                                    <td>
                                        {{ $r->name }}
                                    </td>
                                    <td>
                                       {{ $r->email }}
                                    </td>
                                    <td>
                                        {{ $r->phonenumber }}
                                    </td>
                                    <td>
                                        {{ $r->company }}
                                         
                                    </td>
                                    
                                    <td>
                                        <a href="{{ url('admin/advertisementview') }}/{{ $r->id }}" class="action-icon" title="View Advertisement"> <i class="mdi mdi-eye"></i></a>
                                        <a onclick="return confirm('Are You Sure You want to Delete This')" href="{{ url('admin/advertisementsdelte') }}/{{ $r->id }}" class="action-icon" title="Delte Category"> <i class="mdi mdi-delete"></i></a>
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