<div class="form-wrapper">
    @csrf

    @if (isset($formFields) && is_array($formFields))
        @foreach ($formFields as $field)
            <div class="mb-4">
                <label for="{{ $field['name'] }}" class="block text-sm font-medium text-gray-700">
                    {{ $field['label'] }}
                    @if($field['required'] ?? false) <span class="text-red-500">*</span> @endif
                </label>

                {{-- SELECT FIELD --}}
                @if ($field['type'] === 'select')
                    @php
                        $options = $field['options'] ?? [];
                        $selectedValue = old($field['name'], $data[$field['name']] ?? '');
                    @endphp

                    <select name="department_id" id="department_id" class="form-select" required>
        <option value="">-- Select Department --</option>
        @foreach($departments as $department)
            <option value="{{ $department->id }}" 
                {{ $employee->department->first()->id == $department->id ? 'selected' : '' }}>
                {{ $department->name }}
            </option>
        @endforeach
    </select>
                {{-- TEXTAREA FIELD --}}
                @elseif ($field['type'] === 'textarea')
                    <textarea name="{{ $field['name'] }}" id="{{ $field['name'] }}"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                              placeholder="{{ $field['placeholder'] ?? '' }}"
                              {{ $field['required'] ? 'required' : '' }}>{{ old($field['name'], $data[$field['name']] ?? '') }}</textarea>

                {{-- FILE FIELD --}}
                @elseif ($field['type'] === 'file')
                    <input type="file" name="{{ $field['name'] }}" id="{{ $field['name'] }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                           {{ $field['required'] ? 'required' : '' }}>

                {{-- OTHER INPUTS --}}
                @else
                    <input
                        type="{{ $field['type'] }}"
                        name="{{ $field['name'] }}"
                        id="{{ $field['name'] }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        placeholder="{{ $field['placeholder'] ?? '' }}"
                        value="{{ old($field['name'], $data[$field['name']] ?? '') }}"
                        {{ $field['required'] ? 'required' : '' }}
                        @if(isset($field['step'])) step="{{ $field['step'] }}" @endif
                    >
                @endif

                @error($field['name'])
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        @endforeach

        {{-- Submit Button --}}
        <div class="mt-6">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                {{ isset($data) ? 'Update' : 'Save' }}
            </button>
        </div>
    @else
        <p class="text-red-500">No form fields configured.</p>
    @endif
</div>