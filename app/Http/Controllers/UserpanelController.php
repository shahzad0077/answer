<?php

namespace App\Http\Controllers;

use App\Helper\Cmf;
use Illuminate\Http\Request;
use App\Models\pets;
use App\Models\playexercises;
use App\Models\feedingandtreats;
use App\Models\phonebooks;
use App\Models\lostandfounds;
use App\Models\receipts;
use App\Models\veterinaryandmedical;
use App\Models\medicalnotes;
use App\Models\medicins;
use App\Models\bannerimages;
use App\Models\likesdislikes;
use App\Models\allergies;
use App\Models\sleeppets;
use App\Models\training;
use App\Models\vocabularies;
use App\Models\boardings;
use App\Models\groomer;
use App\Models\journals;
use App\Models\access;
use App\Models\plans;
use App\Models\user;
use App\Models\schedules;
use App\Models\subscriptions;
use App\Models\payementhistory;
use Illuminate\Support\Str;
use DB;
use Auth;
use File;
use Stripe;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
class UserpanelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function directorypath($id)
    {
        return base_path('public/userdata/').'/'.$id;

    }
    public function deleteglobelfunction($id,$table,$idname)
    {
        DB::table($table)->where($idname , $id)->delete();
        return redirect()->back()->with('message', 'Deleted Successfully');
    }
    /****************************************************
                    Save Media to User Directory
    *****************************************************/
    public function sendimagetodirectory($imagename , $useremail)
    {
        $userid = Auth::user()->id;
        $checkuserplan = subscriptions::where('users' , $userid)->get()->first();

        if($checkuserplan->count() > 0)
        {
            $getplan = plans::where('id' , $checkuserplan->plans)->get()->first();
            $memorylimit = $getplan->space;
        }
        else
        {
            $memorylimit = Cmf::site_settings('trialmemorylimit');
        }

        $file_size = 0;
        $path = $this->directorypath($useremail);
        foreach( File::allFiles($path) as $file)
        {
            $file_size += $file->getSize();
        }
        $size =  number_format($file_size / 1048576,2);

        if($memorylimit <= $size)
        {
            return "limitexceded";
        }
        else
        {
            $filesize = $imagename->getSize();
            $size =  number_format($filesize / 1048576,2);
            $previousspaceused = subscriptions::where('users' , $userid)->get()->first()->spaceused;
            $data = array('spaceused' => $previousspaceused+$size);
            subscriptions::where('users', $userid)->update($data);
            $file = $imagename;
            $filename = rand() . '.' . $file->getClientOriginalExtension();
            $path = 'userdata/'.$useremail;
            $file->move(public_path($path), $filename);
            return $filename; 
        }
    }
    /****************************************************
                    Check Banner Image Function
    *****************************************************/
    public function bannerimage($pagename)
    {

        $userid = Auth::user()->id;
        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        if(!empty($selectedpet))
        {

          $bannerimages =  bannerimages::where('users' , $userid)->where('pets' , $selectedpet->pet)->where('pagename' , $pagename);

          if($bannerimages->count() == 0)
          {
            $bannerimages = 'noimage';
            // echo "string";exit;
          }
          else
          {
            $bannerimages = $bannerimages->get()->first();
          }

        }else{
           $bannerimages = 'noimage';
        }
        return $bannerimages;
    }
    public function checkuserpet()
    {
        $userid = Auth::user()->id;
        $pet = pets::where('users' , $userid)->count();
        if($pet > 0)
        {
          $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first()->pet;
          return pets::where('id' , $selectedpet)->get();
        }else{
            return pets::where('users' , $userid)->get();
        }
    }
    public function getallpets()
    {
        $userid = Auth::user()->id;
        return pets::where('users' , $userid)->get();
    }
    /****************************************************
                    Schedule Module
    *****************************************************/
    public function viewschedule()
    {
        $userid = Auth::user()->id;

        $pets = pets::where('users' , $userid)->get();
        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();

        if(!empty($selectedpet))
        {
            $schedule = schedules::where('pets' , $selectedpet->pet)->where('users' , $userid)->get();
        }
        else
        {
            $schedule = 'null';
        }
        $checkpet = $this->checkuserpet();
        $todaydate = date('Y-m-d');
        return view('user-panel.schedule.index')->with(array('todaydate'=>$todaydate,'pets'=>$pets,'schedule'=>$schedule,'checkpet'=>$checkpet));
    }
    public function createschedule(Request $request)
    {
        $schedule = new schedules;
        $schedule->users = Auth::user()->id;
        $schedule->pets =  $request->pets;
        $schedule->tittle = $request->tittle;
        $schedule->type = $request->type;
        $schedule->date = $request->date;
        $schedule->time = $request->time;
        $schedule->notes = $request->notes;
        $schedule->save();
        return redirect()->back()->with('message', 'Schedule Added Successfully');
    }
    public function showevent($id)
    {
        $userid = Auth::user()->id;
        $data = schedules::where('id' , $id)->get()->first();
        $pets = pets::where('users' , $userid)->get();
        echo '
        
                
        <input type="hidden" name="id" value="'.$data->id.'">

        <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">'.$data->tittle.'</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div id="showformdata" style="display:none">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-group has-float-label">
                        <select name="pets" class="form-control select2-single" required="">
                            <option selected="male" disabled="">Select</option>';
                            foreach($pets as $p)
                            {
                               echo '<option '; if($p->id == $data->pets){ echo "selected "; }  echo 'value="'.$p->id.'">'.$p->petname.'</option>';
                            }
                            
                        echo '</select>
                        <span>Select Pet</span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-group has-float-label">
                            <input name="tittle" value="'.$data->tittle.'" class="form-control" type="text" placeholder="">
                            <span>Title</span>
                        </label>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label class="form-group has-float-label">
                        <select name="type" class="form-control select2-single" required="">
                            <option  selected="male" disabled="">Select</option>
                            <option '; if($data->type == 'Eating'){ echo "selected "; }  echo ' value="Eating">Eating</option>
                            <option '; if($data->type == 'Grooming'){ echo "selected "; }  echo '  value="Grooming">Grooming</option>
                            <option '; if($data->type == 'Routeen Checkup'){ echo "selected "; }  echo '  value="Routeen Checkup">Routine chekcup</option>
                            <option '; if($data->type == 'Playing'){ echo "selected "; }  echo '  value="Playing">Playing </option>
                            <option '; if($data->type == 'Relaxing'){ echo "selected "; }  echo '  value="Relaxing">Relaxing</option>
                            <option '; if($data->type == 'Sleeping'){ echo "selected "; }  echo '  value="Sleeping">Sleeping</option>
                            <option '; if($data->type == 'blood-work'){ echo "selected "; }  echo ' value="blood-work">Blood Work</option>
                            <option '; if($data->type == 'vaccination'){ echo "selected "; }  echo ' value="vaccination">Vaccination</option>
                            <option '; if($data->type == 'well-visits'){ echo "selected "; }  echo ' value="well-visits">Well Visits</option>
                            <option '; if($data->type == 'sick-visits'){ echo "selected "; }  echo ' value="sick-visits">Sick Visits</option>
                            <option '; if($data->type == 'surgery'){ echo "selected "; }  echo ' value="surgery">Surgery</option>
                        </select>
                        <span>Schedule Type</span>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-group has-float-label">
                            <input name="date" value="'.$data->date.'" class="form-control" type="date" placeholder="">
                            <span>Select Date</span>
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label class="form-group has-float-label">
                            <input name="time" value="'.$data->time.'" class="form-control" type="time" placeholder="">
                            <span>Select Time</span>
                        </label>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label class="form-group has-float-label">
                            <textarea name="notes" class="form-control" type="text" placeholder="" rows="3">'.$data->notes.'</textarea>
                            <span>Special Notes</span>
                        </label>
                    </div>
                </div>
            </div>
            <div id="loading"></div>
            <div id="showschedule">
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">Pet Name</p>
                        <p class="mb-3">'.pets::where("id" , $data->pets)->get()->first()->petname.' </p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">Schedule Type</p>
                        <p class="mb-3">'.$data->type.'</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">Date</p>
                        <p class="mb-3">'.$data->date.'</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">Timing</p>
                        <p class="mb-3">'.date("g:i a", strtotime($data->time)).'</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-muted text-small mb-2">Special Notes</p>
                        <p class="mb-3">
                            '.$data->notes.'
                        </p>
                    </div>
                </div>
            </div>
            </div>
            
            <div id="editbutton" class="modal-footer">
            <a href="'.url("deleteschedule/").'/'.$data->id.'">
                <button type="button" class="btn btn-danger" >Delete Schedule</button>
            </a>
                <button type="button"  onclick="editshowschedule()" class="btn btn-primary" >Edit Schedule</button>
            </div>
            <div id="updatebutton" style="display:none;" class="modal-footer">
                <button type="submit"  class="btn btn-primary" >Update Schedule</button>
            </div>
            ';
    }
    public function updateschedule(Request $request)
    {

        $data = array('pets' => $request->pets,'tittle' => $request->tittle,'type' => $request->type,'date' => $request->date,'time' => $request->time,'notes' => $request->notes);
        $id =  $request->id;
        schedules::where('id', $id)->update($data);
        return redirect()->back()->with('message', 'Updated Schedule Successfully');
    }
    public function deleteschedule($id)
    {
        schedules::where('id',$id)->delete();
        return redirect()->back()->with('message', 'Schedule Deleted Successfully');
    }
    /****************************************************
                    Like and Dislike Module
    *****************************************************/
    public function viewlikeanddislike()
    {
        $userid = Auth::user()->id;

        $pets = pets::where('users' , $userid)->get();
        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();

        if(!empty($selectedpet))
        {
        $likes = likesdislikes::where('likedislike' , 'like')->where('pets' , $selectedpet->pet)->where('users' , $userid)->get();
        $dislike = likesdislikes::where('likedislike' , 'dislike')->where('pets' , $selectedpet->pet)->where('users' , $userid)->get();
        }
        else
        {
            $likes = 'null';
            $dislike = 'null';
        }
        $checkpet = $this->checkuserpet();
        return view('user-panel.likedislike.index')->with(array('pets'=>$pets,'likes'=>$likes,'dislike'=>$dislike,'checkpet'=>$checkpet));
    }
    public function createlikeanddislike(Request $request)
    {
        $useremail = Auth::user()->email;
        $likeid = rand('46543166' , '46384631');
        $like = new likesdislikes;
        $like->likesdislikesid = $likeid;
        $like->pets =  $request->petid;
        $like->likedislike = $request->likeordislike;
        $like->tittle = $request->tittle;
        $like->description = $request->description;
        $like->users = Auth::user()->id;
        $like->save();
        if($files=$request->file('images')){
        $files=$request->file('images');
            foreach($files as $file){
                $imagename = $this->sendimagetodirectory($file , $useremail);
                DB::statement("INSERT INTO `mediaimages` (`productid`, `image`)VALUES ('$likeid', '$imagename')");
            }
        }
        return redirect()->back()->with('message', 'Case Added Successfully');
    }
    public function getlikedislike($id)
    {
        $data =  likesdislikes::where('id',$id)->get()->first();
        return response()->json(['pets' => $data->pets,'likesdislikesid' => $data->likesdislikesid,'likeordislike' => $data->likedislike,'tittle' => $data->tittle,'description' => $data->description]);
    }
    public function deletelikedislike($id)
    {
        likesdislikes::where('id',$id)->delete();
        return redirect()->back()->with('message', 'Case Added Successfully');
    }
    public function viewlike($id)
    {
       $like =  likesdislikes::where('id',$id)->get()->first();
       $images = DB::table('mediaimages')->where('productid' , $like->likesdislikesid)->get();
       echo '<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">'.$like->tittle.'</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">';
                foreach ($images as $r) {
                     $checkextension = pathinfo($r->image, PATHINFO_EXTENSION);
                        if($checkextension == 'mp4')
                        {
                            echo '<div class="col-md-12"><video style="width: 100%; height: 500px;"  controls>
                                  <source src="'.url("public/userdata").'/'.Auth::user()->email.'/'.$r->image.'" type="video/mp4">
                                  <source src="movie.ogg" type="video/ogg">
                                  Your browser does not support the video tag.
                                </video></div>';
                        }
                        else
                        {
                            echo '<div class="col-md-12"><img style="width:100%;height:100%;" alt="Thumbnail" src="'.url("public/userdata").'/'.Auth::user()->email.'/'.$r->image.'" /></div>';
                        }
                }
                    
                echo '</div>
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-muted text-small mb-2">Special Notes</p>
                        <p class="mb-3">
                            '.$like->tittle.'
                        </p>
                    </div>
                </div>
            </div>';
    }
    public function updatelikedislike(Request $request)
    {
        $useremail = Auth::user()->email;
        if($files=$request->file('images')){
        DB::table('mediaimages')->where('productid' , $request->id)->delete();
        $files=$request->file('images');
            foreach($files as $file){
                $imagename = $this->sendimagetodirectory($file , $useremail);
                DB::statement("INSERT INTO `mediaimages` (`productid`, `image`)VALUES ('$request->id', '$imagename')");
                $data = array('pets' => $request->pets,'likedislike' => $request->likeordislike,'tittle' => $request->tittle,'description' => $request->description);
            }
        }else{
            $data = array('pets' => $request->pets,'likedislike' => $request->likeordislike,'tittle' => $request->tittle,'description' => $request->description);
        }
        $id =  $request->id;
        likesdislikes::where('likesdislikesid', $id)->update($data);
        return redirect()->back()->with('message', 'Updated Successfully');
    }

    /****************************************************
					Play exercise Module
	*****************************************************/
    public function viewexercisepage()
    {
    	$userid = Auth::user()->id;
        $pets = pets::where('users' , $userid)->get();
        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        $bannerimage = $this->bannerimage('exercise');
        $checkpet = $this->checkuserpet();
        if(!empty($selectedpet))
        {
            $exercises = playexercises::where('users' , $userid)->where('pets' , $selectedpet->pet)->orderBy('created_at', 'desc')->get();
        }
        else
        {
            $exercises = 'null';
        }
        return view('user-panel.playandexercise.index')->with(array('pets'=>$pets,'exercises'=>$exercises,'selectedpet'=>$selectedpet,'bannerimage'=>$bannerimage,'checkpet'=>$checkpet));
    }
    public function createnexcersise(Request $request)
    {
        $useremail = Auth::user()->email;
        $petdocument = $this->sendimagetodirectory($request->file('image') , $useremail);
        if($petdocument == "limitexceded")
        {
            return redirect()->back()->with('warning', 'Memory Limit Exceded');
        }
        else
        {
            if($request->pets == 'all')
            {
                $pets = $this->getallpets();
                foreach ($pets as $r) {
                    $exercise = new playexercises;
                    $exercise->users = Auth::user()->id;
                    $exercise->pets  = $r->id;
                    $exercise->exercisename = $request->exercisename;
                    $exercise->exerciseoften = $request->exerciseoften;
                    $exercise->favouritespot = $request->favouritespot;
                    $exercise->image = $petdocument;
                    $exercise->specialnotes = $request->specialnotes;
                    $exercise->save();
                }
                return redirect()->back()->with('message', 'Record Added Successfully');
            }
            else
            {
                $exercise = new playexercises;
                $exercise->users = Auth::user()->id;
                $exercise->pets  = $request->pets;
                $exercise->exercisename = $request->exercisename;
                $exercise->exerciseoften = $request->exerciseoften;
                $exercise->favouritespot = $request->favouritespot;
                $exercise->image = $petdocument;
                $exercise->specialnotes = $request->specialnotes;
                $exercise->save();
                return redirect()->back()->with('message', 'Play & Exercise Added Successfully');
            }
        }
    }
    public function showexercise($id)
    {
    	$exercise = playexercises::where('id',$id)->get()->first();
    	echo '<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">'.DB::table('pets')->where('id' , $exercise->pets)->get()->first()->petname.' - Play Exercise  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="row mb-2">
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">'.$exercise->exercisename.'</p>
                        <p class="mb-3">Play with ball in the ground</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">How Often</p>
                        <p class="mb-3"> <span class="badge badge-primary">'.$exercise->exerciseoften.'</span> </p>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">Favourite Spot</p>
                        <p class="mb-3">'.$exercise->favouritespot.'</p>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <p class="text-muted text-small mb-2">Notes</p>
                        <p class="mb-3">'.$exercise->specialnotes.'</p>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <h6 class="theme-text"> <i class="simple-icon-picture"></i> &nbsp; Media</h6> <hr>
                    </div>
                </div>
                <div class="row mb-4">';
                        $checkextension = pathinfo($exercise->image, PATHINFO_EXTENSION);
                        if($checkextension == 'mp4')
                        {
                            echo '<video style="width: 100%; height: 500px;"  controls>
                                  <source src="'.url("public/userdata").'/'.Auth::user()->email.'/'.$exercise->image.'" type="video/mp4">
                                  <source src="movie.ogg" type="video/ogg">
                                  Your browser does not support the video tag.
                                </video>';
                        }
                        else
                        {
                            echo '<div class="col-md-4"><img onclick="showimage('.$exercise->id.')" alt="Thumbnail" src="'.url("public/userdata").'/'.Auth::user()->email.'/'.$exercise->image.'" class="list-thumbnail-thumb-half responsive border-0" /></div>';
                        }
                        
                    echo '</div>';
    }
    public function showimageexercise($id)
    {
    	$exercise = playexercises::where('id',$id)->get()->first();
    	echo '<div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <img alt="Thumbnail" src="'.url("public/userdata").'/'.Auth::user()->email.'/'.$exercise->image.'" class="list-thumbnail-thumb-xfull responsive border-0" />
                    </div>
                </div>
            </div>';
    }
    public function editplayexercise($id)
    {
    	$exercise = playexercises::where('id',$id)->get()->first();

        $exerciseimage = url("public/userdata").'/'.Auth::user()->email.'/'.$exercise->image;

        return response()->json(['image' => $exerciseimage,'playexercisesid' => $exercise->id,'pets' => $exercise->pets,'exercisename' => $exercise->exercisename,'exerciseoften' => $exercise->exerciseoften,'favouritespot' => $exercise->favouritespot,'specialnotes' => $exercise->specialnotes]);
    }
    public function updateexercise(Request $request)
    {   
        $useremail = Auth::user()->email;
    	if(!empty($request->image))
    	{
            $image = $this->sendimagetodirectory($request->file('image') , $useremail);
            if($image == 'limitexceded')
            {
                return redirect()->back()->with('warningmemory', 'Memory Limit Exceded');
            }else{
                $data = array('image' => $image);
                playexercises::where('id', $id)->update($data);
            }
    		
    	}
        $data = array('pets' => $request->pets,'exercisename' => $request->exercisename,'exerciseoften' => $request->exerciseoften,'favouritespot' => $request->favouritespot,'specialnotes' => $request->specialnotes);
        $id =  $request->playexercisesid;
        playexercises::where('id', $id)->update($data);
        return redirect()->back()->with('message', 'Your pet has been registerd');
    }
    public function filterplayandexercise($id)
    {
        $userid = Auth::user()->id;


        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        if($id == 'Daily')
        {
            $data = playexercises::where('pets' , $selectedpet->pet)->where('users' , $userid)->where('exerciseoften', 'Daily')->orderBy('created_at', 'desc')->get();
        }
        if($id == 'All')
        {
            $data = playexercises::where('pets' , $selectedpet->pet)->where('users' , $userid)->orderBy('created_at', 'desc')->get();
        }
        if($id == 'Twice')
        {
            $data = playexercises::where('pets' , $selectedpet->pet)->where('users' , $userid)->where('exerciseoften', 'Twice')->orderBy('created_at', 'desc')->get();
        }
        if($id == 'Whenever')
        {
            $data = playexercises::where('pets' , $selectedpet->pet)->where('users' , $userid)->where('exerciseoften', 'Whenever')->orderBy('created_at', 'desc')->get();

        }
        
        if($data->count() > 0)
        {

        foreach($data as $r)
            {
                echo '<div class="card d-flex flex-row mb-3">
                    <a class="d-flex" href="javascript:void(0)" onclick="showexercise('.$r->id.')" >
                        <img src="'.url("public/userdata").'/'.Auth::user()->email.'/'.$r->image.'" alt="Fat Rascal" class="list-thumbnail rounded-none responsive border-0" />
                    </a>
                    <div class="pl-2 d-flex flex-grow-1 min-width-zero">
                        <div class="card-body align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero align-items-lg-center">
                            <a href="javascript:void(0)" onclick="showexercise('.$r->id.')" class="w-20 w-sm-100">
                                <p class="list-item-heading mb-1 truncate">'.$r->exercisename.'</p>
                            </a>
                            <p class="mb-1 text-muted text-small w-30 w-sm-100"> <span>
                            '.Str::limit($r->specialnotes, 150).'
                                  </span> </p>

                            <p class="mb-1 text-muted text-small w-15 w-sm-100 text-center"> <span data-toggle="tooltip" data-placement="top" title="How often">'.$r->exerciseoften.'</span> </p>
                            <p class="mb-1 text-muted text-small w-25 w-sm-100 text-center"> <span data-toggle="tooltip" data-placement="top" title="Favourite Spot">'.$r->favouritespot.'</span></p>
                        </div>

                        <div class="custom-control custom-checkbox pl-1 align-self-center pr-4">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <a href="javascript:void(0)" onclick="editfunction('.$r->id.')" data-toggle="tooltip" data-placement="top" title="Edit"><i class="simple-icon-pencil"></i></a> &nbsp;&nbsp;
                                    <a onclick="deletefunction('.$r->id.')" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Delete"><i class="simple-icon-trash" ></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        }else{
            echo "empty";
        }
    }
    /****************************************************
					Feeding Treets Module
	*****************************************************/
	public function viewefeedingtreets()
	{
		$userid = Auth::user()->id;
        $pets = pets::where('users' , $userid)->get();

        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        $bannerimage = $this->bannerimage('feeding');
        $checkpet = $this->checkuserpet();
        if(!empty($selectedpet))
        {
            $feedingandtreats = feedingandtreats::where('users' , $userid)->where('pets' , $selectedpet->pet)->orderBy('created_at', 'desc')->get();
        }
        else
        {
            $feedingandtreats = 'null';
        }
        return view('user-panel.feedingtreats.index')->with(array('pets'=>$pets,'feedingandtreats'=>$feedingandtreats,'checkpet'=>$checkpet,'bannerimage'=>$bannerimage));
	}
    public function createfeedingandtreats(Request $request)
    {
        $useremail = Auth::user()->email;
        $food = new feedingandtreats;
        $food->pets =  $request->pets;
        $food->foodmodel =  $request->foodmodel;
        $food->users =  Auth::user()->id;
        $food->foodtype =  $request->foodtype;
        $food->foodtime =  $request->foodtime;
        $food->foodammount =  $request->foodammount;
        $food->foodrouteen =  $request->foodrouteen;
        $food->cookinginstructions =  $request->cookinginstructions;
        $food->brandsfood =  $request->brandsfood;
        $food->mealtooper =  $request->mealtooper;
        $food->product1 =  $request->product1;
        $food->product2ammount =  $request->product2ammount;
        $food->product2 =  $request->product2;
        $food->product2ammount =  $request->product2ammount;
        if(!empty($request->prepcookingimage))
        {
            $food->prepcookingimage = $this->sendimagetodirectory($request->file('prepcookingimage') , $useremail);
        }
        if(!empty($request->foodbrandimage))
        {
            $food->foodbrandimage = $this->sendimagetodirectory($request->file('foodbrandimage') , $useremail);
        }
        if(!empty($request->platedfoodimage))
        {
            $food->platedfoodimage = $this->sendimagetodirectory($request->file('platedfoodimage') , $useremail);
        }
        $food->foodspecialnotes =  $request->foodspecialnotes; 
        $food->foodshoppinglist =  $request->foodshoppinglist;
        if(!empty($request->shoppinglistimage))
        {
            $food->shoppinglistimage = $this->sendimagetodirectory($request->file('shoppinglistimage') , $useremail);
        }
        if(!empty($request->pictureoftreats))
        {
            $food->pictureoftreats = $this->sendimagetodirectory($request->file('pictureoftreats') , $useremail);
        }
        $food->foodvitamans =  $request->foodvitamans;
        if(!empty($request->foodtooperimage))
        {
            $food->foodtooperimage = $this->sendimagetodirectory($request->file('foodtooperimage') , $useremail);
        }
        $food->additionalinstruction =  $request->additionalinstruction;

        $food->alergyfromanyfood =  $request->alergyfromanyfood;
        $food->save();
        return redirect()->back()->with('message', 'Your pet has been registerd');
    }
    public function deletefoodandtreats($id)
    {
        feedingandtreats::where('id',$id)->delete();
        return redirect()->back()->with('message', 'Case Added Successfully');
    }
    public function showfoodandtreats($id)
    {
        $food = feedingandtreats::where('id',$id)->get()->first();
        $pet = DB::table('pets')->where('id' , $food->pets)->get()->first();

        echo '<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">'.$pet->petname.'</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <h6 class="theme-text"> <i class="simple-icon-note"></i> &nbsp; Basic Information</h6> <hr>
                    </div>
                </div> 
                <div class="row mb-2">
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">Food Type</p>
                        <p class="mb-3">'.$food->foodtype.'</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">Time</p>
                        <p class="mb-3">'.date("g:i a", strtotime($food->foodtime)).'</p>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">Amount</p>
                        <p class="mb-3">'.$food->foodammount.'</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">Type</p>
                        <p class="mb-3"> <span class="badge badge-danger">'.$food->foodrouteen.'</span> </p>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12">
                        <p class="text-muted text-small mb-2">What the meal contains</p>
                        <p class="mb-3">'.$food->foodspecialnotes.'</p>
                    </div>';
                    if(!empty($food->cookinginstructions))
                    {
                    
                     echo '<div class="col-md-6">
                     <p class="text-muted text-small mb-2">Cooking Instructions</p>
                            <p class="mb-3">'.$food->cookinginstructions.'</p>
                        </div>';
                    }
                    echo '</div>
                <div class="row mb-2">';
                if(!empty($food->foodshoppinglist))
                {
                    echo '<div class="col-md-6">
                        <p class="text-muted text-small mb-2">Shopping List</p>
                        <p class="mb-3">'.$food->foodshoppinglist.'</p>
                    </div>';
                }

                if(!empty($food->mealtooper))
                {
                    echo '<div class="col-md-6">
                        <p class="text-muted text-small mb-2">Food Toppers</p>
                        <p class="mb-3">'.$food->mealtooper.'</p>
                    </div>';
                }
                echo '</div>';
                if(!empty($food->product1))
                {
                    echo '<div class="row mb-2">
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">Product 1</p>
                        <p class="mb-3">'.$food->product1.'</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">Product 1 Ammount</p>
                        <p class="mb-3">'.$food->product1ammount.'</p>
                    </div>
                </div>';
                }
                if(!empty($food->product2))
                {
                    echo '<div class="row mb-2">
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">Product 2</p>
                        <p class="mb-3">'.$food->product2.'</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">Product 2 Ammount</p>
                        <p class="mb-3">'.$food->product2ammount.'</p>
                    </div>
                </div>';
                }
                if(!empty($food->brandsfood))
                {
                    echo '<div class="row mb-2">
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">Brand’s of Food</p>
                        <p class="mb-3">'.$food->brandsfood.'</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">Meal Topper</p>
                        <p class="mb-3">'.$food->mealtooper.'</p>
                    </div>
                </div>';
                }

                echo '<div class="row mb-2">
                    <div class="col-md-12">
                        <p class="text-muted text-small mb-2">Alergies</p>
                        <p class="mb-3">'.$food->alergyfromanyfood.'</p>
                    </div>
                </div>';

                if(!empty($food->breedernotes))
                {

                echo '<div class="row mb-2">
                    <div class="col-md-12">
                        <p class="text-muted text-small mb-2">Notes form Breeder</p>
                        <p class="mb-3">
                            '.$pet->breedernotes.'
                        </p>
                    </div>
                </div>';

            }

            if(!empty($food->additionalinstruction))
                {

                echo '<div class="row mb-2">
                    <div class="col-md-12">
                        <p class="text-muted text-small mb-2">Aditional Notes</p>
                        <p class="mb-3">
                            '.$food->additionalinstruction.'
                        </p>
                    </div>
                </div>';

            }
                echo '<div class="row mb-2">
                    <div class="col-md-12">
                        <h6 class="theme-text"> <i class="simple-icon-picture"></i> &nbsp; Media</h6> <hr>
                    </div>
                </div>  

                <div class="row mb-4">';
                    if(!empty($food->platedfoodimage)){
                        echo '<div class="col-md-4">
                        <p class="mb-2">Picture of plated Food</p>
                        <img data-toggle="modal" data-target="#view-img" alt="Thumbnail" src="'.url("public/userdata").'/'.Auth::user()->email.'/'.$food->platedfoodimage.'" class="list-thumbnail-thumb-half responsive border-0" />
                            </div>';
                      }      
                    if(!empty($food->shoppinglistimage)){    
                    echo '<div class="col-md-4">
                        <p class="mb-2">Picture of shopping list</p>
                        <img data-toggle="modal" data-target="#view-img" alt="Thumbnail" src="'.url("public/userdata").'/'.Auth::user()->email.'/'.$food->shoppinglistimage.'" class="list-thumbnail-thumb-half responsive border-0" />
                        </div>';
                       } 
                    if(!empty($food->shoppinglistimage)){
                    echo '<div class="col-md-4">
                        <p class="mb-2">Picture of food topper</p>
                        <img data-toggle="modal" data-target="#view-img" alt="Thumbnail" src="'.url("public/userdata").'/'.Auth::user()->email.'/'.$food->foodtooperimage.'" class="list-thumbnail-thumb-half responsive border-0" />
                        </div>';
                    }
                    if(!empty($food->foodbrandimage)){
                    echo '<div class="col-md-4">
                        <p class="mb-2">Picture of Brand</p>
                        <img data-toggle="modal" data-target="#view-img" alt="Thumbnail" src="'.url("public/userdata").'/'.Auth::user()->email.'/'.$food->foodbrandimage.'" class="list-thumbnail-thumb-half responsive border-0" />
                        </div>';
                    }
                    if(!empty($food->pictureoftreats)){
                    echo '<div class="col-md-4">
                        <p class="mb-2">Picture of Treats</p>
                        <img data-toggle="modal" data-target="#view-img" alt="Thumbnail" src="'.url("public/userdata").'/'.Auth::user()->email.'/'.$food->pictureoftreats.'" class="list-thumbnail-thumb-half responsive border-0" />
                        </div>';
                    }
                    if(!empty($food->prepcookingimage)){
                    echo '<div class="col-md-4">
                        <p class="mb-2">Picture of Prep or Cooking</p>
                        <img data-toggle="modal" data-target="#view-img" alt="Thumbnail" src="'.url("public/userdata").'/'.Auth::user()->email.'/'.$food->prepcookingimage.'" class="list-thumbnail-thumb-half responsive border-0" />
                        </div>';
                    }
                echo '</div>
            </div>';
    }
    public function filterfeedingandtreats($id)
    {
        $userid = Auth::user()->id;


        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        if($id == 'Raw')
        {
            $data = feedingandtreats::where('pets' , $selectedpet->pet)->where('users' , $userid)->where('foodmodel', 'Raw')->orderBy('created_at', 'desc')->get();
        }
        if($id == 'All')
        {
            $data = feedingandtreats::where('pets' , $selectedpet->pet)->where('users' , $userid)->orderBy('created_at', 'desc')->get();
        }
        if($id == 'Home Cooked')
        {
            $data = feedingandtreats::where('pets' , $selectedpet->pet)->where('users' , $userid)->where('foodmodel', 'Home Cooked')->orderBy('created_at', 'desc')->get();
        }
        if($id == 'Commercial')
        {
            $data = feedingandtreats::where('pets' , $selectedpet->pet)->where('users' , $userid)->where('foodmodel', 'Commercial')->orderBy('created_at', 'desc')->get();

        }
        if($id == 'Other Mix')
        {
            $data = feedingandtreats::where('pets' , $selectedpet->pet)->where('users' , $userid)->where('foodmodel', 'Mix')->orderBy('created_at', 'desc')->get();

        }
        
        if($data->count() > 0)
        {

        foreach($data as $r)
            {
                echo '<div class="card d-flex flex-row mb-3">
                    <a style="cursor: pointer;" class="d-flex" onclick="showfoodandtreats('.$r->id.')">
                        <img src="'.url("public/userdata").'/'.Auth::user()->email.'/'.DB::table('pets')->where('id' , $r->pets)->get()->first()->petimage.'" alt="Fat Rascal" class="list-thumbnail rounded-none responsive border-0" />
                    </a>
                    <div class="pl-2 d-flex flex-grow-1 min-width-zero">
                        <div class="card-body align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero align-items-lg-center">
                            <a onclick="showfoodandtreats('.$r->id.')" class="w-20 w-sm-100">
                                <p class="list-item-heading mb-1 truncate">'.$r->foodtype.'<small class="f-11">('.$r->foodmodel.')</small></p>
                            </a>
                            <p class="mb-1 text-muted text-small w-15 w-sm-100">'.date("g:i a", strtotime($r->foodtime)).'</p>
                            <p class="mb-1 text-muted text-small w-25 w-sm-100">'.Str::limit($r->foodspecialnotes, 50).'</p>
                            <div class="w-15 w-sm-100">
                                <span class="badge badge-pill badge-danger">'.$r->foodrouteen.'</span>
                            </div>
                        </div>
                        <div class="custom-control custom-checkbox pl-1 align-self-center pr-4">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <!-- <a title="Edit"><i class="simple-icon-pencil"></i></a> &nbsp;&nbsp; -->
                                    <a href="javascript:void(0)" onclick="deletefunction('.$r->id.')" data-toggle="tooltip" data-placement="top" title="Delete"><i class="simple-icon-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';            


            }
        }else{
            echo "empty";
        }
    }
    public function editfeeding($id)
    {
        echo "string";
    }
    /****************************************************
                    Phone Book Module
    *****************************************************/
    public function viewphonebook()
    {
        $userid = Auth::user()->id;

        $pets = pets::where('users' , $userid)->get();
        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        if(!empty($selectedpet))
        {
            $phone = phonebooks::where('pets' , $selectedpet->pet)->where('users' , $userid)->get();
        }
        else
        {
            $phone = 'null';
        }
        $checkpet = $this->checkuserpet();
        return view('user-panel.phonebook.index')->with(array('pets'=>$pets,'phone'=>$phone,'checkpet'=>$checkpet));

    }
    public function createphone(Request $request)
    {
        $useremail = Auth::user()->email;
        if(!empty($request->image))
        {
            $image = $this->sendimagetodirectory($request->file('image') , $useremail);
            if($image == 'limitexceded')
            {
                return redirect()->back()->with('warning', 'Memory Limit Exceded');
            }else{
                $phone = new phonebooks;
                $phone->users = Auth::user()->id;
                $phone->pets  = $request->pets;
                $phone->name  = $request->name;
                $phone->phonenumber = $request->phone;
                $phone->label = $request->label;
                $phone->email = $request->email;
                if(!empty($request->image))
                {
                    $phone->image = $image;
                }
                $phone->save();
                return redirect()->back()->with('message', 'Phone Number Added Successfully');
            }
        }else{
            $phone = new phonebooks;
            $phone->users = Auth::user()->id;
            $phone->pets  = $request->pets;
            $phone->name  = $request->name;
            $phone->phonenumber = $request->phone;
            $phone->label = $request->label;
            $phone->email = $request->email;
            $phone->save();
            return redirect()->back()->with('message', 'Phone Number Added Successfully');
        }

    }
    public function deletephonebook($id)
    {
        phonebooks::where('id',$id)->delete();
        return redirect()->back()->with('message', 'Deleted Successfully');
    }
    public function getphonenumber($id)
    {
        $phone = phonebooks::where('id',$id)->get()->first();
        return response()->json(['phonebookid' => $phone->id,'name' => $phone->name,'email' => $phone->email,'phonenumber' => $phone->phonenumber,'label' => $phone->label]);
    }
    public function updatephonebook(Request $request)
    {   
        $useremail = Auth::user()->email;
        if(!empty($request->image))
        {
            $image = $this->sendimagetodirectory($request->file('image') , $useremail);
            $data = array('image' => $image,'name' => $request->name,'email' => $request->email,'phonenumber' => $request->phone,'label' => $request->label);
        }else{
            $data = array('name' => $request->name,'email' => $request->email,'phonenumber' => $request->phone,'label' => $request->label);
        }
        $id =  $request->phonebookid;
        phonebooks::where('id', $id)->update($data);
        return redirect()->back()->with('message', 'Phonebook Updated Successfully');
    }
    public function filterphonebook($id)
    {
        $userid = Auth::user()->id;

        $pets = pets::where('users' , $userid)->get();
        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        if(!empty($selectedpet))
        {
            $phone = phonebooks::where('pets' , $selectedpet->pet)->where('users' , $userid)->where('label' , $id)->get();
        }
        else
        {
            $phone = 'null';
        }
        $checkpet = $this->checkuserpet();
        return view('user-panel.phonebook.index')->with(array('pets'=>$pets,'phone'=>$phone,'checkpet'=>$checkpet));
    }
    /****************************************************
                    Lost and Found Module
    *****************************************************/
    public function lostfound()
    {
        $userid = Auth::user()->id;
        $pets = pets::where('users' , $userid)->get();
        $pettypes = DB::table('pettypes')->get();
        $lost = lostandfounds::where('users' , $userid)->get();
        return view('user-panel.lostandfound.index')->with(array('pets'=>$pets,'pettypes'=>$pettypes,'lost'=>$lost));
    }
    public function lostfounddetail($id)
    {
        $lost = lostandfounds::where('id' , $id)->get()->first();
        return view('user-panel.lostandfound.detail')->with(array('lost'=>$lost));
    }
    public function showpetinfoforlostandfound($id)
    {
        $pet = pets::where('id',$id)->get()->first();
        return response()->json(['pettype' => $pet->pettype,'petgender' => $pet->petgender,'petmicrochip' => $pet->petmicrochip,'petownercontact' => $pet->petownercontact]);
    }
    public function createlostandfound(Request $request)
    {
        $lost = new lostandfounds;
        $lost->users = Auth::user()->id;
        $lost->pets  = $request->pets;
        $lost->gender = $request->gender;
        $lost->type = $request->pettype;
        $lost->lostlocation = $request->lostlocation;
        $lost->lostday = $request->lostday;
        $lost->lostdate = $request->lostdate;
        $lost->microchipnumber  = $request->microchipnumber;
        $lost->companyname = $request->companyname;
        $lost->contacttoreport = $request->contacttoreport;
        $lost->localpolice = $request->localpolice;
        $lost->sourrindingtown  = $request->surroundingtown;
        $lost->policerescueorganization = $request->rescue;
        $lost->facebook = $request->facebook;
        $lost->instructions = $request->instructions;
        $lost->save();
        return redirect()->back()->with('message', 'Lost and Found Added Successfully');
    }
    /****************************************************
                   Reciept Module
    *****************************************************/
    public function viewreceiept()
    {
        $userid = Auth::user()->id;

        $pets = pets::where('users' , $userid)->get();
        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        if(!empty($selectedpet))
        {
            $receiept = receipts::where('pets' , $selectedpet->pet)->where('users' , $userid)->orderBy('created_at', 'desc')->get();
        }
        else
        {
            $data = 'null';
        }
        $checkpet = $this->checkuserpet();
        return view('user-panel.receiept.index')->with(array('pets'=>$pets,'receiept'=>$receiept,'checkpet'=>$checkpet));
    }
    public function createreciept(Request $request)
    {
        $useremail = Auth::user()->email;       
        $reciept = new receipts;
        $reciept->users = Auth::user()->id;
        $reciept->pets  = $request->pets;
        $reciept->type = $request->type;
        $reciept->tittle = $request->tittle;
        $reciept->description = $request->description;
        if(!empty($request->file('file')))
        {
            $file = $this->sendimagetodirectory($request->file('file') , $useremail);
            $reciept->file = $file;
        }
        if(!empty($request->file('file')))
        {
            $image = $this->sendimagetodirectory($request->file('image') , $useremail);
            $reciept->image = $image;
        }
        $reciept->save();
        return redirect()->back()->with('message', 'Reciept Added Successfully');
    }


    public function deletereciept($id)
    {
        receipts::where('id',$id)->delete();
        return redirect()->back()->with('message', 'Deleted Successfully');
    }
    public function getreciept($id)
    {
        $data = receipts::where('id',$id)->get()->first();
        return response()->json(['receiorid' => $data->id,'pets' => $data->pets,'type' => $data->type,'tittle' => $data->tittle,'description' => $data->description]);
    }
    public function updatereciept(Request $request)
    {   
        $useremail = Auth::user()->email;
        $id =  $request->recieptid;
        if(!empty($request->image))
        {
            $image = $this->sendimagetodirectory($request->file('image') , $useremail);
            $data1 = array('image' => $image);
            receipts::where('id', $id)->update($data1);
        }
        if(!empty($request->file))
        {
            $file = $this->sendimagetodirectory($request->file('file') , $useremail);
            $data2 = array('file' => $image);
            receipts::where('id', $id)->update($data2);
        }
        $data3 = array('pets' => $request->pets,'type' => $request->type,'tittle' => $request->tittle,'description' => $request->description);
        receipts::where('id', $id)->update($data3);
        return redirect()->back()->with('message', 'Phonebook Updated Successfully');
    }
    public function showreciept($id)
    {
        $data = receipts::where('id',$id)->get()->first();
        echo '<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">'.$data->tittle.'</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row mb-2">
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">Dated</p>
                        <p class="mb-3">'.$data->created_at.'</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">Receiept Type</p>
                        <p class="mb-3"> <span class="badge badge-primary">'.$data->type.'</span> </p>
                    </div>
                </div>'; 
                if(!empty($data->file)){
                    echo '<div class="row mb-3">
                        <div class="col-md-12">
                             <p class="mb-2">File</p>
                            <a download="" href="'.url("public/userdata").'/'.Auth::user()->email.'/'.$data->file.'"><span class="iconsmind-File-Cloud"></span>Receiept Document (1)</a>
                        </div>
                    </div>';
                }

            echo '<div class="row mb-2">
                    <div class="col-md-12">
                        <p class="text-muted text-small mb-2">Description</p>
                        <p class="mb-3">
                            '.$data->description.'
                        </p>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12">
                        <h6 class="theme-text"> <i class="simple-icon-picture"></i> &nbsp; Media</h6> <hr>
                    </div>
                </div>'; 
                if(!empty($data->image)){
                    echo '<div class="row mb-4">
                    <div class="col-md-4">
                        <p class="mb-2">Picture</p>
                        <img data-toggle="modal" data-target="#view-img" alt="Thumbnail" src="'.url("public/userdata").'/'.Auth::user()->email.'/'.$data->image.'" class="list-thumbnail-thumb-half responsive border-0" />
                    </div>';
                }
                    
                echo '</div>
            </div>';
    }
    /****************************************************
                   Veterinary & Medical Module
    *****************************************************/
    public function veternrymedical()
    {
        $userid = Auth::user()->id;

        $pets = pets::where('users' , $userid)->get();

        $pettypes = DB::table('pettypes')->get();

        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();

        $bannerimage = $this->bannerimage('medicine');

        $checkpet = $this->checkuserpet();

        if(!empty($selectedpet))
        {
            $record = veterinaryandmedical::where('user' , $userid)->where('pets' , $selectedpet->pet)->get();
            $medicalnotes = medicalnotes::where('users' , $userid)->where('pets' , $selectedpet->pet)->get();
            $medicins = medicins::where('users' , $userid)->where('pets' , $selectedpet->pet)->get();
        }
        else
        {
            $record = 'null';
            $medicalnotes = 'null';
            $medicins = 'null';
        }

        return view('user-panel.veterinarymedical.index')->with(array('pets'=>$pets,'pettypes'=>$pettypes,'checkpet'=>$checkpet,'bannerimage'=>$bannerimage,'record'=>$record,'medicalnotes'=>$medicalnotes,'medicins'=>$medicins));
    }
    public function createveterinary(Request $request)
    {
        $useremail = Auth::user()->email;
        $paperwork = $this->sendimagetodirectory($request->file('paperwork') , $useremail);
        $medicine = new veterinaryandmedical;
        $medicine->user = Auth::user()->id;
        $medicine->pets  = $request->pets;
        $medicine->type = $request->type;
        $medicine->tittle = $request->tittle;
        $medicine->weight = $request->weight;
        $medicine->checkoff = $request->checkoff;
        $medicine->visitdate = $request->visitdate;
        $medicine->condition = $request->condition;
        $medicine->paperwork = $paperwork;
        $medicine->followupdate = $request->followupdate;
        $medicine->reason = $request->reason;
        $medicine->save();


        $schedule = new schedules;
        $schedule->users = Auth::user()->id;
        $schedule->pets =  $request->pets;
        $schedule->tittle = $request->tittle;
        $schedule->type = $request->type;
        $schedule->date = date("Y-m-d", strtotime($request->visitdate));
        $schedule->notes = $request->reason;
        $schedule->save();


        $schedule = new schedules;
        $schedule->users = Auth::user()->id;
        $schedule->pets =  $request->pets;
        $schedule->tittle = 'Follow Up '.$request->tittle;
        $schedule->type = $request->type;
        $schedule->date = date("Y-m-d", strtotime($request->followupdate));
        $schedule->notes = $request->reason;
        $schedule->save();


        return redirect()->back()->with('message', 'Record Added Successfully');
    }
    public function creatmedicalnotes(Request $request)
    {
        $useremail = Auth::user()->email;
        $notes = new medicalnotes;
        $notes->users = Auth::user()->id;
        $notes->pets  = $request->pets;
        $notes->notes = $request->notes;
        $notes->save();
        return redirect()->back()->with('message', 'Important Notes Added Successfully');
    }
    public function creatmedicins(Request $request)
    {
        $medicine = new medicins;
        $medicine->users = Auth::user()->id;
        $medicine->pets  = $request->pets;
        $medicine->medicin = $request->medicin;
        $medicine->save();
        return redirect()->back()->with('message', 'Medicine Added Successfully');
    }
    public function showmedicalrecord($id)
    {
        $data = veterinaryandmedical::where('id' , $id)->get()->first();
        echo '<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">'.$data->tittle.'</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row mb-2">
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">Visit Date</p>
                        <p class="mb-3">'.$data->visitdate.'</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">Follow Up type</p>
                        <p class="mb-3">'.$data->followupdate.'</p>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">Weight</p>
                        <p class="mb-3">'.$data->weight.'</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">Type</p>
                        <p class="mb-3">'.$data->type.'</p>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">Pet Condition</p>
                        <p class="mb-3">'.$data->condition.'</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">Check Off</p>
                        <p class="mb-3">'.$data->checkoff.'</p>
                    </div>
                </div>'; 
                if(!empty($data->paperwork)){
                    echo '<div class="row mb-3">
                        <div class="col-md-12">
                             <p class="mb-2">File</p>
                            <a download="" href="'.url("public/userdata").'/'.Auth::user()->email.'/'.$data->paperwork.'"><span class="iconsmind-File-Cloud"></span>Paper Work</a>
                        </div>
                    </div>';
                }

            echo '

                <div class="row mb-2">
                    <div class="col-md-12">
                        <p class="text-muted text-small mb-2">Notes</p>
                        <p class="mb-3">
                            '.$data->reason.'
                        </p>
                    </div>
                </div>
            </div>';
    }
    public function editmedicine($id)
    {
        $data = medicins::where('id' , $id)->get()->first();
        $userid = Auth::user()->id;
        $pets = pets::where('users' , $userid)->get();
        echo '<input type="hidden" value="'.$data->id.'" name="id">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label class="form-group has-float-label">
                        <select name="pets"  class="form-control select2-single" required="">
                            <option  value="" >Select Pet</option>';
                            foreach ($pets as $r) {
                               echo '<option '; if($r->id == $data->pets){ echo "selected "; }  echo 'value="'.$r->id.'">'.$r->petname.'</option>';
                            }
                        echo '</select>
                        <span>Select Pet</span>
                    </div>
                </div>
                               
                <div class="row mb-2 mt-2">
                    <div class="col-md-12">
                        <label class="form-group has-float-label">
                            <textarea name="medicin" class="form-control" type="text" placeholder="Put the medicins" rows="3">'.$data->medicin.'</textarea>
                            <span>Medicins</span>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-primary">Update Medicine</button>
                    </div>
                </div>';
    }
    public function editmedical($id)
    {
        $data = veterinaryandmedical::where('id' , $id)->get()->first();
        $userid = Auth::user()->id;
        $pets = pets::where('users' , $userid)->get();
        echo '<input type="hidden" value="'.$data->id.'" name="id">
                    <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-group has-float-label">
                        <select name="pets"  class="form-control select2-single" required="">
                            <option  value="" >Select Pet</option>';
                            foreach ($pets as $r) {
                               echo '<option '; if($r->id == $data->pets){ echo "selected "; }  echo 'value="'.$r->id.'">'.$r->petname.'</option>';
                            }
                        echo '</select>
                        <span>Select Pet</span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-group has-float-label">
                        <select name="type" class="form-control" required="">
                            <option value="">Select</option>
                            <option '; if($data->type == 'blood-work'){ echo "selected "; }  echo ' value="blood-work">Blood Work</option>
                            <option '; if($data->type == 'vaccination'){ echo "selected "; }  echo ' value="vaccination">Vaccination</option>
                            <option '; if($data->type == 'well-visits'){ echo "selected "; }  echo ' value="well-visits">Well Visits</option>
                            <option '; if($data->type == 'sick-visits'){ echo "selected "; }  echo ' value="sick-visits">Sick Visits</option>
                            <option '; if($data->type == 'Surgery'){ echo "selected "; }  echo ' value="surgery">Surgery</option>
                        </select>
                        <span>Medical Type</span>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label class="form-group has-float-label">
                            <input required="" value="'.$data->tittle.'" name="tittle" class="form-control" type="text" placeholder="eg. Ketty has some blood issues">
                            <span>Title</span>
                        </label>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-group has-float-label">
                            <input name="weight" value="'.$data->weight.'" class="form-control" type="text">
                            <span>Pets Weight</span>
                        </label>
                    </div>
                    <div class="col-md-6">
                       <label class="form-group has-float-label">
                            <input name="checkoff" value="'.$data->checkoff.'" class="form-control" placeholder="eg. Medicin, Vitamins" type="text">
                            <span>Check off</span>
                        </label>
                    </div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-group has-float-label">
                            <input required="" value="'.$data->visitdate.'" name="visitdate" class="form-control datepicker" placeholder="Date of Visit">
                            <span>Date of Visit</span>
                        </label>
                    </div>
                    <div class="col-md-6">
                       <label class="form-group has-float-label">
                        <select name="condition" class="form-control" required="">
                            <option value="">Select</option>
                            <option '; if($data->condition == 'normal'){ echo "selected "; }  echo ' value="normal">Normal</option>
                            <option '; if($data->condition == 'Critical'){ echo "selected "; }  echo ' value="Critical">Critical</option>
                        </select>
                        <span>Pets Condition</span>
                    </div>
                </div>

                

                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-group has-float-label">
                            <input name="paperwork" class="form-control" type="file">
                            <span>Diagnostic Paperwork</span>
                        </label>
                    </div>
                    <div class="col-md-6">
                       <label class="form-group has-float-label">
                            <input required="" value="'.$data->followupdate.'" name="followupdate" class="form-control datepicker" placeholder="Follow-Up Date">
                            <span>Follow-Up Date</span>
                        </label>
                    </div>
                </div>
                
                <div class="row mb-2 mt-2">
                    <div class="col-md-12">
                        <label class="form-group has-float-label">
                            <textarea name="reason" class="form-control" type="text" placeholder="" rows="3">'.$data->reason.'</textarea>
                            <span>Reason for the Visit</span>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-primary">Update Record</button>
                    </div>
                </div>';
    }
    public function updatemedicine(Request $request)
    {
        $id = $request->id;
        $data3 = array('medicin' => $request->medicin,'pets' => $request->pets);
        medicins::where('id', $id)->update($data3);
        return redirect()->back()->with('message', 'Medicine Updated Successfully');
    }
    public function updatemedicalrecord(Request $request)
    {
        $useremail = Auth::user()->email;
        $id =  $request->id;

        if(!empty($request->file('paperwork')))
        {
            $image = $this->sendimagetodirectory($request->file('paperwork') , $useremail);
            if($image == "limitexceded")
            {
                return redirect()->back()->with('warning', 'Memory Limit Exceded');
            }
            else
            { 
                $data1 = array('paperwork' => $image);
                veterinaryandmedical::where('id', $id)->update($data1);
                
            }
        }
        $data3 = array('pets' => $request->pets,'type' => $request->type,'tittle' => $request->tittle,'weight' => $request->weight,'checkoff' => $request->checkoff,'visitdate' => $request->visitdate,'condition' => $request->condition,'reason' => $request->reason,'followupdate' => $request->followupdate);
        veterinaryandmedical::where('id', $id)->update($data3);
        return redirect()->back()->with('message', 'Medical Record Updated Successfully');
    }
    /****************************************************
                   Change Remember Pet
    *****************************************************/
    public function changerememberPet($id)
    {
        $userid = Auth::user()->id;
        $data = array('pet' => $id);
        DB::table('rememberpet')->where('users', $userid)->update($data);
        return redirect()->back()->with('message', 'Your Pet Is Changed');
    }
    /****************************************************
                   Banner Image
    *****************************************************/
    public function savebannerimage(Request $request)
    {
        $userid = Auth::user()->id;
        $useremail = Auth::user()->email;
        $image = $this->sendimagetodirectory($request->file('image') , $useremail);

        if($image == 'limitexceded')
        {
            return redirect()->back()->with('warning', 'Memory Limit Exceded');
        }else{
            $checkimage = bannerimages::where('users' , $userid)->where('pets' , $request->pet)->where('pagename' , $request->page)->count();
            if($checkimage > 0)
            {
               $data = array('bannerimage' => $image);
               DB::table('bannerimages')->where('users', $userid)->where('pets' , $request->pet)->where('pagename' , $request->page)->update($data);
            }else{
                $bannerimages = new bannerimages;
                $bannerimages->users = Auth::user()->id;
                $bannerimages->pets  = $request->pet;
                $bannerimages->pagename  = $request->page;
                $bannerimages->bannerimage = $image;
                $bannerimages->save();
            }
            return redirect()->back()->with('message', 'Banner Image Updated Successfully');
        }
    }
    public function deletebannerimage($id)
    {
        bannerimages::where('id',$id)->delete();
        return redirect()->back()->with('message', 'Deleted Successfully');
    }
    /****************************************************
                   Allergy Module
    *****************************************************/
    public function viewallergy()
    {
        $userid = Auth::user()->id;

        $pets = pets::where('users' , $userid)->get();
        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();

        if(!empty($selectedpet))
        {
            $allergies = allergies::where('pets' , $selectedpet->pet)->where('users' , $userid)->get();
        }
        else
        {
            $allergies = 'null';
        }
        $checkpet = $this->checkuserpet();
        return view('user-panel.allergy.index')->with(array('pets'=>$pets,'allergies'=>$allergies,'checkpet'=>$checkpet));
    }
    public function createallergy(Request $request)
    {
        $useremail = Auth::user()->email;
        $image = $this->sendimagetodirectory($request->file('image') , $useremail);
        if($image == "limitexceded")
        {
            return redirect()->back()->with('warning', 'Memory Limit Exceded');
        }
        else
        {
            if($request->pets == 'all')
            {
                $pets = $this->getallpets();
                foreach ($pets as $r) {
                    $allergies = new allergies;
                    $allergies->users = Auth::user()->id;
                    $allergies->pets  = $r->id;
                    $allergies->tittle = $request->tittle;
                    $allergies->description = $request->description;
                    $allergies->type = $request->type;
                    $allergies->image = $image;
                    $allergies->save();
                }
                return redirect()->back()->with('message', 'Record Added Successfully');
            }
            else
            {
                $allergies = new allergies;
                $allergies->users = Auth::user()->id;
                $allergies->pets  = $request->pets;
                $allergies->tittle = $request->tittle;
                $allergies->description = $request->description;
                $allergies->type = $request->type;
                $allergies->image = $image;
                $allergies->save();
                return redirect()->back()->with('message', 'Record Added Successfully');
            }
        }
    }
    public function showallergy($id)
    {
        $allergy = allergies::where('id',$id)->get()->first();
        echo '<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">'.DB::table('pets')->where('id' , $allergy->pets)->get()->first()->petname.' - Play Exercise  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="row mb-2">
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">Allergy Tittle</p>
                        <h5>'.$allergy->tittle.'</h5> 
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted text-small mb-2">Allergy Type</p>
                        <p class="mb-3"> <span class="badge badge-primary">'.$allergy->type.'</span> </p>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <p class="text-muted text-small mb-2">Notes</p>
                        <p class="mb-3">'.$allergy->description.'</p>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <h6 class="theme-text"> <i class="simple-icon-picture"></i> &nbsp; Media</h6> <hr>
                    </div>
                </div>
                <div class="row mb-4">';
                        $checkextension = pathinfo($allergy->image, PATHINFO_EXTENSION);
                        if($checkextension == 'mp4')
                        {
                            echo '<video style="width: 100%; height: 500px;"  controls>
                                  <source src="'.url("public/userdata").'/'.Auth::user()->email.'/'.$allergy->image.'" type="video/mp4">
                                  <source src="movie.ogg" type="video/ogg">
                                  Your browser does not support the video tag.
                                </video>';
                        }
                        else
                        {
                            echo '<div class="col-md-4"><img onclick="showimageallergy('.$allergy->id.')" alt="Thumbnail" src="'.url("public/userdata").'/'.Auth::user()->email.'/'.$allergy->image.'" class="list-thumbnail-thumb-half responsive border-0" /></div>';
                        }
                        
                    echo '</div>';
    }
    public function showimageallergy($id)
    {
        $exercise = allergies::where('id',$id)->get()->first();
        echo '<div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <img alt="Thumbnail" src="'.url("public/userdata").'/'.Auth::user()->email.'/'.$exercise->image.'" class="list-thumbnail-thumb-xfull responsive border-0" />
                    </div>
                </div>
            </div>';
    }
    public function editallergy($id)
    {
        $data = allergies::where('id',$id)->get()->first();

        $dataimage = url("public/userdata").'/'.Auth::user()->email.'/'.$data->image;

        return response()->json(['image' => $dataimage,'playexercisesid' => $data->id,'tittle' => $data->tittle,'pets' => $data->pets,'type' => $data->type,'specialnotes' => $data->description]);
    }
    public function updateallergy(Request $request)
    {
        $useremail = Auth::user()->email;
        $id =  $request->id;

        if(!empty($request->file('image')))
        {
            $image = $this->sendimagetodirectory($request->file('image') , $useremail);
            if($image == "limitexceded")
            {
                return redirect()->back()->with('warning', 'Memory Limit Exceded');
            }
            else
            { 
                $data1 = array('image' => $image);
                allergies::where('id', $id)->update($data1);
                
            }
        }
        $data3 = array('pets' => $request->pets,'type' => $request->type,'tittle' => $request->tittle,'description' => $request->description);
        allergies::where('id', $id)->update($data3);
        return redirect()->back()->with('message', 'Allergy Updated Successfully');
    }
    /****************************************************
                   Sleep And Relyx Module
    *****************************************************/
    public function viewsleeprelyx()
    {
        $userid = Auth::user()->id;
        $pets = pets::where('users' , $userid)->get();
        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        $bannerimage = $this->bannerimage('sleepandrelyx');
        if(!empty($selectedpet))
        {
            $sleeppets = sleeppets::where('pets' , $selectedpet->pet)->where('users' , $userid)->get();
        }
        else
        {
            $sleeppets = 'null';
        }
        $checkpet = $this->checkuserpet();
        return view('user-panel.sleepandrelyx.index')->with(array('pets'=>$pets,'sleeppets'=>$sleeppets,'checkpet'=>$checkpet,'bannerimage'=>$bannerimage));
    }
    public function creatsleeprelyx(Request $request)
    {
        $useremail = Auth::user()->email;
        if(!empty($request->file('image')))
        {
            $image = $this->sendimagetodirectory($request->file('image') , $useremail);
            if($image == "limitexceded")
            {
                return redirect()->back()->with('warning', 'Memory Limit Exceded');
            }
            else
            {
                if($request->pets == 'all')
                {
                    $pets = $this->getallpets();
                    foreach ($pets as $r) {
                        $sleep = new sleeppets;
                        $sleep->users = Auth::user()->id;
                        $sleep->pets  = $r->id;
                        $sleep->favourite = $request->favourite;
                        $sleep->sleepsopt = $request->sleepsopt;
                        $sleep->sleeptiming = $request->sleeptiming;
                        $sleep->disturbancenotes = $request->disturbancenotes;
                        $sleep->notes = $request->notes;
                        $sleep->image = $image;
                        $sleep->save();
                    }
                    return redirect()->back()->with('message', 'Record Added Successfully');
                }
                else
                {
                    $sleep = new sleeppets;
                    $sleep->users = Auth::user()->id;
                    $sleep->pets  = $request->pets;
                    $sleep->favourite = $request->favourite;
                    $sleep->sleepsopt = $request->sleepsopt;
                    $sleep->sleeptiming = $request->sleeptiming;
                    $sleep->disturbancenotes = $request->disturbancenotes;
                    $sleep->notes = $request->notes;
                    $sleep->image = $image;
                    $sleep->save();
                    return redirect()->back()->with('message', 'Record Added Successfully');
                }
            }
        }else{
            $sleep = new sleeppets;
            $sleep->users = Auth::user()->id;
            $sleep->pets  = $request->pets;
            $sleep->favourite = $request->favourite;
            $sleep->sleepsopt = $request->sleepsopt;
            $sleep->sleeptiming = $request->sleeptiming;
            $sleep->disturbancenotes = $request->disturbancenotes;
            $sleep->notes = $request->notes;
            $sleep->save();
            return redirect()->back()->with('message', 'Record Added Successfully');
        }
         
    }
    public function showsleeprelyx($id)
    {
        $data = sleeppets::where('id' , $id)->get()->first();
        $pet = pets::where('id' , $data->pets)->get()->first();
        echo '<div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">'.$pet->petname.'</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <p class="text-muted text-small mb-2">Sleeping Spot</p>
                            <p class="mb-3">'.$data->sleepsopt.'</p>
                        </div>
                        
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <p class="text-muted text-small mb-2">Timing</p>
                            <p class="mb-3">'.$data->sleeptiming.'</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted text-small mb-2">Type</p>
                            <p class="mb-3"> <span class="badge badge-danger">'.$data->favourite.'</span> </p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <p class="text-muted text-small mb-2">Disturbance Notes</p>
                            <p class="mb-3">
                                <span class="simple-icon-bell"></span>
                                '.$data->disturbancenotes.'
                             </p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <p class="text-muted text-small mb-2">Notes</p>
                            <p class="mb-3">
                                '.$data->notes.'
                            </p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <h6 class="theme-text"> <i class="simple-icon-picture"></i> &nbsp; Media</h6> <hr>
                        </div>
                    </div>';
                    if(!empty($data->image))
                    {
                        echo '<div class="row mb-4">';
                        $checkextension = pathinfo($data->image, PATHINFO_EXTENSION);
                        if($checkextension == 'mp4')
                        {
                            echo '<video style="width: 100%; height: 500px;"  controls>
                                  <source src="'.url("public/userdata").'/'.Auth::user()->email.'/'.$data->image.'" type="video/mp4">
                                  <source src="movie.ogg" type="video/ogg">
                                  Your browser does not support the video tag.
                                </video>';
                        }
                        else
                        {
                            echo '<div class="col-md-4"><img onclick="showimage('.$data->id.')" alt="Thumbnail" src="'.url("public/userdata").'/'.Auth::user()->email.'/'.$data->image.'" class="list-thumbnail-thumb-half responsive border-0" /></div>';
                        }
                        
                    echo '</div>';
                    }
                    
    }
    public function updatesleeprelyx(Request $request)
    {
        $useremail = Auth::user()->email;
        $id =  $request->id;

        if(!empty($request->file('image')))
        {
            $image = $this->sendimagetodirectory($request->file('image') , $useremail);
            if($image == "limitexceded")
            {
                return redirect()->back()->with('warning', 'Memory Limit Exceded');
            }
            else
            { 
                $data1 = array('image' => $image);
                sleeppets::where('id', $id)->update($data1);
                
            }
        }
        $data3 = array('pets' => $request->pets,'favourite' => $request->favourite,'sleepsopt' => $request->sleepsopt,'sleeptiming' => $request->sleeptiming,'disturbancenotes' => $request->disturbancenotes,'notes' => $request->notes);
        sleeppets::where('id', $id)->update($data3);
        return redirect()->back()->with('message', 'Record Updated Successfully');
    }
    public function editsleeppets($id)
    {
        $data = sleeppets::where('id' , $id)->get()->first();
        $userid = Auth::user()->id;
        $pets = pets::where('users' , $userid)->get();
        echo '<input type="hidden" value="'.$data->id.'" name="id">
                    <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-group has-float-label">
                        <select name="pets"  class="form-control select2-single" required="">
                            <option  value="" >Select Pet</option>';
                            foreach ($pets as $r) {
                               echo '<option '; if($r->id == $data->pets){ echo "selected "; }  echo 'value="'.$r->id.'">'.$r->petname.'</option>';
                            }
                        echo '</select>
                        <span>Select Pet</span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-group has-float-label">
                        <select name="favourite" class="form-control" required="">
                            <option value="">Select</option>
                            <option '; if($data->favourite == 'Regular'){ echo "selected "; }  echo ' value="Regular">Regular</option>
                            <option '; if($data->favourite == 'Most Probably'){ echo "selected "; }  echo ' value="Most Probably">Most Probably</option>
                            <option '; if($data->favourite == 'Favourite'){ echo "selected "; }  echo ' value="Favourite">Favourite</option>
                        </select>
                        <span>Medical Type</span>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label class="form-group has-float-label">
                            <input required="" value="'.$data->sleepsopt.'" name="sleepsopt" class="form-control" type="text" placeholder="eg. Bed, floor">
                            <span>Sleeping Spot</span>
                        </label>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label class="form-group has-float-label">
                            <input required="" value="'.$data->sleeptiming.'" name="sleeptiming" class="form-control" type="time">
                            <span>Timing</span>
                        </label>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12">
                        <label class="form-group has-float-label">
                            <textarea name="disturbancenotes" class="form-control" type="text" placeholder="eg. When they want to Relax, When Workmen Come" rows="3">'.$data->disturbancenotes.'</textarea>
                            <span>Disturbance Notes</span>
                        </label>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12">
                        <label class="form-group has-float-label">
                            <textarea name="notes" class="form-control" type="text" placeholder="Bedtime Routine, " rows="3">'.$data->notes.'</textarea>
                            <span>Notes</span>
                        </label>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label class="form-group has-float-label">
                            <input class="form-control" type="file" name="image">
                            <span>Add Picture</span>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-primary">Update Record</button>
                    </div>
                </div>';
    }
    /****************************************************
                   Training Module
    *****************************************************/
    public function viewtraining()
    {
        $userid = Auth::user()->id;

        $pets = pets::where('users' , $userid)->get();
        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        $bannerimage = $this->bannerimage('training');
        if(!empty($selectedpet))
        {
            $data = training::where('pets' , $selectedpet->pet)->where('users' , $userid)->get();
            $vocabulary = vocabularies::where('pets' , $selectedpet->pet)->where('users' , $userid)->get();
        }
        else
        {
            $data = 'null';
            $vocabulary = 'null';
        }
        $checkpet = $this->checkuserpet();
        return view('user-panel.training.index')->with(array('pets'=>$pets,'data'=>$data,'vocabulary'=>$vocabulary,'checkpet'=>$checkpet,'bannerimage'=>$bannerimage));
    }
    public function creattraining(Request $request)
    {
        $useremail = Auth::user()->email;
        $image = $this->sendimagetodirectory($request->file('image') , $useremail);
        if($request->pets == 'all')
        {
            $pets = $this->getallpets();
            foreach ($pets as $r) {
                $training = new training;
                $training->users = Auth::user()->id;
                $training->pets  = $r->id;
                $training->type = $request->type;
                $training->activityname = $request->activityname;
                $training->direction = $request->direction;
                $training->image = $image;
                $training->save();
            }
            return redirect()->back()->with('message', 'Record Added Successfully');
        }
        else
        {
            $training = new training;
            $training->users = Auth::user()->id;
            $training->pets  = $request->pets;
            $training->type = $request->type;
            $training->activityname = $request->activityname;
            $training->direction = $request->direction;
            $training->image = $image;
            $training->save();
            return redirect()->back()->with('message', 'Record Added Successfully');
        }
        
    }
    public function creatvocabulary(Request $request)
    {
        if($request->pets == 'all')
        {
            $pets = $this->getallpets();
            foreach ($pets as $r) {
                $vacabulary = new vocabularies;
                $vacabulary->users = Auth::user()->id;
                $vacabulary->pets  = $r->id;
                $vacabulary->type = $request->type;
                $vacabulary->word = $request->word;
                $vacabulary->command = $request->command;
                $vacabulary->defination = $request->defination;
                $vacabulary->reward = $request->reward;
                $vacabulary->save();
            }
            return redirect()->back()->with('message', 'Record Added Successfully');
        }else
        {
            $vacabulary = new vocabularies;
            $vacabulary->users = Auth::user()->id;
            $vacabulary->pets  = $request->pets;
            $vacabulary->type = $request->type;
            $vacabulary->word = $request->word;
            $vacabulary->command = $request->command;
            $vacabulary->defination = $request->defination;
            $vacabulary->reward = $request->reward;
            $vacabulary->save();
            return redirect()->back()->with('message', 'Record Added Successfully');
        }
        
    }
    /****************************************************
                   Boarding and Day Care Module
    *****************************************************/
    public function viewboardingdaycare()
    {
        $userid = Auth::user()->id;

        $pets = pets::where('users' , $userid)->get();
        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        $bannerimage = $this->bannerimage('boarding');
        if(!empty($selectedpet))
        {
            $boardings = boardings::where('pets' , $selectedpet->pet)->where('users' , $userid)->where('type' , 'boardings')->get()->first();
            $day = boardings::where('pets' , $selectedpet->pet)->where('users' , $userid)->where('type' , 'day-care')->get()->first();
            $walker = boardings::where('pets' , $selectedpet->pet)->where('users' , $userid)->where('type' , 'walker-sitter')->get()->first();
            $other = boardings::where('pets' , $selectedpet->pet)->where('users' , $userid)->where('type' , 'other')->get()->first();
        }
        else
        {
            $boardings = 'null';
        }
        $checkpet = $this->checkuserpet();
        return view('user-panel.boarding.index')->with(array('pets'=>$pets,'boardings'=>$boardings,'day'=>$day,'walker'=>$walker,'other'=>$other,'checkpet'=>$checkpet,'bannerimage'=>$bannerimage));
    }
    public function checkpetforboarding($id)
    {
        $data = boardings::where('pets' , $id)->get();
        if($data->count())
        {
            $type = $data->first()->type;
            if($type == 'boardings')
            {
                $types =  '<option value="day-care">Day Care</option><option value="walker-sitter">Walker or Sitter</option><option value="other">Other</option>';
            }
            if($type == 'day-care')
            {
                $types =  '<option value="boardings">Boardings</option><option value="walker-sitter">Walker or Sitter</option><option value="other">Other</option>';
            }
            if($type == 'walker-sitter')
            {
                $types =  '<option value="boardings">Boardings</option><option value="day-care">Day Care</option><option value="other">Other</option>';
            }
            if($type == 'other')
            {
                $types =  '<option value="boardings">Boardings</option><option value="day-care">Day Care</option><option value="walker-sitter">Walker or Sitter</option>';
            }
        }else{
            $types =  '<option selected="" disabled="">Select</option>
                        <option value="day-care">Day Care</option>
                        <option value="boardings">Boardings</option>
                        <option value="walker-sitter">Walker or Sitter</option>
                        <option value="other">Other</option>';
        }
        $petdata = pets::where('id' , $id)->get()->first();
        return response()->json(['types' => $types,'petownercontact' => $petdata->petownercontact,'petowneremail' => $petdata->petowneremail]);
    }
    public function createboarding(Request $request)
    {
        $id = rand('20000' , '5000000');
        $useremail = Auth::user()->email;
        if($files=$request->file('images')){
        $files=$request->file('images');
            foreach($files as $file){
                $imagename = $this->sendimagetodirectory($file , $useremail);
                DB::statement("INSERT INTO `mediaimages` (`productid`, `image`)VALUES ('$id', '$imagename')");
            }
        }
        if($request->pets == 'all')
        {
            $pets = $this->getallpets();
            foreach ($pets as $r) {
                $boarding = new boardings;
                $boarding->boardingid  = $id;
                $boarding->users = Auth::user()->id;
                $boarding->pets  = $r->id;
                $boarding->type = $request->type;
                $boarding->name = $request->name;
                $boarding->contact = $request->contact;
                $boarding->email = $request->email;
                $boarding->website = $request->website;
                $boarding->cost = $request->cost;
                $boarding->notes = $request->notes;
                $boarding->importantnotes = $request->importantnotes;
                $boarding->save();
            }
            return redirect()->back()->with('message', 'Record Added Successfully');
        }else
        {
            $boarding = new boardings;
            $boarding->users = Auth::user()->id;
            $boarding->boardingid  = $id;
            $boarding->pets  = $request->pets;
            $boarding->type = $request->type;
            $boarding->name = $request->name;
            $boarding->contact = $request->contact;
            $boarding->email = $request->email;
            $boarding->website = $request->website;
            $boarding->cost = $request->cost;
            $boarding->notes = $request->notes;
            $boarding->importantnotes = $request->importantnotes;
            $boarding->save();
            return redirect()->back()->with('message', 'Record Added Successfully');
        }
        
    }
    /****************************************************
                   Journal Module
    *****************************************************/
    public function viewjournal()
    {
        $userid = Auth::user()->id;

        $pets = pets::where('users' , $userid)->get();
        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        if(!empty($selectedpet))
        {
            $data = journals::where('pets' , $selectedpet->pet)->where('users' , $userid)->orderBy('created_at', 'desc')->limit(5)->get();
        }
        else
        {
            $data = 'null';
        }
        $checkpet = $this->checkuserpet();
        return view('user-panel.journal.index')->with(array('pets'=>$pets,'data'=>$data,'checkpet'=>$checkpet));
    }
    public function createjournal(Request $request)
    {
        $useremail = Auth::user()->email;
        $image = $this->sendimagetodirectory($request->file('image') , $useremail);
        $journal = new journals;
        $journal->users = Auth::user()->id;
        $journal->pets  = $request->pets;
        $journal->tittle = $request->tittle;
        $journal->date = $request->date;
        $journal->description = $request->description;
        $journal->image = $image;
        $journal->save();
        return redirect()->back()->with('message', 'Journal Added Successfully');
    }
    public function journalloaddata(Request $request)
    {
        $output = '';
        $id = $request->id;
        $userid = Auth::user()->id;
        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        $posts = journals::where('pets' , $selectedpet->pet)->where('id','<',$id)->where('users' , $userid)->limit(6)->get();
        
        if(!$posts->isEmpty())
        {
            foreach($posts as $r)
            {
                                
                $output .= '<div class="d-flex flex-row mb-3 pb-3 hover-on pt-3">
                                <div class="col-md-2 col-3 br-left-1">
                                    <a href="#" class="">
                                        <div class="text-center">
                                            <h2><i class="simple-icon-calendar text-theme"></i></h2>
                                            <small class="text-theme">'.$r->date.'</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-10 col-9">
                                    <div class="pl-3 pr-2">
                                        <a href="#">
                                            <p class="font-weight-medium mb-0">'.$r->tittle.'
                                            </p>
                                            <p class="text-muted mb-1 text-small mt-2">'.Str::limit($r->description, 150).'<a data-toggle="collapse" data-target="#collapseid'.$r->id.'" href="javascript:void(0)" class="link-text">more</a>

                                                <div class="row collapse" id="collapseid'.$r->id.'">
                                                    <div class="col-md-12">
                                                        <div class="mt-2 mb-2">
                                                            <p>'.$r->description.'</p>
                                                        </div>
                                                        <img alt="Thumbnail" src="'.url("public/userdata").'/'.Auth::user()->email.'/'.$r->image.'" class="list-thumbnail-thumb-full responsive border-0" />
                                                    </div>
                                                </div>
                                            </p>
                                        </a>
                                    </div>
                                    
                                </div>
                            </div>';
            }
            
            $output .= '<div id="remove-row">
                    <button id="btn-more" data-id="'.$r->id.'" class="mb-5 btn btn-block btn-default " data-toggle="collapse" data-target="#demo">
                        Load more
                    </button>
                </div>';
            
            echo $output;
        }
    }
    public function filterjournal($id)
    {
        $userid = Auth::user()->id;


        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        if($id == 'This Month')
        {
            $data = journals::where('pets' , $selectedpet->pet)->where('users' , $userid)->whereMonth('created_at', Carbon::now()->month)->orderBy('created_at', 'desc')->get();
        }
        if($id == 'All')
        {
            $data = journals::where('pets' , $selectedpet->pet)->where('users' , $userid)->orderBy('created_at', 'desc')->get();
        }
        if($id == 'This Week')
        {
            $data = journals::where('pets' , $selectedpet->pet)->where('users' , $userid)->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->orderBy('created_at', 'desc')->get();
        }
        if($id == 'Today')
        {
            $data = journals::where('pets' , $selectedpet->pet)->where('users' , $userid)->whereDate('created_at', Carbon::today())->orderBy('created_at', 'desc')->get();

        }
        
        if($data->count() > 0)
        {

        foreach($data as $r)
            {
                                
                echo '<div class="d-flex flex-row mb-3 pb-3 hover-on pt-3">
                                <div class="col-md-2 col-3 br-left-1">
                                    <a href="#" class="">
                                        <div class="text-center">
                                            <h2><i class="simple-icon-calendar text-theme"></i></h2>
                                            <small class="text-theme">'.$r->date.'</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-10 col-9">
                                    <div class="pl-3 pr-2">
                                        <a href="#">
                                            <p class="font-weight-medium mb-0">'.$r->tittle.'
                                            </p>
                                            <p class="text-muted mb-1 text-small mt-2">'.Str::limit($r->description, 150).'<a data-toggle="collapse" data-target="#collapseid'.$r->id.'" href="javascript:void(0)" class="link-text">more</a>

                                                <div class="row collapse" id="collapseid'.$r->id.'">
                                                    <div class="col-md-12">
                                                        <div class="mt-2 mb-2">
                                                            <p>'.$r->description.'</p>
                                                        </div>
                                                        <img alt="Thumbnail" src="'.url("public/userdata").'/'.Auth::user()->email.'/'.$r->image.'" class="list-thumbnail-thumb-full responsive border-0" />
                                                    </div>
                                                </div>
                                            </p>
                                        </a>
                                    </div>
                                    
                                </div>
                            </div>';
            }
        }else{
            echo "empty";
        }
        
    }
    /****************************************************
                   Groomer Module
    *****************************************************/
    public function viewgroomer()
    {
        $userid = Auth::user()->id;

        $pets = pets::where('users' , $userid)->get();
        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        if(!empty($selectedpet))
        {
            $data = groomer::where('pets' , $selectedpet->pet)->where('users' , $userid)->get();
        }
        else
        {
            $data = 'null';
        }
        $checkpet = $this->checkuserpet();
        return view('user-panel.groomer.index')->with(array('pets'=>$pets,'data'=>$data,'checkpet'=>$checkpet));
    }
    public function getallgroomer($id)
    {
        $data =  phonebooks::where('pets',$id)->get();
        if($data->count() > 0)
        {
            foreach ($data as $r) {
                echo '<option value="'.$r->name.'">'.$r->name.'</option>';
            }
        }else{
            echo "string";
        }
        
    }
    public function creategroomer(Request $request)
    {
        $groomer = new groomer;
        $groomer->users = Auth::user()->id;
        $groomer->pets  = $request->pets;
        $groomer->tittle = $request->tittle;
        $groomer->date = $request->date;
        $groomer->time = $request->time;
        $groomer->specialist = $request->specialist;
        $groomer->notes = $request->notes;
        $groomer->status = 1;
        if(!empty($request->activity))
        {
            $groomer->activity = implode("|",$request->activity);
        }
        $groomer->save();

        $schedule = new schedules;
        $schedule->users = Auth::user()->id;
        $schedule->pets =  $request->pets;
        $schedule->tittle = $request->tittle;
        $schedule->type = 'Grooming';
        $schedule->date = $request->date;
        $schedule->time = $request->time;
        $schedule->notes = $request->notes;
        $schedule->save();


        return redirect()->back()->with('message', 'Groomer Added Successfully');
    }

    /****************************************************
                   Subscriptions Module
    *****************************************************/
    public function viewsubscrptionplans()
    {
        $data = plans::where('published' , 1)->get();
        return view('user-panel.subscription.plans')->with(array('data'=>$data));
    }
    public function purchaseplan($id)
    {
        $data = plans::where('id' , $id)->get()->first();
        return view('user-panel.purchase')->with(array('data'=>$data));
    }
    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => $request->price * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com." 
        ]);

        $checksubscription = subscriptions::where('users' , Auth::user()->id)->count();
        if($checksubscription > 0)
        {
            $data = array('plans'=>$request->planid);
            DB::table('subscriptions')->where('users' , Auth::user()->id)->update($data);
        }else{
            $subscribe = new subscriptions;
            $subscribe->users = Auth::user()->id;
            $subscribe->plans = $request->planid;
            $subscribe->spaceused = 0;
            $subscribe->save();
        }
        $history = new payementhistory;
        $history->users = Auth::user()->id;
        $history->payement = $request->price;
        $history->save();

        return redirect()->back()->with('message', 'You have successfully purchased the plan, you can continue using the system. Enjoy the journey');
    }
    /****************************************************
                   Access Module
    *****************************************************/
    public function viewaccess()
    {
        $userid = Auth::user()->id;

        $pets = pets::where('users' , $userid)->get();
        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        if(!empty($selectedpet))
        {
            $data = access::where('pets' , $selectedpet->pet)->where('users' , $userid)->get();
        }
        else
        {
            $data = 'null';
        }
        $checkpet = $this->checkuserpet();
        return view('user-panel.access.index')->with(array('pets'=>$pets,'data'=>$data,'checkpet'=>$checkpet));
    }
    public function invitenewuser(Request $request)
    {
        $checkemail = user::where('email' , $request->email)->count();
        if($checkemail == 0)
        {
            $accessid = rand('1000' , '20000');
            $access = new access;
            $access->id = $accessid;
            $access->users = Auth::user()->id;
            $access->pets  = $request->pets;
            $access->name = $request->name;
            $access->email = $request->email;
            $access->label = $request->label;
            $access->phone = $request->phone;
            $access->status = 'Not Accepted';
            $access->enablestatus = 1;
            $access->accessusers = implode("|",$request->modeules); 
            $access->save();
            $email = $request->email;
            $subject = 'You have been invited to join Pets Protect as a '. $request->label.'';
            $requesturl = url('setpassword').'/'.$accessid.'/'.$request->email;
            $petname = pets::where('id' , $request->pets)->get()->first()->petname;
            Mail::send(array('html' => 'emails.invitation'), array('name' => $request->name,'email' => $request->email,'label' => $request->label,'requesturl' => $requesturl,'petname' => $petname), function($message) use ($email, $subject)
            {
                $message->to($email)->subject($subject);
            });
            return redirect()->back()->with('message', 'New User Invited Successfully');
        }
        else{
            $accessid = rand('1000' , '20000');
            $access = new access;
            $access->id = $accessid;
            $access->users = Auth::user()->id;
            $access->pets  = $request->pets;
            $access->name = $request->name;
            $access->email = $request->email;
            $access->label = $request->label;
            $access->phone = $request->phone;
            $access->status = 'Not Accepted';
            $access->enablestatus = 1;
            $access->accessusers = implode("|",$request->modeules); 
            $access->save();
            $email = $request->email;
            $subject = 'You have been invited to join Pets Protect as a '. $request->label.'';
            $requesturl = url('setpassword').'/'.$accessid.'/'.$request->email;
            $petname = pets::where('id' , $request->pets)->get()->first()->petname;
            Mail::send(array('html' => 'emails.invitation'), array('name' => $request->name,'email' => $request->email,'label' => $request->label,'requesturl' => $requesturl,'petname' => $petname), function($message) use ($email, $subject)
            {
                $message->to($email)->subject($subject);
            });
            return redirect()->back()->with('message', 'New User Invited Successfully');
        }
    }
    public function checkemail($id)
    {
        $data = user::where('email' , $id)->count();
        if($data >= 1)
        {
            echo "user";
        }else{
            echo "notuser";
        }
    }
    public function deleteuserforaccess($id)
    {
        $userid = user::where('accessid' , $id)->get()->first()->id;
        DB::table('rememberpet')->where('users' , $id)->delete();
        user::where('accessid' , $id)->delete();
        accesses::where('id' , $id)->delete();
        return redirect()->back()->with('message', 'Deleted Successfully');
    }
    public function getuseredit($id)
    {
        $userid = Auth::user()->id;
        $data = access::where('id' , $id)->get()->first();
        $pets = pets::where('users' , $userid)->get();

        echo '<input type="hidden" value="'.$data->id.'" name="id">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label class="form-group has-float-label">
                        <select name="pets"  class="form-control select2-single" required="">
                            <option  value="" >Select Pet</option>';
                            foreach ($pets as $r) {
                               echo '<option '; if($r->id == $data->pets){ echo "selected "; }  echo 'value="'.$r->id.'">'.$r->petname.'</option>';
                            }
                        echo '</select>
                        <span>Select Pet</span>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-group has-float-label">
                            <input class="form-control" value="'.$data->name.'" type="text" required name="name" placeholder="Full name">
                            <span>Full name</span>
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label class="form-group has-float-label">
                            <input value="'.$data->phone.'" class="form-control" type="text" name="phone">
                            <span>Phone Number</span>
                        </label>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label class="form-group has-float-label">
                            <input readonly class="form-control" value="'.$data->email.'" type="text" required name="email" >
                            <span>Email</span>
                        </label>
                        <div style="color: red;" id="emailwarning"></div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label class="form-group has-float-label">
                            <input value="'.$data->label.'" class="form-control" type="text" required="" name="label" placeholder="eg. Doctor">
                            <span>Add Lable</span>
                        </label>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12 col-7">
                        <label>Modules Access</label>
                        <select class="form-control select2-multiple" required="" name="modeules[]" multiple="multiple">
                            <option '; 

                            foreach(explode('|', $data->accessusers) as $module)
                            {
                                if($module == 'journal'){
                                    echo "selected ";
                                }
                            }



                             echo ' value="journal">Journal</option>
                            <option '; 

                            foreach(explode('|', $data->accessusers) as $module)
                            {
                                if($module == 'schedule'){
                                    echo "selected ";
                                }
                            }



                             echo ' value="schedule">Schedule</option>
                            <option '; 

                            foreach(explode('|', $data->accessusers) as $module)
                            {
                                if($module == 'phonebook'){
                                    echo "selected ";
                                }
                            }



                             echo ' value="phonebook">Phonebook</option>
                            <option '; 

                            foreach(explode('|', $data->accessusers) as $module)
                            {
                                if($module == 'receiept'){
                                    echo "selected ";
                                }
                            }



                             echo ' value="receiept">Receiept</option>
                            <option '; 

                            foreach(explode('|', $data->accessusers) as $module)
                            {
                                if($module == 'medicine'){
                                    echo "selected ";
                                }
                            }



                             echo ' value="medicine">Medicine</option>
                            <option '; 

                            foreach(explode('|', $data->accessusers) as $module)
                            {
                                if($module == 'allergy'){
                                    echo "selected ";
                                }
                            }



                             echo ' value="allergy">Allergy</option>
                            <option '; 

                            foreach(explode('|', $data->accessusers) as $module)
                            {
                                if($module == 'playandexercise'){
                                    echo "selected ";
                                }
                            }



                             echo ' value="playandexercise">Play & Exercise</option>
                            <option '; 

                            foreach(explode('|', $data->accessusers) as $module)
                            {
                                if($module == 'feading'){
                                    echo "selected ";
                                }
                            }



                             echo ' value="feading">Feeding & Treats</option>
                            <option '; 

                            foreach(explode('|', $data->accessusers) as $module)
                            {
                                if($module == 'sleepandrelax'){
                                    echo "selected ";
                                }
                            }



                             echo ' value="sleepandrelax">Sleep & Relax</option>
                            <option '; 

                            foreach(explode('|', $data->accessusers) as $module)
                            {
                                if($module == 'likeanddislike'){
                                    echo "selected ";
                                }
                            }



                             echo ' value="likeanddislike">Likes & Dislikes</option>
                            <option '; 

                            foreach(explode('|', $data->accessusers) as $module)
                            {
                                if($module == 'trainingandvocabulary'){
                                    echo "selected ";
                                }
                            }



                             echo ' value="trainingandvocabulary">Training & Vocabulary</option>
                            <option '; 

                            foreach(explode('|', $data->accessusers) as $module)
                            {
                                if($module == 'boarding'){
                                    echo "selected ";
                                }
                            }



                             echo ' value="boarding">Boarding & Daycare</option>

                            
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button id="inviteuserbitton" class="btn btn-primary">Update User Access</button>
                    </div>
                </div>';

    }
    public function updateaccessuser(Request $request)
    {
        $useremail = Auth::user()->email;
        $id =  $request->id;
        $data = array('pets' => $request->pets,'name' => $request->name,'phone' => $request->phone,'label' => $request->label,'accessusers' => implode("|",$request->modeules));
        access::where('id', $id)->update($data);
        return redirect()->back()->with('message', 'User Access Updated Successfully');
    }
    
}   
