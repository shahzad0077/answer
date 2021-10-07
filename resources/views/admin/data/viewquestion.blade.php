@extends('layouts.admin-app')
@section('title','View Questions')
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
                <h4 class="page-title">{!! Str::limit($data->question_name, 100) !!}</h4>
            </div>
        </div>
    </div>     
    @include('admin.alert')
    <div class="tab-content">
        <div class="tab-pane show active" id="all">
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
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
                        <div class="col-md-3 col-2">
                            <input type="text" onkeyup="searchanswer(this.value)" class="form-control" placeholder="Search by Answer Tittle...." name="">
                        </div>
                        <div class="col-md-7 col-10 text-right">
                            <div class="dropdown text-right">
                               <button data-toggle="modal" data-target="#add-answer"  class="btn btn-success"><i class="uil-alt-plus"></i>Add Answer</button>
                               
                               <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a onclick="changeurlofform('publishedquestion')" class="dropdown-item" href="javascript:void(0);">Published</a>
                                    <a onclick="changeurlofform('underreviewquestion')" class="dropdown-item" href="javascript:void(0);">Under Review</a>
                                    <a onclick="changeurlofform('movetotrashquestion')" class="dropdown-item" href="javascript:void(0);">Move to Trash</a>
                                    <a onclick="changeurlofform('deletequestion')" class="dropdown-item" href="javascript:void(0);">Delete</a>
                                </div>

                               
                            </div>
                        </div>
                    </div>
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
                                        @foreach($answers as $r)
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
                                                @if(!empty(DB::table('users')->where('username' , $r->users)->get()->first()->name))
                                                {{ DB::table('users')->where('username' , $r->users)->get()->first()->name }}
                                                @else
                                                  {{$r->users}}
                                                @endif
                                            </td>
                                            <td>
                                                {{ date('d M Y, h:s a ', strtotime($r->created_at)) }}
                                            </td>
                                            <td>
                                                {{  $r->visible_status }}
                                            </td>
                                            <td>
                                                <span onclick="answerview({{ $r->id }})" class="btn btn-primary">View Complete</span>
                                            </td>                                            
                                            <td class="table-action">
                                                <a href="{{ url('admin/question/') }}/{{ $data->id }}/{{ $r->id }}" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                                <a onclick="globaldelete({{$r->id}} , 'onlyanswers')" href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach  
                                        </form>                                     
                                    </tbody>
                                </table>
                                @if(isset($search))
                                @else
                                <div id="pagination" style="margin-top: 50px;">
                                    {!! $answers->links('frontend.pagination') !!}
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
<!-- Modal -->
<div class="modal fade" id="add-answer" tabindex="-1" role="dialog" aria-labelledby="edit-modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit-modalLabel">Add Answer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{ url('addanswer') }}">
        {{ csrf_field() }}
      <input type="hidden" value="{{ $data->id }}" name="id">
      <div class="modal-body">
        <div class="form-group mb-2">
            <label for="validationCustom01">Detailed Answer</label>
            <textarea id="summernote-basic" required="" name="answer" class="form-control" rows="8"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <a type="button" class="btn btn-secondary" data-dismiss="modal">Close</a>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>
@include('admin.data.modalsection')
@endsection