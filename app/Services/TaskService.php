<?php
namespace App\Services;

use App\Models\Task;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class TaskService
{
    public function getAllTasks()
    {
        try {
            return Task::with(['user:id,name,phone,type,position', 'project:id,name'])
                ->paginate(10);
        } catch (Exception $e) {
            throw new Exception('Terjadi kesalahan saat mengambil data tugas.');
        }
    }

    public function createTask($data)
    {
        try {
            return Task::create($data);
        } catch (QueryException $e) {
            throw new Exception('Terjadi kesalahan saat menyimpan data tugas.');
        }
    }

    public function getTaskById($id)
    {
        try {
            $task = Task::with(['user:id,name,phone,type,position', 'project:id,name'])
                ->findOrFail($id);

            return $task;
        } catch (ModelNotFoundException $e) {
            throw new Exception('Tugas tidak ditemukan.');
        }
    }

    public function updateTask($task, $data)
    {
        try {
            $task->update($data);
            return $task;
        } catch (QueryException $e) {
            throw new Exception('Terjadi kesalahan saat memperbarui data tugas.');
        }
    }

    public function deleteTask($task)
    {
        try {
            $task->delete();
        } catch (QueryException $e) {
            throw new Exception('Terjadi kesalahan saat menghapus data tugas.');
        }
    }
}
