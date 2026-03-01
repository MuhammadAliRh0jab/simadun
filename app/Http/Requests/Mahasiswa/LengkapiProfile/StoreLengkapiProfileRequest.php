<?php

namespace App\Http\Requests\Mahasiswa\LengkapiProfile;

use App\Rules\IndonesianPhoneNumber;
use App\Rules\PromotorRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreLengkapiProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user() instanceof \App\Models\Mahasiswa;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|min:3|max:255',
            'nim' => 'required|digits:12',
            'no_hp' => ['required', new IndonesianPhoneNumber],
            'email_um' => 'required|email:rfc|ends_with:um.ac.id',
            'email_lain' => 'required|email:rfc|doesnt_end_with:um.ac.id',
            'alamat_malang' => 'required|min:3|max:255',
            'alamat_asal' => 'required|min:3|max:255',
            'asal_instansi' => 'required|min:3|max:255',
            'PT_S1' => 'required|numeric',
            'PT_S2' => 'required|numeric',
            'skor_TPA' => 'required|numeric',
            'skor_toefl' => 'required|numeric',
            'judul' => 'required|min:3|max:255',
            'usulan_promotor' => ['required', new PromotorRule]
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'nama' => 'Nama Lengkap',
            'nim' => 'NIM',
            'no_hp' => 'Nomor HP',
            'email_um' => 'Email UM',
            'email_lain' => 'Email Lain',
            'alamat_malang' => 'Alamat Malang',
            'alamat_asal' => 'Alamat Asal',
            'asal_instansi' => 'Asal Instansi',
            'PT_S1' => 'IPK S1',
            'PT_S2' => 'IPK S2',
            'skor_TPA' => 'Skor TPA',
            'skor_toefl' => 'Skor TOEFL',
            'judul' => 'Judul Disertasi',
            'usulan_promotor' => 'Usulan Promotor',
        ];
    }
}