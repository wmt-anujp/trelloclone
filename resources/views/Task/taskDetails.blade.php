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
                            <p><span style="color: green">Title: </span>{{$task->title}}</p>
                            <p><span style="color: green">Description: </span>{{$task->description}}</p>
                            <p><span style="color: green">Deadline: </span>{{$task->due_date}}</p>
                            <p><span style="color: green">Assigned To: </span>
                                @foreach ($task->users as $tasks){{$tasks->name.", "}}@endforeach
                            </p>
                        </div>
                    </div>
            </div>
            <div>
                <a href="" class="btn btn-primary mt-2 commentbtn">Comment</a>
            </div>
            <div class="mt-4">
                <h4 style="color: green">All Comments</h4>
                <hr>
                {{-- @foreach ($comments as $comment)
                    <p><span style="color: green">Commented By: </span>{{$comment->user->name}}</p>
                    <p>{{$comment->comment}}</p>
                    <hr>
                @endforeach --}}
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
@endsection
@section('js')
    <script>
        var token="{{csrf_token()}}";
        var urlComment="{{route('')}}";
    </script>
    <script src="{{URL::to('src/js/commentModal.js')}}"></script>
@endsection