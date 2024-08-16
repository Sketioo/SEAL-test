<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        // $userId = $this->route('user');

        return [
            'nip' => 'nullable|unique:users,nip,',
            'name' => 'sometimes|required|string|max:255',
            'username' => 'sometimes|required|string|max:255|unique:users,username,',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,',
            'position' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|in:magang,pegawai',
            'phone' => 'sometimes|required|string|max:255',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'sometimes|required|string|min:8',
        ];
    }

    public function messages()
    {
        return [
            'nip.unique' => 'NIP sudah digunakan.',
            'name.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'email.email' => 'Email harus berupa alamat email yang valid.',
            'position.required' => 'Posisi wajib diisi.',
            'type.required' => 'Tipe pengguna wajib diisi.',
            'type.in' => 'Tipe pengguna harus salah satu dari: magang, pegawai.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'photo_profile.required' => 'Foto profil wajib diisi.',
            'photo_profile.image' => 'Foto profil harus berupa gambar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal harus :min karakter.',
        ];
    }
}
