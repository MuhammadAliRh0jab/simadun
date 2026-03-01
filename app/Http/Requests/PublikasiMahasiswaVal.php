<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublikasiMahasiswaVal extends FormRequest
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
            'nama' => 'required|string|max:255',
            'nim' => 'required|numeric|digits:12',
            'Judul_jurnal' => 'required|string|max:255',
            'Nama_jurnal' => 'required|string|max:255',
            'nomor' => 'required',
            'hal' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'tgl_terbit' => 'required',
        ];
    }

    // pesan
    public function messages()
    {
        return [
            'nama.required' => 'Nama tidak boleh kosong',
            'nama.string' => 'Nama harus berupa huruf',
            'nama.max' => 'Nama maksimal 255 karakter',
            'nim.required' => 'NIM tidak boleh kosong',
            'nim.numeric' => 'NIM harus berupa angka',
            'nim.digits' => 'NIM harus 12 digit',
            'Judul_jurnal.required' => 'Judul jurnal tidak boleh kosong',
            'Judul_jurnal.string' => 'Judul jurnal harus berupa huruf',
            'Judul_jurnal.max' => 'Judul jurnal maksimal 255 karakter',
            'Nama_jurnal.required' => 'Nama jurnal tidak boleh kosong',
            'Nama_jurnal.string' => 'Nama jurnal harus berupa huruf',
            'Nama_jurnal.max' => 'Nama jurnal maksimal 255 karakter',
            'nomor.required' => 'Nomor harus berupa angka',
            'hal.required' => 'Halaman tidak boleh kosong',
            'hal.string' => 'Halaman harus berupa huruf',
            'hal.max' => 'Halaman maksimal 255 karakter',
            'jenis.required' => 'Jenis tidak boleh kosong',
            'jenis.string' => 'Jenis harus berupa huruf',
            'jenis.max' => 'Jenis maksimal 255 karakter',
            'tgl_terbit.required' => 'Tanggal terbit tidak boleh kosong',
        ];
    }
}
