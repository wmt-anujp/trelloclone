@extends('layouts.master')
@section('title')
    Dashboard
@endsection
@section('csrf')
    
@endsection
@section('content')
    <div class="container px-5 mb-5">
        <div class="row mt-5">
            <div class="col-md-12">
                <a href="{{route('task.create')}}" class="btn btn-primary mt-5">New Task</a>
            </div>
        </div>
    </div>
    <div class="row g-2 mt-5 justify-content-start">
        {{dd($tasks)}}
        @foreach ($tasks as $task)
            {{-- @if () --}}
                <div class="col-12 col-md-3">
                    <a href=""></a>
                </div>
            {{-- @elseif() --}}
                <div class="col-12 col-md-3">
                    <a href=""></a>
                </div>
            {{-- @endif --}}
        @endforeach
</div>
@endsection