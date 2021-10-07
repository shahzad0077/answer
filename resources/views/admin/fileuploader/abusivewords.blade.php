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
                        <li class="breadcrumb-item active">Abusive Words File Upload</li>
                    </ol>
                </div>
                <h4 class="page-title">Abusive Words File Upload</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    @include('admin.alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Only for Add Abusive Words
                </div>
                <div class="card-body">
                    <p style="color: red;"><b>Notes:</b> File extention should be .CSV, Excell.</p>
                    <p style="color: red;">Make sure the file is formated this way, please see the template <a href="{{ url('/admin/images/abusive_words_template.xlsx') }}" download="">Template.xlxs</a></p>
                    <form enctype="multipart/form-data" method="POST" action="{{ url('createfileabusivewords') }}" class="needs-validation" novalidate>
                        {{ csrf_field() }}
                        <div class="form-group mb-3">
                            <label for="validationCustom03">Select File</label>
                            <input style="height:45px;" accept=".xlsx" type="file" class="form-control" name="uploadedfile" id="validationCustom09"
                                 required>
                                 <input type="hidden" value="abusivewords"  name="filetype"> 
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
                                    @foreach(DB::table('uploadedfiledatas')->where('filetype' , 'abusivewords')->get() as $r)
                                    <tr>
                                        <td><a href="{{ url('/images') }}/{{ $r->file }}">{{ $r->filename }}</a></td>
                                        <td>{{ $r->created_at }}</td>
                                        <td>{{ DB::table('users')->where('id' , $r->added_by)->get()->first()->name }}</td>
                                        <td style="text-transform:capitalize;">{{ $r->status }}</td>
                                        <td>
                                            
                                            <button class="btn btn-success">Imported</button>
                                            
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
@endsection