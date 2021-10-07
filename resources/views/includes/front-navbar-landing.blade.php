
<!-- <div class="preloader">
    <div class="preloader-inner">
        <div class="preloader-icon">
            <span></span>
            <span></span>
        </div>
    </div>
</div> -->
<!-- ==========Preloader========== -->
<!-- ==========Overlay========== -->
<div class="overlay"></div>
<a href="#" class="scrollToTop">
    <i class="fas fa-angle-up"></i>
</a>
<!-- ==========Overlay========== -->

<!-- ==========Header-Section========== -->
<header class="header-section bg-theme">
    <div class="container">
        <div class="header-wrapper">
            <div class="logo logo-landing">
                <a href="{{url('/')}}">
                    <img class="logo-landing-page" alt="answerout">
                </a>
            </div>
            <ul class="menu">

              <li>
                  <a  href="{{ url('contact-us') }}" class="btn contact-us-img header-btn-signin">
                    Contact Us
                  </a>
              </li>

              <li>
                  <a  href="{{ url('categories/') }}" class="mr-01">
                    <img width="36px" class="mobile-categories-icon" alt="">
                  </a>
              </li>


                <li>
                    <a  href="{{ url('ask') }}" class="btn btn-theme-white-ask header-btn-signin mr-10">Ask Question</a>
                </li>

               <!--  @if(Auth::check())
                <li id="hidenotification">
                    <a href="{{url('/profile/notifications')}}">@if(DB::table('usernotification')->where('users',Auth::user()->id)->where('status' , 1)->count() > 0) <span class="notify-badge">{{DB::table('usernotification')->where('users',Auth::user()->id)->where('status' , 1)->count()}}</span> @endif<img width="30px;" src="{{asset('public/front/assets/images/shahzad/notification.svg')}}"></a>
                </li>

                <li style="display:none;" id="shownotification">
                    <a href="{{url('/profile/notifications')}}"><span class="notify-badge" id="showncount"></span><img width="30px;" src="{{asset('public/front/assets/images/shahzad/notification.svg')}}"></a>
                </li>

                @endif -->

                @if(Auth::check() )
                <li class="user-profile">
                    <a class="mr-0 pl-0" href="#">
                        <img class="profile-circle-img" alt="{{ Auth::user()->name }}" src="@if(!empty(Auth::user()->profileimageupdated)) {{asset('public/images/')}}/{{ Auth::user()->profileimage }} @else  {{ Auth::user()->profileimage }} @endif" />
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="{{url('/my-profile')}}">Profile</a>
                        </li>
                        <li>
                            <a class="dropdown-item"  href="{{ route('logout') }}">Sign out</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <label class="theme-switch" for="checkbox">
                        <input type="checkbox" id="checkbox" />
                        <div class="slider round"></div>
                    </label>
                </li>
                @else

                <li>
                    <a href="{{ url('signup') }}" class="btn btn-theme-white header-btn-signin mr-10">Sign Up</a>
                </li>

                <li>
                    <a href="{{ url('signin') }}" class="btn btn-theme-white header-btn-signin mr-10">Sign In</a>
                </li>

                <li>

                    <label class="theme-switch" for="checkbox">
                        <input type="checkbox" id="checkbox" />
                        <div class="slider round"></div>
                    </label>
                </li>
                @endif
            </ul>

            @if(Auth::check() )
                <div class="row zindex-99999 d-lg-none">
                    <div class="col-1"></div>
                    <div class="col-3 col-mb-first">
                        <a href="{{url('/categories')}}"><img class="mobile-categories-icon" style="margin-top:-7px" width="32px;" id="explore-icon"></a>
                    </div>
                    <div class="col-4 col-mb-second">
                        <a href="{{ url('ask') }}" class="btn" id="btn-landing-btn">Ask</a>
                    </div>
                    <div class="col-2 col-mb-third dropdown">
                        <a class="dropbtn" href="javascript:void(0)">
                            <img class="profile-circle-img-mobile" alt="{{ Auth::user()->name }}" src="@if(!empty(Auth::user()->profileimageupdated)) {{asset('public/images/')}}/{{ Auth::user()->profileimage }} @else  {{ Auth::user()->profileimage }} @endif" />
                        </a>
                        <div class="dropdown-content">
                            <a href="{{url('/my-profile')}}">Profile</a>
                            <a href="{{url('/user/profile-settings')}}">Settings</a>
                            <a class="dropdown-item"  href="{{ route('logout') }}">Sign out</a>
                        </div>
                    </div>
                </div>
            @else


                <div class="row zindex-99999 d-lg-none">
                    <div class="col-2 offset-1 col-mb-one-icon">
                        <a href="{{url('/categories')}}"><img class="mobile-categories-icon" width="32px;"></a>
                    </div>
                    <div class="col-4">
                        <a href="{{ url('ask') }}" class="btn" id="btn-landing-btn">Ask</a>
                    </div>
                    <div class="col-2">
                        <a href="{{ url('signin') }}" class="btn" id="btn-landing-btn">Login</a>
                    </div>
                </div>

            @endif


        </div>
    </div>
</header>


@if(Auth::check())
<script type="text/javascript">
    $( document ).ready(function() {
        getnotification();
    });
    function getnotification()
    {
        setTimeout(function(){
            sendajaxcall();
        }, 5000);
    }
    function sendajaxcall()
    {
        var mainurl = '{{ url('') }}';
        var id = 1;
        $.ajax({
            type: "GET",
            url: mainurl+'/getnotification/'+id,
            success: function(resp) {
                if(resp > 0)
                {
                    $('#hidenotification').hide();
                    $('#shownotification').show();
                    $('#showncount').html(resp);
                }
            getnotification();
            }
        });
    }
</script>
@endif
