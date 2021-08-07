<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded = [
        'id'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }
}
