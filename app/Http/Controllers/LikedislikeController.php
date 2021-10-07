<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pets;
use App\Models\likesdislikes;
use DB;
use Auth;
class LikedislikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function sendimagetodirectory($imagename , $useremail)
    {
        $file = $imagename;
        $filename = rand() . '.' . $file->getClientOriginalExtension();
        $path = 'userdata/'.$useremail;
        $file->move(public_path($path), $filename);
        return $filename;
    }
    public function index()
    {
        $userid = Auth::user()->id;
        $pets = pets::where('users' , $userid)->get();
        $likes = likesdislikes::where('likedislike' , 'like')->get();
        $dislike = likesdislikes::where('likedislike' , 'dislike')->get();
        return view('user-panel.likedislike.index')->with(array('pets'=>$pets,'likes'=>$likes,'dislike'=>$dislike));
    }
    public function store(Request $request)
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
        echo $id;
    }
    public function deletelikedislike($id)
    {
        likesdislikes::where('id',$id)->delete();
        return redirect()->back()->with('message', 'Case Added Successfully');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
