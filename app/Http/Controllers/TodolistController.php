<?php

namespace App\Http\Controllers;

use App\Models\Todolist;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTodolistRequest;
use App\Http\Requests\UpdateTodolistRequest;

class TodolistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $todolists = Todolist::all();
        } else {
            $todolists = Todolist::where('user_id', Auth::id())->get();
        }

        return response()->json($todolists);
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
    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|string|max:255',
            'is_completed' => 'boolean'
        ]);

        $todo = Todolist::create([
            'user_id' => Auth::id(),
            'task' => $request->task,
            'is_completed' => $request->is_completed ?? false
        ]);

        return response()->json(['message' => 'Task created successfully', 'task' => $todo], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $todo = Todolist::findOrFail($id);

        if (Auth::user()->role !== 'admin' && $todo->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($todo);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todolist $todolist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $todo = Todolist::findOrFail($id);

        if (Auth::user()->role !== 'admin' && $todo->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'task' => 'sometimes|string|max:255',
            'is_completed' => 'sometimes|boolean'
        ]);

        $todo->update($request->only('task', 'is_completed'));

        return response()->json(['message' => 'Task updated successfully', 'task' => $todo]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $todo = Todolist::findOrFail($id);

        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $todo->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
