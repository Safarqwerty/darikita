<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKegiatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // pastikan sudah dibatasi di controller atau middleware
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|in:Pendidikan,Bencana,Sosial',
            'lokasi' => 'required|string|max:255',
            'lokasi_kegiatan' => 'required|string',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:draft,publish,selesai',
            'batas_pendaftar' => 'nullable|integer|min:1',
            'gambar_lokasi' => 'nullable|image|max:2048',
        ];
    }
}
