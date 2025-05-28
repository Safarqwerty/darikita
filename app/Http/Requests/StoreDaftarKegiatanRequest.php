<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDaftarKegiatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kegiatan_id' => 'required|exists:kegiatans,id',
            'latar_belakang' => 'required|string',
            'pernah_relawan' => 'required|boolean',
            'nama_kegiatan_relawan' => 'nullable|string|required_if:pernah_relawan,1',
            'jenis_kendaraan' => 'nullable|string',
            'merk_kendaraan' => 'nullable|string',
            'siap_kontribusi' => 'required|boolean',
            'bukti_follow' => 'required|image|max:2048',
            'bukti_repost' => 'required|image|max:2048',
        ];
    }
}
