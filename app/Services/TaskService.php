<?php

namespace App\Services;

use App\Models\Task;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;

class TaskService
{
    public function getAllTasks()
    {
        try {
            return Cache::remember('tasks_all', now()->addMinutes(10), function () {
                return Task::with(['user:id,name,phone,type,position', 'project:id,name'])
                    ->paginate(10);
            });
        } catch (Exception $e) {
            throw new Exception('Terjadi kesalahan saat mengambil data tugas.');
        }
    }

    public function createTask($data)
    {
        try {
            //* Clear cache when a new task is created
            Cache::forget('tasks_all');
            return Task::create($data);
        } catch (QueryException $e) {
            throw new Exception('Terjadi kesalahan saat menyimpan data tugas.');
        }
    }

    public function getTaskById($id)
    {
        try {
            return Cache::remember("task_{$id}", now()->addMinutes(10), function () use ($id) {
                return Task::with(['user:id,name,phone,type,position', 'project:id,name'])
                    ->findOrFail($id);
            });
        } catch (ModelNotFoundException $e) {
            throw new Exception('Tugas tidak ditemukan.');
        }
    }

    public function updateTask(Task $task, $data)
    {
        try {
            //* Clear specific task cache
            Cache::forget("task_{$task->id}");
            Cache::forget('tasks_all');

            $task->update($data);

            return $task;
        } catch (QueryException $e) {
            throw new Exception('Terjadi kesalahan saat memperbarui data tugas.');
        }
    }

    public function deleteTask(Task $task)
    {
        try {
            //* Clear specific task cache
            Cache::forget("task_{$task->id}");
            Cache::forget('tasks_all');

            $task->delete();
        } catch (QueryException $e) {
            throw new Exception('Terjadi kesalahan saat menghapus data tugas.');
        }
    }
}
