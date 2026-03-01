<?php

namespace App\Http\Requests\Ujian;

use Illuminate\Foundation\Http\FormRequest;

class DisertasiTertutupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Normalisasi sebelum validasi:
     * - buang elemen kosong dari array usulan_penguji (kadang Select2 kirim '')
     * - reindex array agar [0,1,2]
     */
    protected function prepareForValidation(): void
    {
        $penguji = $this->input('usulan_penguji', []);

        if (is_array($penguji)) {
            $penguji = array_values(array_filter($penguji, fn($v) => filled($v)));
        }

        $this->merge([
            'usulan_penguji' => $penguji,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nim'              => ['required','string'],
            'nama'             => ['required','string'],

            // 2–3 penguji internal
            'usulan_penguji'   => ['required','array','min:2','max:3'],
            'usulan_penguji.*' => ['integer','distinct','exists:dosens,id'],

            // opsional penguji eksternal
            'nama_px1'         => ['nullable','string'],
            'nama_px2'         => ['nullable','string'],
            'id_px1'           => ['nullable','string'],
            'id_px2'           => ['nullable','string'],
            'email_px1'        => ['nullable','email'],
            'email_px2'        => ['nullable','email'],

            // LINK naskah (BUKAN file)
            'naskah'           => ['required','url'],
        ];
    }

    public function messages(): array
    {
        return [
            'nim.required'                 => 'NIM harus diisi',
            'nama.required'                => 'Nama harus diisi',

            'usulan_penguji.required'      => 'Usulan penguji harus diisi',
            'usulan_penguji.array'         => 'Usulan penguji tidak valid',
            'usulan_penguji.min'           => 'Usulan penguji minimal 2 orang',
            'usulan_penguji.max'           => 'Usulan penguji maksimal 3 orang',

            'usulan_penguji.*.integer'     => 'ID penguji tidak valid',
            'usulan_penguji.*.distinct'    => 'Penguji tidak boleh sama',
            'usulan_penguji.*.exists'      => 'Penguji yang dipilih tidak ditemukan',

            'nama_px1.string'              => 'Nama penguji eksternal 1 harus berupa teks',
            'nama_px2.string'              => 'Nama penguji eksternal 2 harus berupa teks',
            'id_px1.string'                => 'ID penguji eksternal 1 harus berupa teks',
            'id_px2.string'                => 'ID penguji eksternal 2 harus berupa teks',
            'email_px1.email'              => 'Email penguji eksternal 1 tidak valid',
            'email_px2.email'              => 'Email penguji eksternal 2 tidak valid',

            'naskah.required'              => 'Link naskah harus diisi',
            'naskah.url'                   => 'Link naskah harus berupa URL yang valid',
        ];
    }

    public function attributes(): array
    {
        return [
            'nim'                => 'NIM',
            'nama'               => 'Nama',
            'usulan_penguji'     => 'Usulan penguji',
            'usulan_penguji.*'   => 'Penguji',
            'naskah'             => 'Link naskah',
        ];
    }
}
