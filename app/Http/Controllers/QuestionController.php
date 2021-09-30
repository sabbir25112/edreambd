<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QuestionController extends Controller
{
    public function index(Exam $exam)
    {
        if ($exam->classroom->isTeacher())
        {
            $questions = $exam->questions()->paginate(10);
            return view('exam.question.index', compact('exam', 'questions'));
        }
        Session::flash('status', 'You are not allowed');
        return redirect()->back();
    }

    public function create(Exam $exam)
    {
        return view('exam.question.create', compact('exam'));
    }

    public function store(Exam $exam, Request $request)
    {
        if ($exam->classroom->isTeacher())
        {
            $question_data = $request->except(['answer']);
            $question_data += [
                'answer'    => implode(',', $request->answer),
                'exam_id'   => $exam->id,
            ];
            Question::create($question_data);

            Session::flash('status', 'Question Added Successfully');
            return redirect()->route('classroom.exam.question', $exam->id);
        }
        Session::flash('status', 'You are not allowed');
        return redirect()->back();
    }

    public function edit(Exam $exam, Question $question)
    {
        return view('exam.question.edit', compact('exam', 'question'));
    }

    public function update(Exam $exam, Question $question, Request $request)
    {
        if ($exam->classroom->isTeacher())
        {
            $question_data = $request->except(['answer']);
            $question_data += [
                'answer'    => implode(',', $request->answer),
                'exam_id'   => $exam->id,
            ];
            $question->update($question_data);

            Session::flash('status', 'Question Updated Successfully');
            return redirect()->route('classroom.exam.question', $exam->id);
        }
        Session::flash('status', 'You are not allowed');
        return redirect()->back();
    }
}
