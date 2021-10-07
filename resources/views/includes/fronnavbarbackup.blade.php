
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- ==========Preloader========== -->
    <!-- ==========Overlay========== -->
    <div class="overlay"></div>
    <a href="#" class="scrollToTop">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- ==========Overlay========== -->

    <!-- ==========Header-Section========== -->
    <header class="header-section">
        <div class="container">
            <div class="header-wrapper">
                <div class="logo">
                    <a href="{{url('/')}}">
                        <img src="{{ url('/images') }}/{!! Cmf::site_settings('logo_front') !!}" width="100" alt="logo">
                    </a>
                </div>
                <ul class="menu">
                    <li>
                        <input type="text" class="form-control search-input typeahead tt-query" placeholder="Search your answers for any question..." autocomplete="off" spellcheck="false" name="">
                    </li>
                    @if(Auth::check() )
                    <li>
                        <a href="{{url('/ask')}}}" class="btn btn-theme">ASK QUESTION</a>
                    </li>
                    @else
                    <li>
                        <a href="{{ url('signin') }}" class="btn btn-theme">Sign In</a>
                    </li>
                    @endif
                    <li class="d-xs-block">
                        <div class="serch-icon">
                            <i class="fas fa-bell text-theme"></i>
                        </div>
                    </li>
                    @if(Auth::check() )
                    <li class="user-profile">
                        <a href="{{url('/my-profile')}}">
                            <img style=" border-radius: 50px; height: 45px; width: 45px; " alt="{{ Auth::user()->name }}" src="@if(!empty(Auth::user()->profileimageupdated)) {{asset('/images/')}}/{{ Auth::user()->profileimage }} @else  {{ Auth::user()->profileimage }} @endif" />
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
                    @endif
                </ul>
                <div class="header-bar d-lg-none">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </header>