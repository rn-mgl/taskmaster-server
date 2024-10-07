<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::where("created_by", Auth::id())->with("user")->get();

        return response()->json(["projects" => $projects]);
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
            "title" => ["string", "required"],
            "description" => ["string", "required"],
            "banner_image" => ["string", "nullable"],
            "deadline" => ["date", "required"],
            "status" => ["string", "required"],
        ]);

        $statusMapping = [
            "None" => 0,
            "On Going" => 1,
            "Hold" => 2,
            "Done" => 3
        ];

        $status = (int)$statusMapping[$attributes['status']];

        if (!$status) {
            throw ValidationException::withMessages([
                'status' => 'Invalid Status'
            ]);
        }

        $code = Str::upper(Str::random(6));

        $project_data = [
            "title" => $attributes["title"],
            "description" => $attributes["description"],
            "banner_image" => $attributes["banner_image"],
            "deadline" => $attributes["deadline"],
            "status" => $status,
            "code" => $code,
            "created_by" => Auth::id()
        ];

        try {
            $created_project = Project::create($project_data);

            return response()->json(["success" => $created_project->id ? true : false]);
        } catch (\Throwable $th) {
            throw new \Exception("Error in creating project. " . $th->getMessage());
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
