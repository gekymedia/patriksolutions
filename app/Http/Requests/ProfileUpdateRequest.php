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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        // If only photo is being uploaded (no name/email in request), make name and email optional
        $hasName = $this->filled('name');
        $hasEmail = $this->filled('email');
        $isPhotoOnly = $this->hasFile('photo') && !$hasName && !$hasEmail;
        
        return [
            'name' => [$isPhotoOnly ? 'nullable' : 'required', 'string', 'max:255'],
            'email' => [$isPhotoOnly ? 'nullable' : 'required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ];
    }
}
