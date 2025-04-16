<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectReportController extends Controller
{
    public function show($projectId)
    { 
        $project = Project::with(['tasks.remark'])
            ->where('id', $projectId)
            ->where('user_id', Auth::user()->id)
            ->firstOrFail();

            return response()->json(['message' => 'Project report fetched successfully', 'project' =>  $project],200);
        
    }
}
