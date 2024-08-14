<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index',[
        'name' => 'kamal'
    ]);
});

Route::get('/hello', function(){
    return "Hello";
})->name('hello');

Route::get('/hello/{name}',function($name){
    return "Hello $name";
});

Route::get('/hallo',function(){
    return redirect()->route('hello');
});

Route::fallback(function(){
    return 'stil got somewhere !';
});