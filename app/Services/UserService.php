<?php
namespace App\Services;

use App\Models\User;
use App\Services\FileUploadService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function getAllUsers()
    {
        try {
            return Cache::remember('users_all', now()->addMinutes(10), function () {
                return User::with(['tasks' => function ($query) {
                    $query->select('id', 'title', 'description', 'status', 'due_date', 'user_id');
                }])->paginate(10);
            });
        } catch (Exception $e) {
            throw new Exception('Terjadi kesalahan saat mengambil data pengguna.');
        }
    }

    public function createUser($data)
    {
        try {
            if (isset($data['photo_profile'])) {
                $data['photo_profile'] = $this->fileUploadService->uploadFile($data['photo_profile'], 'profile_photos');
            }

            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);

            //* Clear cache after creating a user
            Cache::forget('users_all');

            return $user;
        } catch (QueryException $e) {
            throw new Exception('Terjadi kesalahan saat menyimpan data pengguna.');
        }
    }

    public function getUserById($id)
    {
        try {
            return Cache::remember("user_{$id}", now()->addMinutes(10), function () use ($id) {
                return User::withCount('tasks')->with(['tasks' => function ($query) {
                    $query->select('id', 'title', 'description', 'status', 'due_date', 'user_id');
                }])->findOrFail($id);
            });
        } catch (ModelNotFoundException $e) {
            throw new Exception('Pengguna tidak ditemukan.');
        }
    }

    public function updateUser(User $user, $data)
    {
        try {
            if (isset($data['photo_profile'])) {
                $data['photo_profile'] = $this->fileUploadService->uploadFile($data['photo_profile'], 'profile_photos');
            }

            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            $user->update($data);

            //* Clear specific user cache and general users cache
            Cache::forget("user_{$user->id}");
            Cache::forget('users_all');

            return $user;
        } catch (QueryException $e) {
            throw new Exception('Terjadi kesalahan saat memperbarui data pengguna.');
        }
    }

    public function deleteUser(User $user)
    {
        try {
            //* Clear specific user cache and general users cache
            Cache::forget("user_{$user->id}");
            Cache::forget('users_all');

            $user->delete();
        } catch (QueryException $e) {
            throw new Exception('Terjadi kesalahan saat menghapus data pengguna.');
        }
    }
}
