<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\QueryException as DatabaseQueryException;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $credentials['email'])->first();


        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response([
                'message' => 'Login Failed'
            ], 401);
        } else {
            $token = $user->createToken('myapptoken')->plainTextToken;
            return response([
                'message' => 'Login Successfull',
                'token' => $token
            ], 200);
        }
    }

    public function regis(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => ['required', 'unique:users,id_user'],
            'username' => ['required', 'max:255', 'unique:users,username'],
            'password' => ['required', 'min:5', 'max:255'],
            'email' => ['required', 'email'],
            'name' => ['required', 'min:3', 'max:255'],
            'role' => ['required', 'in:user,admin']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        };

        $request['password'] = bcrypt($request['password']);
        $input = $request->all();

        try {
            $user = User::create($input);
            $response = [
                'message' => 'Registered Succesful',
                'data' => $user
            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (DatabaseQueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo
            ]);
        }
    }

    public function logout(Request $request)
    {
        // $user = User::where('email', $credentials['email'])->first();
        // $request->user()->currentAccessToken()->delete();

        // $user->tokens()->where('id', $tokenId)->delete();

        $response = [
            'message' => 'Logout Successfull'
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}
