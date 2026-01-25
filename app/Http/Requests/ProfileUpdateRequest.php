<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'username' => ['required', 'string', 'max:20', 'unique:users,username,' . $this->user()->id],
            'whatsapp' => ['required', 'string', 'max:14'],
            'gender' => ['required', 'in:L,P'],
            'tempat_lahir' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z\s]+$/'],
            'tanggal_lahir' => ['required', 'date'],
            'avatar' => [
                'nullable',
                'image',
                'mimetypes:image/jpeg,image/png,image/webp',
                'max:2048',
            ],

        ];
    }
}
