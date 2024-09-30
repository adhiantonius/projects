<?php
namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Request;
use Illuminate\Http\Request as HttpRequest;

class ReportController extends Controller
{
    public function showReport(HttpRequest $request)
    {
        // Set the number of items per page to 5
        $itemsPerPage = 5;

        // Fetch paginated issues
        $issues = Issue::latest()->paginate($itemsPerPage);

        // Fetch paginated requests
        $requests = Request::latest()->paginate($itemsPerPage);

        return view('report', compact('issues', 'requests'));
    }
}
