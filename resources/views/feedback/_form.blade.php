<div class="form-wrapper">
    @csrf
    @php
        $formFields = config('form.feedback_form');
    @endphp

    @foreach ($formFields as $field)
        <div class="mb-4">
            <label for="{{ $field['name'] }}" class="block font-semibold">
                {{ $field['label'] }}
            </label>

            {{-- Handle employee_id separately --}}
            @if ($field['name'] === 'employee_id' && $field['type'] === 'select')
                <select name="employee_id" id="employee_id" class="w-full border rounded p-2" required>
                    <option value="">-- Select Employee --</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->name }}
                        </option>
                    @endforeach
                </select>

            {{-- Handle regular select fields like rating --}}
            @elseif ($field['type'] === 'select')
                <select
                    name="{{ $field['name'] }}"
                    id="{{ $field['name'] }}"
                    class="w-full border rounded p-2"
                    @if ($field['required']) required @endif
                >
                    <option value="">-- Select --</option>
                    @foreach ($field['options'] as $optionValue => $optionLabel)
                        <option value="{{ $optionValue }}" {{ old($field['name']) == $optionValue ? 'selected' : '' }}>
                            {{ $optionLabel }}
                        </option>
                    @endforeach
                </select>

            @elseif ($field['type'] === 'textarea')
                <textarea
                    name="{{ $field['name'] }}"
                    id="{{ $field['name'] }}"
                    class="w-full border rounded p-2"
                    placeholder="{{ $field['placeholder'] ?? '' }}"
                    @if ($field['required']) required @endif
                >{{ old($field['name']) }}</textarea>

            @else
                <input
                    type="{{ $field['type'] }}"
                    name="{{ $field['name'] }}"
                    id="{{ $field['name'] }}"
                    value="{{ old($field['name']) }}"
                    placeholder="{{ $field['placeholder'] ?? '' }}"
                    class="w-full border rounded p-2"
                    @if ($field['required']) required @endif
                />
            @endif
        </div>
    @endforeach

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
        Submit
    </button>
</div>
