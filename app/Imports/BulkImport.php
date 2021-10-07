<?php
namespace App\Imports;
use App\Models\answerquestions;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BulkImport implements ToModel, WithHeadingRow

{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        return new answerquestions([
             'question_name'=>   $row['question'],
             'question_content'=>   $row['content'],
             'question_image'=>   $row['question_image'],
             'question_auther' => $row['question_user'],
             'accepted_answer' =>  $row['answer'],
             'answer_image' =>  $row['answer_image'],
             'answer_user' =>  $row['answer_user'],
             'question_status' =>  $row['status'],
             'question_subject' => $row['subject'],
             'question_asked_time' => $row['asked_time'],
             'question_like' => $row['likes'],
             'question_ratting' => $row['rating'],
             'question_vote_count' => $row['vote_count'],
             'expert_answer' => $row['expert_answer'],
             'metta_tittle' => $row['meta_title'],
             'metta_description' => $row['meta_description'],
             'delete_status' => 'Active',
             'visible_status' => 'Published',
        ]);
    }
}