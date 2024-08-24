<?php

use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\Task;



Route::get('/', function() {
    return redirect()->route('tasks.index');
});

Route::get('/tasks', function (){
    return view('index',[
        'tasks' => Task::get()
    ]);
})->name('tasks.index');

Route::post('/tasks', function(TaskRequest $request) {

    $task = Task::create($request->validated());

    return redirect()->route('tasks.show',['task' => $task->id])->with('success','Task created successfully!');
})->name('tasks.store');

Route::put('/tasks/{task}', function(Task $task,TaskRequest $request) {
    
    $task->update($request->validated());
    return redirect()->route('tasks.show',['task' => $task->id])->with('success','Task updated successfully!');
})->name('tasks.update');

Route::view('tasks/create','create')->name('tasks.create');

Route::get('/tasks/{task}/edit', function(Task $task){

    return view('edit', ['task'=> $task]);
})->name('tasks.edit');

Route::get('/tasks/{task}', function(Task $task){

    return view('show', ['task'=> $task]);
})->name('tasks.show');



// Route::get('/hello', function(){
//     return "Hello";
// })->name('hello');

// Route::get('/hello/{name}',function($name){
//     return "Hello $name";
// });

// Route::get('/hallo',function(){
//     return redirect()->route('hello');
// });

Route::fallback(function(){
    return 'stil got somewhere !';
});

Route::get('test',function(){
    return DB::table('users')->get();
});