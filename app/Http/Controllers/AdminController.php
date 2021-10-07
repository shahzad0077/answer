<?php
namespace App\Http\Controllers;
use App\Helper\Cmf;
use Illuminate\Http\Request;
use App\Models\modules;
use App\Models\categories;
use App\Models\blogs;
use App\Models\user;
use App\Models\onlyanswers;
use App\Models\testimonials;
use App\Models\cmshomepages;
use App\Models\userroles;
use App\Models\newsletters;
use App\Models\blogcategories;
use App\Models\realstories;
use App\Models\Abusivewords;
use App\Models\dynamicpages;
use App\Models\Uploadedquestions;
use App\Models\advertisementrequests;
use App\Imports\BulkImport;
use App\Imports\Abusivewordsimport;
use App\Imports\Usersimport;
use App\Models\expertrequest;
use App\Models\answerquestions;
use App\Models\abusivealerts;
use App\Models\uploadedfiledata;
use App\Models\urlredirection;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\userfile;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;
use DB;
use Mail;
use File;
use Validator;
use Redirect;
use DataTables;

use App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Image;
use Illuminate\Support\Facades\Hash;
use Stripe;
class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function slugify($text)
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        // $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = iconv('UTF-8', 'UTF-8//IGNORE', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        if (empty($text)) {
          return 'n-a';
        }
        return $text;
    }
    public function allsiteurl()
    {
        $data = DB::table('siteurls')->paginate(Cmf::site_settings('datashowlimit'));
        $status = 'all';
        return view('admin.siteurls.index')->with(array('data'=>$data,'statusnavbar'=>$status));
    }
    public function deletepage($id)
    {
        $data = DB::table('dynamicpages')->where('id' , $id)->get()->first();

        DB::table('siteurls')->where('modulename' , 'dynamicpages')->where('url' , $data->slug)->delete();

        DB::table('dynamicpages')->where('id' , $id)->delete();
        return redirect()->back()->with('message', 'Page Deleted Successfully');
    }
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function twofactor(Request $request)
    {
        $userid = auth()->user()->id;
        $userdata = user::where('id' , $userid)->get()->first();
        $code = $userdata->two_factor_code;
        if($code == $request->code)
        {
            $data = array('authenticated'=>1);
            DB::table('users')->where('id' , auth()->user()->id)->update($data);
            return redirect()->route('admin.dashboard');
        }else{
            return redirect()->back()->with('message', 'Code Is Inforect Please Try Again');
        }
    }
    public function resendcode()
    {
        $code = rand(100000, 999999);
        $email = auth()->user()->email;
        $subject = 'Two Factor Authentication Code';
        $User = User::find(auth()->user()->id);
        $User->two_factor_code = $code;
        $User->two_factor_expires_at = now()->addMinutes(10);
        $User->save();
        Mail::send(array('html' => 'emails.contact'), array('code' => $code,'email' => $email), function($message) use ($email, $subject)
        {
            $message->to($email)->subject($subject);
        });
        return redirect()->back()->with('successmessage', 'Code Send Successfully Please Check youe Email');
    }
    public function changenotificationstatus($id)
    {
        $data = array('status'=>0);
        DB::table('adminnotification')->where('id' , $id)->update($data);
    }
    /****************************************************
                   Plans Module
    *****************************************************/
    public function addplan()
    {
        return view('admin.plans.addplan');
    }
    public function allplans()
    {
        $data = plans::all();
        return view('admin.plans.allplans')->with(array('data'=>$data));
    }
    public function createnewplan(Request $request)
    {
        $image = $request->file('image');
        $blogimage = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $blogimage);
        $plan = new plans;
        $plan->tittle = $request->title;
        $plan->url = $this->slugify($request->title);
        $plan->noofusers =  $request->noofusers;
        $plan->validity = $request->valadity;
        $plan->price = $request->price;
        $plan->space = $request->space;
        $plan->lineone = $request->lineone;
        $plan->linetwo = $request->linetwo;
        $plan->linethree = $request->linethree;
        $plan->linefour = $request->linefour;
        $plan->linefive = $request->linefive;
        $plan->linesix = $request->linesix;
        $plan->lineseven = $request->lineseven;
        $plan->lineeieght = $request->lineeieght;
        $plan->linenine = $request->linenine;
        $plan->lineten = $request->lineten;
        $plan->image = $blogimage;
        $plan->published = 1;
        $plan->save();
        return redirect()->back()->with('message', 'Plan Successfully Inserted');
    }
    public function deleteplan($id)
    {
        DB::table('plans')->where('id' , $id)->delete();
        return redirect()->back()->with('message', 'Plan Deleted Successfully');
    }
    public function editplan($id)
    {
        $data = DB::table('plans')->where('id' , $id)->get()->first();
        return view('admin.plans.editplan')->with(array('data'=>$data));
    }
    public function updateplan(Request $request)
    {
        $id = $request->id;
        if($file=$request->file('image')){
            $imagename=rand() . '.' . $file->getClientOriginalName();
            $file->move(public_path('images'),$imagename);
            $data = array('image'=>$imagename);
            modules::where('id', $id)->update($data);
        }
        $url = $this->slugify($request->title);
        $data2 = array('url'=>$url,'lineone'=>$request->lineone,'linetwo'=>$request->linetwo,'linethree'=>$request->linethree,'linefour'=>$request->linefour,'linefive'=>$request->linefive,'linesix'=>$request->linesix,'lineseven'=>$request->lineseven,'lineeieght'=>$request->lineeieght,'linenine'=>$request->linenine,'lineten'=>$request->lineten,'tittle'=>$request->title,'noofusers'=>$request->noofusers,'validity'=>$request->valadity,'price'=>$request->price,'space'=>$request->space);
        DB::table('plans')->where('id', $id)->update($data2);
        return redirect()->back()->with('message', 'Updated Successfully');
    }
    public function changetopublishplans($one , $two)
    {
        if($two == 1)
        {
            $data = array('published'=>0);
        }else{
            $data = array('published'=>1);
        }
        plans::where('id', $one)->update($data);
    }
    /****************************************************
                   Module Module
    *****************************************************/
    public function modulesinformation()
    {
        $data = modules::all();
        return view('admin.information.all')->with(array('data'=>$data));
    }
    public function addinformation($id)
    {
        $data = modules::where('id' , $id)->get()->first();
        return view('admin.information.addinformation')->with(array('data'=>$data));
    }
    public function updatemodule(Request $request)
    {
        $id = $request->id;
        if($file=$request->file('image')){
            $imagename=rand() . '.' . $file->getClientOriginalName();
            $file->move(public_path('images'),$imagename);
            $data = array('image'=>$imagename);
            modules::where('id', $id)->update($data);
        }
        if($file=$request->file('icon')){
            $imagename=rand() . '.' . $file->getClientOriginalName();
            $file->move(public_path('images'),$imagename);
            $data = array('icon'=>$imagename);
            modules::where('id', $id)->update($data);
        }
        $data2 = array('name'=>$request->name,'video'=>$request->video,'instructions'=>$request->description);
        modules::where('id', $id)->update($data2);
        return redirect()->back()->with('message', 'Updated Successfully');
    }
    public function changetopublish($one , $two)
    {
        if($two == 1)
        {
            $data = array('published'=>0);
        }else{
            $data = array('published'=>1);
        }
        modules::where('id', $one)->update($data);
    }
    /****************************************************
                   Users Module
    *****************************************************/
    public function viewallusers()
    {
        $data = user::orderBy('created_at' , 'desc')->paginate(Cmf::site_settings('datashowlimit'));
        return view('admin.users.all')->with(array('data'=>$data));
    }
    public function searchusername($id)
    {
        $data = user::Where('username', 'like', '%' . $id . '%')->get();

        foreach ($data as $r) {
            echo ' <tr>
                <td>'.$r->name.'</td>
                <td onclick="copyToClipboard('.$r->id.')"><a target="_blank" href="'.url('/admin/user/detail').'/'.$r->id.'">'.$r->username.'</a>
                    <input type="hidden" value="'.$r->username.'" id="username'.$r->id.'" name="">
                </td>
                <td>'.$r->email.'</td>
                <td>'.$r->phonenumber.'</td>
                <td>';if($r->expert == 'on'){ echo  "Expert";}else{ echo "Simple User";} echo '</td>
                <td>';
                    if($r->email == 'info@sarcksolution.com')
                    {
                       echo "Super Admin";
                    }
                    else{ 
                    echo '<div>
                        <input type="checkbox" onclick="publish('.$r->id.','.$r->active.')" id="switch1'.$r->id.'"'; if($r->active == 1){echo 'checked'; }  echo 'data-switch="success"/>
                        <label for="switch1'.$r->id.'" data-on-label="Yes" data-off-label="No" class="mb-0 d-block"></label>
                    </div>';
                }
                    
                echo '</td>
                <td class="table-action text-center">';
                    if($r->email == 'info@sarcksolution.com')
                    {
                        echo 'Super Admin';
                    }    
                    else{    
                       echo  '<a  onclick="return confirm("Are You Sure You want this User I you Delete This user then Automaticaly Delete All Records Against This User")" href="'.url("deleteuser").'/'.$r->username.'" class="action-icon" title="Delte User"> <i class="mdi mdi-delete"></i>
                        </a>'; 
                    }
               echo '</td>
            </tr>';
        }

    }
    public function deleteuser($id)
    {
         DB::table('answerquestions')->where('question_auther' , $id)->update(array('delete_status'=>'Delete'));
         DB::table('onlyanswers')->where('users' , $id)->update(array('delete_status'=>'Delete'));
         $getid = user::where('username' ,$id)->get()->first()->id;   
         DB::table('usernotification')->where('users' , $getid)->delete();
         DB::table('savequestion')->where('users' , $getid)->delete();
         DB::table('useractivities')->where('user' , $getid)->delete();
         DB::table('users')->where('username' , $id)->delete();
        return redirect()->back()->with('message', 'Delete User Successfully');
    }
    public function changetopublishuser($one , $two)
    {
        if($two == 1)
        {
            $data = array('active'=>0);
        }else{
            $data = array('active'=>1);
        }
        user::where('id', $one)->update($data);
    }
    public function userdetails($id)
    {
        $data = user::where('id' , $id)->get()->first();
        $useractivities = DB::table('useractivities')->where('user' , $data->id)->orderby('created_at', 'desc')->paginate(Cmf::site_settings('datashowlimit'));
        $questiondata = answerquestions::where('delete_status' , 'Active')->where('question_auther' , $data->username)->orderBy('created_at' , 'desc')->get();
        return view('admin.users.detail')->with(array('data'=>$data,'useractivities'=>$useractivities,'questiondata'=>$questiondata));
    }

    public function userdetailsanswere($id)
    {
        $data = user::where('id' , $id)->get()->first();
        $useractivities = DB::table('useractivities')->where('user' , $data->id)->orderby('created_at', 'desc')->paginate(Cmf::site_settings('datashowlimit'));
        $questiondata = onlyanswers::where('delete_status' , 'Active')->where('users' , $data->username)->orderBy('created_at' , 'desc')->get();
        return view('admin.users.userdetailsanswere')->with(array('data'=>$data,'useractivities'=>$useractivities,'questiondata'=>$questiondata));
    }
        
    public function expertrequests()
    {   
        $data1 = array('newstatus'=>'old');
        DB::table('expertrequests')->update($data1);
        $data = expertrequest::all();
        return view('admin.users.expert')->with(array('data'=>$data));
    }
    public function makeexpert($id)
    {
        $data = array('expert'=>'on');
        DB::table('users')->where('id' , $id)->update($data);
        Cmf::save_user_notification('You are Now Expert in Anwer Out' , 'test',$id);
        return redirect()->back()->with('message', 'This User Is Expert Successfully');
    }
    public function removeexpert($id)
    {
        $data = array('expert'=>'off');
        DB::table('users')->where('id' , $id)->update($data);
        Cmf::save_user_notification('You are Removed From Expert Usr Now you are Simple User in Anwer Out' , 'test',$id);
        return redirect()->back()->with('message', 'This User Is Removed Expert Successfully');
    }
    /****************************************************
                   Blogs Module
    *****************************************************/
    public function blogcategories()
    {
        $data = blogcategories::where('delete_status' ,'Active')->get();
        return view('admin.blogs.categories')->with(array('data'=>$data));
    }
    public function deleteblogcategory($id)
    {
        $data = array('delete_status'=>'Delete');
        blogcategories::where('id' ,$id)->update($data);
        return redirect()->back()->with('message', 'Blog Category Deleted Successfully');
    }
    public function addblog()
    {
        return view('admin.blogs.addblog');
    }
    public function addnewcategory()
    {
        return view('admin.blogs.addblogcategory');
    }
    public function createblogcategory(Request $request)
    {
        $name = $request->name;
        if(Cmf::checkurl($request->slug) > 0)
        {
            return redirect()->back()->with('warning', 'Please Change the Slug Because This Slug is Same With Other Url');
        }
        else
        {
            $blogcategoryid = rand('10000' , '9000000');
            $saveblog = new blogcategories;
            $saveblog->id = $blogcategoryid;
            $saveblog->name = $name;
            $saveblog->slug = $request->slug;
            $saveblog->shortdescription = $request->blogshortdescription;
            $saveblog->metta_tittle = $request->metta_tittle;
            $saveblog->metta_description = $request->metta_description;
            $saveblog->metta_keywords = $request->metta_keywords;            
            $saveblog->visible_status = $request->visible_status;
            $saveblog->delete_status = 'Active';
            $saveblog->added_by = auth()->user()->id;
            $saveblog->save();
            Cmf::savesiteurl($request->slug , 'blogcategory');
            return redirect()->back()->with('message', 'Blog Category Successfully Inserted');
        }
    }
    public function updateblogcategory(Request $request)
    {

        $checkurl = blogcategories::where('id' , $request->id)->get()->first()->slug;
        $saveblog = blogcategories::find($request->id);
        $saveblog->name = $request->name;
        if($checkurl != $request->slug){
            $saveblog->slug = $request->slug;
            Cmf::savesiteurl($request->slug , 'blogcategory');
        }
        $saveblog->shortdescription = $request->blogshortdescription;
        $saveblog->metta_tittle = $request->metta_tittle;
        $saveblog->metta_description = $request->metta_description;
        $saveblog->metta_keywords = $request->metta_keywords;            
        $saveblog->visible_status = $request->visible_status;
        $saveblog->delete_status = 'Active';
        $saveblog->added_by = auth()->user()->id;
        $saveblog->save();
        return redirect()->back()->with('message', 'Blog Category Updated Inserted');   
    }
    public function editblogcategory($id)
    {
        $data = blogcategories::where('id' , $id)->get()->first();
        return view('admin.blogs.editcategory')->with(array('data'=>$data));
    }
    public function createblog(Request $request)
    {
        $name = $request->name;
        if(Cmf::checkurl($request->slug) > 0)
        {
            return redirect()->back()->with('warning', 'Please Change the Slug Because This Slug is Same With Other Url');
        }
        else
        {
            $saveblog = new blogs;
            $saveblog->name = $name;
            $saveblog->url = $request->slug;
            $saveblog->blog = $request->content;
            $saveblog->visible_status = $request->visible_status;
            $saveblog->delete_status = 'Active';
            $saveblog->added_by = auth()->user()->id;
            $saveblog->save();
            Cmf::savesiteurl($request->slug , 'singleblog');
            if(!empty($request->blogcategory))
            {
                foreach ($request->blogcategory as $b) {
                    DB::statement("INSERT INTO `wphj_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`)VALUES ('$saveblog->id', '$b', '0')");
                }
            }
            if(!empty($request->image))
            {
                Cmf::save_image_name('blogimages' , 'blogid' , $saveblog->id , $request->image);
            }
            return redirect()->back()->with('message', 'Blog Successfully Inserted');
        }
    }
    public function blogs(Request $request)
    {
        $data = blogs::where('delete_status' ,'Active')->paginate(Cmf::site_settings('datashowlimit'));
        $status = 'all';
        return view('admin.blogs.all')->with(array('data'=>$data,'statusnavbar'=>$status));
    }
    public function searchblog(Request $request)
    {
        $data = blogs::where('delete_status' , 'Active')->Where('name', 'like', '%' . $request->searchword . '%')->get();
        $status = 'search';
        return view('admin.blogs.all')->with(array('data'=>$data,'statusnavbar'=>$status,'searchword'=>$request->searchword));
    }


    public function searchurl(Request $request)
    {
        $data = DB::table('siteurls')->Where('url', 'like', '%' . $request->searchword . '%')->get();
        $status = 'search';
        return view('admin.siteurls.index')->with(array('data'=>$data,'statusnavbar'=>$status,'searchword'=>$request->searchword));
    }

    public function addnewredirect(Request $request)
    {
        $testimonials = new urlredirection;
        $testimonials->from = request('fromurl');
        $testimonials->to = request('tourl');
        $testimonials->save();
        return redirect()->back()->with('message', 'Redirect Successfully Inserted');
    }
    

    public function urlredirection()
    {
        $data = urlredirection::all();
        return view('admin.siteurls.redirection')->with(array('data'=>$data));
    }

    public function blogswithid($id)
    {
        if($id == 'published')
        {
            $data = blogs::where('delete_status' ,'Active')->where('visible_status' ,'Published')->paginate(Cmf::site_settings('datashowlimit'));
        }
        if($id == 'unpublished')
        {
            $data = blogs::where('delete_status' ,'Active')->where('visible_status' ,'Not Published')->paginate(Cmf::site_settings('datashowlimit'));
        }
        if($id == 'trash')
        {
            $data = blogs::where('delete_status' ,'Active')->where('visible_status' ,'Trash')->paginate(Cmf::site_settings('datashowlimit'));
        }
        return view('admin.blogs.blogswithid')->with(array('data'=>$data,'statusnavbar'=>$id));
    }


    public function changetopublishblog($one , $two)
    {
        if($two == 'Published')
        {
            $data = array('visible_status'=>'Not Published');
        }else{
            $data = array('visible_status'=>'Published');
        }
        blogs::where('id', $one)->update($data);
        return redirect()->back()->with('message', 'Restore successfully');
    }
    public function deleteblog($id)
    {
        $data = blogs::where('id', $id)->get()->first();
        DB::table('siteurls')->where('modulename' , 'singleblog')->where('url' , $data->url)->delete();
        $array = array('delete_status'=>'Delete');
        blogs::where('id', $id)->update($array);
        return redirect()->back()->with('message', 'Blog Delete Successfully');
    }
    public function deleteblogtrash($id)
    {
        $data = array('visible_status'=>'Trash');
        blogs::where('id', $id)->update($data);
        return redirect()->back()->with('message', 'Blog Delete Successfully');
    }
    public function editblog($id)
    {
        $data = blogs::where('id' ,$id)->get()->first();
        return view('admin.blogs.edit-blog')->with(array('data'=>$data));
    }
    public function updateblog(Request $request)
    {
        $blogdata = blogs::where('id', $request->id)->get()->first();
        $blogurl = $blogdata->url;
        $url = $request->slug;

        $blog_in_siteurl = DB::table('siteurls')->where('url', $blogurl)->where('modulename' , 'singleblog')->first();
        $arrayName = array('url' => $url);
        DB::table('siteurls')->where('id' , $blog_in_siteurl->id)->update($arrayName);
        
 
        if(!empty($request->file('image')))
        {
            DB::table('blogimages')->where('blogid' ,$request->id)->delete();
            Cmf::save_image_name('blogimages', 'blogid' ,$request->id , $request->image);
        }

        $data = array('url'=>$url,'name'=>$request->name,'created_at'=>$request->date,'blog'=>$request->content,'visible_status'=>$request->visible_status);

        $id =  $request->id;

        blogs::where('id', $id)->update($data);

        DB::table('wphj_term_relationships')->where('object_id' , $id)->delete();

        if(!empty($request->blogcategory))
        {
            foreach ($request->blogcategory as $b) 
            {
                DB::statement("INSERT INTO `wphj_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`)VALUES ('$id', '$b', '0')");
            }
        }
        return redirect()->back()->with('message', 'Blog Updated Successfully');
    }
    public function blogcoments()
    {
        $data = DB::table('blogcoments')->where('delete_status' , 'Active')->orderby('created_at' , 'desc')->get();
        return view('admin.blogs.blogcoment')->with(array('data'=>$data));
    }
    public function editblogcoment($id)
    {
        $data = array('newstatus'=>'old');
        DB::table('blogcoments')->where('id' , $id)->update($data);
        $data = DB::table('blogcoments')->where('id' , $id)->get()->first();
        return view('admin.blogs.editblogcoment')->with(array('data'=>$data));
    }
    public function updateblogcoment(Request $request)
    {
        $data = array('coment'=>$request->coment,'visible_status'=>$request->visible_status);
        DB::table('blogcoments')->where('id' , $request->id)->update($data);
        return redirect()->back()->with('message', 'Comment Updated Successfully');
    }
    public function deleteblogcoment($id)
    {
        DB::table('blogcoments')->where('id' , $id)->delete();
        return redirect()->back()->with('message', 'Comment Deleted Successfully');
    }
    public function deleteblogcomentreply($id)
    {
        DB::table('comentreply')->where('id' , $id)->delete();
        return redirect()->back()->with('message', 'Comment Reply Deleted Successfully');
    }


    /****************************************************
                   Contact Messages Module
    *****************************************************/
    public function messages()
    {
        $data = DB::table('contactuses')->get();
        
        return view('admin.contact.allmessages')->with(array('data'=>$data));
    }
    public function viewmessage($id)
    {
        $data2 = array('status'=>0);
        DB::table('contactuses')->where('id' , $id)->update($data2);
        $data = DB::table('contactuses')->where('id',$id)->get()->first();
        return view('admin.contact.view')->with(array('data'=>$data));
    }
    public function deletecontactus($id)
    {
        DB::table('contactuses')->where('id',$id)->delete();
        return redirect()->back()->with('message', 'Deleted Successfully');
    }

    /****************************************************
                   Testimonials Module
    *****************************************************/
    public function alltestimonials()
    {
        $data = DB::table('testimonials')->get();
        return view('admin.testimonials.all')->with(array('data'=>$data));
    }
    public function addnewtestimonials()
    {
        return view('admin.testimonials.add');
    }
    public function createtestimonial(Request $request)
    {
        $new_name = Cmf::sendimagetodirectory($request->image);
        $testimonials = new testimonials;
        $testimonials->name = request('name');
        $testimonials->image = $new_name;
        $testimonials->testimonial = request('testimonials');
        $testimonials->status = 'Published';
        $testimonials->save();
        return redirect()->back()->with('message', 'Testimonial Successfully Inserted');

    }
    public function deletetestimonial($id)
    {
        testimonials::where('id' , $id)->delete();
        return redirect()->back()->with('message', 'Testimonial Deleted Successfully');
    }
    public function edittestimonial($id)
    {
        $data = DB::table('testimonials')->where('id',$id)->get()->first();
        return view('admin.testimonials.edit')->with(array('data'=>$data));
    }
    public function updatetestimonials(Request $request)
    {
        if(!empty($request->image))
        {
            $new_name = Cmf::sendimagetodirectory($request->image);
            $data = array('image'=>$new_name);
            DB::table('testimonials')->where('id',$request->id)->update($data);
        }
        $data = array('name'=>$request->name,'testimonial'=>$request->testimonial,'status'=>$request->status);
        DB::table('testimonials')->where('id',$request->id)->update($data);

        return redirect()->back()->with('message', 'Updated Successfully');

    }
    /****************************************************
                   CMS Homepage Module
    *****************************************************/
    public function cmshomepage()
    {
        $data = DB::table('cmshomepages')->get();
        return view('admin.cms.homepage')->with(array('data'=>$data));
    }               
    public function createhomepagesections(Request $request)
    {
        $image = $request->file('image');
        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $new_name);
        $homepage = new cmshomepages;
        $homepage->image = $new_name;
        $homepage->tittle = request('tittle');
        $homepage->description = request('description');
        $homepage->video = request('video');
        $homepage->save();
        return redirect()->back()->with('message', 'Successfully Inserted');
    }
    public function updatecmshomepage(Request $request)
    {
        $id = $request->id;
        if($file=$request->file('image')){
            $imagename=rand() . '.' . $file->getClientOriginalName();
            $file->move(public_path('images'),$imagename);
            $data = array('image'=>$imagename);
            cmshomepages::where('id', $id)->update($data);
        }
        $data2 = array('tittle'=>$request->tittle,'description'=>$request->description,'video'=>$request->video);
        cmshomepages::where('id', $id)->update($data2);
        return redirect()->back()->with('message', 'Updated Successfully');
    }
    public function getcmshomepage($id)
    {
        $data = cmshomepages::where('id' , $id)->get()->first();
        echo '<input value="'.$data->id.'" type="hidden" class="form-control" name="id" >
                <label for="validationCustom01">Title</label>
                <input value="'.$data->tittle.'" type="text" class="form-control" name="tittle" id="validationCustom01"
                    placeholder="Title" required >
            </div>
            <div class="form-group mb-3">
                <label for="validationCustom01">Description</label>
                <textarea class="form-control" name="description" id="validationCustom02"
                    placeholder="Put something" required rows="4">'.$data->description.'</textarea>
            </div>
            <div class="form-group mb-3">
                <label for="validationCustom03">Image</label>
                <input style="height: 44px;" type="file" class="form-control" name="image" id="validationCustom09"
                     >
            </div>
            <div class="form-group mb-3">
                <label for="validationCustom01">Video URL</label>
                <input type="text" value="'.$data->video.'" class="form-control" name="video" id="validationCustom01"
                    placeholder="Video URL" required >
            </div>
            <button class="btn btn-primary" type="submit">Update</button>';
    }


    public function cmsfaq()
    {
        $data = DB::table('faq')->get();
        return view('admin.cms.faq')->with(array('data'=>$data));
    }
    public function createfaq(Request $request)
    {
        DB::statement("INSERT INTO `faq` (`question`, `answer`)VALUES ('$request->question', '$request->answer')");
        return redirect()->back()->with('message', 'Successfully Inserted');
    }
    public function updatefaq(Request $request)
    {
        $data = array('question'=>$request->question,'answer'=>$request->answer);
        DB::table('faq')->where('id' , $request->id)->update($data);
        return redirect()->back()->with('message', 'Updated Successfully');
    }
    public function deletefaq($id)
    {
        DB::table('faq')->where('id' , $id)->delete();
        return redirect()->back()->with('message', 'Deleted Successfully');
    }
    

    public function cmsrealstories()
    {
        $data = DB::table('realstories')->get();
        return view('admin.cms.real')->with(array('data'=>$data));
    }
    public function createrealstories(Request $request)
    {
        $image = $request->file('image');
        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $new_name);
        $cms = new realstories;
        $cms->image = $new_name;
        $cms->rattings = request('rattings');
        $cms->description = request('description');
        $cms->subtittle = request('subtittle');
        $cms->name = request('name');

        $cms->save();
        return redirect()->back()->with('message', 'Successfully Inserted');
    }
    public function updatecmsrealstories(Request $request)
    {
        $id = $request->id;
        if($file=$request->file('image')){
            $imagename=rand() . '.' . $file->getClientOriginalName();
            $file->move(public_path('images'),$imagename);
            $data = array('image'=>$imagename);
            realstories::where('id', $id)->update($data);
        }
        $data2 = array('rattings'=>$request->rattings,'name'=>$request->name,'description'=>$request->description,'subtittle'=>$request->subtittle);
        realstories::where('id', $id)->update($data2);
        return redirect()->back()->with('message', 'Updated Successfully');
    }
    public function deleterealstories($id)
    {
        DB::table('realstories')->where('id' , $id)->delete();
        return redirect()->back()->with('message', 'Deleted Successfully');
    }
    public function getrealstories($id)
    {
        $data = realstories::where('id' , $id)->get()->first();
        echo '<input value="'.$data->id.'" type="hidden" class="form-control" name="id" >
                <label for="validationCustom01">Name</label>
                <input value="'.$data->name.'" type="text" class="form-control" name="name" id="validationCustom01"
                    placeholder="Title" required >
            </div>
            <div class="form-group mb-3">
                <label for="validationCustom01">Subtittle</label>
                <input type="text" value="'.$data->subtittle.'" class="form-control" name="subtittle" id="validationCustom01"
                    placeholder="Video URL" required >
            </div>
            <div class="form-group mb-3">
                <label for="validationCustom01">Rattings</label>
                <input type="number" min="0" max="5" value="'.$data->rattings.'" class="form-control" name="rattings" id="validationCustom01"
                    placeholder="Min 0 and Max 5" required >
            </div>
            <div class="form-group mb-3">
                <label for="validationCustom01">Description</label>
                <textarea class="form-control" name="description" id="validationCustom02"
                    placeholder="Put something" required rows="4">'.$data->description.'</textarea>
            </div>
            <div class="form-group mb-3">
                <label for="validationCustom03">Image</label>
                <input style="height: 44px;" type="file" class="form-control" name="image" id="validationCustom09"
                     >
            </div>
            <button class="btn btn-primary" type="submit">Update</button>';
    }
    

    /****************************************************
                   Settings
    *****************************************************/
    public function settings()
    {
        return view('admin.settings.index');
    }
    public function emailsettings()
    {
        return view('admin.settings.email');
    }
    public function gatewaysettings()
    {
        return view('admin.settings.payement');
    }
    public function themesettings()
    {
        return view('admin.settings.themesettings');
    }
    public function getsettingstableid($key)
    {
        return DB::table('system_settings')->where('key' , $key)->get()->first()->id;
    }
    public function updatesettings($one , $two)
    {
        $data = array('value'=>$one);
        DB::table('system_settings')->where('id', $this->getsettingstableid($two))->update($data);
    }
    public function updategenralsettings(Request $request)
    {
        $this->updatesettings($request->email_address,'email_address');
        $this->updatesettings($request->mobile_number,'mobile_number');
        $this->updatesettings($request->footer_text,'footer_text');
        $this->updatesettings($request->facebook_link,'facebook_link');
        $this->updatesettings($request->twitter_link,'twitter_link');
        $this->updatesettings($request->instagram_link,'instagram_link');
        $this->updatesettings($request->linkdlin_link,'linkdlin_link');
        $this->updatesettings($request->youtube_link,'youtube_link');
        $this->updatesettings($request->pintrest_link,'pintrest_link');
        $this->updatesettings($request->meta_title,'meta_title');
        $this->updatesettings($request->meta_description,'meta_keywords');
        $this->updatesettings($request->meta_keywords,'meta_description');
        $this->updatesettings($request->frontenddatashowlimit,'frontenddatashowlimit');
        return redirect()->back()->with('message', 'Updated Successfully');
    }
    public function updateemailsettings(Request $request)
    {
        $this->updatesettings($request->email_address,'email_address');
        $this->updatesettings($request->email_password,'email_password');
        $this->updatesettings($request->email_tittle,'email_tittle');
        $this->updatesettings($request->smtp_email_address,'smtp_email_address');
        $this->updatesettings($request->smtp_email_password,'smtp_email_password');
        $this->updatesettings($request->smtp_email_host,'smtp_email_host');
        $this->updatesettings($request->smtp_email_port,'smtp_email_port');
        return redirect()->back()->with('message', 'Updated Successfully');
    }
    public function changenoofrecordsperpage($id)
    {
        $this->updatesettings($id,'datashowlimit');
        return redirect()->back();
    }


    public function updatepayementsettings(Request $request)
    {
        $this->updatesettings($request->publishable_key,'publishable_key');
        $this->updatesettings($request->secret_key,'secret_key');
        return redirect()->back()->with('message', 'Updated Successfully');
    }
    public function updatethemesettings(Request $request)
    {
        $this->updatesettings($request->color,'theme_color');
        return redirect()->back()->with('message', 'Updated Successfully');
    }
    /****************************************************
                   Discounts Module
    *****************************************************/
    public function discounts()
    {
        $data = DB::table('discounts')->get();
        return view('admin.discounts.index')->with(array('data'=>$data));
    }
    public function createnewcoupen(Request $request)
    {
        $coupen = new discounts;
        $coupen->coupen = $request->coupen;
        $coupen->discount = $request->discount;
        $coupen->percentageorfix = $request->percentageorfix;
        $coupen->end_date = $request->end_date;
        $coupen->status = 1;
        $coupen->save();
        return redirect()->back()->with('message', 'Coupen Successfully Inserted');
    }
    public function changetopublishdiscounts($one , $two)
    {
        if($two == 1)
        {
            $data = array('status'=>0);
        }else{
            $data = array('status'=>1);
        }
        discounts::where('id', $one)->update($data);
    }


    public function newsletters()
    {
        $data = newsletters::all();
        return view('admin.newsletters')->with(array('data'=>$data));
    }

    public function sendemailsnewsletters(Request $request)
    {
        $subject = $request->subject;
        $emailbody = $request->emailbody;
        foreach ($request->allemails as $email) {
            Mail::send(array('html' => 'emails.newsletteremail'), array('emailbody' => $request->emailbody), function($message) use ($email, $subject)
            {
                $message->to($email)->subject($subject);
            });
        }
        return redirect()->back()->with('message', 'Mails Sended Successfully');
    }
    /****************************************************
                   Admin Profile Settings
    *****************************************************/
    public function profile()
    {
        return view('admin.settings.profile_settings');
    }
    public function updateprofile(Request $request)
    {
      $name = $request->name;
      $email = $request->email;
      $country = $request->country;
      $phone = $request->phone;
      $twofactor = $request->twofactor;exit;
      $id =  Auth::user()->id;
      $data = array('name'=>$name,"email"=>$email,"country"=>$country,"phonenumber"=>$phone,"twofactor"=>$twofactor);
        user::where('id', $id)
        ->update($data);
      return redirect()->back()->with('message', 'Updated Successfully');
   }
    public function updatepassword(Request $request)
    {
      $password = $request->password;
      $password = Hash::make($request->password);
      $id =  Auth::user()->id;
      $data = array('password'=>$password);
        user::where('id', $id)
        ->update($data);
      return redirect()->back()->with('message', 'Updated Successfully');
   }
   /****************************************************
                   Categories
    *****************************************************/
    public function createcategory(Request $request)
    {
        $name = $request->name;
        if(Cmf::checkurl($request->slug) > 0)
        {
            return redirect()->back()->with('warning', 'Please Change the Category Name Or Other Because This Category URL is Same With Other Url');
        }
        else
        {
            $category = new categories;
            $category->name = $name;
            $category->url = $request->slug;
            $category->backgroundcolor = $request->color;
            $category->text_color = $request->text_color;
            $category->metta_tittle = $request->metta_tittle;
            $category->metta_description = $request->metta_description;
            $category->metta_keywords = $request->metta_keywords;            
            $category->status = $request->status;
            $category->order = $request->order;
            $category->save();
            Cmf::savesiteurl($request->slug , 'category');
            if(!empty($request->icon))
            {
                Cmf::save_image_name('subjectimages' , 'subjectid' , $category->id , $request->icon);
            }
            return redirect()->back()->with('message', 'Category Successfully Inserted');
        }
    }
    public function categories()
    {
        $data = categories::where('status' ,'Active')->get();
        return view('admin.categories.all')->with(array('data'=>$data));
    }
    public function editcategory($id)
    {
        $data = categories::where('id' ,$id)->get()->first();
        return view('admin.categories.edit-category')->with(array('data'=>$data));
    }
    public function updatecategory(Request $request)
    {
        $url = $request->slug;
        $savedurl = DB::table('siteurls')->where('url', $url)->where('modulename' , 'category')->first();
        if(empty($savedurl))
        {
            DB::statement("INSERT INTO `siteurls` (`url`, `modulename`)VALUES ('$url', 'category')");
        }
        if(!empty($request->file('icon'))){

            DB::table('subjectimages')->where('subjectid',$request->id)->delete();
            Cmf::save_image_name('subjectimages' , 'subjectid' , $request->id , $request->icon);
        }
        $data = array('url'=>$url,'text_color'=>$request->text_color,'order'=>$request->order,'name'=>$request->name,'backgroundcolor'=>$request->color,'metta_tittle'=>$request->metta_tittle,'metta_description'=>$request->metta_description,'metta_keywords'=>$request->metta_keywords,'status'=>$request->status);
        $id =  $request->id;
        categories::where('id', $id)->update($data);
        return redirect()->back()->with('message', 'Category Updated Successfully');
    }
    public function deletecategory($id)
    {
        $data = array('status'=>'delete');
        categories::where('id', $id)->update($data);
        return redirect()->back()->with('message', 'Category Deleted Successfully');
    }
    /****************************************************
                   Add User Roles
    *****************************************************/
    public function allmanagers()
    {
        $data = user::where('is_admin' ,'1')->get();
        return view('admin.userroles.index')->with(array('data'=>$data));
    }
    public function adduserroles()
    {
        $data = userroles::all();
        return view('admin.userroles.roles')->with(array('data'=>$data));
    }
    public function createuserrole(Request $request)
    {
        $rand = rand('1000' , '2000000');
        $role = new userroles;
        $role->id = $rand;
        $role->name = $request->name;
        $role->save();
        foreach($request->parent as $r)
        {
            DB::statement("INSERT INTO `rolesparent` (`userroles`,`parentid`)VALUES ('$rand', '$r')");
        }
        foreach($request->child as $r)
        {
            DB::statement("INSERT INTO `roleschild` (`userroles`,`childid`)VALUES ('$rand', '$r')");
        }
        return redirect()->back()->with('message', 'Role Added Successfully');
    }
    public function updateuserrole(Request $request)
    {

        DB::table('rolesparent')->where('userroles' , $request->id)->delete();
        DB::table('roleschild')->where('userroles' , $request->id)->delete();
        $rand = $request->id;
        foreach($request->parent as $r)
        {
            DB::statement("INSERT INTO `rolesparent` (`userroles`,`parentid`)VALUES ('$rand', '$r')");
        }
        foreach($request->child as $r)
        {
            DB::statement("INSERT INTO `roleschild` (`userroles`,`childid`)VALUES ('$rand', '$r')");
        }
        return redirect()->back()->with('message', 'Role Updated Successfully');
    }
    public function advertisementrequests()
    {
        
        $data = advertisementrequests::all();
        return view('admin.advertisementrequests')->with(array('data'=>$data));
    }
    public function advertisementsdelte($id)
    {
        
         advertisementrequests::where('id' , $id)->delete();
        return redirect()->back()->with('message', 'Deleted Successfully');
    }
    
    public function advertisementview($id)
    {
        DB::table('advertisementrequests')->where('id' , $id)->update(array('newstatus'=>'old'));
        $data = advertisementrequests::find($id);
        return view('admin.advertisementview')->with(array('data'=>$data));
    }
    public function createadminuser(Request $request)
    {

        $email = $request->email;
        if(DB::table('users')->where('email' , $email)->count() > 0)
        {
            return redirect()->back()->with('warning', 'This Email is Already Exist in System');
        }
        else
        {
            $myvalue = $request->name;
            $arr = explode(' ',trim($myvalue));
            $username = $arr[0] . rand(pow(10, 8 - 1), pow(10, 8) -1);
            $username = strtolower($username);
            $user = new user;
            $user->name = $request->name;
            $user->profileimage = 'https://img.favpng.com/22/22/23/male-avatar-user-profile-clip-art-png-favpng-D6fQkBXdkGV4QGp022dE3tPHY.jpg';
            $user->username = $username;
            $user->is_admin = 1;
            $user->active = 1;
            $user->email = $request->email;
            $user->userroleid = $request->userroleid;
            $user->password = Hash::make($request->password);            
            $user->save();
            return redirect()->back()->with('message', 'User Added Successfully');
        }
    }
    public function updateadminuser(Request $request)
    {
        $data = array('name'=>$request->name,'userroleid'=>$request->userroleid);
        DB::table('users')->where('id' , $request->id)->update($data);
        return redirect()->back()->with('message', 'User Added Successfully');
    }
    /****************************************************
                   Add Dile Uploader
    *****************************************************/
    public function fileuplaoder()
    {
        return view('admin.fileuploader.index');
    }
    public function create_subjects()
    {
        $get = answerquestions::where('create_subject' , 1)->groupBy('question_subject')->get();
        foreach($get as $r)
        {
            $check  = categories::where('name' , $r->question_subject)->count();
            if($check == 0)
            {
                $url = $this->slugify(str_replace(' ', '', $r->question_subject));
                if(DB::table('siteurls')->where('url' , $url)->where('modulename' , 'category')->count() > 0)
                {
                    $url = $url.'-'.$r->id;
                    $category = new categories;
                    $category->name = $r->question_subject;
                    $category->url = $url;
                    $category->backgroundcolor = Cmf::site_settings('default_category_background');
                    $category->status = 'Active';
                    $category->order = 0;
                    $category->save();
                    Cmf::savesiteurl($url , 'category');
                }
                else
                {
                    $category = new categories;
                    $category->name = $r->question_subject;
                    $category->url = $url;
                    $category->backgroundcolor = Cmf::site_settings('default_category_background');
                    $category->status = 'Active';
                    $category->order = 0;
                    $category->save();
                    Cmf::savesiteurl($url , 'category');
                }
            }
        }
        $create_subject = array('create_subject'=>1);
        DB::table('answerquestions')->update($create_subject);
    }

    public function create_url_of_all_questions()
    {
        $getforurl = answerquestions::where('question_url', null)->get();
        foreach($getforurl as $r)
        {
            $name = $r->question_name;
            $url = $this->slugify($name);
            $shortenurl = Cmf::shorten_url($url);
            $url = $shortenurl;
            $data = array('question_url'=>$url);
            answerquestions::where('id' , $r->id)->update($data);
        }
    }

    public function create_answers_of_all_question()
    {
        ini_set('max_execution_time', 0); // 0 = Unlimited
        ini_set('memory_limit', '-1');
        $getforanswer = answerquestions::where('create_answer' , 0)->whereNotNull('accepted_answer')->get();
        if(!empty($getforanswer))
        {
            foreach($getforanswer as $r)
            {
                $checkalreadyanswer = onlyanswers::where('questionid' , $r->id)->count();
                if($checkalreadyanswer == 0)
                {
                    $answer = new onlyanswers;
                    $answer->users = $r->answer_user;
                    $answer->questionid = $r->id;
                    $answer->answer = $r->accepted_answer;
                    $answer->delete_status = 'Active';
                    $answer->visible_status = 'Published';
                    $answer->rattings = $r->question_ratting;
                    $answer->likes = $r->question_like;
                    $answer->save();

                if(!empty($r->answer_image))
                {

                    foreach(explode(',', $r->answer_image) as $i)
                    {
                        $date = date('Y-m-d h:m:s');
                        $userid = auth()->user()->id;
                        DB::statement("INSERT INTO `answerimages` (`answerid`, `image_name`, `image_status`, `added_by`, `created_at`)VALUES ('$answer->id', '$i', 'Active', $userid , '$date')");
                    }
                }    

                }

                $create_answer = array('create_answer'=>1);
                answerquestions::where('id'  ,$r->id)->update($create_answer);

            }
        }
        $this->creat_user_of_answer();
    }

    public function insert_images_of_all_questions()
    {
        $getforquestionimage = answerquestions::whereNotNull('question_image')->where('create_images' , 0)->get();
        if(!empty($getforquestionimage))
        {
            foreach($getforquestionimage as $r)
            {
                foreach(explode(',', $r->question_image) as $i)
                {
                    $date = date('Y-m-d h:m:s');
                    $userid = auth()->user()->id;
                    DB::statement("INSERT INTO `questionimages` (`questionid`, `image_name`, `image_status`, `added_by`, `created_at`)VALUES ('$r->id', '$i', 'Active', $userid , '$date')");
                }

                $create_images = array('create_images'=>1);
                answerquestions::where('id'  ,$r->id)->update($create_images);
            }
        }
    }
    public function creat_user_of_question()
    {
        $get = answerquestions::where('create_user' , 0)->groupBy('question_auther')->get();
        foreach ($get as $r) {
            $check = user::where('username' , $r->question_auther)->count();
            if($check == 0)
            {
                $user = new user;
                $user->username = $r->question_auther;
                $user->profileimage = url('images').'/'.DB::table('profileimages')->inRandomOrder()->get()->first()->image_name;
                $user->is_admin = 0;
                $user->save();
            }
            $create_user = array('create_user'=>1);
            answerquestions::where('id'  ,$r->id)->update($create_user);
        }
    }
    public function creat_user_of_answer()
    {
        $get = onlyanswers::groupBy('users')->get();
        foreach ($get as $r) {
            $check = user::where('username' , $r->users)->count();
            if($check == 0)
            {
                $user = new user;
                $user->username = $r->users;
                $user->profileimage = url('images').'/'.DB::table('profileimages')->inRandomOrder()->get()->first()->image_name;
                $user->is_admin = 0;
                $user->save();
            }
        }
    }

    public function uploadfile(Request $request)
    {
        ini_set('max_execution_time', 0); // 0 = Unlimited
        Uploadedquestions::truncate();
        ini_set('memory_limit', '-1');
        set_time_limit(20000000000);

        // Import Answer Questions to answerquestions Table

        Excel::import(new BulkImport,request()->file('uploadedfile'));

        // Null Question Name Delete

        answerquestions::where('question_name', null)->delete();


        // Duplicate Delete

        // $getduplicate = Uploadedquestions::groupBy('accepted_answer','question_image','question_content','question_name', 'question_auther', 'question_subject', 'question_like', 'question_ratting')->get();
        // $userRolesId = array_column($getduplicate ->toArray(), 'id');
        // answerquestions::whereNotIn('id', $userRolesId )->delete();
           
        // Upload File For Saving REcords to Uploadfiledata Table

        $file = $request->uploadedfile;
        $filename = $file->getClientOriginalName();
        $name = rand() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $name);
        $user = new uploadedfiledata;
        $user->filename = $filename;
        $user->file = $name;
        $user->status = 'createquestions';
        $user->added_by = auth::user()->id;
        $user->filetype = $request->filetype;
        $user->save();
        $count = $data = Uploadedquestions::count();
        return redirect()->back()->with('uploadedcomplete', $user->id);
    }

    public function createfile($id , $importfile)
    {      

        if($importfile == 'createquestions')
        {
            ini_set('memory_limit', '-1');
            set_time_limit(20000000000);
            ini_set('max_execution_time', 0); // 0 = Unlimited
            $data = answerquestions::where('create_url' , 0)->get();
           foreach ($data as $r) {
               $url = $this->slugify($r->question_name);
               $shortenurl = Cmf::shorten_url($url);
               $question_url = array('question_url'=>$shortenurl,'create_url'=>1);
               answerquestions::where('id'  ,$r->id)->update($question_url);
           }

           $this->creat_user_of_question();

           $this->create_subjects();

           $this->create_answers_of_all_question();

           $this->insert_images_of_all_questions();

           $fileupdate = uploadedfiledata::find($id);
           $fileupdate->status = 'importSuccessfully';
           $fileupdate->save();
           
           echo "successfully";  
        }


        if($importfile == 'createuser')
        {
            ini_set('memory_limit', '-1');
            set_time_limit(20000000000);
            ini_set('max_execution_time', 0); // 0 = Unlimited
            $this->creat_user_of_question();
            $fileupdate = uploadedfiledata::find($id);
            $fileupdate->status = 'createsubject';
            $fileupdate->save();
            echo "createsubject";
        }

        if($importfile == 'createsubject')
        {
            ini_set('memory_limit', '-1');
            set_time_limit(20000000000);
            ini_set('max_execution_time', 0); // 0 = Unlimited
            $this->create_subjects();
            $fileupdate = uploadedfiledata::find($id);
            $fileupdate->status = 'createurl';
            $fileupdate->save();
            echo "createanswer";
        }

        if($importfile == 'createanswer')
        {
            ini_set('max_execution_time', 0); // 0 = Unlimited
            set_time_limit(20000000000);
            $this->create_answers_of_all_question();
            $fileupdate = uploadedfiledata::find($id);
            $fileupdate->status = 'createimages';
            $fileupdate->save();
            echo "createimages";
        }

        if($importfile == 'createimages')
        {
            ini_set('max_execution_time', 0); // 0 = Unlimited
            ini_set('memory_limit', '-1');
            set_time_limit(20000000000);
            $this->insert_images_of_all_questions();
            $fileupdate = uploadedfiledata::find($id);
            $fileupdate->status = 'importSuccessfully';
            $fileupdate->save();
            echo "successfully";
        }

    }

    public function abusivewordfileview()
    {
        return view('admin.fileuploader.abusivewords');
    }

    public function createfileabusivewords(Request $request)
    {
           set_time_limit(20000000000);
           Excel::import(new Abusivewordsimport,request()->file('uploadedfile'));
           Abusivewords::where('word', null)->delete();
           $getduplicate = Abusivewords::groupBy('word')->get();
           $userRolesId = array_column($getduplicate ->toArray(), 'id');
           Abusivewords::whereNotIn('id', $userRolesId )->delete();

           $file = $request->uploadedfile;
           $filename = $file->getClientOriginalName();
           $name = rand() . '.' . $file->getClientOriginalExtension();
           $file->move(public_path('images'), $name);
           $user = new uploadedfiledata;
           $user->filename = $filename;
           $user->file = $name;
           $user->status = 'importSuccessfully';
           $user->added_by = auth::user()->id;
           $user->filetype = $request->filetype;
           $user->save();
           return redirect()->back()->with('message', 'File Uploaded Successfully');
    }

    public function usersfileview()
    {
        return view('admin.fileuploader.usersfile');
    }

    public function createfileusers(Request $request)
    {
        set_time_limit(20000000000);
        DB::table('userfile')->delete();
        Excel::import(new Usersimport,request()->file('uploadedfile'));
        $data = userfile::all();
        foreach ($data as $r) {
            $user = user::where('username' , $r->username)->count();
            if($user == 0)
            {
                $user = new user;
                $user->username = $r->username;
                $user->is_admin = 0;
                $user->save();
            }
        }
       $file = $request->uploadedfile;
       $filename = $file->getClientOriginalName();
       $name = rand() . '.' . $file->getClientOriginalExtension();
       $file->move(public_path('images'), $name);
       $user = new uploadedfiledata;
       $user->filename = $filename;
       $user->file = $name;
       $user->status = 'importSuccessfully';
       $user->added_by = auth::user()->id;
       $user->filetype = $request->filetype;
       $user->save();
        return redirect()->back()->with('message', 'File Uploaded Successfully');
    }


    
    /****************************************************
                   Question Answers
    *****************************************************/
    public function questionsall()
    {
        $data = answerquestions::where('delete_status' , 'Active')->orderBy('id', 'DESC')->paginate(Cmf::site_settings('datashowlimit'));
        return view('admin.data.question')->with(array('data'=>$data));
    }
    public function questionspublished()
    {
        $data = answerquestions::where('visible_status' , 'Published')->where('delete_status' , 'Active')->orderBy('id', 'DESC')->paginate(Cmf::site_settings('datashowlimit'));
        return view('admin.data.questionspublished')->with(array('data'=>$data));
    }
    public function questionsunderreview()
    {
        $data = answerquestions::where('visible_status' , 'Under Review')->where('delete_status' , 'Active')->orderBy('id', 'DESC')->paginate(Cmf::site_settings('datashowlimit'));
        return view('admin.data.questionsunderreview')->with(array('data'=>$data));
    }
    public function questionstrash()
    {
        $data = answerquestions::where('visible_status' , 'Trash')->where('delete_status' , 'Active')->orderBy('id', 'DESC')->paginate(Cmf::site_settings('datashowlimit'));
        return view('admin.data.questionstrash')->with(array('data'=>$data));
    }
    public function deletequestion(Request $request)
    {
        if ($request->allid) {
            foreach ($request->allid as $r) {
                $question = answerquestions::find($r);
                $question->delete_status = 'Delete';
                $question->save();
            }
            return redirect()->back()->with('message', 'Selected record has been deleted successfully.');
        }
    }
    public function movetotrashquestion(Request $request)
    {
        if ($request->allid) {
            foreach ($request->allid as $r) {
                $question = answerquestions::find($r);
                $question->visible_status = 'Trash';
                $question->save();
            }
            return redirect()->back()->with('message', 'Selected record has been deleted successfully.');
        }
    }
    public function publishedquestion(Request $request)
    {
        if ($request->allid) {
            foreach ($request->allid as $r) {
                $question = answerquestions::find($r);
                $question->visible_status = 'Published';
                $question->save();
            }
            return redirect()->back()->with('message', 'Selected record has been deleted successfully.');
        }
    }
    public function underreviewquestion(Request $request)
    {
        if ($request->allid) {
            foreach ($request->allid as $r) {
                $question = answerquestions::find($r);
                $question->visible_status = 'Under Review';
                $question->save();
            }
            return redirect()->back()->with('message', 'Selected record has been deleted successfully.');
        }
    }
    public function filteranswer(Request $request)
    {
        if($request->filterbydate == 'all')
        {
            $data = onlyanswers::where('delete_status' , 'Active')->orderBy('created_at', 'desc')->get();
        }
        if($request->filterbydate == 'today')
        {
            $data = onlyanswers::where('delete_status' , 'Active')->orderBy('created_at', 'desc')->whereDate('created_at', Carbon::today())->orderBy('created_at', 'desc')->get();
        }
        if($request->filterbydate == 'week')
        {
            $data = onlyanswers::where('delete_status' , 'Active')->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->orderBy('created_at', 'desc')->get();
        }
        if($request->filterbydate == 'month')
        {
            $data = onlyanswers::where('delete_status' , 'Active')->orderBy('created_at', 'desc')->whereMonth('created_at', Carbon::now()->month)->orderBy('created_at', 'desc')->get();
        }
        return view('admin.data.answers')->with(array('data'=>$data,'search'=>'search','filterbydate'=>$request->filterbydate));

    }
    public function filterquestion(Request $request)
    {

        if(!empty($request->filterbydate))
        {
            if(!empty($request->filterbysubject))
            {
                if(!empty($request->filterbystatus))
                {
                    if($request->filterbydate == 'month')
                    {
                        $data = answerquestions::where('question_subject' , $request->filterbysubject)->where('question_status' , $request->filterbystatus)->whereMonth('created_at', Carbon::now()->month)->orderBy('created_at', 'desc')->get();
                    }
                    if($request->filterbydate == 'all')
                    {
                        $data = answerquestions::where('question_subject' , $request->filterbysubject)->where('question_status' , $request->filterbystatus)->orderBy('created_at', 'desc')->get();
                    }
                    if($request->filterbydate == 'week')
                    {
                        $data = answerquestions::where('question_subject' , $request->filterbysubject)->where('question_status' , $request->filterbystatus)->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->orderBy('created_at', 'desc')->get();
                    }
                    if($request->filterbydate == 'today')
                    {
                        $data = answerquestions::where('question_subject' , $request->filterbysubject)->where('question_status' , $request->filterbystatus)->whereDate('created_at', Carbon::today())->orderBy('created_at', 'desc')->get();
                    }
                }else{
                    if($request->filterbydate == 'month')
                    {
                        $data = answerquestions::where('question_subject' , $request->filterbysubject)->whereMonth('created_at', Carbon::now()->month)->orderBy('created_at', 'desc')->get();
                    }
                    if($request->filterbydate == 'all')
                    {
                        $data = answerquestions::where('question_subject' , $request->filterbysubject)->orderBy('created_at', 'desc')->get();
                    }
                    if($request->filterbydate == 'week')
                    {
                        $data = answerquestions::where('question_subject' , $request->filterbysubject)->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->orderBy('created_at', 'desc')->get();
                    }
                    if($request->filterbydate == 'today')
                    {
                        $data = answerquestions::where('question_subject' , $request->filterbysubject)->whereDate('created_at', Carbon::today())->orderBy('created_at', 'desc')->get();
                    }
                }
            }else{
                if(!empty($request->filterbystatus))
                {
                    if($request->filterbydate == 'month')
                    {
                        $data = answerquestions::where('question_status' , $request->filterbystatus)->whereMonth('created_at', Carbon::now()->month)->orderBy('created_at', 'desc')->get();
                    }
                    if($request->filterbydate == 'all')
                    {
                        $data = answerquestions::where('question_status' , $request->filterbystatus)->orderBy('created_at', 'desc')->get();
                    }
                    if($request->filterbydate == 'week')
                    {
                        $data = answerquestions::where('question_status' , $request->filterbystatus)->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->orderBy('created_at', 'desc')->get();
                    }
                    if($request->filterbydate == 'today')
                    {
                        $data = answerquestions::where('question_status' , $request->filterbystatus)->whereDate('created_at', Carbon::today())->orderBy('created_at', 'desc')->get();
                    }
                }else{
                    if($request->filterbydate == 'month')
                    {
                        $data = answerquestions::whereMonth('created_at', Carbon::now()->month)->orderBy('created_at', 'desc')->get();
                    }
                    if($request->filterbydate == 'all')
                    {
                        $data = answerquestions::orderBy('created_at', 'desc')->get();
                    }
                    if($request->filterbydate == 'week')
                    {
                        $data = answerquestions::where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->orderBy('created_at', 'desc')->get();
                    }
                    if($request->filterbydate == 'today')
                    {
                        $data = answerquestions::whereDate('created_at', Carbon::today())->orderBy('created_at', 'desc')->get();
                    }
                }
            }
        }
        return view('admin.data.question')->with(array('data'=>$data,'search'=>'search','filterbydate'=>$request->filterbydate,'filterbystatus'=>$request->filterbystatus,'filterbysubject'=>$request->filterbysubject));
    }
    public function viewquestion($id)
    {
        $data = answerquestions::where('id' , $id)->get()->first();
        $answers = onlyanswers::where('delete_status' , 'Active')->where('questionid' , $data->id)->paginate(Cmf::site_settings('datashowlimit'));
        return view('admin.data.viewquestion')->with(array('data'=>$data,'answers'=>$answers));
    }
    public function removelink($text)
   {
        $regex = "@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@";
        return preg_replace($regex, ' ', $text);
   }
    public function addanswer(Request $request)
    {
        $this->validate($request, [
            'answer' => 'required',
        ]);
        $message = "Answer Added successfully";
        $alert = 'message';
        $id = $request->id;
        $answer = $this->removelink($request->answer);
        $userid = auth()->user()->id;
        $date = date('Y-m-d h:m:s');
        $randid = rand('10000' , '500000');
        $answerid = $randid.$id;
        $username = auth()->user()->username;
        $answersave = new onlyanswers;
        $answersave->users = $username;
        $answersave->questionid = $id;
        $answersave->answer = $answer;
        $answersave->delete_status = 'Active';
        $answersave->visible_status = 'Published';
        $answersave->rattings = 0;
        $answersave->save();

        $answersave->id;
          

        $getquestion = answerquestions::find($id);
        $getanswer = onlyanswers::where('id' , $answerid)->get()->first();
        $getuser = user::where('username' , $getquestion->question_auther)->get()->first();
        $getquestion = answerquestions::find($id);
        $questionurl = url("").'/'.$getquestion->question_url;
        $usernotification = 'Someone Added Answer of Your Question . <a href="'.$questionurl.'">View Question</a>';
        Cmf::save_user_notification($usernotification , 'test',$getuser->id);

        $answerid = $answersave->id;

        $getallabusivewords = Abusivewords::all();
        foreach($getallabusivewords as $r)
        {
           $count =  onlyanswers::where('id', $answerid)->Where('answer', 'like', '%' . $r->word . '%')->count();
           if($count > 0)
           {
                $data = array('visible_status'=>'Under Review');
                onlyanswers::where('id' , $answerid)->update($data);
                $notification = auth()->user()->name.' Used Abusive Word in Answer';
                $url = url('admin/question').'/'.$id.'/'.$answerid;
                Cmf::save_admin_notification($notification ,$url,'uil-home-alt');
                Cmf::addabusivealert($getquestion->id , $answerid);
                Cmf::save_user_notification('We found something suspecious in your content please wait untill we approve your Answer' , 'test',$userid);
                $message = "We found something suspecious in your content please wait untill we approve your Answer";
                $alert = 'warning';
           }
        }
        if(Auth::user()->is_admin == 1)
        {
            return redirect()->back()->with($alert, $message)->with($alert, $message);
        }else{
            return Redirect::to(url('question').'/'.$getquestion->question_url)->with($alert, $message);
        }
    }
    public function createquestion(Request $request)
    {

        $previusid =   DB::table('answerquestions')->Orderby('id' , 'DESC')->get()->first()->id;
        $randid = $previusid+1;
        $name = $request->question_name;
        $url = $this->slugify($name);
        $shortenurl = Cmf::shorten_url($url);
        if(Cmf::checkurl($shortenurl) > 0)
        {
            $url = $shortenurl.'-'.$randid;
        }
        else
        {
            $url = $shortenurl;
        }
        $question = new answerquestions;
        $question->id = $randid;
        $question->question_name = $request->question_name;
        $question->question_content = $request->question_content;
        $question->question_url = $url;
        $question->question_status = 'Un Answered';
        $question->question_subject = $request->question_subject;
        $question->question_auther = auth()->user()->username;
        $question->question_like = $request->question_like;
        $question->question_ratting = $request->question_ratting;
        $question->delete_status = 'Active';
        $question->visible_status = 'Published';
        $question->metta_tittle = $request->metta_tittle;
        $question->metta_description = $request->metta_description;
        $question->save();
        Cmf::savesiteurl($url , 'singlequestion');
        $ip_address =  Cmf::getUserIpAddr();
        $activity = '<a href="'.url('admin/viewquestion').'/'.$randid.'">'.auth()->user()->name.' Added New Question</a>';
        Cmf::save_useractivities($ip_address , $activity,auth()->user()->id);
        if(!empty($request->image))
        {
            Cmf::save_image_name('questionimages' , 'questionid' , $randid , $request->image);
        }
        $message = "Question Added Successfully";
        $alert = 'message';

        if(Cmf::check_abusive_words($request->question_name) == 1)
        {
            $data = array('visible_status'=>'Under Review');
            answerquestions::where('id' , $randid)->update($data);
            $notification = auth()->user()->name.' Used Abusive Word in Question';
            $url = url('admin/viewquestion').'/'.$randid;
            Cmf::save_admin_notification($notification ,$url,'uil-home-alt');
            Cmf::addabusivealert($randid , $randid);
            $message = "We found something suspecious in your Question Name . Delete This Question or Re check Again";
            $alert = 'warning';
        }
    
        if(Cmf::check_abusive_words($request->question_content) == 1)
        {
            $data = array('visible_status'=>'Under Review');
            answerquestions::where('id' , $randid)->update($data);
            $notification = auth()->user()->name.' Used Abusive Word in Question';
            $url = url('admin/viewquestion').'/'.$randid;
            Cmf::save_admin_notification($notification ,$url,'uil-home-alt');
            Cmf::addabusivealert($randid , $randid);
            $message = "We found something suspecious in your Question Content . Delete This Question or Re check Again";
            $alert = 'warning';
        }

        return redirect()->back()->with($alert, $message);
        
    }
    public function deletequestiontrash($id)
    {
        $data = array('visible_status'=>'Trash');
        onlyanswers::where('questionid' , $id)->update($data);
        $data = array('visible_status'=>'Trash');
        DB::table('answerquestions')->where('id' , $id)->update($data);
        return redirect()->back()->with('message', 'Move to Trash successfully.');
    }
    public function deletequestionpermanently($id)
    {
        $checkanswers = onlyanswers::where('questionid' , $id)->count();
        if($checkanswers > 0)
        {
            $checkanswers = onlyanswers::where('questionid' , $id)->get();
            foreach ($checkanswers as $r) {
                DB::table('onlyanswers')->where('questionid' , $id)->delete();
            }
        }
        DB::table('answerquestions')->where('id' , $id)->delete();
        return redirect()->back()->with('message', 'Deleted successfully.');
    }
    public function searchanswer($id)
    {
        $data = onlyanswers::where('delete_status', 'Active')->Where('answer', 'like', '%' . $id . '%')->get();

       if(!empty($data))
       {
            foreach ($data as $r) {
                echo '<tr>
            <td>
                <div class="custom-control custom-checkbox">
                    <input value="'.$r->id.'" name="allid[]" type="checkbox" class="custom-control-input" id="customCheck'.$r->id.'">
                    <label class="custom-control-label" for="customCheck'.$r->id.'">&nbsp;</label>
                </div>
            </td>
            <td><a onclick="answerview('.$r->id.')" href="javascript:void(0)">A-'.$r->id.'</a></td>
            <td>
                '.Str::limit($r->answer  , 30).'
            </td>
            <td>
                '.$r->users.'
            </td>
            <td>
                '.date('d M Y, h:s a ', strtotime($r->created_at)).'
            </td>
            <td>
                <div class="badge badge-pill '; 


                if($r->visible_status == 'Published')
                    { 
                        echo 'badge-success'; 
                    } 
                if($r->visible_status == 'Trash')
                    { 
                        echo  'badge-danger'; 
                    }  
                if($r->visible_status == 'Under Review')
                    { 
                        echo 'badge-warning'; 
                    }

                    echo '" style="font-size: 15px;">'.$r->visible_status.'</div>
            </td>
            <td>
                <span onclick="answerview('.$r->id.')" class="btn btn-primary">View Complete</span>
            </td>
            <td class="table-action">
                <a href="'.url('admin/question/').'/'.$r->questionid.'/'.$r->id.'" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                <a  onclick="globaldelete('.$r->id.',"onlyanswers")" href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
            </td>
        </tr>';     
            } 
       }else{

            echo '<div style="text-align:center;">No Result Found</div>';

       }
       
    }
    public function addquestion()
    {
        return view('admin.data.add-question');
    }
    public function viewsingleanswer($id)
    {
        $data = onlyanswers::where('id' , $id)->get()->first();
        return response()->json(['answer' => $data->answer,'visible_status' => $data->visible_status,'users' => $data->users]);
    }
    public function editanswer($id , $answerid)
    {
        $data = answerquestions::where('id' , $id)->get()->first();
        $answers = onlyanswers::where('id' , $answerid)->get()->first();
        return view('admin.data.editanswer')->with(array('data'=>$data,'answers'=>$answers));
    }
    public function updateanswer(Request $request)
    {
        $data = array('answer'=>$request->answer,'visible_status'=>$request->visible_status,'likes'=>$request->likes,'rattings'=>$request->rattings);
        DB::table('onlyanswers')->where('id' , $request->id)->update($data);
        return redirect()->back()->with('message', 'Updated Successfully.');
    }
    public function viewsinglequestionview($id)
    {
        $data = answerquestions::where('id' , $id)->get()->first();
        return response()->json(['question_name' => $data->question_name,'accepted_answer' => $data->accepted_answer,'question_status' => $data->question_status,'question_subject' => $data->question_subject,'question_auther' => $data->question_auther,'question_like' => $data->question_like,'question_ratting' => $data->question_ratting,'question_vote_count' => $data->question_vote_count,'question_asked_time' => $data->question_asked_time,'question_number_of_answer' => $data->question_number_of_answer,'visible_status' => $data->visible_status]);
    }
    public function editquestion($id)
    {
        $data = answerquestions::where('id' , $id)->get()->first();
        return view('admin.data.editquestion')->with(array('data'=>$data));
    }

    public function updatquestion(Request $request)
    {

        if(!empty($request->image))
        {
            DB::table('questionimages')->where('questionid' , $request->id)->delete();
            Cmf::save_image_name('questionimages' , 'questionid' , $request->id , $request->image);
        }
        $shortenurl = Cmf::shorten_url($request->slug);
        $checkstatus = answerquestions::where('id'  ,$request->id)->get()->first()->visible_status;
        if($checkstatus != $request->visible_status)
        {
            $usernotification = 'Your Question Status Changed From '.$checkstatus.' To '.$request->visible_status.' . <a href="'.url("question/").'/'.$shortenurl.'">View Question</a>';
            Cmf::save_user_notification($usernotification , 'test',DB::table('users')->where('username' , answerquestions::where('id'  ,$request->id)->get()->first()->question_auther)->get()->first()->id);
        }        
        $data = array('question_url'=>$shortenurl,'question_content'=>$request->question_content,'metta_tittle'=>$request->metta_tittle,'metta_description'=>$request->metta_description,'question_name'=>$request->question_name,'accepted_answer'=>$request->accepted_answer,'question_subject'=>$request->question_subject,'visible_status'=>$request->visible_status);
        DB::table('answerquestions')->where('id' , $request->id)->update($data);
        $message = "Question Updated Added Successfully";
        $alert = 'message';




        return redirect()->back()->with($alert, $message);
    }
    public function answers()
    {
        $data = onlyanswers::where('delete_status' , 'Active')->orderBy('id', 'DESC')->paginate(Cmf::site_settings('datashowlimit'));
        return view('admin.data.answers')->with(array('data'=>$data));
    }
    public function deleteanswers(Request $request)
    {
        if ($request->allid) {
            foreach ($request->allid as $r) {
                $question = onlyanswers::find($r);
                $question->delete_status = 'Delete';
                $question->save();
            }
            return redirect()->back()->with('message', 'Selected record has been deleted successfully.');
        }
    }
    public function deleteanswerid($id)
    {
        DB::table('onlyanswers')->where('id' , $id)->delete();
        return redirect()->back()->with('message', 'Selected record has been deleted successfully.');
    }
    public function deleteanswertrash($id)
    {
        $question = onlyanswers::find($id);
        $question->visible_status = 'Trash';
        $question->save();
        return redirect()->back()->with('message', 'Added to Trash.');
    }

    public function movetotrashanswers(Request $request)
    {
        if ($request->allid) {
            foreach ($request->allid as $r) {
                $question = onlyanswers::find($r);
                $question->visible_status = 'Trash';
                $question->save();
            }
            return redirect()->back()->with('message', 'Selected record has been deleted successfully.');
        }
    }
    public function publishedanswers(Request $request)
    {
        if ($request->allid) {
            foreach ($request->allid as $r) {
                $question = onlyanswers::find($r);
                $question->visible_status = 'Published';
                $question->save();
            }
            return redirect()->back()->with('message', 'Selected record has been deleted successfully.');
        }
    }
    public function underreviewanswers(Request $request)
    {
        if ($request->allid) {
            foreach ($request->allid as $r) {
                $question = onlyanswers::find($r);
                $question->visible_status = 'Under Review';
                $question->save();
            }
            return redirect()->back()->with('message', 'Selected record has been deleted successfully.');
        }
    }
    public function answerspublished()
    {
        $data = onlyanswers::where('visible_status' , 'Published')->where('delete_status' , 'Active')->orderBy('id', 'DESC')->paginate(Cmf::site_settings('datashowlimit'));
        return view('admin.data.answerspublished')->with(array('data'=>$data));
    }
    public function answersunderreview()
    {
        $data = onlyanswers::where('visible_status' , 'Under Review')->where('delete_status' , 'Active')->orderBy('id', 'DESC')->paginate(Cmf::site_settings('datashowlimit'));
        return view('admin.data.answersunderreview')->with(array('data'=>$data));
    }
    public function answerstrash()
    {
        $data = onlyanswers::where('visible_status' , 'Trash')->where('delete_status' , 'Active')->orderBy('id', 'DESC')->paginate(Cmf::site_settings('datashowlimit'));
        return view('admin.data.answerstrash')->with(array('data'=>$data));
    }
    /****************************************************
                   Dynamic Pages
    *****************************************************/
    public function addpage()
    {
        return view('admin.cms.addpage');
    }
    public function allpages()
    {
        $data = dynamicpages::where('delete_status' , 'Active')->get();
        $viewstatus = 'all';
        return view('admin.cms.allpages')->with(array('data'=>$data,'viewstatus'=>$viewstatus));
    }
    public function allpageswithid($id)
    {
        if($id == 'published')
        {
            $data = dynamicpages::where('delete_status' , 'Active')->where('visible_status' , 'Published')->get();
        }
        if($id == 'notpublished')
        {
            $data = dynamicpages::where('delete_status' , 'Active')->where('visible_status' , 'Not Published')->get();
        }
        
        $viewstatus = $id;
        return view('admin.cms.allpages')->with(array('data'=>$data,'viewstatus'=>$viewstatus));
    }

    public function editpage($id)
    {
        $data = dynamicpages::where('id' , $id)->get()->first();
        return view('admin.cms.editpage')->with(array('data'=>$data));
    }
    public function createdynamicpage(Request $request)
    {
        $name = $request->name;
        if(Cmf::checkurl($request->slug) > 0)
        {
            return redirect()->back()->with('warning', 'Please Change the Page Slug Because This URL is Same With Other Url');
        }
        else
        {
            $dynamicpages = new dynamicpages;
            $dynamicpages->name = $name;
            $dynamicpages->slug = $request->slug;
            $dynamicpages->content = $request->content;
            $dynamicpages->show_on_footer = $request->show_on_footer;
            $dynamicpages->show_bellow = $request->show_bellow;
            $dynamicpages->visible_order = 0;
            $dynamicpages->metta_tittle = $request->metta_tittle;
            $dynamicpages->metta_description = $request->metta_description;
            $dynamicpages->metta_keywords = $request->metta_keywords;            
            $dynamicpages->delete_status = 'Active';
            $dynamicpages->added_by = auth()->user()->id;
            $dynamicpages->visible_status = $request->visible_status;
            $dynamicpages->save();
            Cmf::savesiteurl($request->slug , 'dynamicpages');
            return redirect()->back()->with('message', 'Page Successfully Inserted');
        }
    }
    public function updatepage(Request $request)
    {
        $url = $request->slug;
        $savedurl = DB::table('siteurls')->where('url', $url)->where('modulename' , 'dynamicpages')->first();
        if(empty($savedurl))
        {
            DB::statement("INSERT INTO `siteurls` (`url`, `modulename`)VALUES ('$url', 'dynamicpages')");
        }

        $data = array('show_bellow'=>$request->show_bellow,'visible_order'=>$request->visible_order,'show_on_footer'=>$request->show_on_footer,'slug'=>$url,'name'=>$request->name,'content'=>$request->content,'metta_tittle'=>$request->metta_tittle,'metta_description'=>$request->metta_description,'metta_keywords'=>$request->metta_keywords,'visible_status'=>$request->visible_status);
        $id =  $request->id;
        dynamicpages::where('id', $id)->update($data);
        return redirect()->back()->with('message', 'Page Updated Successfully');
    }
    /****************************************************
                   Notifications
    *****************************************************/
    public function abusivealerts()
    {
        $data = abusivealerts::all();
        return view('admin.notification.abusive')->with(array('data'=>$data));
    }

    public function advertisements()
    {
        return view('admin.settings.advertisements');
    }
    public function saveadvertisements(Request $request)
    {
        $this->updatesettings($request->header_script,'header_script');
        $this->updatesettings($request->body_script,'body_script');
        $this->updatesettings($request->footer_script,'footer_script');
        $this->updatesettings($request->left_add_1,'left_add_1');
        $this->updatesettings($request->left_add_2,'left_add_2');
        $this->updatesettings($request->right_add_1,'right_add_1');
        $this->updatesettings($request->right_add_2,'right_add_2');
        $this->updatesettings($request->question_detail_page_top,'question_detail_page_top');
        $this->updatesettings($request->answercard_advertisement,'answercard_advertisement');
        $this->updatesettings($request->question_card_advertisement,'question_card_advertisement');
        return redirect()->back()->with('message', 'Updated Successfully');
    }
    public function additionalcss()
    {
        return view('admin.settings.additional-css');
        
    }
    public function saveadditionalcss(Request $request)
    {
        $this->updatesettings($request->aditional_css,'aditional_css');
        return redirect()->back()->with('message', 'Updated Successfully');
    }
    public function media()
    {
        $data = DB::table('questionimages')->where('image_status' , 'Active')->get();
        return view('admin.media.index')->with(array('data'=>$data,'active'=>'questionimages'));
    }
    public function addmultipleimages(Request $request)
    {

        if($request->imagetype == 'other')
        {
            if(!empty($request->image))
            {
                foreach($request->image as $r)
                {  
                    Cmf::save_image_name('mediaimages' , 'mediaimag' , 1 , $r);
                }
            }
        }else{
            if(!empty($request->image))
            {
                foreach($request->image as $r)
                {  
                    Cmf::save_image_name('profileimages' , 'userid' , 1 , $r);
                }
            }
        }

        
        return redirect()->back()->with('message', 'Uploaded Successfully');
    }
    PUBLIC function getallimagesof($id)
    {

        $data = DB::table($id)->where('image_status' , 'Active')->paginate(Cmf::site_settings('datashowlimit'));
        return view('admin.media.index')->with(array('data'=>$data,'active'=>$id));
    }
    public function updatemediaimage(Request $request)
    {
        if(!empty($request->image))
        {
            $imagename = Cmf::sendimagetodirectory($request->image);
            $data = array('image_name'=>$imagename);
            DB::table($request->columname)->where('id' , $request->id)->update($data);
        }
        $data2 = array('image_tittle'=>$request->image_tittle);
        DB::table($request->columname)->where('id' , $request->id)->update($data2);
        return redirect()->back()->with('message', 'Updated Successfully');

    }
    public function deleteglobelfunction($id , $tablename)
    {
        $data = array('delete_status'=>'Delete');
        DB::table($tablename)->where('id' , $id)->update($data);
        return redirect()->back()->with('message', 'Deleted Successfully');
    }
    public function searchquestiontable($id)
    {
       $data = answerquestions::where('delete_status', 'Active')->Where('question_name', 'like', '%' . $id . '%')->get();

       if(!empty($data))
       {
            foreach ($data as $r) {
                echo '<tr>
            <td>
                <div class="custom-control custom-checkbox">
                    <input value="'.$r->id.'" name="allid[]" type="checkbox" class="custom-control-input" id="customCheck'.$r->id.'">
                    <label class="custom-control-label" for="customCheck'.$r->id.'">&nbsp;</label>
                </div>
            </td>
            <td><a href="'.url('admin/viewquestion').'/'.$r->id.'">Q-'.$r->id.'</a></td>
            <td>
                '.Str::limit($r->question_name  , 30).'
            </td>
            <td>
                '.$r->question_subject.'
            </td>
            <td>';
                if(!empty($r->accepted_answer))
                {
                    echo '<span class="badge badge-success-lighten"><i class="mdi mdi-timer-sand"></i>Answered</span>';
                }else{
                    echo '<span class="badge badge-warning-lighten"><i class="mdi mdi-timer-sand"></i>Unanswered</span>';
                }
                
            echo '</td>
            <td>
                '.DB::table('onlyanswers')->where('delete_status' , 'Active')->where('questionid' , $r->id)->count().'
            </td>
            <td>
                '.date('d M Y, h:s a ', strtotime($r->created_at)).'
            </td>
            <td>
                <div class="badge badge-pill '; 


                if($r->visible_status == 'Published')
                    { 
                        echo 'badge-success'; 
                    } 
                if($r->visible_status == 'Trash')
                    { 
                        echo  'badge-danger'; 
                    }  
                if($r->visible_status == 'Under Review')
                    { 
                        echo 'badge-warning'; 
                    }

                    echo '" style="font-size: 15px;">'.$r->visible_status.'</div>
            </td>
            <td class="table-action">
                <a href="'.url('admin/editquestion/').'/'.$r->id.'" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                <a  href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
            </td>
        </tr>';     
            } 
       }else{

            echo '<div style="text-align:center;">No Result Found</div>';

       }
       

    }
    public function sitemap()
    {
        return view('admin.settings.sitemap');
    }
    public function genratesitemap($id)
    {
        if($id == 'question')
        {
            $data = answerquestions::where('visible_status' , 'Published')->where('delete_status' , 'Active');

            $url = url('questionsitemap.xml');
        }
        if($id == 'blogs')
        {
            $data = blogs::where('visible_status' , 'Published')->where('delete_status' , 'Active');
            $url = url('blogpostssitemap.xml');
        }
        if($id == 'pages')
        {
            $data = dynamicpages::where('visible_status' , 'Published')->where('delete_status' , 'Active');
            $url = url('dynamicpagesitemap.xml');
        }

        return response()->json(['count' => $data->count(),'url' => $url]);
    }
    public function deleteimagequestionadmin($id)
    {
        DB::table('questionimages')->where('id'  ,$id)->delete();
        return redirect()->back()->with('message', 'Deleted Successfully.');
    }
    public function deletemediaimage($id , $table)
    {
        DB::table($id)->where('id' , $table)->delete();
        return redirect()->back()->with('message', 'Deleted Successfully.');
    }
    public function searchtags($id)
    {


        $data = DB::table('wphj_term_taxonomy')->where('taxonomy' , 'post_tag')->get();

         echo '<div style="height: 300px;overflow: auto;overflow-x: hidden;">';
          foreach($data as $r){

            if(!empty(DB::table('wphj_terms')->where('term_id' , $r->term_id)->where('name', 'like',  $id . '%')->get()->first()->name))
            {
               
                echo '<div style="background-color:#dddddd;padding:10px;color: black;margin-bottom: 10px;">
                    <div class="row">
                        <div  title="" class="col-md-11">'. Str::limit(DB::table('wphj_terms')->where('term_id' , $r->term_id)->where('name', 'like', '%' . $id . '%')->get()->first()->name, 60).'
                        </div>
                        <div style="cursor: pointer;" onclick="addtage('.DB::table('wphj_terms')->where('term_id' , $r->term_id)->where('name', 'like', '%' . $id . '%')->get()->first()->term_id.')" class="col-md-1">
                            +
                        </div>
                    </div>
                </div>';
            }

           
          }
      echo '</div>';
    }


    public function addtag($blogid , $tagid)
    {
        DB::statement("INSERT INTO `wphj_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`)VALUES ('$blogid', '$tagid', '0')");


        foreach(DB::table('wphj_term_relationships')->where('object_id' , $blogid)->get() as $r)
        {
            if(DB::table('wphj_term_taxonomy')->where('term_id' , $r->term_taxonomy_id)->get()->first()->taxonomy == 'post_tag')
            {
                echo '<div style="background-color:#dddddd;padding:10px;color: black;margin-bottom: 10px;">
                    <div class="row">
                        <div title="'.DB::table('wphj_terms')->where('term_id' , $r->term_taxonomy_id)->get()->first()->name.'" class="col-md-11">'.Str::limit(DB::table('wphj_terms')->where('term_id' , $r->term_taxonomy_id)->get()->first()->name, 50).'</div>
                        <div style="cursor: pointer;" onclick="deletetag('.DB::table('wphj_terms')->where('term_id' , $r->term_taxonomy_id)->get()->first()->term_id.')" class="col-md-1">
                            X
                        </div>
                    </div>
                </div>';
            }
        }
    }
    public function deletetag($blogid , $tagid)
    {

        DB::table('wphj_term_relationships')->where('object_id' , $blogid)->where('term_taxonomy_id' , $tagid)->delete();

        foreach(DB::table('wphj_term_relationships')->where('object_id' , $blogid)->get() as $r)
        {
            if(DB::table('wphj_term_taxonomy')->where('term_id' , $r->term_taxonomy_id)->get()->first()->taxonomy == 'post_tag')
            {
                echo '<div style="background-color:#dddddd;padding:10px;color: black;margin-bottom: 10px;">
                    <div class="row">
                        <div title="'.DB::table('wphj_terms')->where('term_id' , $r->term_taxonomy_id)->get()->first()->name.'" class="col-md-11">'.Str::limit(DB::table('wphj_terms')->where('term_id' , $r->term_taxonomy_id)->get()->first()->name, 50).'</div>
                        <div style="cursor: pointer;" onclick="deletetag('.DB::table('wphj_terms')->where('term_id' , $r->term_taxonomy_id)->get()->first()->term_id.')" class="col-md-1">
                            X
                        </div>
                    </div>
                </div>';
            }
        }
    }


    public function changebulkusersofall(Request $request)
    {
        if ($request->allid) {
            foreach ($request->allid as $r) {
                $question = blogs::find($r);
                $question->added_by = $request->user;
                $question->save();
            }
            return redirect()->back()->with('message', 'Selected record has been Updated successfully.');
        }
    }

    public function searchusers($id)
    {
        $data = user::Where('username', 'like', '%' . $id . '%')->get();



        foreach ($data as $r) {
            
            echo '<option value="'.$r->id.'">'.$r->username.'</option>';   


        }
    }
}