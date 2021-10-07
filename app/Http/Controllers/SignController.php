<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Auth;
use Exception;
use App\Models\User;
use App\Helper\Cmf;
use DB;
use Redirect;
class SignController extends Controller
{
    public function signup()
    {
        return view('frontend.signup');
    }
    public function signin()
    {
        return view('frontend.login');
    }
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function checkuseractive($email)
    {
        return DB::table('users')->where('email' , $email)->get()->first()->active;
    }
    public function checkuseractivefacebook($id)
    {
        return DB::table('users')->where('facebook_id' , $id)->get()->first()->active;
    }
    
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();
            if($finduser){
                if($this->checkuseractive($user->email) == 0)
                {
                    return redirect()->route('signin')->with(array('warning'=>'Your Account is Banned Due to Some Reasons. If you want to Reopen your Account Please contact Us' , 'email'=>$user->email));
                }else{
                    Auth::login($finduser);
                    $data = array('online'=>1,'lastlogin'=>date(Cmf::site_settings('datetime')));
                    DB::table('users')->where('id' , Auth::user()->id)->update($data);
                    if(!isset($_COOKIE['redirecturl'])) {
                        return redirect()->route('home');
                    } else {
                       $newURL =  $_COOKIE['redirecturl'];
                       return Redirect::to($newURL);
                    }
                }
            }else{
                $myvalue = $user->name;
                $arr = explode(' ',trim($myvalue));
                $username = $arr[0] . rand(pow(10, 8 - 1), pow(10, 8) -1);
                $username = strtolower($username);
                $newUser = User::create([
                    'name' => $user->name,
                    'username' => $username,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'profileimage'=> $user->getAvatar(),
                    'is_admin'=> 0,
                    'active'=> 1,
                    'online'=> 1,
                    'lastlogin'=>date(Cmf::site_settings('datetime'))
                ]);
                Auth::login($newUser);
                $data = array('online'=>1,'lastlogin'=>date(Cmf::site_settings('datetime')));
                DB::table('users')->where('id' , Auth::user()->id)->update($data);
                return redirect()->route('myprofile');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function facebookSignin()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            $finduser = User::where('facebook_id', $user->id)->first();



            if($finduser){
                if($this->checkuseractivefacebook($user->id) == 0)
                {
                    return redirect()->route('signin')->with(array('warning'=>'Your Account is Banned Due to Some Reasons. If you want to Reopen your Account Please contact Us' , 'email'=>$user->email));
                }else{
                    Auth::login($finduser);
                    $data = array('online'=>1,'lastlogin'=>date(Cmf::site_settings('datetime')));
                    DB::table('users')->where('id' , Auth::user()->id)->update($data);
                    if(!isset($_COOKIE['redirecturl'])) {
                        return redirect()->route('home');
                    } else {
                       $newURL =  $_COOKIE['redirecturl'];
                       return Redirect::to($newURL);
                    }
                }
            }else{
                $myvalue = $user->name;
                $arr = explode(' ',trim($myvalue));
                $username = $arr[0] . rand(pow(10, 8 - 1), pow(10, 8) -1);
                $username = strtolower($username);
                $newUser = User::create([
                    'name' => $user->name,
                    'username' => $username,
                    'email' => $user->email,
                    'facebook_id'=> $user->id,
                    'profileimage'=> $user->getAvatar(),
                    'is_admin'=> 0,
                    'active'=> 1,
                    'online'=> 1,
                    'lastlogin'=>date(Cmf::site_settings('datetime'))
                ]);
                Auth::login($newUser);
                $data = array('online'=>1,'lastlogin'=>date(Cmf::site_settings('datetime')));
                DB::table('users')->where('id' , Auth::user()->id)->update($data);
                return redirect()->route('myprofile');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
