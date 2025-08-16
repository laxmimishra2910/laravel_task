<form action="{{ route('feedback.destroy', $feedback->id) }}" method="POST" style="display:inline-block;">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this feedback?')">
        Delete
    </button>
</form>
