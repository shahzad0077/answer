<?php

namespace App\Http\Controllers\Auth;
use App\Helper\Cmf;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\access;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use File;
Use DB;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $email = $data['email'];
        if(DB::table('accesses')->where('email' , $email)->get()->count() == 0){
            $sendingpath = 'userdata/'.$email;
            $path = public_path($sendingpath);
            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }
            $url = url('admin/users');
            Cmf::save_admin_notification($data['name'].' is a New Registerd User ' , $url , 'mdi-account-circle mr-1');
        }
        if(isset($data['accessid']))
        {
            $accessid =  $data['accessid'];
            $email =  $data['email'];
            $password =  $data['password'];
            $name =  $data['name'];
            $data = array('status'=>'Accepted');
            DB::table('accesses')->where('id', $accessid)->update($data);
            return User::create([
                'name' => $name,
                'profileimage' => '2122741339.jpg',
                'is_admin' => '0',
                'active' => '1',
                'accessid' => $accessid,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
        }
        else
        {
            return User::create([
                'name' => $data['name'],
                'profileimage' => '2122741339.jpg',
                'is_admin' => '0',
                'active' => '1',
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
        }
        
    }
}
