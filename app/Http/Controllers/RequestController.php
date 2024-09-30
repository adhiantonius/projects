<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request as HttpRequest;
use App\Models\Request as RequestModel;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    // Create request form
    public function create()
    {
        // Fetch employees from db
        $employees = DB::select("SELECT employeeName, DepartmentName FROM mmEmployee");
        return view('request.create', ['employees' => $employees]);
    }

    // Store new request
    public function store(HttpRequest $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'department' => 'required',
            'subject' => 'required',
            'purpose' => 'required',
            'manager_engineer' => 'required',
            'date' => 'required|date',
            'priority' => 'required|in:Low,Medium,High',
            'attachments.*' => 'file|mimes:xlsx,xls,csv,jpg,png,pdf,doc,docx|max:2048', // Validasi file
        ]);
    
        // Proses penyimpanan file
        if ($request->hasFile('attachments')) {
            $attachmentNames = [];
            foreach ($request->file('attachments') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');
                $attachmentNames[] = $filePath; // Simpan jalur file
            }
            $validatedData['attachments'] = implode(',', $attachmentNames);
        }
    
       
        $validatedData['status'] = 'Aktif';
        
        // Simpan data
        RequestModel::create($validatedData);
    
        // Redirect dengan pesan sukses
        return redirect()->route('request.index')->with('success', 'Request successfully created!');
    }
    

    
public function index()
{
    // Get all requests with pagination, limit to 5 per page
    $requests = RequestModel::paginate(5); 

    // Pass the paginated data to the view
    return view('request.index', compact('requests'));
}


    // Show a single request
    public function show($id)
    {
        $request = RequestModel::findOrFail($id);
        return view('request.show', compact('request'));
    }

    // Edit request status
    public function updateStatus(HttpRequest $request, $id)
    {
        $requestModel = RequestModel::findOrFail($id);
        $requestModel->status = $request->input('status');
        $requestModel->save();
    
        return redirect()->route('request.show', $id)->with('success', 'Status updated successfully!');
    }
    
    // Update request
    public function update(HttpRequest $request, $id)
    {
        // Validate data
        $validatedData = $request->validate([
            'department' => 'required',
            'subject' => 'required',
            'purpose' => 'required',
            'manager_engineer' => 'required',
            'priority'=> 'required|in:Low,Medium,High',
            'date' => 'required|date',
            'attachments.*' => 'file|mimes:jpg,png,pdf,doc,docx|max:2048', 
        ]);

        // Find the request
        $requestModel = RequestModel::findOrFail($id);

        // Handle file upload
        if ($request->hasFile('attachments')) {
            $attachmentNames = [];
            foreach ($request->file('attachments') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');
                $attachmentNames[] = $filePath; // Simpan nama/jalur file
            }
            // Gabungkan nama file menjadi string terpisah dengan koma
            $validatedData['attachments'] = implode(',', $attachmentNames);
        }

        // Update request
        $requestModel->update($validatedData);

        // Redirect with success message
        return redirect()->route('request.show', $requestModel->id)->with('success', 'Request updated successfully!');
    }

    // Delete request
    public function destroy($id)
    {
        $request = RequestModel::findOrFail($id);

        // Delete the request
        $request->delete();

        return redirect()->route('request.index')->with('success', 'Request deleted successfully!');
    }
}
