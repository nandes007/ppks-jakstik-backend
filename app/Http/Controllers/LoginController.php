<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->first();

        if (empty($user) || !Hash::check($password, $user->password)) {
            return response()->json([
                'message' => 'Maaf, email dan password salah!'
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        $token = $user->createToken($user->name.date('YmdHis'));

        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token
        ]);
    }
}
