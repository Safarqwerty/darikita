<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDaftarKegiatanRequest extends FormRequest
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
            'latar_belakang' => 'sometimes|string',
            'pernah_relawan' => 'sometimes|boolean',
            'nama_kegiatan_relawan' => 'sometimes|required_if:pernah_relawan,1|string',
            'jenis_kendaraan' => 'sometimes|string',
            'merk_kendaraan' => 'sometimes|string',
            'siap_kontribusi' => 'sometimes|boolean',
            'bukti_follow' => 'sometimes|image|max:2048',
            'bukti_repost' => 'sometimes|image|max:2048',
        ];
    }
}
