<?php

namespace App\Http\Controllers\Auth;
use RealRashid\SweetAlert\Facades\Alert;   
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\sitesettings;   
use Validator;
use Session;
Use DB;
use Auth;
use App\Helper\Cmf;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
  
    use AuthenticatesUsers;
  
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';
   
    /**
     * Create a new controller instance.
     *
     * @return void
     */ 
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function checkuseractive($email)
    {
        return DB::table('users')->where('email' , $email)->get()->first()->active;
    }
    public function logout(Request $request) {
      $data = array('online'=>0,'lastlogout'=>date(Cmf::site_settings('datetime')));
      DB::table('users')->where('id' , Auth::user()->id)->update($data);
      if(auth()->user()->twofactor == 'on')
      {
        $data = array('authenticated'=>0);
        DB::table('users')->where('id' , auth()->user()->id)->update($data);
      }
      Auth::logout();
      return redirect()->route('signin');
    }
    public function login(Request $request)
    {   
        $input = $request->all();
   
        $request->validate([
                'email' => 'exists:users',
            ]);

        if($this->checkuseractive($request->email) == 0)
        {
            return redirect()->route('login')->with(array('error'=>'Your Account is Banned Due to Some Reasons. If you want to Reopen your Account Please contact Us' , 'email'=>$request->email));
        }else{
            if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'], 'active' => 1)))
            {
                if (auth()->user()->is_admin == 1) {
                    return redirect()->route('admin.dashboard');
                }else{
                   return redirect()->route('dashboard');
                }
            }else{
                return redirect()->route('login')->with(array('error'=>'Email-Address or Password Are Wrong.' , 'email'=>$request->email));
            } 
        }   
    }
}