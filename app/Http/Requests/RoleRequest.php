<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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

        $role = $this->route('role');

       return match ($this->route()?->getName()) {
           'roles.store' =>   [
                'name' => 'required|string|max:100|min:3|unique:roles,name',
                'permissions' => ['required','array','min:1'],
                'permissions.*' => ['exists:permissions,id']
            ],
           'roles.update' =>   [
               'name' => 'required|string|max:100|min:3|unique:roles,name,' . $role->id,
               'permissions' => ['required','array','min:1'],
               'permissions.*' => ['exists:permissions,id']
           ]
       };
    }
}
