<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDonasiRequest extends FormRequest
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
            'nama_bencana' => 'sometimes|string|max:255',
            'deskripsi' => 'sometimes|string',
            'target_dana' => 'sometimes|numeric|min:10000',
            'tanggal_mulai' => 'sometimes|date|after_or_equal:today',
            'tanggal_selesai' => 'sometimes|date|after:tanggal_mulai',
            'status' => 'sometimes|in:open,closed',
            'gambar' => 'sometimes|image|max:2048',
        ];
    }
}
