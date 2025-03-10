<?php

namespace App\Http\Controllers;

use App\Models\Todolist;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $todolists = Todolist::with('user')->get();
        return view('admin.index', compact('todolists'));
    }
}
