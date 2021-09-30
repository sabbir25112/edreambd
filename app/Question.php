<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = ['id'];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function getAnswerTextAttribute()
    {
        $output = [];
        $answers = explode(',', $this->answer);
        foreach ($answers as $answer)
        {
            // $output[] = "Option ". $answer;
            $option = 'option_'.$answer;
            $output[] = $this->$option;
        }
        return implode(', ', $output);
    }

    public function getAnswerArrayAttribute()
    {
        return explode(',', $this->answer);
    }
}
