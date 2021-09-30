<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamSheet extends Model
{
    protected $guarded = ['id'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }
}
