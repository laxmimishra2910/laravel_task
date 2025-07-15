<?php

namespace App\Http\Controllers\CustomName;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use Yajra\DataTables\Facades\DataTables;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request) {

      if (!has_role('admin', 'employee')) {
        return view('unauthorized'); // Custom view with alert
    }

        if ($request->ajax()) {
        $feedbacks = Feedback::with('employee')->select('feedback.*');

       return DataTables::of($feedbacks)
    ->addColumn('employee_name', function ($feedback) {
        return $feedback->employee->name ?? 'N/A';
    })
    ->addColumn('action', function ($feedback) {
        return view('feedback.partials.action-button', compact('feedback'))->render();
    })
    ->rawColumns(['action'])
    ->make(true);
}

       $feedbacks = Feedback::with('employee')->latest()->get(); // ✅ only one query
        return view('feedback.index', compact('feedbacks'));
    }

    public function create() {
        $statuses = config('custom.feedback_statuses');
    $defaultMessage = config('custom.default_feedback_message');
     return view('feedback.create', compact('statuses', 'defaultMessage'));
        
    }

    public function store(Request $request) {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'message' => 'required|string',
            'rating' => 'required|in:Excellent,Good,Average,Poor',
        ]);

        Feedback::create($request->all());
        return redirect()->route('feedback.index')->with('success', 'Feedback submitted!');
    }

    public function destroy(Feedback $feedback) {
        $feedback->delete();
        return redirect()->route('feedback.index')->with('success', 'Feedback deleted!');
    }
    public function report()
{
    $report = Feedback::selectRaw('rating, COUNT(*) as total')
                ->groupBy('rating')
                ->pluck('total', 'rating');
    return view('feedback.report', compact('report'));
}

}