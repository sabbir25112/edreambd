<?php namespace App\Http\Controllers;

use App\Attendance;
use App\Classroom;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index($classroom_id)
    {
        $date = request()->get('date') ? Carbon::create(request()->get('date')) : Carbon::today();
        $attendance = Attendance::where('date', $date)->pluck('student_id')->toArray();
        $students = Classroom::find($classroom_id)->student;
        return view('attendance.index', compact('classroom_id', 'attendance', 'students', 'date'));
    }
}
