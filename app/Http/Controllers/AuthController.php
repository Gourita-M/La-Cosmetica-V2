<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    private function permissionsForRole(string $role): array
    {
        return match ($role) {
            'admin' => [
                'orders.read.all',
                'orders.update.status',
                'products.manage',
                'categories.manage',
                'statistics.read',
            ],
            'employee' => [
                'orders.read.all',
                'orders.update.status',
            ],
            default => [
                'orders.read.own',
                'orders.create',
                'orders.cancel.own',
            ],
        };
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'user' => $user,
            'token' => $token,
            'permissions' => $this->permissionsForRole($user->role),
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        return response()->json([
            'token' => $token,
            'user' => auth()->user(),
            'permissions' => $this->permissionsForRole(auth()->user()->role),
        ]);
    }

    public function index()
    {
        return View('Auth.login');
    }

    public function indexRegister()
    {
        return View('Auth.register');
    }
}
