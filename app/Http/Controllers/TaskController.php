<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'deadline' => ['required', 'date'],
            'status' => ['required', 'integer'],
            'priority' => ['required', 'integer'],
        ]);

        $attributes['deadline'] = Carbon::parse($attributes['deadline'])->format("Y-m-d H:i:s");

        $db = DB::insert("INSERT INTO tasks (title, description, deadline, status, priority, project_id) values(?, ?, ?, ?, ?, ?)", [
            $attributes['title'],
            $attributes['description'],
            $attributes['deadline'],
            $attributes['status'],
            $attributes['priority'],
            1

        ]);

        return response()->json(['test' => $db]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
