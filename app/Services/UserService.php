<?php
namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAllUsers()
    {
        try {
          return User::with(['tasks' => function ($query) {
            $query->select('id', 'title', 'description', 'status', 'due_date', 'user_id');
        }])->paginate(10);
        } catch (Exception $e) {
            throw new Exception('Terjadi kesalahan saat mengambil data pengguna.');
        }
    }

    public function createUser($data)
    {
        try {
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }
            return User::create($data);
        } catch (QueryException $e) {
            throw new Exception('Terjadi kesalahan saat menyimpan data pengguna.');
        }
    }

    public function getUserById($id)
    {
        try {
          return User::withCount()->with(['tasks' => function ($query) {
            $query->select('id', 'title', 'description', 'status', 'due_date', 'user_id');
        }])->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new Exception('Pengguna tidak ditemukan.');
        }
    }

    public function updateUser($user, $data)
    {
        try {
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }
            $user->update($data);
            return $user;
        } catch (QueryException $e) {
            throw new Exception('Terjadi kesalahan saat memperbarui data pengguna.');
        }
    }

    public function deleteUser($user)
    {
        try {
            $user->delete();
        } catch (QueryException $e) {
            throw new Exception('Terjadi kesalahan saat menghapus data pengguna.');
        }
    }
}
