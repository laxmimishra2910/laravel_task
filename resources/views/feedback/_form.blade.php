

@csrf
<div class="mb-3">
    <label for="client_name">Name</label>
    <input type="text" name="client_name" class="form-control" value="{{ old('client_name', $feedback->client_name ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="email">Email (optional)</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $feedback->email ?? '') }}">
</div>

<div class="mb-3">
    <label for="message">Message</label>
    <textarea name="message" class="form-control" required>{{ old('message', $feedback->message ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="rating">Rating</label>
    <select name="rating" class="form-select" required>
        @foreach(['Excellent', 'Good', 'Average', 'Poor'] as $rate)
            <option value="{{ $rate }}" {{ old('rating', $feedback->rating ?? '') == $rate ? 'selected' : '' }}>
                {{ $rate }}
            </option>
        @endforeach
    </select>
</div>

<button type="submit" class="btn btn-success">Submit Feedback</button>
