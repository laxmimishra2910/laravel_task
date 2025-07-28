<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackRequest extends FormRequest
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
            'employee_id' => 'required|exists:employees,id',
            'client_name' => 'required|string|regex:/^[a-zA-Z\s]+$/|min:2|max:255',
            'email' => 'nullable|email:rfc,dns|max:255',
            'message' => 'required|string|min:10|max:1000',
            'rating' => 'required|string|in:Excellent,Good,Average,Poor',
        ];
    }

    /**
     * Custom validation error messages.
     */
    public function messages(): array
    {
        return [
            'employee_id.required' => 'Please select an employee.',
            'employee_id.exists' => 'The selected employee does not exist.',

            'client_name.required' => 'Client name is required.',
            'client_name.regex' => 'Client name can only contain letters and spaces.',
            'client_name.min' => 'Client name must be at least 2 characters.',
            'client_name.max' => 'Client name must not exceed 255 characters.',

            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email must not exceed 255 characters.',

            'message.required' => 'Feedback message is required.',
            'message.min' => 'Feedback must be at least 10 characters.',
            'message.max' => 'Feedback must not exceed 1000 characters.',

            'rating.required' => 'Rating is required.',
            'rating.in' => 'Rating must be one of: Excellent, Good, Average, or Poor.',
        ];
    }
}
