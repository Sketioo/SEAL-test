<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'status' => 'sometimes|required|in:selesai,proses,pending',
            'due_date' => 'sometimes|required|date',
            'project_id' => 'sometimes|required|uuid|exists:projects,id',
            'user_id' => 'sometimes|required|uuid|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul tugas wajib diisi.',
            'description.required' => 'Deskripsi tugas wajib diisi.',
            'status.required' => 'Status tugas wajib diisi.',
            'due_date.required' => 'Tanggal jatuh tempo wajib diisi.',
            'project_id.required' => 'Proyek terkait wajib diisi.',
            'user_id.required' => 'Pengguna terkait wajib diisi.',
            'title.max' => 'Judul tugas tidak boleh melebihi 255 karakter.',
            'description.max' => 'Deskripsi tugas tidak boleh melebihi 255 karakter.',
            'title.string' => 'Judul tugas harus berupa string.',
            'description.string' => 'Deskripsi tugas harus berupa string.',
            'status.string' => 'Status tugas harus berupa string.',
            'status.in' => 'Status tugas tidak valid.',
            'due_date.date' => 'Format tanggal jatuh tempo tidak valid.',
            'due_date.date_format' => 'Format tanggal jatuh tempo tidak valid.',
            'due_date.after' => 'Tanggal jatuh tempo harus setelah hari ini.',
            'project_id.uuid' => 'Proyek terkait harus berupa UUID.',
            'user_id.uuid' => 'Pengguna terkait harus berupa UUID.',
            'project_id.exists' => 'Proyek tidak ditemukan.',
            'user_id.exists' => 'Pengguna tidak ditemukan.',
        ];
    }
}
