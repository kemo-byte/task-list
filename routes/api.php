<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Task;
use App\Http\Requests\TaskRequest;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tasks', function() {
    $task = Task::paginate(10);
    if ($task->isEmpty()) {
        return response()->json(['message' => 'There are no tasks!'], 404);
    }
    return response()->json($task, 200);
})->name('tasks.index');

Route::post('/tasks', function(TaskRequest $request) {
    $task = Task::create($request->validated());
    return response()->json($task, 201);
})->name('tasks.store');

Route::put('/tasks/{task}', function(Task $task, TaskRequest $request) {
    $task->update($request->validated());
    return response()->json($task);
})->name('tasks.update');

Route::delete('/tasks/{task}', function(Task $task) {
    $task->delete();
    return response()->json(null, 204);
})->name('tasks.destroy');

Route::put('/tasks/{task}/toggle-complete', function(Task $task) {
    $task->toggleComplete();
    return response()->json($task);
})->name('tasks.toggle-complete');
