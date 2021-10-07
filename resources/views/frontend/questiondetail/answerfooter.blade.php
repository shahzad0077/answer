 <style type="text/css">
     .fa{
        cursor: pointer;
     }
 </style>

 <div class="row">
     <div class="col-md-5 col-12">
         <div class="p-s-p-header-area">
            <div class="img">
                <img src="{{ Cmf::getuserdetailsbyid($user)->profileimage }}" alt="">
            </div>
            <h6 class="name">
                Answerd by <a href="{{url('user-profile')}}/{{ $r->users }}" class="text-theme">

                    {{$user}}
                </a>
            </h6>
            <!-- <span class="is-varify">
                <i class="fas fa-check"></i>
            </span> -->

        </div>
     </div>

     <div class="col-md-7 col-12 text-right mt-top-mobile">
        <span class="f-13 time-stamp-answer">{{ Cmf::create_time_ago($r->created_at) }}</span>
        @if(Auth::check())
         <span  class="hand-cursor mr-1"><b class="f-15-question" id="showanswerlike{{ $r->id }}">@if($r->likes > 0){{$r->likes}} @endif</b></span>
            @if(DB::table('answer_likes')->where('answerid' , $r->id)->where('users' , Auth::user()->username)->count() > 0)

            <img class="heart-answer" id="unlikeanswer{{$r->id}}" onclick="unlikeanswer({{$r->id}})" src="{{asset('/front/assets/images/shahzad/heart-and-stars/heart-filled.svg')}}" style="cursor: pointer;">

            <img class="heart-answer" id="likeanswer{{$r->id}}" onclick="likeanswer({{$r->id}})" src="{{asset('/front/assets/images/shahzad/heart-and-stars/heart-empty.svg')}}" style="cursor: pointer;display:none;">

            @else
                @if(Auth::user()->username != $r->users)
                    <img class="heart-answer" id="unlikeanswer{{$r->id}}" onclick="unlikeanswer({{$r->id}})" src="{{asset('/front/assets/images/shahzad/heart-and-stars/heart-filled.svg')}}" style="display:none; cursor: pointer;">

                    <img class="heart-answer" id="likeanswer{{$r->id}}" onclick="likeanswer({{$r->id}})" src="{{asset('/front/assets/images/shahzad/heart-and-stars/heart-empty.svg')}}" style="cursor: pointer;">
                @else

                <span onclick="cantlike()" class="hand-cursor"><b class="f-15-question"></b>
                    <img style="cursor: pointer;" class="heart-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/heart-empty.svg')}}">
                </span>

                @endif

            @endif
            <!-- @if($r->likes > 0)
            <span  class="hand-cursor"><b class="f-15-question" id="showanswerlike{{ $r->id }}">{{$r->likes}}</b>
            <i  class="fa fa-heart" style="font-size:20px;color: red;"></i>
            @endif -->
        @else
            @if($r->likes > 0)

            <span onclick="showlogin()" class="hand-cursor"><b class="f-15-question" id="showanswerlike{{ $r->id }}">{{$r->likes}}</b>
                <img style="cursor: pointer;" class="heart-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/heart-filled.svg')}}">

            </span>
            @else

            <span onclick="showlogin()" class="hand-cursor"><b class="f-15-question"></b>
                <img style="cursor: pointer;" class="heart-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/heart-empty.svg')}}">
            </span>
            @endif

        @endif


        @if(Auth::check())
                  @if(Auth::user()->username != $r->users)
                      <span id='stars' class="ml-2"><b class="f-15-question" id="startrattingsanswer{{$r->id}}">@if($r->rattings > 0){{ number_format($r->rattings, 1)}}@endif</b></span>

                      <span id='stars' class="ml-2"><b class="f-15-question" id="showratting{{ $r->id }}"></b></span>
                      <span id="hidestarsanswer{{ $r->id }}">
                      <?php

                          $actualratting = number_format($r->rattings, 0);

                        if($actualratting == 1){ ?>

                        <img id="answerstar-1-{{$r->id}}" onclick="starrattingsanswer(1,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">

                        <img id="answerstar-2-{{$r->id}}"  onclick="starrattingsanswer(2,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">

                        <img id="answerstar-3-{{$r->id}}"  onclick="starrattingsanswer(3,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">

                        <img id="answerstar-4-{{$r->id}}"  onclick="starrattingsanswer(4,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">

                        <img id="answerstar-5-{{$r->id}}"  onclick="starrattingsanswer(5,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">

                        <?php }elseif ($actualratting == 2){ ?>

                        <img id="answerstar-1-{{$r->id}}" onclick="starrattingsanswer(1,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">

                        <img id="answerstar-2-{{$r->id}}"  onclick="starrattingsanswer(2,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">

                        <img id="answerstar-3-{{$r->id}}"  onclick="starrattingsanswer(3,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">

                        <img id="answerstar-4-{{$r->id}}"  onclick="starrattingsanswer(4,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">

                        <img id="answerstar-5-{{$r->id}}"  onclick="starrattingsanswer(5,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">

                        <?php }elseif ($actualratting == 3){ ?>

                            <img id="answerstar-1-{{$r->id}}" onclick="starrattingsanswer(1,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">

                            <img id="answerstar-2-{{$r->id}}"  onclick="starrattingsanswer(2,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">

                            <img id="answerstar-3-{{$r->id}}"  onclick="starrattingsanswer(3,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">

                            <img id="answerstar-4-{{$r->id}}"  onclick="starrattingsanswer(4,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">

                            <img id="answerstar-5-{{$r->id}}"  onclick="starrattingsanswer(5,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">

                        <?php }elseif ($actualratting == 4){ ?>

                            <img id="answerstar-1-{{$r->id}}" onclick="starrattingsanswer(1,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">

                            <img id="answerstar-2-{{$r->id}}"  onclick="starrattingsanswer(2,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">

                            <img id="answerstar-3-{{$r->id}}"  onclick="starrattingsanswer(3,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">

                            <img id="answerstar-4-{{$r->id}}"  onclick="starrattingsanswer(4,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">

                            <img id="answerstar-5-{{$r->id}}"  onclick="starrattingsanswer(5,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">


                        <?php }elseif ($actualratting == 5){ ?>
                          <img id="answerstar-1-{{$r->id}}" onclick="starrattingsanswer(1,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">

                            <img id="answerstar-2-{{$r->id}}"  onclick="starrattingsanswer(2,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">

                            <img id="answerstar-3-{{$r->id}}"  onclick="starrattingsanswer(3,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">

                            <img id="answerstar-4-{{$r->id}}"  onclick="starrattingsanswer(4,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">

                            <img id="answerstar-5-{{$r->id}}"  onclick="starrattingsanswer(5,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">


                          <?php }elseif ($actualratting == 0){ ?>
                          <img id="answerstar-1-{{$r->id}}" onclick="starrattingsanswer(1,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">

                            <img id="answerstar-2-{{$r->id}}"  onclick="starrattingsanswer(2,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">

                            <img id="answerstar-3-{{$r->id}}"  onclick="starrattingsanswer(3,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">

                            <img id="answerstar-4-{{$r->id}}"  onclick="starrattingsanswer(4,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">

                            <img id="answerstar-5-{{$r->id}}"  onclick="starrattingsanswer(5,{{$r->id}})" class="stars-answer" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                          <?php } ?>
                    </span>
                    @if(DB::table('answer_rattings')->where('answerid' , $r->id)->count() > 0)

                      ({{DB::table('answer_rattings')->where('answerid' , $r->id)->count()}})

                      @endif
                  @else
                  @if($r->rattings > 0)
                  <span id='stars' class="ml-3"><b class="f-15-question" id="startrattingsanswer{{$r->id}}">@if($r->rattings > 0){{ number_format($r->rattings, 1)}}@endif</b></span>
                  <?php
                        $actualratting = number_format($r->rattings, 0);
                        if($actualratting == 1){ ?>
                          <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                            <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                            <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                            <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                            <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                        <?php }elseif ($actualratting == 2){ ?>
                          <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                        <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                        <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                        <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                        <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                        <?php }elseif ($actualratting == 3){ ?>
                          <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                            <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                            <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                            <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                            <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                        <?php }elseif ($actualratting == 4){ ?>
                          <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                        <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                        <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                        <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                        <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                        <?php }elseif ($actualratting == 5){ ?>
                          <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                        <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                        <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                        <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                        <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                        <?php } ?>
                        @if(DB::table('answer_rattings')->where('answerid' , $r->id)->count() > 0)

                      ({{DB::table('answer_rattings')->where('answerid' , $r->id)->count()}})

                      @endif
                      @else

                      <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                      <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                      <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                      <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                      <img class="stars-ratings-img" onclick="cantrate()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                      @if(DB::table('answer_rattings')->where('answerid' , $r->id)->count() > 0)

                      ({{DB::table('answer_rattings')->where('answerid' , $r->id)->count()}})

                      @endif
                      @endif

                  @endif
              @else
                  @if($r->rattings > 0)
                  <span id='stars' class="ml-3"><b class="f-15-question" id="startrattingsanswer{{$r->id}}">@if($r->rattings > 0){{ number_format($r->rattings, 1)}}@endif</b></span>
                  <?php
                        $actualratting = number_format($r->rattings, 0);
                        if($actualratting == 1){ ?>
                          <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                        <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                        <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                        <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                        <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                        <?php }elseif ($actualratting == 2){ ?>
                          <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                            <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                            <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                            <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                            <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                        <?php }elseif ($actualratting == 3){ ?>
                          <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                        <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                        <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                        <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                        <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                        <?php }elseif ($actualratting == 4){ ?>
                          <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                        <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                        <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                        <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                        <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                        <?php }elseif ($actualratting == 5){ ?>
                          <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                        <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                        <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                        <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                        <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}">
                        <?php } ?>

                        @if(DB::table('answer_rattings')->where('answerid' , $r->id)->count() > 0)

                          ({{DB::table('answer_rattings')->where('answerid' , $r->id)->count()}})

                          @endif
                      @else


                      <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                      <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                      <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                      <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">
                      <img class="stars-ratings-img" onclick="showlogin()" src="{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}">

                      @if(DB::table('answer_rattings')->where('answerid' , $r->id)->count() > 0)

                      ({{DB::table('answer_rattings')->where('answerid' , $r->id)->count()}})

                      @endif
                      @endif

              @endif

     </div>

 </div>
<script type="text/javascript">
    function starrattingsanswer(id,answerid)
    {

        if(id == 1)
        {
            $('#hidestarsanswer'+answerid).html("<img class='stars-answer ml-1 pointer' id='answerstar-1-"+answerid+"' onclick='starrattingsanswer(1,"+answerid+")' width='25px' src='{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}'><img class='stars-answer ml-1 pointer' id='answerstar-2-"+answerid+"' onclick='starrattingsanswer(2,"+answerid+")' width='25px' src='{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}'><img class='stars-answer ml-1 pointer' id='answerstar-3-"+answerid+"' onclick='starrattingsanswer(3,"+answerid+")' width='25px' src='{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}'><img class='stars-answer ml-1 pointer' id='answerstar-4-"+answerid+"' onclick='starrattingsanswer(4,"+answerid+")' width='25px' src='{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}'><img class='stars-answer ml-1 pointer' id='answerstar-5-"+answerid+"' onclick='starrattingsanswer(5,"+answerid+")' width='25px' src='{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}'>")
        }

        if(id == 2)
        {
            $('#hidestarsanswer'+answerid).html("<img class='stars-answer ml-1 pointer' id='answerstar-1-"+answerid+"' onclick='starrattingsanswer(1,"+answerid+")' width='25px' src='{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}'><img class='stars-answer ml-1 pointer' id='answerstar-2-"+answerid+"' onclick='starrattingsanswer(2,"+answerid+")' width='25px' src='{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}'><img class='stars-answer ml-1 pointer' id='answerstar-3-"+answerid+"' onclick='starrattingsanswer(3,"+answerid+")' width='25px' src='{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}'><img class='stars-answer ml-1 pointer' id='answerstar-4-"+answerid+"' onclick='starrattingsanswer(4,"+answerid+")' width='25px' src='{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}'><img class='stars-answer ml-1 pointer' id='answerstar-5-"+answerid+"' onclick='starrattingsanswer(5,"+answerid+")' width='25px' src='{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}'>")
        }
        if(id == 3)
        {
            $('#hidestarsanswer'+answerid).html("<img class='stars-answer ml-1 pointer' id='answerstar-1-"+answerid+"' onclick='starrattingsanswer(1,"+answerid+")' width='25px' src='{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}'><img class='stars-answer ml-1 pointer' id='answerstar-2-"+answerid+"' onclick='starrattingsanswer(2,"+answerid+")' width='25px' src='{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}'><img class='stars-answer ml-1 pointer' id='answerstar-3-"+answerid+"' onclick='starrattingsanswer(3,"+answerid+")' width='25px' src='{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}'><img class='stars-answer ml-1 pointer' id='answerstar-4-"+answerid+"' onclick='starrattingsanswer(4,"+answerid+")' width='25px' src='{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}'><img class='stars-answer ml-1 pointer' id='answerstar-5-"+answerid+"' onclick='starrattingsanswer(5,"+answerid+")' width='25px' src='{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}'>")
        }
        if(id == 4)
        {
            $('#hidestarsanswer'+answerid).html("<img class='stars-answer ml-1 pointer' id='answerstar-1-"+answerid+"' onclick='starrattingsanswer(1,"+answerid+")' width='25px' src='{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}'><img class='stars-answer ml-1 pointer' id='answerstar-2-"+answerid+"' onclick='starrattingsanswer(2,"+answerid+")' width='25px' src='{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}'><img class='stars-answer ml-1 pointer' id='answerstar-3-"+answerid+"' onclick='starrattingsanswer(3,"+answerid+")' width='25px' src='{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}'><img class='stars-answer ml-1 pointer' id='answerstar-4-"+answerid+"' onclick='starrattingsanswer(4,"+answerid+")' width='25px' src='{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}'><img class='stars-answer ml-1 pointer' id='answerstar-5-"+answerid+"' onclick='starrattingsanswer(5,"+answerid+")' width='25px' src='{{asset('/front/assets/images/shahzad/heart-and-stars/star-empty.svg')}}'>")
        }
        if(id == 5)
        {
            $('#hidestarsanswer'+answerid).html("<img class='stars-answer ml-1 pointer' id='answerstar-1-"+answerid+"' onclick='starrattingsanswer(1,"+answerid+")' width='25px' src='{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}'><img class='stars-answer ml-1 pointer' id='answerstar-2-"+answerid+"' onclick='starrattingsanswer(2,"+answerid+")' width='25px' src='{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}'><img class='stars-answer ml-1 pointer' id='answerstar-3-"+answerid+"' onclick='starrattingsanswer(3,"+answerid+")' width='25px' src='{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}'><img class='stars-answer ml-1 pointer' id='answerstar-4-"+answerid+"' onclick='starrattingsanswer(4,"+answerid+")' width='25px' src='{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}'><img class='stars-answer ml-1 pointer' id='answerstar-5-"+answerid+"' onclick='starrattingsanswer(5,"+answerid+")' width='25px' src='{{asset('/front/assets/images/shahzad/heart-and-stars/star-filled.svg')}}'>")
        }
        var mainurl = '{{ url('') }}';
         $.ajax({
            type: "GET",
            url: mainurl+'/answerratting/'+id+'/'+answerid,
            success: function(resp) {

                $('#startrattingsanswer'+answerid).hide();
                 $('#showratting'+answerid).html(resp);
            }
        });
    }

    function likeanswer(id)
    {
        var mainurl = '{{ url('') }}';
         $.ajax({
            type: "GET",
            url: mainurl+'/likeanswer/'+id,
            success: function(resp) {
                $('#likeanswer'+id).hide();
                $('#unlikeanswer'+id).show();
                $('#showanswerlike'+id).html(resp);
                $.toast({
                    heading: 'Liked',
                    text: 'You Like This Answer',
                    position: 'top-right',
                    icon: 'info',
                    stack: false
                })
            }
        });
    }
    function unlikeanswer(id)
    {
        var mainurl = '{{ url('') }}';
         $.ajax({
            type: "GET",
            url: mainurl+'/unlikeanswer/'+id,
            success: function(resp) {
                $('#likeanswer'+id).show();
                $('#unlikeanswer'+id).hide();
                $('#showanswerlike'+id).html(resp);
                $.toast({
                    heading: 'DisLike',
                    text: 'You DisLike This Answer',
                    position: 'top-right',
                    icon: 'info',
                    stack: false
                })
            }
        });
    }
    function showlogin()
    {
        $('#loginmodal').modal({backdrop: 'static', keyboard: false});
    }
    function cantrate()
    {
        $('#cantrate').modal({backdrop: 'static', keyboard: false});
    }
    function cantlike()
    {
        $('#cantlike').modal({backdrop: 'static', keyboard: false});
    }


</script>


<script type="text/javascript">
    $(document).ready(function(){
        $('.rating ul li').on('click', function() {

    let li = $(this),
        ul = li.parent(),
        rating = ul.parent(),
        last = ul.find('.current');

    if(!rating.hasClass('animate-left') && !rating.hasClass('animate-right')) {

        last.removeClass('current');

        ul.children('li').each(function() {
            let current = $(this);
            current.toggleClass('active', li.index() > current.index());
        });

        rating.addClass(li.index() > last.index() ? 'animate-right' : 'animate-left');
        rating.css({
            '--x': li.position().left + 'px'
        });
        li.addClass('move-to');
        last.addClass('move-from');

        setTimeout(() => {
            li.addClass('current');
            li.removeClass('move-to');
            last.removeClass('move-from');
            rating.removeClass('animate-left animate-right');
        }, 800);

    }

})

    });
</script>


<!-- The Modal -->
<div class="modal fade" id="cantrate">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <a type="button" class="close" data-dismiss="modal">&times;</a>
      </div>
      <div class="modal-body">
        <section class="">
            <div class="container">
              <div class="row justify-content-end">
                <div class="col-lg-12">
                  <div class="align-items-center">
                        <h4>You can't Rate this answer because you are the owner of this answer</h4>
                  </div>
                </div>
              </div>
            </div>
          </section>
      </div>
    </div>
  </div>
</div>
<!-- The Modal -->
<div class="modal fade" id="cantlike">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <a type="button" class="close" data-dismiss="modal">&times;</a>
      </div>
      <div class="modal-body">
        <section class="">
            <div class="container">
              <div class="row justify-content-end">
                <div class="col-lg-12">
                  <div class="align-items-center">
                        <h4>You can't Like this answer because you are the owner of this answer</h4>
                  </div>
                </div>
              </div>
            </div>
          </section>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="loginmodal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <a type="button" class="close" data-dismiss="modal">&times;</a>
      </div>
      <div class="modal-body">
    <section class="">
        <div class="container">
          <div class="row justify-content-end">
            <div class="col-lg-12">
              <div class="align-items-center">
                <div class="row align-items-center">
                  <div class="col-lg-10 offset-md-1">
                    <div class="row mb-5">
                      <div class="col-lg-12 text-center">
                        <!-- Logo -->
                        <a href="{{url('/')}}">
                            <img class="logo-landing-page" id="logo-modal" alt="answerout">
                        </a>
                      </div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-lg-12 col-md-12">
                        <a href="{{ url('auth/google') }}" class="btn btn-primary btn-google"><img src="{{asset('/front/assets/images/shahzad/google-icon.svg')}}"> Log in with Google</a>
                      </div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-lg-12 col-md-12">
                        <a href="{{ url('auth/facebook') }}" class="btn btn-primary btn-google"><img src="{{asset('/front/assets/images/shahzad/facebook-icon.svg')}}"> Log in with Facebook</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
          </div>
        </div>
      </div>
</div>
