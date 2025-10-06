<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;
use App\Models\MockTestModule;

class MockTestModuleController extends Controller
{
    public function index()
    {
        $modules = MockTestModule::with('exam')->latest()->paginate(10);
        return view('mock-tests.modules.index', compact('modules'));
    }

    public function create()
    {
        $exams = Exam::all();
        return view('mock-tests.modules.create', compact('exams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'nullable|exists:exams,id',
            'slug' => 'required|unique:mock_test_modules,slug',
            'name' => 'required|string',
            'status' => 'required|in:active,disabled',
        ]);

        MockTestModule::create($request->all());
        return redirect()->route('mock-test-modules.index')->with('success', 'Module created successfully.');
    }

    public function edit(MockTestModule $mockTestModule)
    {
        $exams = Exam::all();
        return view('mock-tests.modules.edit', compact('mockTestModule', 'exams'));
    }

    public function update(Request $request, MockTestModule $mockTestModule)
    {
        $request->validate([
            'exam_id' => 'nullable|exists:exams,id',
            'slug' => 'required|unique:mock_test_modules,slug,' . $mockTestModule->id,
            'name' => 'required|string',
            'status' => 'required|in:active,disabled',
        ]);

        $mockTestModule->update($request->all());
        return redirect()->route('mock-test-modules.index')->with('success', 'Module updated successfully.');
    }

    public function destroy(MockTestModule $mockTestModule)
    {
        $mockTestModule->delete();
        return redirect()->route('mock-test-modules.index')->with('success', 'Module deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $module = MockTestModule::findOrFail($id);

        // Toggle status
        $module->status = $module->status === 'active' ? 'disabled' : 'active';
        $module->save();

        return redirect()->back()->with('success', 'Module status updated successfully.');
    }

}
