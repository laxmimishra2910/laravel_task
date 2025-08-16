<div class="form-wrapper">
    @csrf

    @if (isset($formFields) && is_array($formFields))
        @foreach ($formFields as $field)
            <div class="mb-4">
                <label for="{{ $field['name'] }}" class="block text-sm font-medium text-gray-700">
                    {{ $field['label'] }}
                </label>

                {{-- SELECT FIELD --}}
                @if ($field['type'] === 'select')
                    @php
                        $options = $field['options'] ?? [];
                        // Safely get selected value with array check
                        $selectedValue = old($field['name'], $data[$field['name']] ?? '');
                        $selectedValue = is_array($selectedValue) ? '' : $selectedValue;
                    @endphp

                    <select name="{{ $field['name'] }}" id="{{ $field['name'] }}"
                            class="form-select mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            {{ $field['required'] ? 'required' : '' }}>
                        <option value="">-- Select {{ $field['label'] }} --</option>
                        @foreach($options as $optionValue => $optionLabel)
                            <option value="{{ $optionValue }}" {{ $selectedValue == $optionValue ? 'selected' : '' }}>
                                {{ is_array($optionLabel) ? json_encode($optionLabel) : $optionLabel }}
                            </option>
                        @endforeach
                    </select>

                {{-- TEXTAREA --}}
                @elseif ($field['type'] === 'textarea')
                    @php
                        $value = old($field['name'], $data[$field['name']] ?? '');
                        $value = is_array($value) ? json_encode($value) : $value;
                    @endphp
                    <textarea name="{{ $field['name'] }}" id="{{ $field['name'] }}"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                              placeholder="{{ $field['placeholder'] ?? '' }}"
                              {{ $field['required'] ? 'required' : '' }}>{{ $value }}</textarea>

                {{-- OTHER INPUTS --}}
                @else
                    @php
                        $value = old($field['name'], $data[$field['name']] ?? '');
                        $value = is_array($value) ? json_encode($value) : $value;
                    @endphp
                    <input
                        type="{{ $field['type'] }}"
                        name="{{ $field['name'] }}"
                        id="{{ $field['name'] }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        placeholder="{{ $field['placeholder'] ?? '' }}"
                        value="{{ $value }}"
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