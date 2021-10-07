<!-- Topbar Start -->
<div class="navbar-custom topnav-navbar">
    <div class="container-fluid">

        <!-- LOGO -->
        <a href="{{url('admin/dashboard')}}" class="topnav-logo">
            <span class="topnav-logo-lg">
                <img src="{{asset('/admin/images/logo.png')}}" alt="" height="56">
            </span>
            <span class="topnav-logo-sm">
                <img src="{{asset('/admin/images/logo.png')}}" alt="" height="56">
            </span>
        </a>

        <ul class="list-unstyled topbar-right-menu float-right mb-0">
        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <i class="dripicons-bell noti-icon"></i>
                <span class="@if(DB::table('adminnotification')->where('status' , 1)->count() > 0)noti-icon-badge @endif"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-lg">

                <!-- item-->
                <div class="dropdown-item noti-title">
                    <h5 class="m-0">
                        <span class="float-right">
                            <a href="javascript: void(0);" class="text-dark">
                                <!-- <small>Clear All</small> -->
                            </a>
                        </span>Notification
                    </h5>
                </div>

                <div style="max-height: 230px;" data-simplebar>
                    <!-- item-->
                    @foreach(DB::table('adminnotification')->where('status' , 1)->orderby('created_at' , 'desc')->limit(10)->get() as $r)
                    <a href="{{ $r->url }}" onclick="changestatusofnotifcation({{ $r->id }})" style="@if(DB::table('adminnotification')->where('id' , $r->id)->where('status' , 1)->count() > 0)background-color: aliceblue; @endif" target="_blank" class="dropdown-item notify-item">
                        <div class="notify-icon bg-primary">
                            <i class="{{ $r->icon }}"></i>
                        </div>
                        <p style="overflow: unset;text-overflow: unset;" class="notify-details">{{ $r->notification }}
                            <small class="text-muted">{{ date('d M Y, h:s a ', strtotime($r->created_at)) }}</small>
                        </p>
                    </a>
                    @endforeach
                </div>

                <!-- All-->
                <!-- <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                    View All
                </a> -->
<script type="text/javascript">
    function changestatusofnotifcation(id)
    {
        var mainurl = '{{ url("") }}';
        $.ajax({
            type: "GET",
            url: mainurl+"/changestatusofnotifcation/"+id,
            success: function(resp) {

            }
        });
    }
</script>
            </div>
        </li>
        <li class="dropdown notification-list">
            <a  class="nav-link dropdown-toggle nav-user arrow-none mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <span class="account-user-avatar">
                    <img src="{{ Auth::user()->profileimage }}" alt="user-image" class="rounded-circle">
                </span>
                <span>
                    <span class="account-user-name">{{ Auth::user()->name }}</span>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                <!-- item-->
                <div class=" dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Welcome ! {{ Auth::user()->name }}</h6>
                </div>
                <!-- item-->
                <a style="
    color: black !important;
" href="{{url('admin/profile')}}" class="dropdown-item notify-item">
                    <i class="mdi mdi-account-edit mr-1"></i>
                    <span>Settings</span>
                </a>
                <!-- item-->
                <a   href="{{ route('logout') }}" class="dropdown-item notify-item">
                    <i class="mdi mdi-logout mr-1"></i>
                    <span>Logout</span>
                </a>
            </div>
        </li>
    </ul>
        <a class="button-menu-mobile disable-btn">
            <div class="lines">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </a>
        
    </div>
</div>
<!-- end Topbar -->