<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ url('filterquestion') }}">
            {{ csrf_field() }}
        <div class="row">
            <div class="col-md-3">
                @if(isset($search))
                <select name="filterbydate" class="form-control">
                    <option  value="all" selected="">All</option>
                    <option @if($filterbydate == 'all') selected @endif value="all" selected="">Filter by Date</option>
                    <option @if($filterbydate == 'today') selected @endif value="today">Today</option>
                    <option @if($filterbydate == 'week') selected @endif value="week">This Week</option>
                    <option @if($filterbydate == 'month') selected @endif value="month">This Month</option>
                </select>
                @else
                <select name="filterbydate" class="form-control">
                    <option  value="all" selected="">Filter by Date</option>
                    <option  value="all" >All</option>
                    <option  value="today">Today</option>
                    <option  value="week">This Week</option>
                    <option value="month">This Month</option>
                </select>
                @endif
            </div>
            <div class="col-md-3">
                @if(isset($search))
                <select name="filterbysubject" class="form-control">
                    <option value="" selected="">Filter by Subject</option>
                    <option value="" >All Subject</option>
                    @foreach(DB::table('categories')->where('status' , 'Active')->get() as $r)
                    <option @if($filterbysubject == $r->name) selected @endif value="{{ $r->name }}">{{ $r->name }}</option>
                    @endforeach
                </select>
                @else
                <select name="filterbysubject" class="form-control">
                    <option value="" selected="">Filter by Subject</option>
                    <option value="" >All Subject</option>
                    @foreach(DB::table('categories')->where('status' , 'Active')->get() as $r)
                    <option value="{{ $r->name }}">{{ $r->name }}</option>
                    @endforeach
                </select>
                @endif
            </div>
            <div class="col-md-3">
                <select name="filterbystatus" class="form-control">
                    <option value="" selected="">Filter By</option>
                    @foreach(DB::table('answerquestions')->groupby('question_status')->get() as $r)
                    <option value="{{ $r->question_status }}">{{ $r->question_status }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-block">Filter</button>
            </div>
        </div>
        </form>
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-2 col-2">
        <select onchange="location = this.value;" class="form-control text-left">
            <option @if(Cmf::site_settings('datashowlimit') == 10) selected @endif value="{{ url('changenoofrecordsperpage/10') }}">10 Records Per Page</option>
            <option @if(Cmf::site_settings('datashowlimit') == 20) selected @endif value="{{ url('changenoofrecordsperpage/20') }}">20 Records Per Page</option>
            <option @if(Cmf::site_settings('datashowlimit') == 30) selected @endif value="{{ url('changenoofrecordsperpage/30') }}">30 Records Per Page</option>
            <option @if(Cmf::site_settings('datashowlimit') == 50) selected @endif value="{{ url('changenoofrecordsperpage/50') }}">50 Records Per Page</option>
            <option @if(Cmf::site_settings('datashowlimit') == 100) selected @endif value="{{ url('changenoofrecordsperpage/100') }}">100 Records Per Page</option>
            <option @if(Cmf::site_settings('datashowlimit') == 200) selected @endif value="{{ url('changenoofrecordsperpage/200') }}">200 Records Per Page</option>
            <option @if(Cmf::site_settings('datashowlimit') == 300) selected @endif value="{{ url('changenoofrecordsperpage/300') }}">300 Records Per Page</option>
        </select>
    </div>
    <div class="col-md-3 col-2">
        <input type="text" onkeyup="search(this.value)" class="form-control" placeholder="Search by Question Tittle...." name="">
    </div>
    <div id="spinnerloader" class="col-md-1 col-2 text-left">
        
    </div>
    <div class="col-md-3">
        <!-- <a href="{{ url('admin/exportanswerquestion') }}"><button class="btn btn-primary">Export all Questions</button></a> -->
    </div>
    <div class="col-md-3 col-10 text-right">
        <div class="dropdown text-right">
            <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Action
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a onclick="changeurlofform('publishedquestion')" class="dropdown-item" href="javascript:void(0);">Published</a>
                <a onclick="changeurlofform('underreviewquestion')" class="dropdown-item" href="javascript:void(0);">Under Review</a>
                <a onclick="changeurlofform('movetotrashquestion')" class="dropdown-item" href="javascript:void(0);">Move to Trash</a>
                <a onclick="changeurlofform('deletequestion')" class="dropdown-item" href="javascript:void(0);">Delete</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function changeurlofform(id)
    {

        if ($(".custom-control-input:checked").length > 0)
        {
            var mainurl = $('#mainurl').val();
            var url = mainurl+'/'+id;
            $('#completeform').attr('action', url).submit();
        }
        else
        {
           swal("Error", "Please Select Any Row", "error");
        }
    }
</script>