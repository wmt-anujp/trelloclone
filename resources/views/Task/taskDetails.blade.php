@extends('layouts.master')
@section('title')
    Task Details
@endsection
@section('content')
<div class="container mt-5 mb-5">
    <div class="row mt-5">
        <div class="col-md-6 offset-md-3 mt-5">
            <div class="card mb-3 mt-5" style="width: 540px;">
                <h3 class="text-center card-header">Task Details</h3>
                    <div class="row g-0">
                        <div class="col-12 px-4 mt-3">
                            <p><span style="color: green">Title: </span>{{$tasks->title}}</p>
                            <p><span style="color: green">Description: </span>{{$tasks->description}}</p>
                            <p><span style="color: green">Deadline: </span>{{$tasks->due_date}}</p>
                            <p><span style="color: green">Assigned To: </span>
                                @foreach ($tasks->users as $task)
                                    {{-- {{$task->name.","}} --}}
                                    {{implode((array) $task->name,", ")}}
                                @endforeach
                                {{-- @foreach ($task->users as $tasks_key=>$tasks_val)
                                    @php
                                        // $count=count($tasks_val->name);
                                        echo $tasks_val->name;
                                        if ($tasks_key < ($tasks_key.length - 1)) {
                                            echo ', ';
                                        }
                                    @endphp
                                @endforeach --}}
                            </p>
                        </div>
                    </div>
            </div>
            <div>
                <a data-task={{$tasks->id}} data-user={{$user}} class="btn btn-primary mt-2 me-3 commentbtn">Comment</a>
                @if ($tasks->assigned_by===$user)
                    <a href="{{route('task.edit',['task'=>$tasks->id])}}" class="btn btn-success mt-2">Edit</a>
                @endif
            </div>
            <div class="mt-4">
                <h4 style="color: green">All Comments</h4>
                <hr>
                @foreach ($comments as $comment)
                    <div class="test">
                        <p><span style="color: green">Commented By: </span>{{$comment->user->name}}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <p style="margin: 0" id="comment_tag">{{$comment->comment}}</p>
                            @if ($comment->user_id===$user)
                                <a data-task={{$task->id}} data-user={{$user}} data-comment={{$comment->id}} class="btn btn-sm btn-outline-info cmntupbtn">Edit</a>
                            @endif
                        </div>
                        <hr>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
{{-- comment modal starts --}}
<div class="modal fade" tabindex="-1" id="cmntmodal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Comment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="POST" id="cmntform">
                @csrf
                <div class="form-group">
                    <label for="comment">Add Comment</label>
                    <textarea class="form-control" name="comment" placeholder="Enter Comment" id="comment" rows="5"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="modalsave">Add Comment</button>
        </div>
      </div>
    </div>
</div>
{{-- comment modal ends --}}

{{-- comment update starts --}}
<div class="modal fade" tabindex="-1" id="cmntupmodal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Comment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="POST" id="cmntform">
                @csrf
                <div class="form-group">
                    <label for="comment">Update Comment</label>
                    <textarea class="form-control" name="comment" placeholder="Enter Comment" id="updatecomment" rows="5"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="modalsavee">Update Comment</button>
        </div>
      </div>
    </div>
</div>
{{-- comment update ends --}}
@endsection
@section('js')
    <script>
        var token="{{csrf_token()}}";
        var urlComment="{{route('add.Comment')}}";
        var urlUpdateComment="{{route('update.Comment')}}";
    </script>
    <script src="{{URL::to('src/js/commentModal.js')}}"></script>
@endsection