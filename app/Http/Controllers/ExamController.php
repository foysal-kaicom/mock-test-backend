<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamListFilterRequest;
use App\Http\Requests\ExamRequest;
use App\Models\Exam;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ExamController extends Controller
{
    public function list(ExamListFilterRequest $request)
    {
        $orderBy = $request->order_by ?? 'id';
        $direction = $request->direction ?? 'asc';

        $query = Exam::with('creator:id,name')
            ->select('id', 'title', 'exam_date', 'application_deadline', 'result_publish_date', 'fee', 'created_by', 'status');
        
        if ($request->has('title') && $request->title != '') {
            $query->where('title', 'like', '%'. $request->title . '%');
        }

        $query->orderBy($orderBy, $direction);
    
        if ($request->has('date_filter') && $request->date_filter != '' && $request->has('from_date') && $request->from_date != '' && $request->has('to_date') && $request->to_date) {
            $query->whereBetween($request->date_filter, [$request->from_date, $request->to_date]);
        }
    
        $exams = $query->paginate(10)->appends($request->all());

        return view('exam.list', compact('exams'));
    }
    

    public function showCreateExam()
    {
        return view('exam.create');
    }

    public function store(ExamRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('exam_images'), $imageName);
            $data['image'] = 'exam_images/' . $imageName;
        }

        $data['created_by'] = Auth::id();
        $data['slug'] = rand(1,99999).'-'.Str::of($data['title'])->slug('-');

        Exam::create($data);

        Toastr::success('Exam Registered Successfully.');
        return redirect()->route('exam.list');
    }

    public function edit(Request $request, string $id)
    {
        $exam = Exam::findOrFail($id);
        $isCopy = $request->query('isCopy', false); 
        return view('exam.edit', compact('exam', 'isCopy'));
    }

    public function update(ExamRequest $request, $id)
    {
        $exam = Exam::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($exam->photo && file_exists(public_path($exam->photo))) {
                unlink(public_path($exam->photo));
            }
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('exam_images'), $imageName);
            $data['image'] = 'exam_images/' . $imageName;
        }

        $data['slug'] = Str::of($data['title'])->slug('-');

        $exam->update($data);

        Toastr::success('Exam Updated Successfully.');
        return redirect()->route('exam.list');
    }

    public function toggleStatus($id)
    {
        try {
            $exam = Exam::findOrFail($id);
    
            if ($exam->status) {
                $exam->status = false;
                $exam->save();
            } else {
                $exam->status = true;
                $exam->save();
            }
            Toastr::success('Status changed successfully.');
            return redirect()->route('exam.list');
        } catch (\Exception $e) {
            Toastr::success('Status not changed');
            return redirect()->route('exam.list');
        }
    }
}
