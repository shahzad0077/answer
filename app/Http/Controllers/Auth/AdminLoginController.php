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
use Illuminate\Support\Facades\Mail;
class AdminLoginController extends Controller
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
    
    public function twofactorshow()
    {
        return view('auth.admintwofactor');
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

                    if(auth()->user()->twofactor == 'on')
                    {
                        $code = rand(100000, 999999);
                        $email = $input['email'];
                        $subject = 'Two Factor Authentication Code';
                        $User = User::find(auth()->user()->id);
                        $User->two_factor_code = $code;
                        $User->two_factor_expires_at = now()->addMinutes(10);
                        $User->save();
                        Mail::send(array('html' => 'emails.contact'), array('code' => $code,'email' => $email), function($message) use ($email, $subject)
                        {
                            $message->to($email)->subject($subject);
                        });                       
                        return redirect()->route('twofactorshow');
                    }else{
                        return redirect()->route('admin.dashboard');
                    }
                    
                }
            }else{
                return redirect()->route('admin.login')->with(array('error'=>'Credentials are Wrong. Try Again.' , 'email'=>$request->email));
            } 
        }   
    }
}