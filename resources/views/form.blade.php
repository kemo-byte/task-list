@extends('layouts.app')

@section('title', isset($task) ? 'Edit Task' : 'Add Task')

@section('styles')

@endsection

@section('content')
    <form method="POST" action="{{ isset($task) ? route('tasks.update', ['task' => $task->id]) : route('tasks.store') }}">
        @csrf
        @isset($task)
            @method('PUT')
        @endisset
        <div>
            <label for="title" class="block uppercase text-slate-700 mb-2">Title</label>
            <input type="text" name="title" id="title" value="{{ $task->title ?? old('title') }}" class="shadow-sm appearance-none border w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none @error('title') border border-red-500 @enderror "
            @class(['border-red-500' => $errors->has('title')])
            >
            @error('title')
                <p class="text-red-500 text-sm">{{  $message  }}</p>
            @enderror
        </div>

        <div>
            <label for="description">Description</label>
            <textarea name="description" id="description"  rows="5" >{{ $task->description ?? old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm">{{  $message  }}</p>
            @enderror
        </div>
        

        <div>
            <label for="long_description" >Long Description</label>
            <textarea name="long_description" id="long_description"  rows="5" >{{ $task->long_description ?? old('long_description') }}</textarea>
            @error('long_description')
                <p class="text-red-500 text-sm">{{  $message  }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" class="btn">
                @isset($task)
                    Update Task
                @else
                    Add Task
                @endisset
            </button>
            <a href="{{route('tasks.index')  }}" class="font-medium text-gray-700 underline decoration-pink-500 ">Cancel</a>
        </div>
    </form>
@endsection