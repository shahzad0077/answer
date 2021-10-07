<style type="text/css">
p img{
    width: 100% !important;
}
</style>
<div class="col-xl-4 col-lg-5 col-md-7">
    <div class="left-profile-area">
        <div class="profile-about-box">
            <div class="top-bg"></div>
            <div class="p-inner-content">
                <div style="cursor:pointer;" data-toggle="modal" data-target="#myModal" class="profile-img">
                    <img src="{{ Auth::user()->profileimage }}" style="height:100%;width: 100%;" alt="">
                    <div class="active-online"></div>
                </div>
                <h5 class="name">
                    {{ Auth::user()->name }}
                </h5>
                @if(Auth::user()->expert == 'on')
                <div>
                    <span style="text-transform:capitalize;" class="badge badge-pill badge-success">Expert</span>
                </div>
                @endif
                <ul class="p-b-meta-one mt-3">
                    <li>
                        <div class="icon">
                            {{ DB::table('onlyanswers')->where('users' , Auth::user()->id)->count() }}
                        </div>
                        <span>Answers</span>
                    </li>
                    <li>
                        <div class="icon">
                            {{ DB::table('onlyanswers')->where('users' , Auth::user()->id)->sum('likes') }}
                        </div>
                        <span>Likes</span>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .activeicon{
        cursor: pointer;
        border: 1px solid #DDD;
        background-color: var(--select-avatar);
        
    }

    .img-profile-user{
        width:100%; height:100px; object-fit:contain; border-radius:10px; border:1px solid lightgray
    }

</style>

<!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <!-- Modal body -->
      <div class="modal-body">
        <div class="row">
            @foreach(DB::table('profileimages')->get() as $r)


            <div onclick="addurlofimage({{$r->id}},'{{$r->image_name}}')" id="iconid{{ $r->id }}" class="col-md-2 col-2 mb-3 iconremoveactive">
                <img class="img-profile-user" src="{{ url('/images') }}/{{ $r->image_name }}">
            </div>

             @endforeach
        </div>
      </div>
      <div class="modal-footer">
        <form method="POST" action="{{ url('profilepicturechange') }}">
            {{ csrf_field() }}
            <input type="hidden" id="imageurl" name="imageurl">
            <input type="hidden" value="{{ Auth::user()->id }}" name="userid">
            <button type="submit" class="btn btn-theme-sm" >Save</button>
        </form>

      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    function addurlofimage(iconid , id)
    {
        $('.iconremoveactive').removeClass('activeicon');
        $('#iconid'+iconid).addClass('activeicon');
        var mainurl = '{{ url("/images") }}';
        $('#imageurl').val(mainurl+'/'+id);

    }
</script>
