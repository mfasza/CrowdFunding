<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampaignStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'image' => ['required', 'mimes:jpg,jpeg,png'],
            'collected' => ['required', 'numeric'],
            'required' => ['required', 'numeric'],
            'address' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul belum diisi',
            'description.required' => 'Deskripsi belum diisi',
            'image.required' => 'Gambar belum diisi',
            'collected.required' => 'Jumlah terkumpul belum diisi',
            'required.required' => 'Jumlah dibutuhkan belum diisi',
            'address.required' => 'Alamat belum diisi',
            'mimes' => 'Format gambar yang diperbolehkan hanya .png, .jpg atau .jpeg'
        ];
    }
}
