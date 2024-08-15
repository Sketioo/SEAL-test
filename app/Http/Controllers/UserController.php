<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);

        return response()->json([
            'status' => 'success',
            'message' => 'Data Karyawan ditemukan',
            'data' => $users->items(),
            'pagination' => [
                'current_page' => $users->currentPage(),
                'total_pages' => $users->lastPage(),
                'total_items' => $users->total(),
                'per_page' => $users->perPage(),
            ],
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Karyawan berhasil ditambahkan',
        ], 201);
    }

    public function show(User $user)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Data Karyawan ditemukan',
            'data' => $user,
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);
        return response()->json([
            'status' => 'success',
            'message' => 'Data Karyawan berhasil diperbarui',
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data Karyawan berhasil dihapus',
        ]);
    }
}
