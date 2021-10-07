<div class="row">
    <div class="col-md-2 col-2">
        <a id="d-mobile-none" href="{{ url('') }}/{{ DB::table('categories')->where('name' , $data->question_subject)->get()->first()->url }}"><span class="badge badge-pill" style="text-transform: capitalize; {{ DB::table('categories')->where('name' , $data->question_subject)->get()->first()->text_color  }}  {{ DB::table('categories')->where('name' , $data->question_subject)->get()->first()->backgroundcolor  }} ">{{ $data->question_subject }}</span></a>

    </div>
    <div class="col-md-10 col-10 text-right mt-minus-10">

        <span class="f-13 mr-1">{{ Cmf::create_time_ago($data->question_asked_time) }}</span>

        @if(Auth::check())
        @if(Auth::user()->username == $data->question_auther)
        <a href="{{ url('editquestion') }}/{{ $data->question_url }}" class="mr-1 btn btn-white-mine-edit btn-sm">edit <img class="float-right pt-1" src="{{asset('/front/assets/images/shahzad/edit-icon.svg')}}"></a>

        @endif
        @endif
        @if(Auth::check())
            @if(Auth::user()->username != $data->question_auther)
                @if(DB::table('onlyanswers')->where('questionid' , $data->id)->where('users' , Auth::user()->username)->count() == 0)
                    <a style="" class="btn btn-theme-sm"  href="{{url('/addanswer')}}/{{ $data->question_url }}"><i><b>Give Answer</b></i></a>
                @endif
            @endif
        @else
            <a class="btn btn-theme-sm"  href="{{url('/addanswer')}}/{{ $data->question_url }}"><i><b>Give Answer</b></i></a>
        @endif



        @if(Auth::check())
            @if(Auth::user()->username != $data->question_auther)
                @if(DB::table('savequestion')->where('questionid' , $data->id)->where('users' , Auth::user()->id)->count() > 0)
                <span id="showsaved" class="ml-1 pointer"><img onclick="unsavequestion({{ $data->id }})" title="Save Later" width="27px" src="{{asset('/front/assets/images/shahzad/tag-filled.svg')}}"></span>
                <span style="cursor:pointer; display: none;" id="hideunsaved" class="ml-1"><img onclick="savequestion({{ $data->id }})" title="Save Later" width="27px" src="{{asset('/front/assets/images/shahzad/tag-empty.svg')}}"></span>
                @else

                <span id="hideunsaved" class="ml-1 pointer"><img onclick="savequestion({{ $data->id }})" title="Save Later" width="27px" src="{{asset('/front/assets/images/shahzad/tag-empty.svg')}}"></span>
                <span style="cursor:pointer;display: none;" id="showsaved" class="ml-1"><img onclick="unsavequestion({{ $data->id }})" title="Save Later" width="27px" src="{{asset('/front/assets/images/shahzad/tag-filled.svg')}}"></span>

                @endif
            @endif
        @endif
    </div>
</div>
<script type="text/javascript">
    function starrattingsquestion(id,questionid)
    {
        var mainurl = '{{ url('') }}';
         $.ajax({
            type: "GET",
            url: mainurl+'/questionratting/'+id+'/'+questionid,
            success: function(resp) {
                $('#hidestars').hide();
                $('#showstarsratting').html(resp);
            }
        });
    }
    function savequestion(id)
    {

        var mainurl = '{{ url('') }}';
         $.ajax({
            type: "GET",
            url: mainurl+'/savequestion/'+id,
            success: function(resp) {
                if(resp == 'success')
                {
                    $('#hideunsaved').hide();
                    $('#showsaved').show();
                    $.toast({
                        heading: 'Saved',
                        text: 'Question Saved Successfully',
                        position: 'top-right',
                        icon: 'info',
                        stack: false
                    });
                }else{

                }
            }
        });
    }
    function unsavequestion(id)
    {
        var mainurl = '{{ url('') }}';
         $.ajax({
            type: "GET",
            url: mainurl+'/unsavequestion/'+id,
            success: function(resp) {
                if(resp == 'success')
                {
                    $('#showsaved').hide();
                    $('#hideunsaved').show();
                    $.toast({
                        heading: 'Un Saved',
                        text: 'Question Un Saved Successfully',
                        position: 'top-right',
                        icon: 'info',
                        stack: false
                    })
                }else{

                }
            }
        });
    }
    function likethis(id)
    {
        var mainurl = '{{ url('') }}';
         $.ajax({
            type: "GET",
            url: mainurl+'/likethisquestion/'+id,
            success: function(resp) {
                $('#likethis').hide();
                $('#unlikethis').show();
                $('#showquestionlike').html(resp);
                $.toast({
                    heading: 'Liked',
                    text: 'You Like This Question',
                    position: 'top-right',
                    icon: 'info',
                    stack: false
                })
            }
        });
    }
    function unlikethis(id)
    {
        var mainurl = '{{ url('') }}';
         $.ajax({
            type: "GET",
            url: mainurl+'/unlikethisquestion/'+id,
            success: function(resp) {
                $('#unlikethis').hide();
                $('#likethis').show();
                $('#showquestionlike').html(resp);
                $.toast({
                    heading: 'DisLike',
                    text: 'You DisLike This Question',
                    position: 'top-right',
                    icon: 'info',
                    stack: false
                })
            }
        });
    }
</script>
