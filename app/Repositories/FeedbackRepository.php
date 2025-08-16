<?php

namespace App\Repositories;

use App\Interfaces\FeedbackRepositoryInterface;
use App\Models\Feedback;
use Yajra\DataTables\Facades\DataTables;

class FeedbackRepository implements FeedbackRepositoryInterface
{
    public function all()
    {
        // Eager load employee
        return Feedback::with('employee')->latest();
    }

    public function create(array $data)
    {
        return Feedback::create($data);
    }

    public function delete($id)
    {
        return Feedback::findOrFail($id)->delete();
    }

    public function report()
    {
        return Feedback::selectRaw('rating, COUNT(*) as total')
            ->groupBy('rating')
            ->pluck('total', 'rating');
    }
}
