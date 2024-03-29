<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
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
        if ($this->method() == "GET" || $this->method() == "PUT") return [];
        else return [
            'nama' => ['required', 'max:100'],
            'email' => ['required', 'max:60'],
            'no_wa' => ['required', 'max:50'],
            'jenis_pengaduan' => ['required', 'max:60'],
            'deskripsi' => ['required', 'max:200']
        ];
        
    }
}
