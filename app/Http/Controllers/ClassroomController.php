<?php namespace App\Http\Controllers;

use App\Classroom;
use App\JoinRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::where('teacher_id', auth()->user()->id)->paginate(config('app.DEFAULT_PAGINATION'));
        return view('classroom.index', compact('classrooms'));
    }

    public function show($classroom_id)
    {
        $classroom = Classroom::find($classroom_id);
        return $classroom;
        return view('classroom.show', compact('classroom'));
    }

    public function create()
    {
        return view('classroom.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required']);

        Classroom::create([
            'name' => $request->name,
            'subject' => $request->subject,
            'section' => $request->section,
            'room' => $request->room,
            'class_code' => Str::random(10),
            'teacher_id' => auth()->user()->id
        ]);

        return redirect()->route('classroom.index');
    }

    public function join()
    {
        return view('classroom.join');
    }

    public function requestJoin(Request $request)
    {
        $this->validate($request, [
            'class_code' => [
                Rule::exists('classrooms', 'class_code')
                    ->whereNot('teacher_id', auth()->user()->id)
            ]
        ]);

        $classroom = Classroom::where('class_code', $request->class_code)->first();
        $pending_join_request = JoinRequest::where('student_id', auth()->user()->id)
                                    ->where('classroom_id', $classroom->id)
                                    ->whereIn('status', ['PENDING', 'ACCEPTED'])
                                    ->first();
        if ($pending_join_request) {
            return redirect()->back()
                ->withErrors(['class_code' => 'You are not allowed to join request in this classroom'])
                ->withInput();
        }
        JoinRequest::create([
            'student_id' => auth()->user()->id,
            'classroom_id' => $classroom->id
        ]);

        Session::flush('status', 'You Classroom Join Request is Pending for Approval');
        return redirect()->route('classroom.index');
    }
}
