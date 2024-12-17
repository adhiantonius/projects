<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as HttpRequest;
use App\Models\Request as RequestModel; // Alias the Request model to avoid conflicts
use App\Models\User;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    public function create()
    {
        $employees = DB::select("SELECT employeeName FROM mmEmployee");
        $departments = DB::select("SELECT DISTINCT DepartmentName FROM mmEmployee");
        return view('request.create', [
            'employees' => $employees,
            'departments' => $departments,
        ]);
    }

    public function store(HttpRequest $request)
    {
        $validatedData = $request->validate([
            'department' => 'required',
            'subject' => 'required',
            'purpose' => 'required',
            'manager_engineer' => 'required',
            'date' => 'required|date',
            'priority' => 'required|in:Low,Medium,High',
            'attachments.*' => 'file|mimes:xlsx,xls,csv,jpg,png,pdf,doc,docx|max:2048',
        ]);

        // Handle attachments if present
        if ($request->hasFile('attachments')) {
            $attachmentNames = [];
            foreach ($request->file('attachments') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');
                $attachmentNames[] = $filePath;
            }
            $validatedData['attachments'] = implode(',', $attachmentNames);
        }

        $validatedData['status'] = 'Active';
        $validatedData['created_by'] = Auth::id();

        $requestModel = RequestModel::create($validatedData);

        return redirect()->route('request.index')->with('success', 'Request successfully created!');
    }

    public function index()
    {
        $userId = Auth::id();
        $userRole = Auth::user()->role;

        $requests = $userRole === 'Admin'
            ? RequestModel::where('status', '<>', 'END')->paginate(5)
            : RequestModel::where('created_by', $userId)->where('status', '<>', 'END')->paginate(5);

        return view('request.index', compact('requests'));
    }

    public function show($id)
    {
        $request = RequestModel::with('participants')->findOrFail($id);
    
        \Log::info($request->participants); // Log the participants data for debugging
    
        $creator = User::find($request->created_by);
        $admin = User::where('role', 'Admin')->first();
    
        // Ensure participants is never null
        $participants = $request->participants ? $request->participants->map(function ($participant) {
            return [
                'name' => $participant->name,
                'email' => $participant->email,
                'role' => 'Participant'
            ];
        })->toArray() : [];
    
        // Add creator and admin if they’re not already in participants
        if ($creator && !in_array($creator->email, array_column($participants, 'email'))) {
            $participants[] = [
                'name' => $creator->name,
                'email' => $creator->email,
                'role' => 'Creator',
            ];
        }
    
        if ($admin && !in_array($admin->email, array_column($participants, 'email'))) {
            $participants[] = [
                'name' => $admin->name,
                'email' => $admin->email,
                'role' => 'Admin',
            ];
        }
    
        $users = User::all();
    
        return view('request.show', compact('request', 'participants', 'users'));
    }
    
    


    public function updateStatus(HttpRequest $request, $id)
    {
        $requestModel = RequestModel::findOrFail($id);
        $requestModel->status = $request->input('status');
        $requestModel->save();

        return redirect()->route('request.show', $id)->with('success', 'Status updated successfully!');
    }

    public function update(HttpRequest $request, $id)
    {
        $validatedData = $request->validate([
            'department' => 'required',
            'subject' => 'required',
            'purpose' => 'required',
            'manager_engineer' => 'required',
            'priority' => 'required|in:Low,Medium,High',
            'date' => 'required|date',
            'attachments.*' => 'file|mimes:jpg,png,pdf,doc,docx|max:2048',
        ]);

        $requestModel = RequestModel::findOrFail($id);

        if ($request->hasFile('attachments')) {
            $attachmentNames = [];
            foreach ($request->file('attachments') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');
                $attachmentNames[] = $filePath;
            }
            $validatedData['attachments'] = implode(',', $attachmentNames);
        }

        $requestModel->update($validatedData);

        return redirect()->route('request.show', $requestModel->id)->with('success', 'Request updated successfully!');
    }

    public function destroy($id)
    {
        $request = RequestModel::findOrFail($id);

        if ($request->priority === 'END') {
            $request->status = 'END';
            $request->save();
            return redirect()->route('request.index')->with('success', 'Request status updated to END successfully!');
        }

        $request->delete();
        return redirect()->route('request.index')->with('success', 'Request deleted successfully!');
    }

    public function report()
    {
        $requests = RequestModel::all();
        return view('request.report', compact('requests'));
    }
    
    public function addParticipant(HttpRequest $httpRequest, $requestId)
    {
        $httpRequest->validate([
            'user_id' => 'required|exists:users,id',
        ]);
    
        $requestModel = RequestModel::findOrFail($requestId);
    
        // Check if the user is already a participant
        if (!$requestModel->participants->contains($httpRequest->user_id)) {
            $requestModel->participants()->attach($httpRequest->user_id);
        }
    
        return redirect()->route('request.show', $requestId)->with('success', 'Participant added successfully');
    }
    
}