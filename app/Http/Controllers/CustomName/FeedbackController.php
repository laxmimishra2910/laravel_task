<?php

namespace App\Http\Controllers\CustomName;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\StoreFeedbackRequest;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Optional: Role-based access check
        if (!has_role('admin', 'employee')) {
            return view('unauthorized');
        }

        if ($request->ajax()) {
            $data = Feedback::with('employee')->latest()->get(); // ✅ Eager load

            return DataTables::of($data)
                ->addColumn('action', function($feedback){
    return '<form action="' . route('feedback.destroy', $feedback->id) . '" method="POST" onsubmit="return confirm(\'Are you sure?\')" style="display:inline;">'
        . csrf_field()
        . method_field('DELETE')
        . '<button type="submit" class="text-red-600 hover:underline">Delete</button>'
        . '</form>';
})

                ->addColumn('employee_name', function($row) {
                    return $row->employee ? $row->employee->name : 'N/A';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $statuses = config('custom.feedback_statuses');
        $defaultMessage = config('custom.default_feedback_message');
        $employees = Employee::all(); 
        $formFields = config('custom.feedback_form'); // ✅ Get the form config

        return view('feedback.index', compact('statuses', 'defaultMessage', 'employees', 'formFields'));
    }

    // ✅ Moved outside index
    public function create()
    {
        if (!has_role('admin', 'employee')) {
            return view('unauthorized');
        }

        $statuses = config('custom.feedback_statuses');
        $defaultMessage = config('custom.default_feedback_message');
        $employees = Employee::all();
        $formFields = config('custom.feedback_form');

        return view('feedback.create', compact('statuses', 'defaultMessage', 'employees', 'formFields'));
    }

    public function store(StoreFeedbackRequest $request)
    {
        $validated = $request->validated();
        Feedback::create($validated);

        return redirect()->route('feedback.index')->with('success', 'Feedback submitted!');
    }

    public function destroy(Feedback $feedback)
    {
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
