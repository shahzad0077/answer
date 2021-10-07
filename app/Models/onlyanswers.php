<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class onlyanswers extends Model
{
    protected $table = 'onlyanswers';
    protected $fillable = [
        'users', 'questionid','answer', 'delete_status','visible_status', 'answer_status',
    ];
}
