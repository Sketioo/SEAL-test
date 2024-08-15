<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::paginate(10);

        return response()->json([
            'status' => 'success',
            'message' => 'Data tugas ditemukan',
            'data' => $tasks->items(),
            'pagination' => [
                'current_page' => $tasks->currentPage(),
                'total_pages' => $tasks->lastPage(),
                'total_items' => $tasks->total(),
                'per_page' => $tasks->perPage(),
            ],
        ]);
    }

    public function store(StoreTaskRequest $request)
    {
        $task = Task::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Tugas berhasil dibuat',
        ]);
    }

    public function show(Task $task)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Data tugas ditemukan',
            'data' => $task, 
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Tugas berhasil diperbarui',
        ]);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Tugas berhasil dihapus',
        ]);
    }
}
