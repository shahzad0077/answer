@extends('layouts.admin-app')
@section('title','All Site URLS')
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
                        <li class="breadcrumb-item active">Site URLS</li>
                    </ol>
                </div>
                <h4 class="page-title">All Site URLS</h4>
            </div>
        </div>
    </div>
    @include('admin.alert')
    <!-- end page title -->
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
        <div class="col-md-10">
            <form method="POST" action="{{ url('searchurl') }}">
                {{ csrf_field() }}
                <input required="" @if(isset($searchword)) value="{{ $searchword }}" @endif type="text" class="form-control" placeholder="Search With URL and Press Enter" name="searchword">
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Module Name</th>
                                <th>URL</th>
                                <th>Created At</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $r)
                            <tr>
                                <td>{{ $r->modulename }}</td>
                                <td>{{ $r->url }}</td>
                                <td>{{ date('d M Y, h:s a ', strtotime($r->created_at)) }}</td>
                                <td class="table-action text-center">
                                    <a href="{{url('admin/blogcategory/edit')}}/{{ $r->id }}" class="action-icon" title="Edit Category"> <i class="mdi mdi-pencil"></i></a>
                                    <a onclick="return confirm('Are You Sure You want to Delete This')" href="{{url('admin/deleteblogcategory')}}/{{ $r->id }}" class="action-icon" title="Delte Category"> <i class="mdi mdi-delete"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($statusnavbar == 'search')
                    @else
                     <div id="pagination" style="margin-top: 50px;">
                        {!! $data->links('frontend.pagination') !!}
                    </div>
                    @endif
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->
</div> <!-- container -->
@endsection