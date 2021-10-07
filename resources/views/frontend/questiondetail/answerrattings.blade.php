
        @if(Auth::check())
                <span id='stars' class="ml-3"><b class="f-15-question" id="startrattingsanswer{{$r->id}}">@if($r->rattings > 0){{ number_format($r->rattings, 1)}}@endif</b></span> 



                @if(DB::table('answer_rattings')->where('answerid' , $r->id)->where('users' , Auth::user()->id)->count() > 0)


                <?php 

                    $actualratting = number_format($r->rattings, 0);

                  if($actualratting == 1){ ?>
                    <i id="answerstar-1-{{$r->id}}"  onclick="starrattingsanswer(1,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-2-{{$r->id}}"  onclick="starrattingsanswer(2,{{$r->id}})" class="fa fa-star-o "></i>
                    <i id="answerstar-3-{{$r->id}}"  onclick="starrattingsanswer(3,{{$r->id}})" class="fa fa-star-o "></i>
                    <i id="answerstar-4-{{$r->id}}"  onclick="starrattingsanswer(4,{{$r->id}})" class="fa fa-star-o "></i>
                    <i id="answerstar-5-{{$r->id}}"  onclick="starrattingsanswer(5,{{$r->id}})" class="fa fa-star-o "></i>
                  <?php }elseif ($actualratting == 2){ ?>
                    <i id="answerstar-1-{{$r->id}}"  onclick="starrattingsanswer(1,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-2-{{$r->id}}"  onclick="starrattingsanswer(2,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-3-{{$r->id}}"  onclick="starrattingsanswer(3,{{$r->id}})" class="fa fa-star-o "></i>
                    <i id="answerstar-4-{{$r->id}}"  onclick="starrattingsanswer(4,{{$r->id}})" class="fa fa-star-o "></i>
                    <i id="answerstar-5-{{$r->id}}"  onclick="starrattingsanswer(5,{{$r->id}})" class="fa fa-star-o "></i>
                  <?php }elseif ($actualratting == 3){ ?>
                    <i id="answerstar-1-{{$r->id}}"  onclick="starrattingsanswer(1,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-2-{{$r->id}}"  onclick="starrattingsanswer(2,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-3-{{$r->id}}"  onclick="starrattingsanswer(3,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-4-{{$r->id}}"  onclick="starrattingsanswer(4,{{$r->id}})" class="fa fa-star-o "></i>
                    <i id="answerstar-5-{{$r->id}}"  onclick="starrattingsanswer(5,{{$r->id}})" class="fa fa-star-o "></i>
                  <?php }elseif ($actualratting == 4){ ?>
                    <i id="answerstar-1-{{$r->id}}"  onclick="starrattingsanswer(1,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-2-{{$r->id}}"  onclick="starrattingsanswer(2,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-3-{{$r->id}}"  onclick="starrattingsanswer(3,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-4-{{$r->id}}"  onclick="starrattingsanswer(4,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-5-{{$r->id}}"  onclick="starrattingsanswer(5,{{$r->id}})" class="fa fa-star-o "></i>
                  <?php }elseif ($actualratting == 5){ ?>
                    <i id="answerstar-1-{{$r->id}}"  onclick="starrattingsanswer(1,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-2-{{$r->id}}"  onclick="starrattingsanswer(2,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-3-{{$r->id}}"  onclick="starrattingsanswer(3,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-4-{{$r->id}}"  onclick="starrattingsanswer(4,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-5-{{$r->id}}"  onclick="starrattingsanswer(5,{{$r->id}})" class="fa fa-star staractive"></i>
                  <?php } ?>
                @else
                    @if(DB::table('answer_likes')->where('answerid' , $r->id)->where('users' , Auth::user()->username)->count() == 0)
                    <span id='stars' class="ml-3"><b class="f-15-question" id="showratting{{ $r->id }}"></b></span> 
                    <span id="hidestarsanswer{{ $r->id }}">
                        <i id="answerstar-1-{{$r->id}}"  onclick="starrattingsanswer(1,{{$r->id}})" class='fa fa-star-o'></i>
                        <i id="answerstar-2-{{$r->id}}"  onclick="starrattingsanswer(2,{{$r->id}})" class='fa fa-star-o'></i>
                        <i id="answerstar-3-{{$r->id}}"  onclick="starrattingsanswer(3,{{$r->id}})" class='fa fa-star-o'></i>
                        <i id="answerstar-4-{{$r->id}}"  onclick="starrattingsanswer(4,{{$r->id}})" class='fa fa-star-o'></i>
                        <i id="answerstar-5-{{$r->id}}"  onclick="starrattingsanswer(5,{{$r->id}})" class='fa fa-star-o'></i>
                    </span>
                    @endif
                @endif
            @else
            <span id='stars' class="ml-3"><b class="f-15-question" id="startrattingsanswer{{$r->id}}">@if($r->rattings > 0){{ number_format($r->rattings, 1)}}@endif</b></span> 
            <?php 

            
                  $actualratting = number_format($r->rattings, 0);

                  if($actualratting == 1){ ?>
                    <i id="answerstar-1-{{$r->id}}"  onclick="starrattingsanswer(1,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-2-{{$r->id}}"  onclick="starrattingsanswer(2,{{$r->id}})" class="fa fa-star-o "></i>
                    <i id="answerstar-3-{{$r->id}}"  onclick="starrattingsanswer(3,{{$r->id}})" class="fa fa-star-o "></i>
                    <i id="answerstar-4-{{$r->id}}"  onclick="starrattingsanswer(4,{{$r->id}})" class="fa fa-star-o "></i>
                    <i id="answerstar-5-{{$r->id}}"  onclick="starrattingsanswer(5,{{$r->id}})" class="fa fa-star-o "></i>
                  <?php }elseif ($actualratting == 2){ ?>
                    <i id="answerstar-1-{{$r->id}}"  onclick="starrattingsanswer(1,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-2-{{$r->id}}"  onclick="starrattingsanswer(2,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-3-{{$r->id}}"  onclick="starrattingsanswer(3,{{$r->id}})" class="fa fa-star-o "></i>
                    <i id="answerstar-4-{{$r->id}}"  onclick="starrattingsanswer(4,{{$r->id}})" class="fa fa-star-o "></i>
                    <i id="answerstar-5-{{$r->id}}"  onclick="starrattingsanswer(5,{{$r->id}})" class="fa fa-star-o "></i>
                  <?php }elseif ($actualratting == 3){ ?>
                    <i id="answerstar-1-{{$r->id}}"  onclick="starrattingsanswer(1,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-2-{{$r->id}}"  onclick="starrattingsanswer(2,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-3-{{$r->id}}"  onclick="starrattingsanswer(3,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-4-{{$r->id}}"  onclick="starrattingsanswer(4,{{$r->id}})" class="fa fa-star-o "></i>
                    <i id="answerstar-5-{{$r->id}}"  onclick="starrattingsanswer(5,{{$r->id}})" class="fa fa-star-o "></i>
                  <?php }elseif ($actualratting == 4){ ?>
                    <i id="answerstar-1-{{$r->id}}"  onclick="starrattingsanswer(1,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-2-{{$r->id}}"  onclick="starrattingsanswer(2,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-3-{{$r->id}}"  onclick="starrattingsanswer(3,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-4-{{$r->id}}"  onclick="starrattingsanswer(4,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-5-{{$r->id}}"  onclick="starrattingsanswer(5,{{$r->id}})" class="fa fa-star-o "></i>
                  <?php }elseif ($actualratting == 5){ ?>
                    <i id="answerstar-1-{{$r->id}}"  onclick="starrattingsanswer(1,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-2-{{$r->id}}"  onclick="starrattingsanswer(2,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-3-{{$r->id}}"  onclick="starrattingsanswer(3,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-4-{{$r->id}}"  onclick="starrattingsanswer(4,{{$r->id}})" class="fa fa-star staractive"></i>
                    <i id="answerstar-5-{{$r->id}}"  onclick="starrattingsanswer(5,{{$r->id}})" class="fa fa-star staractive"></i>
                  <?php } ?>

        @endif 
        </span>
    </div>
</div>
<script type="text/javascript">
    function starrattingsanswer(id,answerid)
    {

        if(id == 1)
        {
            $('#hidestarsanswer'+answerid).html("<i id='answerstar-1-{{$r->id}}'  onclick='starrattingsanswer(1,{{$r->id}})' style='padding-right:5px;' class='fa fa-star staractive'></i><i id='answerstar-2-{{$r->id}}'  onclick='starrattingsanswer(2,{{$r->id}})' style='padding-right:5px;' class='fa fa-star-o'></i><i id='answerstar-3-{{$r->id}}'  onclick='starrattingsanswer(3,{{$r->id}})' style='padding-right:5px;' class='fa fa-star-o'></i><i id='answerstar-4-{{$r->id}}'  onclick='starrattingsanswer(4,{{$r->id}})' style='padding-right:5px;' class='fa fa-star-o'></i><i id='answerstar-5-{{$r->id}}'  onclick='starrattingsanswer(5,{{$r->id}})' class='fa fa-star-o'></i>")
        }

        if(id == 2)
        {
            $('#hidestarsanswer'+answerid).html("<i id='answerstar-1-{{$r->id}}'  onclick='starrattingsanswer(1,{{$r->id}})' style='padding-right:5px;' class='fa fa-star staractive'></i><i id='answerstar-2-{{$r->id}}'  onclick='starrattingsanswer(2,{{$r->id}})' style='padding-right:5px;' class='fa fa-star staractive'></i><i id='answerstar-3-{{$r->id}}'  onclick='starrattingsanswer(3,{{$r->id}})' style='padding-right:5px;' class='fa fa-star-o'></i><i id='answerstar-4-{{$r->id}}'  onclick='starrattingsanswer(4,{{$r->id}})' style='padding-right:5px;' class='fa fa-star-o'></i><i id='answerstar-5-{{$r->id}}'  onclick='starrattingsanswer(5,{{$r->id}})' class='fa fa-star-o'></i>")
        }
        if(id == 3)
        {
            $('#hidestarsanswer'+answerid).html("<i id='answerstar-1-{{$r->id}}'  onclick='starrattingsanswer(1,{{$r->id}})' style='padding-right:5px;' class='fa fa-star staractive'></i><i id='answerstar-2-{{$r->id}}'  onclick='starrattingsanswer(2,{{$r->id}})' style='padding-right:5px;' class='fa fa-star staractive'></i><i id='answerstar-3-{{$r->id}}'  onclick='starrattingsanswer(3,{{$r->id}})' style='padding-right:5px;' class='fa fa-star staractive'></i><i id='answerstar-4-{{$r->id}}'  onclick='starrattingsanswer(4,{{$r->id}})' style='padding-right:5px;' class='fa fa-star-o'></i><i id='answerstar-5-{{$r->id}}'  onclick='starrattingsanswer(5,{{$r->id}})' class='fa fa-star-o'></i>")
        }
        if(id == 4)
        {
            $('#hidestarsanswer'+answerid).html("<i id='answerstar-1-{{$r->id}}'  onclick='starrattingsanswer(1,{{$r->id}})' style='padding-right:5px;' class='fa fa-star staractive'></i><i id='answerstar-2-{{$r->id}}'  onclick='starrattingsanswer(2,{{$r->id}})' style='padding-right:5px;' class='fa fa-star staractive'></i><i id='answerstar-3-{{$r->id}}'  onclick='starrattingsanswer(3,{{$r->id}})' style='padding-right:5px;' class='fa fa-star staractive'></i><i id='answerstar-4-{{$r->id}}'  onclick='starrattingsanswer(4,{{$r->id}})' style='padding-right:5px;' class='fa fa-star staractive'></i><i id='answerstar-5-{{$r->id}}'  onclick='starrattingsanswer(5,{{$r->id}})' class='fa fa-star-o'></i>")
        }
        if(id == 5)
        {
            $('#hidestarsanswer'+answerid).html("<i id='answerstar-1-{{$r->id}}'  onclick='starrattingsanswer(1,{{$r->id}})' style='padding-right:5px;' class='fa fa-star staractive'></i><i id='answerstar-2-{{$r->id}}'  onclick='starrattingsanswer(2,{{$r->id}})' style='padding-right:5px;' class='fa fa-star staractive'></i><i id='answerstar-3-{{$r->id}}'  onclick='starrattingsanswer(3,{{$r->id}})' style='padding-right:5px;' class='fa fa-star staractive'></i><i id='answerstar-4-{{$r->id}}'  onclick='starrattingsanswer(4,{{$r->id}})' style='padding-right:5px;' class='fa fa-star staractive'></i><i id='answerstar-5-{{$r->id}}'  onclick='starrattingsanswer(5,{{$r->id}})' class='fa fa-star staractive'></i>")
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
</script>