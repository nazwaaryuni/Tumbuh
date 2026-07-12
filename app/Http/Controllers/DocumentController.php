<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        Gate::authorize('view-documents');

        $documents = Document::latest()->get();
        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        Gate::authorize('manage-documents');
        return view('documents.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('manage-documents');

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,png|max:10240',
        ]);

        $fileUrl = $request->file('file')->store('documents', 'public');

        Document::create([
            'title' => $request->title,
            'type' => $request->type,
            'file_url' => $fileUrl,
        ]);

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diunggah.');
    }

    public function edit(Document $document)
    {
        Gate::authorize('manage-documents');
        return view('documents.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        Gate::authorize('manage-documents');

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,png|max:10240',
        ]);

        $data = $request->only('title', 'type');

        if ($request->hasFile('file')) {
            if ($document->file_url) {
                Storage::disk('public')->delete($document->file_url);
            }
            $data['file_url'] = $request->file('file')->store('documents', 'public');
        }

        $document->update($data);

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Document $document)
    {
        Gate::authorize('manage-documents');

        if ($document->file_url) {
            Storage::disk('public')->delete($document->file_url);
        }

        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}
