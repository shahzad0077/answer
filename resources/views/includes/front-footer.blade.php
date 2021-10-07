
    <!-- Banner Section Ends -->

    <footer class="footer-section" id="footer">
        <div class="container-fluid footer-shadow">
            <div class="row">
                <div class="col-lg-6 d-sm-block">
                    <div class="container-fluid bg-light">
                      <div class="row">
                        <div class="col-lg-12 p-0">
                          <div class="alert alert-default info-banner">
                            <div class="row">
                              <div class="col-md-12">
                                <h4 class="mb-3">Jammed at a difficult <br> question?</h4>
                                <p>Don't worry. We've got your back. Every Person we meet knows something we don't.  <br> ask us maybe we know.</p>
                              </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12 text-center">
                                <a href="{{url('/ask')}}" class="btn btn-theme-dark"><b><i>ASK QUESTION</i></b></a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="footer-links">
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 mb-5 mobile-mb">
                                <div class="link-wrapper one">
                                    <h4 class="f-l-title mb-3">
                                        ASK US MAY BE WE KNOW
                                    </h4>
                                    <p>{!! Cmf::site_settings('footer_text') !!}</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 mb-5 mobile-mb">
                                <div class="link-wrapper two">
                                    <h4 class="f-l-title mb-3">
                                        Policies
                                    </h4>
                                    <ul class="f-solial-links">
                                        @foreach(DB::table('dynamicpages')->where('show_on_footer' , 'Yes')->where('delete_status' , 'Active')->where('visible_status' , 'Published')->where('show_bellow' , 'Policy')->orderby('visible_order' , 'asc')->get() as $r)
                                        <li>
                                            <a href="{{url('')}}/{{ $r->slug }}">
                                                {{ $r->name }}
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <div class="link-wrapper three">
                                    <h4 class="f-l-title mb-3">
                                        Guidelines
                                    </h4>
                                    <ul class="f-solial-links">
                                         @foreach(DB::table('dynamicpages')->where('show_on_footer' , 'Yes')->where('delete_status' , 'Active')->where('visible_status' , 'Published')->where('show_bellow' , 'Guideline')->orderby('visible_order' , 'asc')->get() as $r)
                                        <li>
                                            <a href="{{url('')}}/{{ $r->slug }}">
                                                {{ $r->name }}
                                            </a>
                                        </li>
                                        @endforeach
                                         <!-- @foreach(DB::table('dynamicpages')->where('delete_status' , 'Active')->where('visible_status' , 'Published')->where('slug' , 'content-guidelines')->get() as $r)
                                        <li>
                                            <a href="{{url('')}}/{{ $r->slug }}">
                                                {{ $r->name }}
                                            </a>
                                        </li>
                                        @endforeach -->
                                        <li>
                                            <a href="{{url('/expert')}}">
                                                Become an Expert
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <div class="link-wrapper four">
                                    <h4 class="f-l-title mb-3">
                                        Help
                                    </h4>
                                    <ul class="f-solial-links">
                                        <li>
                                            <a href="{{ url('signup') }}">
                                                Signup
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('blogs') }}">
                                                Blogs
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('contact-us') }}">
                                                Contact us
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('advertise-with-us') }}">
                                                Advertise with us
                                            </a>
                                        </li>
                                        @foreach(DB::table('dynamicpages')->where('show_on_footer' , 'Yes')->where('delete_status' , 'Active')->where('visible_status' , 'Published')->where('show_bellow' , 'Help')->orderby('visible_order' , 'asc')->get() as $r)
                                        <li>
                                            <a href="{{url('')}}/{{ $r->slug }}">
                                                {{ $r->name }}
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-sm-none">
                    <div class="container-fluid bg-light">
                      <div class="row">
                        <div class="col-lg-12 p-0">
                          <div class="alert alert-default info-banner">
                            <div class="row">
                              <div class="col-md-12">
                                <h4 class="mb-3">Jammed at a difficult <br> question?</h4>
                                <p>Don't worry. We've got your back. Every Person we meet knows something we don't.  <br> ask us maybe we know.</p>
                              </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12 text-center">
                                <a href="{{url('/ask')}}" class="btn btn-theme-dark"><b><i>ASK QUESTION</i></b></a>
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="copyright-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <hr class="hr2">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <h6>Find us on these platforms</h6>
                        <!-- <ul class="footer-social-links">
                            <li>
                                <a href="{!! Cmf::site_settings('instagram_link') !!}">
                                    <img width="24px" src="{{ url('/front/assets/images/shahzad/instagram.svg') }}">
                                </a>
                            </li>
                            <li>
                                <a href="{!! Cmf::site_settings('facebook_link') !!}">
                                    <img width="24px" src="{{ url('/front/assets/images/shahzad/facebook.svg') }}">
                                </a>
                            </li>
                            <li>
                                <a href="{!! Cmf::site_settings('twitter_link') !!}">
                                    <img width="24px" src="{{ url('/front/assets/images/shahzad/twitter.svg') }}">
                                </a>
                            </li>
                            <li>
                                <a href="{!! Cmf::site_settings('linkdlin_link') !!}">
                                    <img width="24px" src="{{ url('/front/assets/images/shahzad/linkedin.svg') }}">
                                </a>
                            </li>
                            <li>
                                <a href="{!! Cmf::site_settings('pintrest_link') !!}">
                                    <img width="24px" src="{{ url('/front/assets/images/shahzad/pintrest.svg') }}">
                                </a>
                            </li>
                            <li>
                                <a href="{!! Cmf::site_settings('youtube_link') !!}">
                                    <img width="24px" src="{{ url('/front/assets/images/shahzad/youtubeicon.png') }}">
                                </a>
                            </li>


                        </ul> -->
                    </div>
                    <div class="col-lg-8 align-self-center">
                        <div class="copyr-text">
                            <span>
                                <b>Copyright © 2021.All Rights Reserved By</b>
                            </span>
                            <a href="{{url('')}}"><b><i class="theme-text">answerout</i></b></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </footer>
  <!-- footer Ends -->
