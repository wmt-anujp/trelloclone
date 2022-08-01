<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ForgotPasswordRequest;
use App\Http\Requests\User\NewPasswordRequest;
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login', 'userLogin', 'forgotPassword', 'verifyOTP', 'setPassword']]);
    // }

    public function login()
    {
        // $user = User::first();
        // $token = auth()->login($user);
        // dd($user);
        $credentials = request(['email', 'password']);
        $anuj = Auth::guard('api')->attempt($credentials);
        dd($anuj);
        if (!$anuj) {
            return response()->json(['error' => 'Please Check Credentials'], 401);
        }
        // return $this->respondWithToken($anuj);
    }

    public function userLogin(userLoginFormRequest $request)
    {
        try {
            if ($some = Auth::guard('api')->attempt($request->only('email', 'password'))) {
                return response()->json([
                    "meta" => $this->customResponse('success', 'Login Successful', '200'),
                    "data" => $this->respondWithToken($some)
                ]);
                // return redirect()->route('user.Dashboard')->with('success', 'Login Successfull');
            } else {
                // return redirect()->back()->with('error', 'Please Check Credentials');
                return response()->json([
                    "meta" => $this->customResponse("ERROR", "Please check credentials", "401")
                ]);
            }
        } catch (\Exception $exception) {
            dd($exception);
            return redirect()->back()->with('error', 'Temporary Server error');
        }
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout(true);
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        $newToken = auth()->refresh();
        return $this->respondWithToken(auth()->refresh());
        $newToken = auth()->refresh(true, true);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $email = $request->validated();
        try {
            $user = User::where('email', $email['email'])->first();
            if (!isset($user)) {
                return response()->json([
                    "meta" => $this->customResponse("ERROR", "Please Enter Registered email address", "401")
                ]);
            }
            $digits = 4;
            $otp = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $currentDateTime = Carbon::now()->addMinutes(5)->format('Y-m-d H:i:m');
            $user->update([
                'otp' => $otp,
                'otp_created_at' => $currentDateTime
            ]);
            return response()->json([
                'meta' => $this->customResponse("OK", "OTP has been sent on entered email address", "200")
            ]);
        } catch (\Exception $exception) {
            dd($exception);
            return response()->json([
                "meta" => $this->customResponse("ERROR", "Something went wrong", "401")
            ]);
        }
    }

    public function verifyOTP(Request $request)
    {
        try {
            $storedOTP = User::where('email', $request->email)->first();
            $enteredOTP = $request->otp;
            if ($storedOTP->otp_created_at < Carbon::now()->format('Y-m-d H:i:m')) {
                $this->setMeta("status", "ERROR");
                $this->setMeta("message", __('message.OTPExpired'));
                $this->setMeta('code', Response::HTTP_BAD_REQUEST);
                return $this->setResponse();
            } elseif ($storedOTP->otp == $enteredOTP) {
                return response()->json([
                    "meta" => $this->customResponse('success', 'OTP Verification Successful', '200')
                ]);
            } else {
                return response()->json([
                    "meta" => $this->customResponse('error', 'Please Enter correct OTP', '401')
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                "meta" => $this->customResponse('error', 'Something went wrong', '401')
            ]);
        }
    }

    public function setPassword(NewPasswordRequest $request)
    {
        try {
            $validated = $request->validated();
            $user = User::where('email', $validated['email'])->first();
            if (isset($user)) {
                $user->update([
                    'password' => Hash::make($validated['password']),
                ]);
                $this->setMeta('status', "OK");
                $this->setMeta('message', __('message.setPassword'));
                $this->setMeta('code', Response::HTTP_OK);
                return $this->setResponse();
            } else {
                $this->setMeta('status', "ERROR");
                $this->setMeta('message', __('message.userUnauthorized'));
                $this->setMeta('code', Response::HTTP_UNAUTHORIZED);
                return $this->setResponse();
            }
        } catch (\Exception $exception) {
            $this->setMeta('status', "ERROR");
            $this->setMeta('message', __('message.serviceUnavailableError'));
            $this->setMeta('code', Response::HTTP_SERVICE_UNAVAILABLE);
            return $this->setResponse();
        }
    }

    public function jobCompletion()
    {
        $jobCompletionData = [
            "associate1" => [
                "id" => '1',
                "name" => 'Anuj Panchal',
                "inprogress" => "02",
                "completed" => "04",
                "manual_completion" => "01",
                "automatic_completion" => "03"
            ],
            "associate2" => [
                "id" => '2',
                "name" => 'Umang Panchal',
                "inprogress" => "10",
                "completed" => "04",
                "manual_completion" => "01",
                "automatic_completion" => "03"
            ],
        ];
        $inProgressData = collect($jobCompletionData)->pluck('inprogress')->sum();
        $completedData = collect($jobCompletionData)->pluck('completed')->sum();
        $manualCompletion = collect($jobCompletionData)->pluck('manual_completion')->sum();
        $automaticCompletion = collect($jobCompletionData)->pluck('automatic_completion')->sum();
        $this->setMeta("status", "OK");
        $this->setMeta("message", __('message.dataGen'));
        $this->setMeta("code", Response::HTTP_OK);
        $this->setData('inprogress', $inProgressData);
        $this->setData('completed', $completedData);
        $this->setData('manual_completion', $manualCompletion);
        $this->setData('automatic_completion', $automaticCompletion);
        return $this->setResponse();
    }

    public function violationReported()
    {
        $violationReportedData = [
            'against_associates' => [
                "associate1" => [
                    "id" => "1",
                    "name" => "Anuj Panchal",
                    "reports" => "02"
                ],
                "associate2" => [
                    "id" => "2",
                    "name" => "Umang Panchal",
                    "reports" => "01"
                ],
                "associate3" => [
                    "id" => "3",
                    "name" => "Praful shah",
                    "reports" => "01"
                ],
            ],
            'against_residents' => [
                'resident1' => [
                    'id' => '1',
                    'name' => 'Dhiraj patel',
                    'reports' => '01'
                ],
                'resident2' => [
                    'id' => '2',
                    'name' => 'abc patel',
                    'reports' => '01'
                ],
            ],
        ];
        $againstassociates = collect($violationReportedData['against_associates'])->pluck('reports')->sum();
        $againstresidents = collect($violationReportedData['against_residents'])->pluck('reports')->sum();
        $this->setMeta('status', "OK");
        $this->setMeta('message', __('message.dataGen'));
        $this->setMeta('code', Response::HTTP_OK);
        $this->setData('against_associates', $againstassociates);
        $this->setData('against_residents', $againstresidents);
        return response($this->setResponse());
    }

    public function associateDetail()
    {
        $associateDetails = [
            'associate1' => [
                "id" => 1,
                "manager_id" => 1,
                "name" => "Anuj Panchal",
                "check_in_status" => 0, // 0 = clock out
                "profile_photo" => '/home/anuj/Pictures/user3.jpg'
            ],
            'associate2' => [
                "id" => 2,
                "manager_id" => 1,
                "name" => "Umang Panchal",
                "check_in_status" => 1, // 1 = clock in
                "profile_photo" => '/home/anuj/Pictures/user1.jpg'
            ],
            'associate3' => [
                "id" => 3,
                "manager_id" => 1,
                "name" => "Praful Shah",
                "check_in_status" => 0,
                "profile_photo" => '/home/anuj/Pictures/user2.jpg'
            ],
            'associate4' => [
                "id" => 4,
                "manager_id" => 1,
                "name" => "Raj Choksi",
                "check_in_status" => 1,
                "profile_photo" => '/home/anuj/Pictures/images.png'
            ],
        ];
        $associateDetails = collect($associateDetails);
        $this->setMeta("status", "OK");
        $this->setMeta("message", __('message.dataGen'));
        $this->setMeta("code", Response::HTTP_OK);
        $this->setData("associatesDetails", $associateDetails);
        return $this->setResponse();
    }

    public function index()
    {
        return view('User.signup');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function userDashboard()
    {
        $tasks = Task::where('due_date', '>=', Carbon::now()->toDateString())->with('users')->get();
        return view('User.dashboard', ['tasks' => $tasks]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(userSignupFormRequest $request)
    {
        try {
            $validatedData = $request->validated();
            dd($validatedData);
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);
            return response()->json(['success' => 'User Registration Successfull'], 200);
            // Auth::guard('user')->login($user);
            // return redirect()->route('user.Dashboard')->with('success', 'SignUp Successfull');
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
