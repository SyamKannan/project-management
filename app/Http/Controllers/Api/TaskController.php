<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index($projectId)
    {
        $project = Project::with('tasks')->where('id', $projectId)->where('user_id', Auth::user()->id)->firstOrFail();
        return response()->json($project->tasks);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'status' => 'required|in:todo,in_Progress,Completed',
           'project_id' => 'required|exists:projects,id'

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $project = Project::where('id', $request->project_id)->where('user_id', Auth::user()->id)->first();

        if (!$project) {
            return response()->json(['error' => 'Project not found'], 400);
        }

        $task = new Task();
        $task->project_id = $project->id;
        $task->title = $request->title;
        $task->status = $request->status;
        $task->save();

        return response()->json(['message' => 'Task created', 'task' => $task]);
    }

    public function update(Request $request, $id)
    { 
        $task = Task::find($id);

        if(!$task){
            return response()->json(['error' => 'Task not found'], 400);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'status' => 'required|in:todo,in_Progress,Completed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $task->update($request->only('title', 'status'));

        return response()->json(['message' => 'Task updated', 'task' => $task]);
    }

    public function destroy($id)
    {
        $task = Task::find($id);

        if(!$task){
            return response()->json(['error' => 'Task not found'], 400);
        }
        $task->delete();

        return response()->json(['message' => 'Task deleted']);
    }
}
