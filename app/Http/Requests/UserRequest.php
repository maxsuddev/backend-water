<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $user = $this->route('user');
        return match ($this->route()?->getName()) {

            'users.store' => [
                'name' => ['required', 'string', 'max:150'],
                'username' => ['required', 'string', 'min:4', 'max:32', 'unique:users'],
                'password' => ['required', 'string', 'min:4', 'max:16'],
                'roles' => ['required', 'array', 'distinct'],
                'roles.*' => ['exists:roles,id']

            ],
            'users.update' => [
                'name' => ['required', 'string', 'max:150'],
                'username' => ['required', 'string', 'min:4', 'max:32', 'unique:users,username,' . $user->id],
                'password' => ['sometimes', 'string', 'min:4', 'max:16'],
                'roles' => ['required', 'array',  'distinct'],
                'roles.*' => ['exists:roles,id']
            ],
            default => []
        };
    }

    /**
     * Get the validation error messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Ismni kiritish majburiy.',
            'name.string' => 'Ism faqat matn bo\'lishi kerak.',
            'name.max' => 'Ism maksimal :max belgidan iborat bo\'lishi mumkin.',

            'username.required' => 'Foydalanuvchi nomini kiritish majburiy.',
            'username.string' => 'Foydalanuvchi nomi faqat matn bo\'lishi kerak.',
            'username.min' => 'Foydalanuvchi nomi minimal :min belgidan iborat bo\'lishi kerak.',
            'username.max' => 'Foydalanuvchi nomi maksimal :max belgidan iborat bo\'lishi mumkin.',
            'username.unique' => 'Bu foydalanuvchi nomi allaqachon band.',

            'password.required' => 'Parolni kiritish majburiy.',
            'password.string' => 'Parol faqat matn bo\'lishi kerak.',
            'password.min' => 'Parol minimal :min belgidan iborat bo\'lishi kerak.',
            'password.max' => 'Parol maksimal :max belgidan iborat bo\'lishi mumkin.',
        ];
    }
}
