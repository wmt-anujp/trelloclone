<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\userLoginFormRequest;
use App\Http\Requests\User\userSignupFormRequest;
use App\Models\Task;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    use ApiResponse;

    public function userLogin(userLoginFormRequest $request)
    {
        try {
            $credentials = $request->validated();
            if (Auth::guard('user')->attempt($credentials)) {
                return redirect()->route('user.Dashboard')->with('success', 'Login Successfull');
            } else {
                return redirect()->back()->with('error', 'Please Check Credentials');
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Temporary Server error');
        }
    }

    public function index()
    {
        return view('User.signup');
    }

    public function userDashboard()
    {
        $tasks = Task::where('due_date', '>=', Carbon::now()->toDateString())->with('users')->get();
        return view('User.dashboard', ['tasks' => $tasks]);
    }

    public function store(userSignupFormRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);
            Auth::guard('user')->login($user);
            return redirect()->route('user.Dashboard')->with('success', 'SignUp Successfull');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Temporary Server Error.');
        }
    }

    public function userLogout()
    {
        try {
            Auth::guard('user')->logout();
            return redirect()->route('user.Login');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Temporary Server Error.');
        }
    }
}
