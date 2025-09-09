<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Publication::all();
    }

    /**
     * Display the specified resource.
     */
    public function show(Publication $publication)
    {
        return $publication;
    }

    /**
     * Download the specified resource.
     */
    public function download($id)
    {
        $publication = Publication::findOrFail($id);
        return Storage::disk('public')->download($publication->file_path, $publication->title . '.pdf');
    }
}