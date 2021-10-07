@extends('layouts.admin-app')
@section('title','Advertisements')
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
                        <li class="breadcrumb-item"><a href="{{url('admin/pages')}}">Pages</a></li>
                        <li class="breadcrumb-item active">Advertisements</li>
                    </ol>
                </div>
                <h4 class="page-title">Advertisements</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    @include('admin.alert')
    <form method="POST" action="{{ url('saveadvertisements') }}">
        {{ csrf_field() }}
    <div class="row">
        <div class="col-md-6">
            <h4>Main Script Area</h4>
        </div>
    </div><hr>
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="form-group mb-2">
                            <label for="validationCustom04">Header Script: <br> <small>Whatever you place will be added to <code>< head>< /head></code></small></label>
                            <textarea name="header_script" class="form-control" rows="5">{!! Cmf::site_settings('header_script') !!}</textarea>
                        </div>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
        <div class="col-md-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="form-group mb-2">
                            <label for="validationCustom04">Body Script: <br> <small>Whatever you place will be added to <code>< body>< /body></code></small></label>
                            <textarea name="body_script" class="form-control" rows="5">{!! Cmf::site_settings('body_script') !!}</textarea>
                        </div>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-2">
                <div class="card-body">
                        <div class="col-md-12">
                            <div class="form-group mb-2">
                                <label for="validationCustom04">Footer Script: <br> <small>Whatever you place will be added to <code>< footer>< /footer></code></small></label>
                                <textarea name="footer_script" class="form-control" rows="5">{!! Cmf::site_settings('footer_script') !!}</textarea>
                            </div>
                        </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-md-12">
            <h4>Page Scripts</h4>
        </div>
    </div><hr>

    <div class="row mb-2"> <!-- end col-->
        <div class="col-md-6">
            <div class="card mb-2">
                <div class="card-body">

                        <div class="col-md-12">
                            <div class="form-group mb-2">
                                <label for="validationCustom04">Left Add 1: </label> <br>
                                <textarea name="left_add_1" class="form-control" rows="5">{!! Cmf::site_settings('left_add_1') !!}</textarea>
                            </div>
                        </div>

          

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
        <div class="col-md-6">
            <div class="card mb-2">
                <div class="card-body">

                        <div class="col-md-12">
                            <div class="form-group mb-2">
                                <label for="validationCustom04">Left Add 2: </label> <br>
                                <textarea name="left_add_2" class="form-control" rows="5">{!! Cmf::site_settings('left_add_2') !!}</textarea>
                            </div>
                        </div>

          

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
    </div>

    <div class="row mb-2"> <!-- end col-->
        <div class="col-md-6">
            <div class="card mb-2">
                <div class="card-body">

                        <div class="col-md-12">
                            <div class="form-group mb-2">
                                <label for="validationCustom04">Right Add 1: </label> <br>
                                <textarea name="right_add_1" class="form-control" rows="5">{!! Cmf::site_settings('right_add_1') !!}</textarea>
                            </div>
                        </div>

          

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
        <div class="col-md-6">
            <div class="card mb-2">
                <div class="card-body">

                        <div class="col-md-12">
                            <div class="form-group mb-2">
                                <label for="validationCustom04">Right Add 2: </label> <br>
                                <textarea name="right_add_2" class="form-control" rows="5">{!! Cmf::site_settings('right_add_2') !!}</textarea>
                            </div>
                        </div>

          

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h4>Question Detail Page Script</h4>
        </div>
    </div><hr>
    <div class="row mb-2">
        <div class="col-lg-6">
            <div class="card mb-2">
                <div class="card-body">
                        <div class="col-md-12">
                            <div class="form-group mb-2">
                                <label for="validationCustom04">Question Page Top: </label> <br>
                                <textarea name="question_detail_page_top" class="form-control" rows="5">{!! Cmf::site_settings('question_detail_page_top') !!}</textarea>
                            </div>
                        </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
        <div class="col-lg-6">
            <div class="card mb-2">
                <div class="card-body">
                        <div class="col-md-12">
                            <div class="form-group mb-2">
                                <label for="validationCustom04">Answer Card: </label> <br>
                                <textarea name="answercard_advertisement" class="form-control" rows="5">{!! Cmf::site_settings('answercard_advertisement') !!}</textarea>
                            </div>
                        </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
    <div class="row mb-2">
        <div class="col-lg-6">
            <div class="card mb-2">
                <div class="card-body">
                        <div class="col-md-12">
                            <div class="form-group mb-2">
                                <label for="validationCustom04">Question Card: </label> <br>
                                <textarea name="question_card_advertisement" class="form-control" rows="5">{!! Cmf::site_settings('question_card_advertisement') !!}</textarea>
                            </div>
                        </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
    <div class="row">
            <div class="col-md-12 text-right">
                <button class="btn btn-primary">Save</button>
            </div>
        </div>
        <br><br><br>
    </form>
</div> <!-- container -->
@endsection