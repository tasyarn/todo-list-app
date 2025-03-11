<?php

namespace App\Http\Controllers;

use App\Models\Todolist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $todolists = Todolist::where('user_id', Auth::id())->get();

        return view('dashboard', compact('todolists'));
    }

    public function indexAPI()
{
    $todolists = Todolist::where('user_id', Auth::id())->get();

    return response()->json([
        'status' => true,
        'message' => 'Data ditemukan',
        'todolist' => $todolists
    ]);
}

}
