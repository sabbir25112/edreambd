<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Exam;
use App\ExamSheet;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($classroom_id)
    {
        $classroom = Classroom::findOrFail($classroom_id);
        if ($classroom->isTeacher() || $classroom->isStudent()) {
            $exams = $classroom->exams()->paginate(10);
            return view('exam.index', compact('classroom','exams'));
        }
        Session::flash('status', 'You are not allowed');
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($classroom_id)
    {
        $classroom = Classroom::findOrFail($classroom_id);
        if ($classroom->isTeacher()) {
            return view('exam.create', compact('classroom'));
        }
        Session::flash('status', 'You are not allowed');
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $classroom_id)
    {
        $classroom = Classroom::findOrFail($classroom_id);
        if ($classroom->isTeacher()) {
            $exam = [
                'start_time'    => Carbon::create($request->start_time),
                'name'          => $request->name,
                'duration'      => $request->duration,
                'classroom_id'  => $classroom_id
            ];
            Exam::create($exam);

            Session::flash('status', 'You have successfully created an exam');
            return redirect()->route('classroom.exam', $classroom_id);
        }
        Session::flash('status', 'You are not allowed');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam)
    {
        if (!$exam->isEditable())
        {
            Session::flash('status', 'This exam is not editable now');
            return redirect()->route('classroom.exam', $exam->classroom->id);
        }

        return view('exam.edit', compact('exam'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
    {
        if (!$exam->isEditable())
        {
            Session::flash('status', 'This exam is not editable now');
            return redirect()->route('classroom.exam', $exam->classroom->id);
        }

        if ($exam->classroom->isTeacher()) {
            $exam_update_data = [
                'start_time'    => Carbon::create($request->start_time),
                'name'          => $request->name,
                'duration'      => $request->duration,
            ];
            $exam->update($exam_update_data);
            Session::flash('status', 'You have successfully updated an exam');
            return redirect()->route('classroom.exam', $exam->classroom->id);
        }
        Session::flash('status', 'You are not allowed');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        //
    }

    public function enter(Exam $exam)
    {
        if (!$exam->isRunning()) {
            Session::flash('status', 'Exam is not running now');
            return redirect()->back();
        }

        $is_exam_sheet_created = ExamSheet::where('exam_id', $exam->id)->where('student_id', auth()->id())->count();
        if (!$is_exam_sheet_created)
        {
            $exam_sheets = [];
            $questions = $exam->questions;
            foreach ($questions as $question)
            {
                $exam_sheets[] = [
                    'exam_id'       => $exam->id,
                    'question_id'   => $question->id,
                    'student_id'    => auth()->id(),
                    'correct_answer'=> $question->answer,
                ];
            }
            ExamSheet::insert($exam_sheets);
        }

        $unanswered_question = ExamSheet::where('exam_id', $exam->id)
            ->with('question')
            ->where('student_id', auth()->id())
            ->whereNull('given_answer')
            ->get();

        if ($unanswered_question->count() == 0) {
            $message = "You have answered all the question. Please check result after finishing the exam";
            return view('exam.finish', compact('message', 'exam'));
        }
        $finish_url = route('classroom.exam.finish', $exam->id);

        return view('exam.hall', compact('unanswered_question', 'exam', 'finish_url'));
    }

    public function finish(Exam $exam)
    {
        $message = "You have reached the end of exam. Please check result after finishing the exam";
        return view('exam.finish', compact('message', 'exam'));
    }

    public function answerSubmit(Exam $exam)
    {
        if (!$exam->isRunning()) {
            return 0;
        }

        if ($exam->classroom->isStudent())
        {
            $exam_sheet = ExamSheet::find(request()->exam_sheet_id);
            if ($exam_sheet) {
                $given_answer = request()->answer;
                $correct_answers = explode(',', $exam_sheet->correct_answer);
                $is_correct = in_array($given_answer, $correct_answers);
                $mark = $is_correct ? $exam_sheet->question->mark : 0;
                $exam_sheet->update([
                    'given_answer'  => $given_answer,
                    'mark'          => $mark,
                    'is_correct'    => $is_correct
                ]);

                return 1;
            }
        }

        return 0;
    }

    public function result(Exam $exam)
    {
        if (!$exam->isEnded())
        {
            Session::flash('status', 'Exam is not ended yet');
            return redirect()->back();
        }
        if ($exam->classroom->isStudent())
        {
            $exam_sheets = ExamSheet::where('exam_id', $exam->id)
                ->where('student_id', auth()->id())
                ->get();

            return view('exam.student_result', compact('exam_sheets', 'exam'));
        }
        if ($exam->classroom->isTeacher())
        {
            $exam_sheets = ExamSheet::select('student_id',
                    DB::raw('SUM(mark) as mark'),
                    DB::raw('SUM(IF(is_correct = 1, 1, 0)) as correct_answer'),
                    DB::raw('SUM(IF(is_correct = 0, 1, 0)) as incorrect_answer')
                )
                ->with('student')
                ->where('exam_id', $exam->id)
                ->groupBy('student_id')
                ->get();

            return view('exam.class_result', compact('exam_sheets', 'exam'));
        }
    }

    public function resultIndividual(Exam $exam, User $student)
    {
        if (!$exam->isEnded())
        {
            Session::flash('status', 'Exam is not ended yet');
            return redirect()->back();
        }
        if ($exam->classroom->isTeacher()) {
            $exam_sheets = ExamSheet::where('exam_id', $exam->id)
                ->where('student_id', $student->id)
                ->get();

            return view('exam.student_result', compact('exam_sheets', 'exam'));
        }

        Session::flash('status', 'You are not allowed');
        return redirect()->back();
    }
}
