<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            $category = $this->route('category');

            return match ($this->route()->getName()) {
                'categories.store' => [
                    'name' => ['required', 'unique:categories,name', 'string', 'max:150'],
                    'description' => ['nullable', 'string', 'max:500'],
                ],
                'categories.update' => [
                    'name' => ['required', 'string', 'max:150', 'unique:categories,name,' . $category->id],
                    'description' => ['nullable', 'string', 'max:500'],
                ],
            };

    }
}
