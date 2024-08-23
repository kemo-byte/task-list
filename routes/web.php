<?php

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
        'tasks' => \App\Models\Task::latest()->get()
    ]);
})->name('tasks.index');

Route::post('/tasks', function(Request $request) {
    $data = $request->validate([
        'title' => 'required|max:255',
        'description' => 'required',
        'long_description' => 'required'
    ]);
    $task = new TasK;
    $task->title = $data['title'];
    $task->description = $data['description'];
    $task->long_description = $data['long_description'];
    $task->save();

    return redirect()->route('tasks.show',['id' => $task->id])->with('success','Task created successfully!');
})->name('tasks.store');

Route::put('/tasks/{id}', function($id,Request $request) {

    $data = $request->validate([
        'title' => 'required|max:255',
        'description' => 'required',
        'long_description' => 'required'
    ]);
    $task = Task::findOrFail($id);
    $task->title = $data['title'];
    $task->description = $data['description'];
    $task->long_description = $data['long_description'];
    $task->save();

    return redirect()->route('tasks.show',['id' => $task->id])->with('success','Task updated successfully!');
})->name('tasks.update');

Route::view('tasks/create','create')->name('tasks.create');

Route::get('/tasks/{id}/edit', function($id){

    return view('edit', ['task'=> \App\Models\Task::findOrFail($id)]);
})->name('tasks.edit');

Route::get('/tasks/{id}', function($id){

    return view('show', ['task'=> \App\Models\Task::findOrFail($id)]);
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