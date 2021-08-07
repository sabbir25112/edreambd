<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $guarded = ['id'];

    public function joinRequest()
    {
        return $this->hasMany(JoinRequest::class);
    }

    public function student()
    {
        return $this->belongsToMany(User::class, 'classroom_student', 'classroom_id', 'student_id');
    }

    public function isTeacher()
    {
        return $this->teacher_id == auth()->user()->id;
    }

    public function resource()
    {
        return $this->hasMany(Resource::class);
    }

    public function addAttendance()
    {
        if (!$this->isTeacher()) {
            $todaysAttendance = Attendance::where('date', Carbon::today())
                ->where('student_id', auth()->user()->id)
                ->where('classroom_id', $this->id)
                ->count();
            if (!$todaysAttendance) {
                Attendance::create([
                    'student_id'    => auth()->user()->id,
                    'classroom_id'  => $this->id,
                    'date'          => Carbon::today()
                ]);
            }
        }
    }
}
