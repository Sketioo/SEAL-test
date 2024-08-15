<?php

namespace App\Http\Controllers;

use Exception;
use App\Services\UserService;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        try {
            $users = $this->userService->getAllUsers();

            return response()->json([
                'status' => 'success',
                'message' => 'Data Karyawan ditemukan',
                'data' => $users->items(),
                'total' => $users->total(),
                'pagination' => [
                    'current_page' => $users->currentPage(),
                    'total_pages' => $users->lastPage(),
                    'total_items' => $users->total(),
                    'per_page' => $users->perPage(),
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

    public function store(StoreUserRequest $request)
    {
        try {
            $this->userService->createUser($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Karyawan berhasil ditambahkan',
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
            $user = $this->userService->getUserById($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Data Karyawan ditemukan',
                'data' => $user,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => [],
            ], 404);
        }
    }

    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $user = $this->userService->getUserById($id);

            $this->auhtorize('update', $user);

            $this->userService->updateUser($user, $request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Data Karyawan berhasil diperbarui',
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
            $user = $this->userService->getUserById($id);

            $this->authorize('delete', $user);

            $this->userService->deleteUser($user);

            return response()->json([
                'status' => 'success',
                'message' => 'Data Karyawan berhasil dihapus',
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
