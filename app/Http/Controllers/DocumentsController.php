<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DocumentsController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::with('division');

        if ($request->has('division_id') && $request->division_id) {
            $query->where('division_id', $request->division_id);
        }

        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $documents = $query->get();
        $divisions = Division::all();

        return view('dashboard.pages.resources.pages.documents', compact('documents', 'divisions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'division_id' => 'required|exists:divisions,id',
            'file' => 'required|file|mimes:pdf,doc,docx',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $filePath = $request->file('file')->store('documents', 'public');

        Document::create([
            'title' => $request->input('title'),
            'division_id' => $request->input('division_id'),
            'file' => $filePath,
            'created_by' => Auth::user()->name  
        ]);

        toastr()->success('Document berhasil ditambahkan');

        return redirect()->route('dashboard.document');
    }

    public function update(Request $request, Document $document)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'division_id' => 'required|exists:divisions,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $document->title = $request->input('title');
        $document->division_id = $request->input('division_id');

        if ($request->hasFile('file')) {
            if ($document->file) {
                Storage::disk('public')->delete($document->file);
            }

            $filePath = $request->file('file')->store('documents', 'public');
            $document->file = $filePath;
        }

        $document->save();
        toastr()->success('Document berhasil di update!');

        return redirect()->route('dashboard.document');
    }

    public function destroy(Document $document)
    {
        if ($document->file) {
            Storage::disk('public')->delete($document->file);
        }

        $document->delete();
        toastr()->success('Document berhasil dihapus!');

        return redirect()->route('dashboard.document');
    }
}
