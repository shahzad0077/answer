<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>@yield('title')</title>
  <!-- Stylesheets -->
  <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,900&amp;display=swap" rel="stylesheet" />
  <link href="{{ asset('/admin/css/icons.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('/admin/css/app.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('/admin/css/vendor/dataTables.bootstrap4.css') }}" rel="stylesheet" />
  <link href="{{ asset('/admin/css/vendor/responsive.bootstrap4.css') }}" rel="stylesheet" />
  <link href="{{ asset('/admin/css/vendor/buttons.bootstrap4.css') }}" rel="stylesheet" />
  <link href="{{ asset('/admin/css/vendor/select.bootstrap4.css') }}" rel="stylesheet" />
  <link href="{{ asset('/admin/css/vendor/summernote-bs4.css') }}" rel="stylesheet" />
  <link href="{{ asset('/admin/css/vendor/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" />
  <link href="{{ asset('/admin/app-modern.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('/admin/app-modern-dark.min.css') }}" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

  <script src="{{ asset('/admin/js/vendor.min.js') }}" type="text/javascript"></script>
  

  <input type="hidden" value="{{ url('') }}" id="mainurl">
  <!-- Responsive -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <script src="{{ asset('/admin/js/app.min.js') }}" type="text/javascript"></script>
  <script src="{{ url('/admin/js/charCount.js') }}"></script>
  <script src="{{ asset('/admin/js/driver.js') }}" type="text/javascript"></script>
</head>
  <body class="loading" data-layout="detached" data-layout-config='{"leftSidebarCondensed":false,"darkMode":false, "showRightSidebarOnStart": true}'>
    <div id="wholebodyloader" class=""></div>
        @include('includes.admin-navbar')
        
        <!-- Start Content-->
        <div class="container-fluid">

            <!-- Begin page -->
            <div class="wrapper">

                @include('includes.admin-sidebar')
                @yield('content-admin')  


            </div> <!-- end wrapper-->
        </div>
        <!-- END Container -->
        
    </body>

  
  
  <script src="{{ asset('/admin/js/vendor/apexcharts.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('/admin/js/vendor/jquery-jvectormap-1.2.2.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('/admin/js/vendor/jquery-jvectormap-world-mill-en.js') }}" type="text/javascript"></script>
  <script src="{{ asset('/admin/js/pages/demo.dashboard-analytics.js') }}" type="text/javascript"></script>
  <script src="{{ asset('/admin/js/app.min.js')}}"></script>
  <script src="{{ asset('/admin/js/vendor/jquery.dataTables.min.js')}}"></script>
  <script src="{{ asset('/admin/js/vendor/dataTables.bootstrap4.js')}}"></script>
  <script src="{{ asset('/admin/js/vendor/dataTables.responsive.min.js')}}"></script>
  <script src="{{ asset('/admin/js/vendor/responsive.bootstrap4.min.js')}}"></script>
  <script src="{{ asset('/admin/js/vendor/dataTables.buttons.min.js')}}"></script>
  <script src="{{ asset('/admin/js/vendor/buttons.bootstrap4.min.js')}}"></script>
  <script src="{{ asset('/admin/js/vendor/buttons.html5.min.js')}}"></script>
  <script src="{{ asset('/admin/js/vendor/buttons.flash.min.js')}}"></script>
  <script src="{{ asset('/admin/js/vendor/buttons.print.min.js')}}"></script>
  <script src="{{ asset('/admin/js/vendor/dataTables.keyTable.min.js')}}"></script>
  <script src="{{ asset('/admin/js/vendor/dataTables.select.min.js')}}"></script>
  <script src="{{ asset('/admin/js/pages/demo.datatable-init.js')}}"></script>
  <script src="{{ asset('/admin/js/vendor/summernote-bs4.min.js')}}"></script>
  <script src="{{ asset('/admin/js/pages/demo.summernote.js')}}"></script>
  <script src="{{ asset('/admin/js/vendor/dropzone.min.js')}}"></script>
  <script src="{{ asset('/admin/js/ui/component.fileupload.js')}}"></script>
</html>


<!-- Delete Modal -->


<div id="deleteglobelmodel" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content modal-filled bg-danger">
            <div class="modal-body p-4">
                <div class="text-center">
                    <i class="dripicons-wrong h1"></i>
                    <h4 class="mt-2">Are you sure?</h4>
                    <p class="mt-3">you want to delete this</p>
                    <a id="deleteglobelmodelhref" class="btn btn-light my-2" href="">Continue</a>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
    function globaldelete(id , tablename)
    {
        var mainurl = '{{ url("") }}';
        var url = mainurl+'/deleteglobelfunction/'+id+'/'+tablename;
        $("#deleteglobelmodelhref").attr("href", url);
        $('#deleteglobelmodel').modal('show');
    }
    function search(value)
    {
        if(value == '')
        {

        }else{
            $('#spinnerloader').html('<i style="font-size: 24px;color: red;" class="mdi mdi-spin mdi-loading"></i>');
            $.ajax({
              type: "GET",
              url: "{{ url('searchquestion') }}/"+value,
              success: function(resp) {
                $('#table_data').html(resp);
                $('#spinnerloader').html('');
              }
            });
        }
    }
    function searchanswer(value)
    {
        if(value == '')
        {

        }else{
            $.ajax({
              type: "GET",
              url: "{{ url('searchanswer') }}/"+value,
              success: function(resp) {
                $('#table_data').html(resp);
              }
            });
        }
    }
</script>
<style>
    form .counter {
        font-size: 15px;
        font-weight: bold;
        color: #008800;
    }

    form .warning {
        color: #600;
    }

    form .exceeded {
        color: #e00;
    }

</style>