<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'Nama proyek harus berupa string.',
            'name.max' => 'Nama proyek tidak boleh melebihi 255 karakter.',
            'description.string' => 'Deskripsi proyek harus berupa string.',
            'description.max' => 'Deskripsi proyek tidak boleh melebihi 255 karakter.',
        ];
    }
}
