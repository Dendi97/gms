<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{

    public function createProject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'bail|required|string|unique:projects,name'
        ]);

        if ($validator->fails()) {
            return response([
                'error' => 'Invalid project name'
            ]);
        }

        $user = Auth::user();

        $user->projects()->create([
            'name' => $request->input('name')
        ]);

        return response([
           'projects' => $user->projects
        ]);
    }

    public function getProjects()
    {
        return [
            'user' => Auth::user()->email,
            'projects' => Auth::user()->projects()->with('todos')->get()
        ];
    }


    public function getProject(int $projectId)
    {
        if ($project = Project::find($projectId)) {
            return [
                'user' => Auth::user()->email,
                'projects' => $project->with('todos')->get()
            ];
        }

        return response([
            'error' => 'Invalid project id'
        ]);
    }
}
