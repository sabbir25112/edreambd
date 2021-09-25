<?php namespace App\Http\Controllers;

use App\Classroom;
use App\Resource;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function classroom($classroom_id)
    {
        $classroom = Classroom::with('resource')->find($classroom_id);
        return view('resource.classroom', compact('classroom'));
    }

    public function add($classroom_id)
    {
        $classroom = Classroom::find($classroom_id);
        return view('resource.add', compact('classroom'));
    }

    public function store(Request $request, $classroom_id)
    {
        $this->validate($request, [
            'name'  => 'required',
            'type'  => 'required',
        ]);


        $file = request()->file('file');
        if ($file) {
            $location = $file->store('uploads', ['disk' => 'public']);
        } else {
            $location = null;
        }


        $data = [
            'name'          => $request->name,
            'description'   => $request->description,
            'type'          => $request->type,
            'location'      => $location,
            'url'           => $request->get('url'),
            'classroom_id'  => $classroom_id
        ];

        Resource::create($data);

        return redirect()->route('classroom.resource', $classroom_id);
    }
}
