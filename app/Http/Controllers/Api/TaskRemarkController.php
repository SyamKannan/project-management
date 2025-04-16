<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskRemark;
use Illuminate\Support\Facades\Validator;

class TaskRemarkController extends Controller
{
    public function index($taskId)
    {
        $task = Task::with('remark')->find($taskId);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 400);
        }

        return response()->json(['message' => 'Task with remark fetched successfully', 'project' =>  $task],200);
    }

    public function store(Request $request, $taskId)
    {
       
        $validator = Validator::make($request->all(), [
            'remark' => 'required|string',
            'date' => 'required|date',
        ]);
      
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
       

        $task = Task::find($taskId);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 400);
        }
        $remark = TaskRemark::create([
            'task_id' => $taskId,
            'remark' => $request->remark,
            'date' => $request->date,
        ]);

        return response()->json(['message' => 'Remark added', 'remark' => $remark]);
    }
}

