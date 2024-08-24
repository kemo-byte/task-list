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
    $data = $request->validated();
    $task = new TasK;
    $task->title = $data['title'];
    $task->description = $data['description'];
    $task->long_description = $data['long_description'];
    $task->save();

    return redirect()->route('tasks.show',['id' => $task->id])->with('success','Task created successfully!');
})->name('tasks.store');

Route::put('/tasks/{task}', function($task,TaskRequest $request) {
    $data = $request->validated();
    $task->title = $data['title'];
    $task->description = $data['description'];
    $task->long_description = $data['long_description'];
    $task->save();

    return redirect()->route('tasks.show',['id' => $task->id])->with('success','Task updated successfully!');
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