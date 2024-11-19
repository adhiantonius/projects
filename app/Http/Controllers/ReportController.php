<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Request as RequestModel; // Import the correct Request model
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function showReport(HttpRequest $request)
    {
        $itemsPerPage = 5;
        $userId = Auth::id(); // Mendapatkan ID user yang sedang login
        $userRole = Auth::user()->role; // Mendapatkan role dari user yang login

        // Buat query awal untuk issues dan requests
        $issuesQuery = Issue::where('status', 'End')->latest();
        $requestsQuery = RequestModel::where('status', 'End')->latest();

        // Jika user bukan admin, hanya tampilkan issues dan requests milik mereka
        if ($userRole != 'Admin') {
            $issuesQuery->where('created_by', $userId);
            $requestsQuery->where('created_by', $userId);
        }

        // Apply filter tanggal untuk issues jika diberikan
        if ($request->filled('start_date')) {
            $issuesQuery->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $issuesQuery->whereDate('created_at', '<=', $request->end_date);
        }

        // Apply filter tanggal untuk requests jika diberikan
        if ($request->filled('start_date')) {
            $requestsQuery->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $requestsQuery->whereDate('created_at', '<=', $request->end_date);
        }

        // Eksekusi query dan lakukan paginasi
        $issues = $issuesQuery->paginate($itemsPerPage);
        $requests = $requestsQuery->paginate($itemsPerPage);

        // Return view report dan kirimkan issues dan requests
        return view('report', compact('issues', 'requests'));
    }
}
