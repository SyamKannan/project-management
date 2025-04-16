<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index()
    {
        $project = Project::with('tasks')->where('user_id',Auth::user()->id)->get();
        return response()->json(['message' => 'Projects fetched successfully', 'project' => $project],200);
    }

    public function store(Request $request)
    {
     
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required',
        ]);
      
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $userId = Auth::user()->id;
        $project = Project::create([
            'user_id' => $userId,
            'title' => $request->title,
            'description' => $request->description,

        ]);

        return response()->json(['message' => 'Project created successfully', 'project' => $project],200);
    }

    public function show($id)
    {
        $project = Project::where('id',$id)->first();

        if(!$project){
            return response()->json(['error' => 'Projevt not found'], 400);
        }

        return response()->json(['message' => 'Project fetched', 'project' => $project],200);
    }

    public function update(Request $request, $id)
    {
        $project = Project::where('id',$id)->first();

        if(!$project){
            return response()->json(['error' => 'Projevt not found'], 400);
        }

         $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required',
        ]);
      
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $project->update(['title' => $request->title, 'description' => $request->description ]);

        return response()->json(['message' => 'Project updated', 'project' => $project],200);
    }

    public function destroy($id)
    {
        $project = Project::where('id',$id)->first();

        if(!$project){
            return response()->json(['error' => 'Projevt not found'], 400);
        }
        $project->delete();

        return response()->json(['message' => 'Project deleted'],200);
    }
}
