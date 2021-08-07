<?php namespace App\Http\Controllers;

use App\JoinRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class JoinRequestController extends Controller
{
    public function sent()
    {
        $join_requests = JoinRequest::where('student_id', auth()->user()->id)
            ->with('classroom')
            ->paginate(config('app.DEFAULT_PAGINATION'));

        return view('join_request.sent', compact('join_requests'));
    }

    public function received()
    {
        $join_requests = JoinRequest::whereHas('classroom', function ($query) {
                return $query->where('teacher_id', auth()->user()->id);
            })
            ->with('classroom', 'student')
            ->paginate(config('app.DEFAULT_PAGINATION'));
        return view('join_request.received', compact('join_requests'));
    }

    public function accept(JoinRequest $join_request)
    {
        try {
            $join_request->update(['status' => 'ACCEPTED']);
            $classroom = $join_request->classroom;
            $classroom->student()->sync($join_request->student);
            Session::flash('status', 'Join Request is Accepted');
        } catch (\Exception $exception) {
            Session::flash('status', 'Something Went Wrong');
        }
        return redirect()->back();
    }

    public function reject(JoinRequest $join_request)
    {
        try {
            $join_request->update(['status' => 'REJECTED']);
            Session::flash('status', 'Join Request is Rejected');
        } catch (\Exception $exception) {
            Session::flash('status', 'Something Went Wrong');
        }
        return redirect()->back();
    }
}
