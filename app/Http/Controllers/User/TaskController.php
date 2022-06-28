<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\addTaskFormRequest;
use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::where('id', '!=', Auth::guard('user')->id())->get();
        return view('Task.addNewTask', ['users' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(addTaskFormRequest $request)
    {
        try {
            $task = Task::create([
                'assigned_by' => Auth::guard('user')->user()->id,
                'title' => $request->title,
                'description' => $request->description,
                'due_date' => $request->deadline,
            ]);
            $task->users()->attach($request->emp);
            return redirect()->route('user.Dashboard')->with('success', 'Task Assigned Successfully');
        } catch (\Exception $exception) {
            dd($exception);
            return redirect()->back()->with('error', 'Temporary Server Error.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tasks = Task::with('users')->find($id);
        return view('Task.taskDetails', ['task' => $tasks, 'user' => Auth::guard('user')->user()->id]);
    }

    public function newComment(Request $request)
    {
        try {
            if (!Auth::guard('user')->user()) {
                return back();
            }
            Comment::create([
                'user_id' => $request->userId,
                'task_id' => $request->taskId,
                'comment' => $request->comment,
            ]);
            return redirect()->back()->with('success', 'Comment Added');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Temporary Server Error.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
