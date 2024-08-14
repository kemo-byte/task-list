@extends('layouts.app')

@section('title','The list of tasks')

@section('content')
        @forelse ($tasks as $task)
            <div>
                <a href="{{ route('tasks.show',['id'=>$task->id]) }}">
                    {{ $task->title }}
                </a>
            </div>
        @empty
            <div>There are tasks!</div>
        @endforelse 
@endsection