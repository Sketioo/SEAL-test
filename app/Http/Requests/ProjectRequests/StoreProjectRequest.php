<?php

namespace App\Http\Requests\ProjectRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama proyek wajib diisi.',
            'name.string' => 'Nama proyek harus berupa string.',
            'name.max' => 'Nama proyek tidak boleh melebihi 255 karakter.',
            'description.required' => 'Deskripsi proyek wajib diisi.',
            'description.string' => 'Deskripsi proyek harus berupa string.',
            'description.max' => 'Deskripsi proyek tidak boleh melebihi 255 karakter.',
        ];
    }
}
