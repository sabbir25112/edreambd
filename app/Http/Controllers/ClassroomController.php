<?php namespace App\Http\Controllers;

use App\Classroom;
use App\JoinRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::where('teacher_id', auth()->user()->id)
            ->withCount('student')
            ->paginate(config('app.DEFAULT_PAGINATION'));
        return view('classroom.index', compact('classrooms'));
    }

    public function show($classroom_id)
    {
        $classroom = Classroom::find($classroom_id);
        $students = Classroom::whereHas('student', function ($query) {
            return $query->where('student_id', auth()->user()->id);
        })->count();
        if ($students == 0 && $classroom->teacher_id != auth()->user()->id) {
            Session::flash('status', 'You are not allowed for this classroom');
            return redirect()->back();
        }
        $classroom->addAttendance();

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

    public function edit($classroom_id)
    {
        $classroom = Classroom::where('teacher_id', auth()->user()->id)->where('id', $classroom_id)->first();
        if (is_null($classroom)) {
            Session::flash('status', 'You are not authorized to update this classroom');
            return redirect()->back();
        }
        return view('classroom.edit', compact('classroom'));
    }

    public function update(Request $request, $classroom_id)
    {
        $classroom = Classroom::where('teacher_id', auth()->user()->id)->where('id', $classroom_id)->first();
        if (is_null($classroom)) {
            Session::flash('status', 'You are not authorized to update this classroom');
            return redirect()->back();
        }
        $classroom->update([
            'name'      => $request->name,
            'subject'   => $request->subject,
            'section'   => $request->section,
            'room'      => $request->room
        ]);

        Session::flash('status', 'Classroom Updated Successfully');
        return redirect()->back();
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

        Session::flash('status', 'You Classroom Join Request is Pending for Approval');
        return redirect()->route('classroom.index');
    }

    public function addStudent($classroom_id)
    {
        $classroom = Classroom::where('teacher_id', auth()->user()->id)->where('id', $classroom_id)->first();
        if (is_null($classroom)) {
            Session::flash('status', 'You are not authorized to update this classroom');
            return redirect()->back();
        }
        return view('classroom.add-student', compact('classroom'));
    }

    public function storeStudent(Request $request, $classroom_id)
    {
        $classroom = Classroom::where('teacher_id', auth()->user()->id)->where('id', $classroom_id)->first();
        if (is_null($classroom)) {
            Session::flash('status', 'You are not authorized to update this classroom');
            return redirect()->back()->withInput();
        }
        if (auth()->user()->email == $request->email) {
            Session::flash('status', 'You can\'t add your email');
            return redirect()->back()->withInput();
        }
        $this->validate($request, [
            'email' => 'required|exists:users,email'
        ]);
        $student = User::where('email', $request->email)->first();
        $classroom->student()->sync($student->id);
        Session::flash('status', 'Student Added Successfully');
        return redirect()->route('classroom.index');
    }

    public function asStudent()
    {
        $classrooms = Classroom::whereHas('student', function ($query) {
            return $query->where('student_id', auth()->user()->id);
        })->paginate(config('app.DEFAULT_PAGINATION'));
        return view('classroom.index', compact('classrooms'));
    }
}
