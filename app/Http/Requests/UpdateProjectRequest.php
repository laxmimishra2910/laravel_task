<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
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
        $projectId = $this->route('project'); // or $this->project if using route model binding

        return [
            'project_name' => [
    'required',
    'string',
    'min:3',
    'max:255',
    Rule::unique('projects', 'project_name')->ignore($projectId),
],

            'description' => 'nullable|string|min:10|max:1000',
            'status' => 'required|string|in: Pending,  In Process,Completed',
            'start_date' => 'required|date|before_or_equal:today',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ];
    }

    /**
     * Optional: Custom error messages (recommended for better UX)
     */
    public function messages(): array
    {
        return [
            'project_name.required' => 'Project name is required.',
            'project_name.min' => 'Project name must be at least 3 characters.',
            'project_name.max' => 'Project name must not exceed 255 characters.',
            'project_name.unique' => 'This project name is already in use.',
            
            'description.min' => 'Description must be at least 10 characters.',
            'description.max' => 'Description must not exceed 1000 characters.',

            'status.required' => 'Project status is required.',
            'status.in' => 'Status must be one of:  Pending,  In Process,Completed',

            'start_date.required' => 'Start date is required.',
            'start_date.before_or_equal' => 'Start date cannot be in the future.',

            'end_date.after_or_equal' => 'End date must be after or equal to the start date.',
        ];
    }
}
