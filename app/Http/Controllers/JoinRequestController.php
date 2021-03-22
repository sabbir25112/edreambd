<?php namespace App\Http\Controllers;

use App\JoinRequest;
use Illuminate\Http\Request;

class JoinRequestController extends Controller
{
    public function index()
    {
        $join_requests = JoinRequest::where('student_id', auth()->user()->id)
            ->with('classroom')
            ->paginate(config('app.DEFAULT_PAGINATION'));

        return view('join_request.index', compact('join_requests'));
    }

    public function received()
    {
        $join_requests = JoinRequest::whereHas('classroom', function ($query) {
                return $query->where('teacher_id', auth()->user()->id);
            })
            ->with('classroom')
            ->paginate(config('app.DEFAULT_PAGINATION'));
        return view('join_request.index', compact('join_requests'));
    }
}
