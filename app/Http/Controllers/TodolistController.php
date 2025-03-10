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

    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|string|max:255',
        ]);

        Todolist::create([
            'task' => $request->task,
            'is_completed' => $request->has('is_completed') ? 1 : 0,
            'user_id' => auth()->id(), // Simpan user_id dari user yang login
        ]);

        return redirect()->back()->with('success', 'Task created successfully!');
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

        // Ambil data yang dikirim
        $data = $request->only('task', 'is_completed');

        // Jika `is_completed` tidak ada di request, berarti nilainya harus diatur ulang ke `0`
        if (!$request->has('is_completed')) {
            $data['is_completed'] = 0;
        }

        $todo->update($data);

        return redirect()->back()->with('success', 'Task updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $todo = Todolist::findOrFail($id);

        $todo->delete();

        return redirect()->back()->with('success', 'Task deleted successfully!');
    }
}
