<?php
namespace App\Imports;
use App\Models\Abusivewords;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Abusivewordsimport implements ToModel, WithHeadingRow

{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        return new Abusivewords([
             'word'=>   $row['word_name'],
        ]);
    }
}