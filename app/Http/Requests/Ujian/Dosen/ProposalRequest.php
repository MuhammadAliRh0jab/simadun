<?php

namespace App\Http\Requests\Ujian\Dosen;

use Illuminate\Foundation\Http\FormRequest;

class ProposalRequest extends FormRequest
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
            'penguji' => 'required|array|min:2|max:3',
            'tanggal' => 'required|date',
            'jam' => 'required|date_format:H:i',
            'ruangan' => 'required|string|max:50',
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
            'penguji.required' => 'Penguji harus diisi',
            'penguji.size' => 'Penguji harus minimal 2 dan maksimal 3',
            'tanggal.required' => 'Tanggal harus diisi',
            'tanggal.date' => 'Tanggal harus berupa tanggal',
            'jam.required' => 'Jam harus diisi',
            'jam.date_format' => 'Jam harus berupa format jam',
            'ruangan.required' => 'Ruangan harus diisi',
            'ruangan.max' => 'Ruangan maksimal 50 karakter',
        ];
    }
}
