<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentsController extends Controller {

    public function index() {
        $pageTitle  = 'All Loan Documents';
        $documents  = Document::orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.documents.index', compact('pageTitle', 'documents'));
    }

    public function store(Request $request, $id = 0) {
        $request->validate([
            'name'        => 'required|string|unique:documents,name,' . $id,
            'description' => 'required|string',
            'file'        => $id ? 'nullable|file|mimes:pdf,doc,docx' : 'required|file|mimes:pdf,doc,docx',
        ]);

        if ($id) {
            $document     = Document::findOrFail($id);
            $notification = 'Document updated successfully';
        } else {
            $document     = new Document();
            $notification = 'Document added successfully';
        }

        $document->name        = $request->name;
        $document->description = $request->description;

        if ($request->hasFile('file')) {
            $path = 'assets/documents';
            try {
                $filePath = fileUploader($request->file, $path);
                $document->file_path = $filePath;
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the file'];
                return back()->withNotify($notify);
            }
        }

        $document->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function status($id) {
        $document = Document::findOrFail($id);
        $document->status = !$document->status;
        $document->save();

        $notify[] = ['success', 'Document status updated successfully'];
        return back()->withNotify($notify);
    }
}
