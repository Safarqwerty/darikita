<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKegiatanRequest extends FormRequest
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
            'judul' => 'sometimes|string|max:255',
            'jenis_kegiatan' => 'sometimes|in:Pendidikan,Bencana,Sosial',
            'lokasi' => 'sometimes|string|max:255',
            'lokasi_kegiatan' => 'sometimes|string',
            'tanggal_mulai' => 'sometimes|date|after_or_equal:today',
            'tanggal_selesai' => 'sometimes|date|after:tanggal_mulai',
            'status' => 'sometimes|in:draft,publish,selesai',
            'batas_pendaftar' => 'sometimes|integer|min:1',
            'gambar_lokasi' => 'sometimes|image|max:2048',
        ];
    }
}
