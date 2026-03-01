<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class LaporanBulananRequest extends FormRequest
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
            'judul' => 'required|string',
            'isi' => 'required|string|min:10|max:255'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'judul.required' => 'Judul laporan bulanan harus diisi',
            'isi.required' => 'Isi laporan bulanan harus diisi',
            'isi.min' => 'Isi laporan bulanan minimal 10 karakter',
            'isi.max' => 'Isi laporan bulanan maksimal 255 karakter'
        ];
    }

}
