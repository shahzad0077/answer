<?php
  
namespace App\Exports;
  
use App\Models\answerquestions;
use Maatwebsite\Excel\Concerns\FromCollection;
  
class QuestionExports implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return answerquestions::all();
    }
}