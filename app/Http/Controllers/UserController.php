<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function register(StoreUserRequest $request)
    {
        $validate=$request->validated();
        if(!$validate)
        {
            return response()->json([
                'data'=>'',
                'message' => 'Error occured while validate data',
                'status' => 401,
            ]);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role'=>$request->role,
        ]);
        if ($user)
        {
            $token = $user->createToken('API TOKEN')->plainTextToken;
            $user->token = $token;
            return response()->json([
                'id'=>$user->id,
                'message'=>'successful',
                'status' => 200,
                'userToken'=>$user->token,
            ]);
        }
        auth()->login($user);
        return response()->json([
            'data'=>'',
            'message'=>'Error occured while trying to create new account',
            'status' => 400,
        ]);
    }
    public function login(Request $request)
    {
        $attribute=$request->validate([
            'email'=>'required|email',
            'password'=>['required']
        ]);
        if(Auth()->attempt($attribute)){
            $token = request()->user()->createToken('API TOKEN')->plainTextToken;
            $id=request()->user()->id;
            return response()->json([
                'id'=>$id,
                'message'=>'success login',
                'status'=>200,
                'userToken'=>$token
            ]);
        }
        return response()->json([
            'data'=>'',
            'message' => 'Error occured while trying  login to your account',
            'status' => 400
        ]);
    }
    public function logout()
    {
        if (Auth::user()->currentAccessToken()->delete()) {
            return response()->json([
                'data' => '',
                'message' => 'success logout ,Good Bye',
                'status' => 200
            ],200);
        }
        return response()->json([
            'data' => '',
            'message' => 'something is wrong while you trying logout',
            'status' => 400,
        ],400);
    }
    public function index(Request $request)
    {
        // Get the authenticated user
        $authUser = $request->user();

        // Retrieve all users
        $users = User::all();


            // Return all users
            return response()->json($users);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            // Retrieve the validated input data
            $validated = $request->validated();

            // Create a new user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // Return a successful response
            return response()->json(['message' => 'User registered successfully'], 201);
        } catch (\Exception $e) {
            // Return an error response
            return response()->json(['message' => 'Error creating user'], 400);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
