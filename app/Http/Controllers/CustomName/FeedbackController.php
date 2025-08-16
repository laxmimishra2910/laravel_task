<?php

namespace App\Http\Controllers\CustomName;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use Yajra\DataTables\Facades\DataTables;
use App\Interfaces\FeedbackRepositoryInterface;

class FeedbackController extends Controller
{
    protected $feedbackRepo;

    public function __construct(FeedbackRepositoryInterface $feedbackRepo)
    {
        $this->feedbackRepo = $feedbackRepo;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->feedbackRepo->all();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('employee_name', function ($row) {
                    // If many-to-many, show comma-separated names
                    return $row->employee->pluck('name')->join(', ') ?: 'N/A';
                })
                ->addColumn('action', function ($row) {
                    return view('feedback.partials.action', [
                        'baseRoute' => 'feedbacks',
                        'feedback' => $row,
                    ])->render();
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('feedback.index');
    }

    public function store(Request $request)
    {
        $this->feedbackRepo->create($request->all());
        return redirect()->route('feedbacks.index')->with('success', 'Feedback submitted.');
    }

    public function destroy($id)
    {
        $this->feedbackRepo->delete($id);
        return response()->json(['success' => 'Feedback deleted successfully.']);
    }
public function report()
{
    $report = $this->feedbackRepo->report(); // calls your repository method

    return view('feedback.report', compact('report'));
}


}
