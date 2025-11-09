<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,gif', 'max:2048'],
        ]);

        $path = $request->file('file')->store('uploads', 'public');

        // kalau dipakai Trix, biasanya butuh url file-nya
        return response()->json([
            'url' => asset('storage/' . $path),
            'path' => $path,
        ]);
    }
}
