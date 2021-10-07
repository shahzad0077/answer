
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

<!-- ==========Overlay========== -->
<a href="#" class="float d-lg-none">
    <label class="theme-switch" for="checkbox">
        <input type="checkbox" id="checkbox" />
        <div class="slider round"></div>
    </label>
</a>

<!-- ==========Header-Section========== -->
<header class="header-section mobile-bt-br">
    <div class="container">
        <div class="header-wrapper">
            <div class="logo">
                <a href="{{url('/')}}">
                    <img class="logo-landing-page-other-page" alt="answerout">
                </a>
            </div>
            <ul class="menu">
                <li>
                    <input value="@if(isset($search)) {{$search}} @endif" onkeyup="searchnavbar()" type="text" class="form-control search-input" placeholder="Search your answers for any question..." autocomplete="off" spellcheck="false" name="">

                    <div style="display: none;" id="livesearch">
                    </div>
                </li>

                <li>
                    <a href="{{ url('ask') }}" class="btn btn-theme-white-ask-otherpage header-btn-signin">Ask Question</a>
                </li>
                <li>
                    <a href="{{url('/categories')}}"><img width="35px;" src="{{asset('/front/assets/images/shahzad/trending.svg')}}"></a>
                </li>
                @if(Auth::check())
                <li id="hidenotification">
                    <a href="{{url('/profile/notifications')}}">@if(DB::table('usernotification')->where('users',Auth::user()->id)->where('status' , 1)->count() > 0) <span class="notify-badge">{{DB::table('usernotification')->where('users',Auth::user()->id)->where('status' , 1)->count()}}</span> @endif<img width="30px;" src="{{asset('/front/assets/images/shahzad/notification.svg')}}"></a>
                </li>

                <li style="display:none;" id="shownotification">
                    <a href="{{url('/profile/notifications')}}"><span class="notify-badge" id="showncount"></span><img width="30px;" src="{{asset('/front/assets/images/shahzad/notification.svg')}}"></a>
                </li>

                @endif

                @if(Auth::check() )
                <li class="user-profile">
                    <a href="#">
                        <img class="profile-circle-img" alt="{{ Auth::user()->name }}" src="@if(!empty(Auth::user()->profileimageupdated)) {{asset('/images/')}}/{{ Auth::user()->profileimage }} @else  {{ Auth::user()->profileimage }} @endif" />
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="{{url('/my-profile')}}">Profile</a>
                        </li>
                        <li>
                            <a href="{{url('/user/profile-settings')}}">Settings</a>
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
                    <a href="{{ url('signin') }}" class="btn btn-theme header-btn-signin mr-2">Sign In</a>
                </li>

                <li>

                    <label class="theme-switch" id="float" for="checkbox">
                        <input type="checkbox" id="checkbox" />
                        <div class="slider round"></div>
                    </label>
                </li>
                @endif
            </ul>


            @if(Auth::check() )
                <div class="row zindex-99999 d-lg-none">
                    <div class="col-2"></div>
                    <div class="col-2 col-mb-second-other">
                        <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" href="{{url('/categories')}}"><img style="margin-top:-7px" width="32px;" src="{{asset('front/assets/images/shahzad/search.svg')}}"></a>
                    </div>
                    <div class="col-2 col-mb-first-other">
                        <a href="{{url('/categories')}}"><img style="margin-top:-7px" width="32px;" src="{{asset('front/assets/images/shahzad/trending.svg')}}"></a>
                    </div>
                    <div class="col-3 col-mb-second-other">
                        <a href="{{ url('ask') }}" class="btn" id="btn-landing-btn-theme">Ask</a>
                    </div>
                    <div class="col-2 col-mb-third-other dropdown">
                        <a class="dropbtn" href="javascript:void(0)">
                            <img class="profile-circle-img-mobile" alt="{{ Auth::user()->name }}" src="@if(!empty(Auth::user()->profileimageupdated)) {{asset('/images/')}}/{{ Auth::user()->profileimage }} @else  {{ Auth::user()->profileimage }} @endif" />
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
                <!-- <div class="col-1"></div> -->
                <div class="col-2 col-mb-second-other">
                    <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" href="{{url('/categories')}}"><img style="margin-top:-7px" width="32px;" src="{{asset('front/assets/images/shahzad/search.svg')}}"></a>
                </div>
                <div class="col-2 col-mb-first-other">
                    <a href="{{url('/categories')}}"><img style="margin-top:-7px" width="32px;" src="{{asset('front/assets/images/shahzad/trending.svg')}}"></a>
                </div>
                <div class="col-3 col-mb-second-other">
                    <a href="{{ url('ask') }}" class="btn" id="btn-landing-btn-theme">Ask</a>
                </div>
                <div class="col-2">
                    <a href="{{ url('signin') }}" style="margin-left:7px;" class="btn" id="btn-landing-btn-theme">Login</a>
                </div>
              </div>


            @endif

            <div class="collapse mt-3" style="width:100%" id="collapseExample">
              <div class="row">
                <div class="col-12">

                    <div class="input-group md-form form-sm form-2 pl-0 mobile-search-collaps">
                        <input value="@if(isset($search)) {{$search}} @endif" onkeyup="searchnavbar()" style="background-color:transparent !important" class="form-control input-md my-0 py-1 amber-border main-search-navbar mobile-search-navbar" type="text" placeholder="Search your answers for any question..." aria-label="Search" autocomplete="off" spellcheck="false">
                        <div onclick="clickonsearchnavbar()" class="input-group-append" style="height: 42px;">
                          <span class="input-group-text amber search-bg-mobile" style="background-color:transparent !important;" id="basic-text1">
                            <img style="margin-right:7px" width="20px;" src="{{asset('front/assets/images/shahzad/search.svg')}}">
                        </span>
                        </div>
                    </div>
                    <div style="display: none;" id="livesearch">
                    </div>

                </div>
              </div>
            </div>
        </div>
    </div>
</header>
<script type="text/javascript">
    function clickonsearchnavbar()
    {
        var value = $('.main-search-navbar').val();
        if(value == '')
        {
            $('.main-search-navbar').focus();
        }else{
            var mainurl = '{{ url('search') }}';
            var value = $('.main-search-navbar').val();
            location.replace(mainurl+'/'+value);
        }
    }
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

<script type="text/javascript">
    function searchnavbar()
    {
        var mainurl = '{{ url('') }}';

        var value = $('.search-input').val();

        if(value == '')
        {
            $('#livesearch').hide();
        }else{
            $.ajax({
                type: "GET",
                url: mainurl+'/searchnavbar/'+value,
                success: function(resp) {
                    $('#livesearch').show();
                    $('#livesearch').html(resp);
                }
            });
        }
    }
    $(document).on('keypress',function(e) {
        if(e.which == 13) {
           var mainurl = '{{ url('search') }}';

       if($('.search-input').val() == '')
       {
            var value = $('.mobile-search-navbar').val();
        }else{
            var value = $('.search-input').val();
        }
        location.replace(mainurl+'/'+value);
        }
    });
    </script>
