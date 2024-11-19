<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IssueController extends Controller
{
    // Method to store a new issue
    public function store(Request $request)
    {
        // Validate the data sent from the form
        $validatedData = $request->validate([
            'date' => 'required|date',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high', // Validate priority
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Save file attachment if it exists
        if ($request->hasFile('attachment')) {
            $fileName = time() . '_' . $request->file('attachment')->getClientOriginalName();
            $attachmentPath = $request->file('attachment')->storeAs('uploads', $fileName, 'public');
            $validatedData['attachment'] = '/storage/' . $attachmentPath;
        }

        // Set status and created_by fields
        $validatedData['status'] = 'Active';
        $validatedData['created_by'] = Auth::id();

        // Create a new issue using the Issue model
        Issue::create($validatedData);

        // Redirect with a success message for a toast notification
        return redirect()->route('issues.index')->with('success', 'Issue created successfully.');
    }

    // Method to display a list of issues
    public function index()
    {
        $userId = Auth::id();
        $userRole = Auth::user()->role; 
    
        if ($userRole == 'Admin') {
            $issues = Issue::where('status', '<>', 'End')->paginate(5);
        } else {
            $issues = Issue::where('created_by', $userId)
                           ->where('status', '<>', 'End')
                           ->paginate(5);
        }
    
        return view('issues.index', compact('issues'));
    }

    // Method to display the form for creating a new issue
    public function create()
    {
        return view('issues.create');
    }

    // Method to display issue details
    public function show(Issue $issue)
    {
        // Fetch the creator of the issue
        $creator = $issue->creator;
    
        // Fetch the first user with the role of 'Admin'
        $admin = User::where('role', 'admin')->first();
    
        // Fetch existing participants attached to this issue
        $participants = $issue->participants->map(function ($participant) {
            return [
                'name' => $participant->name,
                'email' => $participant->email,
                'role' => $participant->pivot->role ?? 'Participant' // Assuming a pivot 'role' field if it exists
            ];
        })->toArray();
    
        // Add the creator and admin to the list of participants (if they are not already included)
        $participants[] = [
            'name' => $creator ? $creator->name : 'Unknown Creator',
            'email' => $creator ? $creator->email : 'unknown@example.com',
            'role' => 'Creator'
        ];
    
        $participants[] = [
            'name' => $admin ? $admin->name : 'Unknown Admin',
            'email' => $admin ? $admin->email : 'unknown@example.com',
            'role' => 'Admin'
        ];
    
        // Fetch all users for participant selection in the view
        $users = User::all();
    
        return view('issues.show', compact('issue', 'participants', 'users'));
    }
    

    // Method to display the form for editing an issue
    public function edit(Issue $issue)
    {
        return view('issues.edit', compact('issue'));
    }

    // Method to update issue data
    public function update(Request $request, Issue $issue)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('attachment')) {
            $fileName = time() . '_' . $request->file('attachment')->getClientOriginalName();
            $filePath = $request->file('attachment')->storeAs('uploads', $fileName, 'public');
            $validatedData['attachment'] = '/storage/' . $filePath;
        }

        $issue->update($validatedData);

        return redirect()->route('issues.index')->with('success', 'Issue updated successfully.');
    }

    // Method to "delete" issue data by setting its status to "End"
    public function destroy(Issue $issue)
    {
        // Instead of deleting, update the status to 'End'
        $issue->status = 'End';
        $issue->save();

        return redirect()->route('issues.index')->with('success', 'Issue status updated to "End" successfully.');
    }

    // Method to update issue status
    public function updateStatus(Request $request, $id)
    {
        $issue = Issue::findOrFail($id);
        $request->validate(['status' => 'required|in:Active,InProgress,End']);
        $issue->status = $request->input('status');
        $issue->save();

        return redirect()->route('issues.show', $id)->with('success', 'Status updated successfully!');
    }

    // Method to display all issues, including those with the status 'End'
    public function report()
    {
        // Get all issues, including those with status 'End'
        $issues = Issue::all();
        return view('issues.report', compact('issues'));
    }
    // In App\Http\Controllers\IssueController.php

public function addParticipant(Request $request, Issue $issue)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
    ]);

    // Check if the user is already a participant
    if (!$issue->participants->contains($request->user_id)) {
        // Attach the user to the issue
        $issue->participants()->attach($request->user_id);
    }

    return redirect()->route('issues.show', $issue->id)->with('success', 'Participant added successfully.');
}

}
