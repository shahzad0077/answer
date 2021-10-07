<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
class LanguageController extends Controller
{
    public function changelanguage($key)
    {
        Session::put('language', $key);
        echo "1";
    }
}
