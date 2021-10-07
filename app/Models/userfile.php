<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userfile extends Model
{
    protected $table = 'userfile';
    protected $fillable = [
        'username', 
    ];
}
