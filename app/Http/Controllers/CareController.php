<?php

namespace App\Http\Controllers;

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
use DB;
use Auth;
class CareController extends Controller
{
    public function checkpetuser($id)
    {
        return pets::where('id' , $id)->get()->first()->users;
    }
    public function petdetails($id)
    {
    	$email = Auth::user()->email;
        $userid = Auth::user()->id;
    	$selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        $selectedpetname = pets::where('id' , $selectedpet->pet)->get()->first();
        $pet = pets::where('id' , $id)->get()->first();
        return view('care-taker.pet-detail')->with(array('pet'=>$pet,'selectedpetname'=>$selectedpetname));
    }
    public function journal()
    {
    	$email = Auth::user()->email;
        $userid = Auth::user()->id;
        $getaccessdata = access::where('email' , $email)->get();
    	$selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        $petuser = $this->checkpetuser($selectedpet->pet);
        $selectedpetname = pets::where('id' , $selectedpet->pet)->get()->first();
        $data = journals::where('pets' , $selectedpet->pet)->where('users' , $petuser)->get();
        return view('care-taker.journal-detail')->with(array('data'=>$data,'pets'=>$getaccessdata,'selectedpetname'=>$selectedpetname));
    }
    public function phonebook()
    {
        $email = Auth::user()->email;
        $userid = Auth::user()->id;
        $getaccessdata = access::where('email' , $email)->get();
        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        $petuser = $this->checkpetuser($selectedpet->pet);
        $selectedpetname = pets::where('id' , $selectedpet->pet)->get()->first();
        $data = phonebooks::where('pets' , $selectedpet->pet)->where('users' , $petuser)->get();
        return view('care-taker.contacts-detail')->with(array('phone'=>$data,'pets'=>$getaccessdata,'selectedpetname'=>$selectedpetname));
    }
    public function receiept()
    {
        $email = Auth::user()->email;
        $userid = Auth::user()->id;
        $getaccessdata = access::where('email' , $email)->get();
        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        $petuser = $this->checkpetuser($selectedpet->pet);
        $selectedpetname = pets::where('id' , $selectedpet->pet)->get()->first();
        $data = receipts::where('pets' , $selectedpet->pet)->where('users' , $petuser)->get();
        return view('care-taker.recepit-detail')->with(array('receiept'=>$data,'pets'=>$getaccessdata,'selectedpetname'=>$selectedpetname));
    }
    public function boardingdaycare()
    {
        $email = Auth::user()->email;
        $userid = Auth::user()->id;
        $getaccessdata = access::where('email' , $email)->get();
        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        $petuser = $this->checkpetuser($selectedpet->pet);
        $selectedpetname = pets::where('id' , $selectedpet->pet)->get()->first();
        $boardings = boardings::where('pets' , $selectedpet->pet)->where('users' , $petuser)->where('type' , 'boardings')->get()->first();
        $day = boardings::where('pets' , $selectedpet->pet)->where('users' , $petuser)->where('type' , 'day-care')->get()->first();
        $walker = boardings::where('pets' , $selectedpet->pet)->where('users' , $petuser)->where('type' , 'walker-sitter')->get()->first();
        $other = boardings::where('pets' , $selectedpet->pet)->where('users' , $petuser)->where('type' , 'other')->get()->first();


        return view('care-taker.boarding-detail')->with(array('boardings'=>$boardings,'day'=>$day,'walker'=>$walker,'other'=>$other,'pets'=>$getaccessdata,'selectedpetname'=>$selectedpetname));
    }
    public function veterinarymedical()
    {
        $email = Auth::user()->email;
        $userid = Auth::user()->id;
        $getaccessdata = access::where('email' , $email)->get();
        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        $petuser = $this->checkpetuser($selectedpet->pet);
        $selectedpetname = pets::where('id' , $selectedpet->pet)->get()->first();
        $data = veterinaryandmedical::where('pets' , $selectedpet->pet)->where('user' , $petuser)->get();
        return view('care-taker.medicine-details')->with(array('record'=>$data,'pets'=>$getaccessdata,'selectedpetname'=>$selectedpetname));
    }
    public function allergy()
    {
        $email = Auth::user()->email;
        $userid = Auth::user()->id;
        $getaccessdata = access::where('email' , $email)->get();
        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        $petuser = $this->checkpetuser($selectedpet->pet);
        $selectedpetname = pets::where('id' , $selectedpet->pet)->get()->first();
        $data = allergies::where('pets' , $selectedpet->pet)->where('users' , $petuser)->get();
        return view('care-taker.allergy-details')->with(array('allergies'=>$data,'pets'=>$getaccessdata,'selectedpetname'=>$selectedpetname));
    }
    public function playexercise()
    {
        $email = Auth::user()->email;
        $userid = Auth::user()->id;
        $getaccessdata = access::where('email' , $email)->get();
        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        $petuser = $this->checkpetuser($selectedpet->pet);
        $selectedpetname = pets::where('id' , $selectedpet->pet)->get()->first();
        $data = playexercises::where('pets' , $selectedpet->pet)->where('users' , $petuser)->get();
        return view('care-taker.play-exercise-detail')->with(array('exercises'=>$data,'pets'=>$getaccessdata,'selectedpetname'=>$selectedpetname));
    }
    public function feedingtreats()
    {
        $email = Auth::user()->email;
        $userid = Auth::user()->id;
        $getaccessdata = access::where('email' , $email)->get();
        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        $petuser = $this->checkpetuser($selectedpet->pet);
        $selectedpetname = pets::where('id' , $selectedpet->pet)->get()->first();
        $data = feedingandtreats::where('pets' , $selectedpet->pet)->where('users' , $petuser)->get();
        return view('care-taker.feeding-detail')->with(array('feedingandtreats'=>$data,'pets'=>$getaccessdata,'selectedpetname'=>$selectedpetname));
    }
    public function sleeprelax()
    {
        $email = Auth::user()->email;
        $userid = Auth::user()->id;
        $getaccessdata = access::where('email' , $email)->get();
        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        $petuser = $this->checkpetuser($selectedpet->pet);
        $selectedpetname = pets::where('id' , $selectedpet->pet)->get()->first();
        $data = sleeppets::where('pets' , $selectedpet->pet)->where('users' , $petuser)->get();
        return view('care-taker.sleep-relax-detail')->with(array('sleeppets'=>$data,'pets'=>$getaccessdata,'selectedpetname'=>$selectedpetname));
    }
    public function likesdislikes()
    {
        $email = Auth::user()->email;
        $userid = Auth::user()->id;
        $getaccessdata = access::where('email' , $email)->get();
        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        $petuser = $this->checkpetuser($selectedpet->pet);
        $selectedpetname = pets::where('id' , $selectedpet->pet)->get()->first();
        $likes = likesdislikes::where('likedislike' , 'like')->where('pets' , $selectedpet->pet)->where('users' , $petuser)->get();
        $dislike = likesdislikes::where('likedislike' , 'dislike')->where('pets' , $selectedpet->pet)->where('users' , $petuser)->get();
        return view('care-taker.likes-dislikes-details')->with(array('likes'=>$likes,'dislike'=>$dislike,'pets'=>$getaccessdata,'selectedpetname'=>$selectedpetname));
    }
    public function training()
    {
        $email = Auth::user()->email;
        $userid = Auth::user()->id;
        $getaccessdata = access::where('email' , $email)->get();
        $selectedpet = DB::table('rememberpet')->where('users' , $userid)->get()->first();
        $petuser = $this->checkpetuser($selectedpet->pet);
        $selectedpetname = pets::where('id' , $selectedpet->pet)->get()->first();
        $data = training::where('pets' , $selectedpet->pet)->where('users' , $petuser)->get();
        $vocabularies = vocabularies::where('pets' , $selectedpet->pet)->where('users' , $petuser)->get();

        return view('care-taker.training-detail')->with(array('vocabularies'=>$vocabularies,'data'=>$data,'pets'=>$getaccessdata,'selectedpetname'=>$selectedpetname));
    }
    
}
