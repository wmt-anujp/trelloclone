@extends('layouts.master')
@section('title')
    Dashboard
@endsection
@section('csrf')
    
@endsection
@section('content')
    <div class="container mb-5">
        <div class="row mt-5">
            <div class="col-md-12">
                <a href="{{route('task.create')}}" class="btn btn-primary mt-5">New Task</a>
            </div>
        </div>
        <div class="row g-2 mt-3 justify-content-start">
            {{-- @foreach ($tasks as $item)
                @foreach ($item->users as $items)
                    {{dd($items)}}
                @endforeach
            @endforeach --}}
            <h3 style="color: green">Tasks List</h3>
            @foreach ($tasks as $task)
                @foreach ($task->users as $tasksuser)
                    @if ($tasksuser->pivot->user_id===Auth::guard('user')->user()->id)
                        <div class="col-12 col-md-2">
                            <a class="btn btn-sm btn-success" href="{{route('task.show',['task'=>$task->id])}}">{{$task->title}}</a>
                        </div>
                    @endif
                @endforeach
            @endforeach
        </div>
    </div>
@endsection