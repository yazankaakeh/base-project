<?php

namespace Modules\Theme\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TinyMCEUploadController extends Controller
{
    /**
     * Handle image upload for TinyMCE
     */
    public function uploadImage(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                // Generate unique filename
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

                // Store in public/uploads/tinymce directory
                $path = $file->storeAs('uploads/tinymce', $filename, 'public');

                // Get the public URL
                $url = Storage::disk('public')->url($path);

                return response()->json([
                    'location' => $url,
                ]);
            }

            return response()->json(['error' => 'No file uploaded'], 400);
        } catch (Exception $e) {
            return response()->json(['error' => 'Upload failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Handle multiple image uploads
     */
    public function uploadImages(Request $request): JsonResponse
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        try {
            $uploadedFiles = [];

            foreach ($request->file('files') as $file) {
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('uploads/tinymce', $filename, 'public');
                $url = Storage::disk('public')->url($path);

                $uploadedFiles[] = [
                    'location' => $url,
                    'name' => $filename,
                ];
            }

            return response()->json($uploadedFiles);
        } catch (Exception $e) {
            return response()->json(['error' => 'Upload failed: ' . $e->getMessage()], 500);
        }
    }
}
