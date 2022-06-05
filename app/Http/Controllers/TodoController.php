<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{

    public function createTodo(Request $request)
    {
        if (!$project = Project::find($request->route('projectId'))) {
            return response([
                'error' => 'Invalid project id'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'description' => 'bail|required|string'
        ]);

        if ($validator->fails()) {
            return response([
                'error' => 'Invalid description'
            ]);
        }

        $todo = $project->todos()->create([
            'user_id' => Auth::id(),
            'description' => $request->input('description')
        ]);

        return response([
            'todo' => $todo
        ]);
    }

    public function viewTodo(Request $request)
    {
        $projectId = $request->route('projectId');
        $todoId = $request->route('todoId');

        if (!Project::find($projectId)) {
            return response([
                'error' => 'Invalid project id'
            ]);
        }

        if ($todo = Todo::find($todoId)) {
            $todo->update([
               'views' => $todo->views += 1
            ]);

            return response([
                'todo' => $todo
            ]);
        }

        return response([
            'error' => 'Invalid todo id'
        ]);
    }

    public function deleteTodo(Request $request)
    {
        $projectId = $request->route('projectId');
        $todoId = $request->route('todoId');

        if (!Project::find($projectId)) {
            return response([
                'error' => 'Invalid project id'
            ]);
        }

        if ($todo = Todo::find($todoId)) {
            $todo->delete();
            return response([
                'Deleted todo' => $todo
            ]);
        }

        return response([
            'error' => 'Invalid todo id'
        ]);
    }

    public function finishTodo(Request $request)
    {
        $projectId = $request->route('projectId');
        $todoId = $request->route('todoId');

        if (!Project::find($projectId)) {
            return response([
                'error' => 'Invalid project id'
            ]);
        }
        if ($todo = Todo::find($todoId)) {
            $todo->update([
               'state' => 'Done'
            ]);
            return response([
                'Deleted todo' => $todo
            ]);
        }

        return response([
            'error' => 'Invalid todo id'
        ]);
    }

    public function getAll(Request $request)
    {
        $projectId = $request->route('projectId');

        if ($project = Project::find($projectId)) {
            return response([
                'todos' => $project->todos
            ]);
        }

        return response([
            'error' => 'Invalid project id'
        ]);
    }
}
