<?php

namespace App\Http\Requests\Ujian;

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
            'nim' => 'required|string',
            'nama' => 'required|string',
            'usulan_penguji' => 'required|array|min:2|max:3',
            'naskah' => 'required'
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
            'nim.required' => 'NIM harus diisi',
            'nama.required' => 'Nama harus diisi',
            'usulan_penguji.required' => 'Usulan penguji harus diisi',
            'usulan_penguji.size' => 'Usulan penguji harus berjumlah 2',
            'naskah.required' => 'File harus diisi',
        ];
    }
}
