<?php

namespace App\Http\Controllers;

use App\Models\student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(student $model)
    {
        return Inertia::render('StudentsDashboard', [
            'studentsData' => $model->all(),
            'count' => $model->count(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, student $model)
    {
        $model->create($request->validate([
            'first_name' => 'required|max:255|min:2',
            'last_name' => 'required|max:255|min:2',
            'department' => 'required|max:255|min:2',
            'email' => 'required|email|max:255|unique:students,email',
        ]));
        return back()->with('message', 'student added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, student $model, $student_id)
    {
        // You need this for encountering Log the incoming request data
        // And you can view this logs at storage/logs/laravel.log
        Log::info('Update request received for student ID: ' . $student_id);
        Log::info('Update request data: ', $request->all());

        $validatedData = $request->validate( // Validate the incoming request data
            [
                'first_name' => 'required|max:255|min:2',
                'last_name' => 'required|max:255|min:2',
                'department' => 'required|max:255|min:2',
                'email' => 'required|email|max:255',
            ],
            [
                'email.unique' => 'The email has already been taken.', // Custom error message for unique rule
            ]
        );

        $student = $model->findOrFail($student_id);

        $student->update($validatedData);

        return back()->with('message', 'Student updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(student $model, $student_id)
    {
        $student = $model->findOrFail($student_id);

        $student->delete();

        // You can also use redirect()->route('your_directory')
        return back()->with('message', 'Student deleted successfully');
    }
}
