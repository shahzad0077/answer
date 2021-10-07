<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abusivewords extends Model
{
    protected $table = 'abusivewords';
    protected $fillable = [
        'word',
    ];
}
