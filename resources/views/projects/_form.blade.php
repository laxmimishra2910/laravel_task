<div class="form-wrapper">
@csrf
@if(isset($project))
    @method('PUT')
@endif

<div class="mb-3">
    <label for="project_name" class="form-label">Project Name</label>
    <input type="text" name="project_name" id="project_name" class="form-control"
           value="{{ old('project_name', $project->project_name ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea name="description" id="description" class="form-control">{{ old('description', $project->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select name="status" id="status" class="form-select" required>
        @foreach(['Pending', 'In Progress', 'Completed'] as $status)
            <option value="{{ $status }}" {{ (old('status', $project->status ?? '') == $status) ? 'selected' : '' }}>
                {{ $status }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="start_date" class="form-label">Start Date</label>
    <input type="date" name="start_date" id="start_date" class="form-control"
           value="{{ old('start_date', $project->start_date ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="end_date" class="form-label">End Date</label>
    <input type="date" name="end_date" id="end_date" class="form-control"
           value="{{ old('end_date', $project->end_date ?? '') }}">
</div>

<button type="submit" class="btn btn-{{ isset($project) ? 'primary' : 'success' }}">
    {{ isset($project) ? 'Update' : 'Create' }} Project
</button>
  <a href="{{ route('projects.index') }}" class="btn btn-secondary">Back</a>
</div>