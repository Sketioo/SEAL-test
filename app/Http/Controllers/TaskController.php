<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Task;
use App\Services\TaskService;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        try {
            $tasks = $this->taskService->getAllTasks();

            return response()->json([
                'status' => 'success',
                'message' => 'Data tugas ditemukan',
                'data' => $tasks->items(),
                'total' => $tasks->total(),
                'pagination' => [
                    'current_page' => $tasks->currentPage(),
                    'total_pages' => $tasks->lastPage(),
                    'total_items' => $tasks->total(),
                    'per_page' => $tasks->perPage(),
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => [],
            ], 500);
        }
    }

    public function store(StoreTaskRequest $request)
    {
        try {
            $this->taskService->createTask($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Tugas berhasil dibuat',
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => [],
            ], 400);
        }
    }

    public function show($id)
    {
        try {
            $task = $this->taskService->getTaskById($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Data tugas ditemukan',
                'data' => $task,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => [],
            ], 404);
        }
    }

    public function update(UpdateTaskRequest $request, $id)
    {
        try {
            $task = $this->taskService->getTaskById($id);

            $this->authorize('update', $task);

            $this->taskService->updateTask($task, $request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Tugas berhasil diperbarui',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => [],
            ], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $task = $this->taskService->getTaskById($id);

            $this->authorize('delete', $task);

            $this->taskService->deleteTask($task);

            return response()->json([
                'status' => 'success',
                'message' => 'Tugas berhasil dihapus',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => [],
            ], 400);
        }
    }
}
