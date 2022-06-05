<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::put('/retrieveAuthToken', [AuthController::class, 'retrieveAuthToken']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    //projects
    Route::post('/projects/create', [ProjectController::class, 'createProject']);
    Route::get('/projects', [ProjectController::class, 'getProjects']);
    Route::get('/projects/{projectId}', [ProjectController::class, 'getProject']);

    //todos
    Route::post('/projects/{projectId}/todos/create', [TodoController::class, 'createTodo']);
    Route::get('/projects/{projectId}/todos', [TodoController::class, 'getAll']);
    Route::get('/projects/{projectId}/todos/{todoId}', [TodoController::class, 'viewTodo']);
    Route::post('/projects/{projectId}/todos/{todoId}/delete', [TodoController::class, 'deleteTodo']);
    Route::post('/projects/{projectId}/todos/{todoId}/finish', [TodoController::class, 'finishTodo']);
});
