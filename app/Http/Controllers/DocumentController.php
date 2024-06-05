<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function destroy(Document $document)
    {
        $document->delete();

        return back()->with('status', 'Document removed successfully.');
    }
}
