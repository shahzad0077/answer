<?php

namespace App\Helper;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\abusivealerts;
use App\Models\Abusivewords;
use Carbon\Carbon;

class Cmf
{
    public static function site_settings($columname)
    {
        return DB::table('system_settings')->where('key' , $columname)->get()->first()->value;
    }
    public static function getuserdetailsbyid($id)
    {
        return DB::table('users')->where('username' , $id)->get()->first();
    }
    public static function sendimagetodirectory($imagename)
    {
        $file = $imagename;
        $filename = rand() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $filename);
        return $filename;
    }
    public static function create_time_ago($time)
    {

        $year = date('Y', strtotime($time));
        $month = date('m', strtotime($time));
        $day = date('d', strtotime($time));
        $datetime = Carbon::parse($time);
        return $datetime->diffForHumans();
    }
    public static function save_image_name($tablename ,$columname , $columid , $imagename)
    {
        $file = $imagename;
        $filename = rand() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $filename);
        $date = date('Y-m-d h:m:s');
        $userid = auth()->user()->id;
        DB::statement("INSERT INTO `$tablename` (`$columname`, `image_name`, `image_status`, `added_by`, `created_at`)VALUES ('$columid', '$filename', 'Active', $userid , '$date')");
    }
    public static function shorten_url($text)
    {
        $words = explode('-', $text);
        $five_words = array_slice($words,0,12);
        $String_of_five_words = implode('-',$five_words)."\n";

        $String_of_five_words = preg_replace('~[^\pL\d]+~u', '-', $String_of_five_words);
        $String_of_five_words = iconv('utf-8', 'us-ascii//TRANSLIT', $String_of_five_words);
        $String_of_five_words = preg_replace('~[^-\w]+~', '', $String_of_five_words);
        $String_of_five_words = trim($String_of_five_words, '-');
        $String_of_five_words = preg_replace('~-+~', '-', $String_of_five_words);
        $String_of_five_words = strtolower($String_of_five_words);
        if (empty($String_of_five_words)) {
          return 'n-a';
        }
        return $String_of_five_words;
    }
    public static function check_abusive_words($word)
    {
        $getallabusivewords = Abusivewords::all();

        foreach($getallabusivewords as $r)
        {
            $abusiveword = $r->word;
            if(strpos($word, $abusiveword) == true){
                return 1;
            } 

        }
    }

    public static function update_save_image_name($tablename ,$columname , $columid , $imagename)
    {
        $file = $imagename;
        $filename = rand() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $filename);
        $date = date('Y-m-d h:m:s');
        $userid = auth()->user()->id;
        $data = array('image_name'=>$filename , 'added_by'=>$userid);
        DB::table($tablename)->where($columname,$columid)->update($data);
    }
    public static function get_image_name($tablename ,$columname , $columid)
    {
        return DB::table($tablename)->where($columname , $columid)->get();
    }
    public static function getalldatacount($tablename)
    {
        return DB::table($tablename)->where('delete_status' , 'Active')->count();
    }
    public static function checkurl($url)
    {
        return DB::table('siteurls')->where('url' , $url)->count();
    }
    public static function savesiteurl($url , $modalname)
    {
        DB::statement("INSERT INTO `siteurls` (`url`, `modulename`)VALUES ('$url', '$modalname')");
    }
    public static function checkuserrolparent($id)
    {
        $roleid = Auth::user()->userroleid;
        return DB::table('rolesparent')->where('userroles' , $roleid)->where('parentid' , $id)->count();
    }
    public static function checkuserrolchild($id)
    {
        $roleid = Auth::user()->userroleid;
        return DB::table('roleschild')->where('userroles' , $roleid)->where('childid' , $id)->count();
    }
    public static function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {

        $output = NULL;

        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {

            $ip = $_SERVER["REMOTE_ADDR"];

            if ($deep_detect) {

                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))

                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))

                    $ip = $_SERVER['HTTP_CLIENT_IP'];

            }

        }

        $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));

        $support    = array("country", "countrycode", "state", "region", "city", "location", "address");

        $continents = array(

            "AF" => "Africa",

            "AN" => "Antarctica",

            "AS" => "Asia",

            "EU" => "Europe",

            "OC" => "Australia (Oceania)",

            "NA" => "North America",

            "SA" => "South America"

        );

        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {

            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));

            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {

                switch ($purpose) {

                    case "location":

                        $output = array(

                            "city"           => @$ipdat->geoplugin_city,

                            "state"          => @$ipdat->geoplugin_regionName,

                            "country"        => @$ipdat->geoplugin_countryName,

                            "country_code"   => @$ipdat->geoplugin_countryCode,

                            "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],

                            "continent_code" => @$ipdat->geoplugin_continentCode

                        );

                        break;

                    case "address":

                        $address = array($ipdat->geoplugin_countryName);

                        if (@strlen($ipdat->geoplugin_regionName) >= 1)

                            $address[] = $ipdat->geoplugin_regionName;

                        if (@strlen($ipdat->geoplugin_city) >= 1)

                            $address[] = $ipdat->geoplugin_city;

                        $output = implode(", ", array_reverse($address));

                        break;

                    case "city":

                        $output = @$ipdat->geoplugin_city;

                        break;

                    case "state":

                        $output = @$ipdat->geoplugin_regionName;

                        break;

                    case "region":

                        $output = @$ipdat->geoplugin_regionName;

                        break;

                    case "country":

                        $output = @$ipdat->geoplugin_countryName;

                        break;

                    case "countrycode":

                        $output = @$ipdat->geoplugin_countryCode;

                        break;

                }

            }

        }

        return $output;

    }
    public static function getUserIpAddr(){

        if(!empty($_SERVER['HTTP_CLIENT_IP'])){

            //ip from share internet

            $ip = $_SERVER['HTTP_CLIENT_IP'];

        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){

            //ip pass from proxy

            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

        }else{

            $ip = $_SERVER['REMOTE_ADDR'];

        }

        return $ip;

    }

    public static function save_admin_notification($notification , $url , $icon)
    {
        DB::statement("INSERT INTO `adminnotification` (`notification`, `url`, `icon`, `status`)VALUES ('$notification', '$url', '$icon', '1')");
    }

    public static function save_user_notification($notification , $url , $user)
    {
        DB::statement("INSERT INTO `usernotification` (`users`, `url`, `notification`, `status`)VALUES ('$user', '$url', '$notification', '1')");
    }    
    public static function addabusivealert($id , $answerid)
    {
        $abusivealerts = new abusivealerts;
        $abusivealerts->questionid = $id;
        $abusivealerts->answerid = $answerid;
        $abusivealerts->users = auth()->user()->id;
        $abusivealerts->status = 'Active';
        $abusivealerts->save();
    }
    public static function save_useractivities($ipaddress ,$activity , $user)
    {
        DB::statement("INSERT INTO `useractivities` (`ipaddress`,`activity`, `user`)VALUES ('$ipaddress','$activity', '$user')");
    }
}
