<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:selesai,proses,pending',
            'due_date' => 'required|date',
            'project_id' => 'required|uuid|exists:projects,id',
            'user_id' => 'required|uuid|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul tugas wajib diisi.',
            'title.string' => 'Judul tugas harus berupa string.',
            'title.max' => 'Judul tugas tidak boleh melebihi 255 karakter.',
            'description.required' => 'Deskripsi tugas wajib diisi.',
            'description.string' => 'Deskripsi tugas harus berupa string.',
            'description.max' => 'Deskripsi tugas tidak boleh melebihi 255 karakter.',
            'status.required' => 'Status tugas wajib diisi.',
            'status.string' => 'Status tugas harus berupa string.',
            'status.in' => 'Status tugas tidak valid.',
            'due_date.required' => 'Tanggal jatuh tempo wajib diisi.',
            'due_date.date' => 'Format tanggal jatuh tempo tidak valid.',
            'due_date.date_format' => 'Format tanggal jatuh tempo tidak valid.',
            'due_date.after' => 'Tanggal jatuh tempo harus setelah hari ini.',
            'project_id.required' => 'Proyek terkait wajib diisi.',
            'project_id.uuid' => 'Proyek terkait harus berupa UUID.',
            'project_id.exists' => 'Proyek tidak ditemukan.',
            'user_id.required' => 'Pengguna terkait wajib diisi.',
            'user_id.uuid' => 'Pengguna terkait harus berupa UUID.',
            'user_id.exists' => 'Pengguna tidak ditemukan.',
        ];
    }

}
