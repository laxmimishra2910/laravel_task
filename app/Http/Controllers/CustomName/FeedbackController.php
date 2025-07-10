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

         if ($request->ajax()) {
        $data = Feedback::latest()->get();
        return DataTables::of($data)
            ->addColumn('action', function ($row) {
    return '<form action="' . route('feedback.destroy', $row->id) . '" method="POST" onsubmit="return confirm(\'Delete this feedback?\')" style="display:inline;">
                ' . csrf_field() . method_field('DELETE') . '
                <button class="btn btn-danger btn-sm">Delete</button>
            </form>';
        })
            ->rawColumns(['action']) // Allow HTML
            ->make(true);
    }
        $feedbacks = Feedback::latest()->get();
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