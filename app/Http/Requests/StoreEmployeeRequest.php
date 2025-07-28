<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:100',
            'email' => 'required|email|unique:employees,email',
            'phone' => [
                'required',
                'regex:/^[0-9]{10}$/', // Accepts only 10-digit numeric values
                'unique:employees,phone'
            ],
            'position' => 'required|string|min:2|max:50',
            'salary' => 'required|numeric|min:0|max:10000000', // Optional upper limit
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'department_id' => 'required|exists:departments,id',
        ];
    }

    /**
     * Custom messages for validation.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Employee name is required.',
            'name.min' => 'Name must be at least 3 characters.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already in use.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Phone number must be a valid 10-digit number.',
            'phone.unique' => 'This phone number is already in use.',
            'position.required' => 'Position is required.',
            'salary.required' => 'Salary is required.',
            'salary.numeric' => 'Salary must be a numeric value.',
            'photo.image' => 'Uploaded file must be an image.',
            'photo.mimes' => 'Photo must be a JPG, PNG, JPEG, GIF, or WEBP file.',
            'department_id.required' => 'Department is required.',
            'department_id.exists' => 'Selected department does not exist.',
        ];
    }
}
