<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uploadedquestions extends Model
{
    protected $table = 'uploadedquestions';
    protected $fillable = [
        'question_name', 'question_content', 'question_url','question_image', 'question_auther','accepted_answer', 'answer_image','answer_user', 'question_status','question_subject','question_asked_time','question_like','question_ratting','question_vote_count','metta_tittle','metta_description','metta_keywords','delete_status','visible_status','expert_answer',
    ];
}
