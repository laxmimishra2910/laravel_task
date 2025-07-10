<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $employeeId = $this->route('employee'); // ✅ uses model binding (UUID)

        return [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('employees', 'email')
                    ->ignore($employeeId, 'id')
                    ->whereNull('deleted_at'), // ✅ ignore soft-deleted emails
            ],
            'phone' => 'required',
            'position' => 'required',
            'salary' => 'required|numeric',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ];
    }
}
