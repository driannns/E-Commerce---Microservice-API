<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $credentials = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ];

        $validators = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ];

        $validation = Validator::make($credentials, $validators);

        if ($validation->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validasi gagal.',
                'errors' => $validation->errors(),
            ], 422);
        }

        $credentials['password'] = bcrypt($credentials['password']);

        $user = User::create($credentials);

        return response()->json([
            'status' => 201,
            'message' => 'Registrasi berhasil. Silahkan login',
        ], 201);
    }

    public function login(Request $request)
    {
        if (!$request->email || !$request->password) {
            return response()->json([
                'status' => 401,
                'error' => [
                    'code' => 'missing_required_credentials',
                    'message' => 'Email dan password dibutuhkan untuk login.'
                ]
            ], 401);
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $user = auth()->user();

            Session::put('user_id', $user->id);
            return response()->json([
                'status' => 200,
                'message' => 'Login berhasil.',
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'registered_at' => $user->created_at->format('d F Y, h:i A'),
                ]
            ], 200);
        };
        return response()->json([
            'status' => 401,
            'error' => [
                'code' => 'invalid_credentials',
                'message' => 'Email atau password salah.'
            ]
        ], 401);
    }
}
