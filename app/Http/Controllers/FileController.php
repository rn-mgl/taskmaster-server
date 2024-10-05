<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class FileController extends Controller
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
        // logger($request->hasFile("file") ? 1 : 2);
        // $request->validate([
        //     "file" => ["file", "required"]
        // ]);

        try {
            $file_url = cloudinary()->upload($request->file("file")->getRealPath(),[
                "folder" => "taskmaster-uploads"
            ])->getSecurePath();

            return response()->json(["url" => $file_url]);
        } catch (\Throwable $th) {
            throw new Exception("Error in uploading file. " . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
