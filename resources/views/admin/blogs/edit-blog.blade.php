@extends('layouts.admin-app')
@section('title','Edit Blog')
@section('content-admin')
<!-- Start Content-->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('admin/blogs')}}">Blog</a></li>
                        <li class="breadcrumb-item active">Edit Blog</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Blog</h4>
            </div>
        </div>
    </div>
    @include('admin.alert')
<form enctype="multipart/form-data" method="POST" action="{{ url('updateblog') }}" class="needs-validation" novalidate>
        {{ csrf_field() }}
        <input type="hidden" value="{{ $data->id }}" name="id">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    Blog Details
                </div>
                <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="validationCustom01">Blog Name</label>
                            <input onkeyup="createslug(this.value)" type="text" value="{{ $data->name }}" class="form-control" name="name" id="validationCustom01"
                                placeholder="Title" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label for="validationCustom02">Slug</label>
                            <input type="text" id="slug" value="{{ $data->url }}" class="form-control" name="slug" onkeyup="checkslug()" 
                                 required >
                                 <small id="slugerror" class="mt-1 text-danger"></small>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label for="validationCustom01">Detailed Content</label>
                            <textarea id="summernote-basic" required="" name="content" class="form-control" rows="8">{{ $data->blog }}</textarea>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="validationCustom03">Main Image</label>
                            <input style="height: 44px;" type="file" class="form-control" name="image" id="validationCustom09"
                                 >
                            <div class="invalid-feedback">
                                Please attach image file.
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="validationCustom03">Blog Date</label>
                            <input value="{{ $data->created_at }}" type="text" class="form-control" name="date" id="validationCustom09"
                                 >

                        </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    Blog Categories
                </div>
                <div class="card-body">
                    <div style="height: 300px;overflow: auto;overflow-x: hidden;">
                        @foreach(DB::table('blogcategories')->where('delete_status' , 'Active')->get() as $r)
                        <div class="row">
                            <div class="col-md-1">
                                <input 

                                    @foreach(DB::table('wphj_term_relationships')->where('object_id' , $data->id)->get() as $c)
                                            @if(DB::table('blogcategories')->where('id' , $c->term_taxonomy_id)->count() > 0)
                                               @if(DB::table('blogcategories')->where('id' , $c->term_taxonomy_id)->get()->first()->id == $r->id) checked @endif
                                              
                                            @endif
                                        @endforeach

                                 id="label{{$r->id}}" value="{{ $r->id }}" type="checkbox" name="blogcategory[]">
                            </div>
                            <div class="col-md-11">
                               <label style="width:350px;" for="label{{$r->id}}"> {{ $r->name }} </label>
                            </div>
                           
                        </div>
                         @endforeach
                    </div>
                    
                </div> <!-- end card-body-->
            </div>
            <style type="text/css">
                #livesearchbanner{
                    position: absolute;
                    width: 90%;
                    background: white;
                    border-bottom-left-radius: 10px;
                    border-bottom-right-radius: 10px;
                    max-height: 600px;
                    overflow-y: auto;
                    border: 1px solid #DDD;
                    margin: auto;
                    z-index: 1000000000000;

                }
            </style>
            <div class="card">
                <div class="card-header">
                    Blog Tags
                </div>
                <div class="card-body">
                    <div style="height: 300px;overflow: auto;overflow-x: hidden;">
                        <div id="showtags">
                            
                        
                        @foreach(DB::table('wphj_term_relationships')->where('object_id' , $data->id)->get() as $r)

                        @if(DB::table('wphj_term_taxonomy')->where('term_id' , $r->term_taxonomy_id)->count() > 0)

                        @if(DB::table('wphj_term_taxonomy')->where('term_id' , $r->term_taxonomy_id)->get()->first()->taxonomy == 'post_tag') 

                        <div style="background-color:#dddddd;padding:10px;color: black;margin-bottom: 10px;">
                            <div class="row">
                                <div title="{{ DB::table('wphj_terms')->where('term_id' , $r->term_taxonomy_id)->get()->first()->name }}" class="col-md-11">
                                    {!! Str::limit(DB::table('wphj_terms')->where('term_id' , $r->term_taxonomy_id)->get()->first()->name, 50) !!} 
                                </div>
                                <div style="cursor: pointer;" onclick="deletetag({{DB::table('wphj_terms')->where('term_id' , $r->term_taxonomy_id)->get()->first()->term_id}})" class="col-md-1">
                                    X
                                </div>
                            </div>
                        </div>

                        @endif

                        @endif

                        @endforeach
                        
                        </div>
                        <textarea onkeyup="searchtags(this.value)" class="form-control" placeholder="Search and Add More Tags"></textarea>
                        <script type="text/javascript">
                            function searchtags(id)
                            {
                                $('#livesearchbanner').show();
                                var mainurl = '{{ url('') }}';
                                if(id == '')
                                {
                                    $('#livesearchbanner').hide();
                                }else{
                                    $.ajax({
                                        type: "GET",
                                        url: mainurl+'/searchtags/'+id,
                                        success: function(resp) {
                                            $('#livesearchbanner').show();
                                            $('#livesearchbanner').html(resp);
                                        }
                                    });
                                }   
                            }
                            function addtage(id)
                            {
                                var blogid = '{{ $data->id }}'
                                var mainurl = '{{ url('') }}';
                                $.ajax({
                                    type: "GET",
                                    url: mainurl+'/addtag/'+blogid+'/'+id,
                                    success: function(resp) {
                                        $('#showtags').html(resp);
                                    }
                                });
                            }
                            function deletetag(tagid)
                            {
                                var blogid = '{{ $data->id }}'
                                var mainurl = '{{ url('') }}';
                                $.ajax({
                                    type: "GET",
                                    url: mainurl+'/deletetag/'+blogid+'/'+tagid,
                                    success: function(resp) {
                                        $('#showtags').html(resp);
                                    }
                                });
                            }
                        </script>
                        <div style="display: none;" id="livesearchbanner">
                            <div class="text-center">
                                Searching....
                            </div>
                        </div>
                    </div>
                    
                </div> <!-- end card-body-->
            </div>
            <div class="card">
                <div class="card-header">
                    Blog Meta Tags
                </div>
                <div class="card-body">
                        <div class="form-group mb-2">
                            <label for="validationCustom03">Meta Title</label>
                            <input type="text" class="form-control" value="{{ $data->metta_tittle }}" name="metta_tittle" id="meta_title">
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="validationCustom04">Meta Description</label>
                                    <textarea class="form-control" name="metta_description" id="meta_description"
                                        placeholder="Put something"  rows="4">{{ $data->metta_description }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="validationCustom04">Meta Keywords</label>
                                    <textarea class="form-control" name="metta_keywords" id="meta_keywords"
                                        placeholder="Put something" rows="4">{{ $data->metta_keywords }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                        <input type="radio" @if($data->visible_status == 'Published') checked @endif value="Published" name="visible_status" id="active">
                        <label for="active">Published</label>
                        </div>
                        <div class="form-group mb-2">
                            <input @if($data->visible_status == 'Not Published') checked @endif type="radio" value="Not Published" name="visible_status" id="delete">
                            <label for="delete">Not Published</label>
                        </div>
                </div> <!-- end card-body-->
            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <button id="submitbutton" type="submit" class="btn btn-primary form-control">Save</button>
                </div>
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
</form>
</div> <!-- container -->
@endsection