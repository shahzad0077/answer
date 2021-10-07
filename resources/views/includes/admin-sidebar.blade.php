<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu left-side-menu-detached">

    <div class="leftbar-user">
        <a href="javascript: void(0);">
            <div class="account-user-avatar">
                <img src="{{ Auth::user()->profileimage }}" alt="user-image" height="42" class="rounded-circle">
            </div>
            <span class="leftbar-user-name">{{ Auth::user()->name }}</span>
        </a>
    </div>

    <!--- Sidemenu -->
    <ul class="metismenu side-nav">
        <li class="side-nav-title side-nav-item">Navigation</li>
        @foreach(DB::table('adminmodulesparent')->get() as $r)
            @php 
                $child = DB::table('adminmoduleschild')->where('adminmodulesparent' , $r->id);
            @endphp
            @if(Cmf::checkuserrolparent($r->id) > 0)
                <li class="side-nav-item">
                    <a href="@if($child->count() > 0)javascript: void(0);@else {{url('admin')}}/{{ $r->url }}@endif" class="side-nav-link">
                        <i class="{{ $r->icon }}"></i>
                        @if(!empty($r->counter))
                        <span class="badge badge-info badge-pill float-right" style=" margin-right: -3px; ">{{ DB::table($r->counter)->where('status', 1)->count() }}</span>
                        @endif
                        <span> {{ $r->modulename }} </span>
                        @if($child->count() > 0)
                        <span class="menu-arrow"></span>
                        @endif
                    </a>
                    @if($child->count() > 0)
                    <ul class="side-nav-second-level" aria-expanded="false">
                        @foreach($child->get() as $c)
                            @if(Cmf::checkuserrolchild($c->id) > 0)
                                @if(DB::table('checkcounter')->where('childid' , $c->id)->count() > 0)
                                    <li>
                                        <a href="{{url('admin')}}/{{ $c->url }}">{{ $c->name }}<span class="badge badge-info badge-pill float-right" style=" margin-right: -3px; ">{{ DB::table($c->counter)->where('newstatus', 'new')->count() }}</span></a>
                                        
                                    </li>
                                @else
                                    <li>
                                        <a href="{{url('admin')}}/{{ $c->url }}">{{ $c->name }}</a>
                                    </li>
                                @endif
                            @endif
                            
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endif
        @endforeach
    </ul>

</div>
<!-- Left Sidebar End -->