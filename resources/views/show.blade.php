@extends('layouts.app')

@section('title', $task->title)

@section('content')
<div class="mb-4">
  <a href="{{ route('tasks.index') }}"
            class="font-medium text-gray-700 underline decoration-pink-500">
                Go back to the task list!
            </a>
</div>
<p class="mb-4 text-slate-700">
    {{ $task->description }}
</p>

@if ($task->long_description)
    <p>{{  $task->long_description }}</p>
@endif
<p class="mb-4 text-sm text-slate-500">
    {{ $task->created_at->diffForHumans() }} . {{ $task->updated_at->diffForHumans() }}
</p>

<p>
    @if ($task->completed)
<span class="font-medium text-green-500">
    Completed
</span>
        @else
        <span class="font-medium text-red-500">
            Not completed
        </span>
    @endif
</p>


<div class="flex gap-2">
    <a href="{{route('tasks.edit',['task' => $task])}}"
        class="btnrounded-md px-2 py-1 text-center font-medium text-slate-500 shadow-sm ring-1 ring-slate-700/10 hover:bg-gray-50">Edit</a>

    <form action="{{ route('tasks.toggle-complete',['task' => $task]) }}" method="post">
        @csrf
        @method('PUT')
        <button type="submit" class="btn">
            Mark as {{ $task->completed ? 'not completed' : 'completed' }}
        </button>
    </form>

    <form action="{{ route('tasks.destroy', ['task' => $task]) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn">Delete</button>
    </form>
</div>

@endsection