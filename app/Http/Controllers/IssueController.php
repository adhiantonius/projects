<?php
namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    // Method untuk menyimpan data issue baru
    public function store(Request $request)
    {
        // Validasi data yang dikirim dari form
        $validatedData = $request->validate([
            'date' => 'required|date',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high', // Validate priority
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // contoh validasi file
        ]);
    
        // Simpan file attachment jika ada
        if ($request->hasFile('attachment')) {
            $fileName = time() . '_' . $request->file('attachment')->getClientOriginalName();
            $filePath = $request->file('attachment')->storeAs('uploads', $fileName, 'public');
            $validatedData['attachment'] = '/storage/' . $filePath;
        }
    
        // Simpan data issue ke database
        $validatedData['status'] = 'Active';
    
        // Create a new issue using the Issue model
        Issue::create($validatedData);
    
        // Redirect ke halaman lain setelah berhasil menyimpan
        return redirect()->route('issues.index')->with('success', 'Issue created successfully.');
    }
    

    // Method index untuk menampilkan daftar issues
    public function index()
    {
        $issues = Issue::paginate(5);
        return view('issues.index', compact('issues'));
    }
    

    // Method create untuk menampilkan form pembuatan issue baru
    public function create()
    {
        return view('issues.create');
    }

    // Method show untuk menampilkan detail issue
    public function show(Issue $issue)
    {
        return view('issues.show', compact('issue'));
    }

    // Method edit untuk menampilkan form edit issue
    public function edit(Issue $issue)
    {
        return view('issues.edit', compact('issue'));
    }

    // Method update untuk memperbarui data issue
    public function update(Request $request, Issue $issue)
    {
        // Validasi data yang dikirim dari form
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

        // Update data issue di database
        $issue->update($validatedData);

        
        return redirect()->route('issues.index')->with('success', 'Issue updated successfully.');
    }

    // Method destroy untuk menghapus data issue
    public function destroy(Issue $issue)
    {
        // Hapus data issue dari database
        $issue->delete();

        // Redirect ke halaman lain setelah berhasil menghapus
        return redirect()->route('issues.index')->with('success', 'Issue deleted successfully.');
    }


    
public function updateStatus(Request $request, $id)
{
    $issue = Issue::findOrFail($id);

    // Validasi status yang masuk agar tidak ada nilai yang tidak diharapkan
    $request->validate([
        'status' => 'required|in:Active,InProgress,End',
    ]);

    $issue->status = $request->input('status');
    $issue->save();

    return redirect()->route('issues.show', $id)->with('success', 'Status updated successfully!');

}
}
