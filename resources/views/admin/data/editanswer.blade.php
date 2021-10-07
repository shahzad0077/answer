@extends('layouts.admin-app')
@section('title','Edit Answer')
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
                        <li class="breadcrumb-item active">Edit Answer</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ $data->question_name }}</h4>
            </div>
        </div>
    </div>     
    @include('admin.alert')
    <div class="tab-content">
        <div class="tab-pane show active" id="all">

            <!-- end page title -->
            <div class="row">
                
                <div class="col-12">
                    <div class="card">
                        
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Edit Answer</h3>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="javascript:history.go(-1)" class="btn btn-primary">Back</a>
                                </div>
                            </div>
                            <form method="POST" action="{{ url('updateanswer') }}">
                                        {{ csrf_field() }}
                                      <input type="hidden" id="answerid" value="{{ $answers->id }}" name="id">
                                      <div class="modal-body">
                                        <div class="form-group mb-2">
                                            <label for="validationCustom01">Detailed Answer</label>
                                            <textarea required="" id="summernote-basic" name="answer" class="form-control" rows="8">{{ $answers->answer }}</textarea>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="validationCustom01">Visible Status</label>
                                            <select id="visiblestatus" class="form-control" name="visible_status">
                                                <option value="">Select User</option>
                                                <option @if($answers->visible_status == 'Published') selected @endif value="Published">Published</option>
                                                <option @if($answers->visible_status == 'Trash') selected @endif value="Trash">Trash</option>
                                                <option @if($answers->visible_status == 'Under Review') selected @endif value="Under Review">Under Review</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="validationCustom01">Answer Likes</label>
                                            <input type="number" class="form-control" value="{{ $answers->likes }}" name="likes" placeholder="Enter Question Likes">
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="validationCustom01">Answer Rattings</label>
                                            <input type="text" class="form-control" value="{{ $answers->rattings }}" name="rattings" placeholder="Enter Rattings Between 1 and 5">
                                        </div>
                                        <div class="form-group mb-2">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                      </div> 
                                </form>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col -->
            </div>
            <!-- end row --> 
        </div>
    </div> 
</div>
  <link rel="stylesheet" href="{{ asset('/front/assets/summernote/summernote-bs4.css') }}">
<script src="{{ asset('/front/assets/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('/front/assets/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('/front/assets/summernote/lang/summernote-ar-AR.js') }}"></script>
<script src="{{ asset('/front/assets/summernote/summernote-ext-rtl.js') }}"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
@endsection