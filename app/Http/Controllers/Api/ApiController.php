<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    //register
    public function register(Request $request){
        $request->validate([
            "name" => "required|string",
            "email" => "required|email|unique:users,email",
            "password" => "required"

        ]);

        // Buat user dengan role default "admin"
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "userRole" => "user" // Set default userRole sebagai "admin"
        ]);

        return response()->json([
            "status" => true,
            "message" => "User registered successfully",
            "data" => $user
        ]);
    }

    //login
    public function login(Request $request){
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        // Cari user berdasarkan email
        $user = User::where("email", $request->email)->first();

        // Jika user tidak ditemukan
        if (!$user) {
            return response()->json([
                "status" => false,
                "message" => "Email tidak terdaftar",
            ], 404);
        }

        // Cek apakah user adalah admin
        if ($user->userRole !== "admin") {
            return response()->json([
                "status" => false,
                "message" => "Akses ditolak. Anda bukan admin.",
            ], 403);
        }

        // Cek password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                "status" => false,
                "message" => "Password salah",
            ], 401);
        }

        // Buat JWT Token
        $token = JWTAuth::fromUser($user);

        return response()->json([
            "status" => true,
            "message" => "Admin logged in successfully",
            "token" => $token
        ]);
    }

    //logout
    public function logout(){

    }
}
