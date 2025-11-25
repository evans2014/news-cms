<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::latest()->paginate(24);
        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $file = $request->file('file');

        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension    = $file->getClientOriginalExtension();

        $baseName = preg_replace('/[^a-zA-Zа-яА-Я0-9_-]/u', '-', $originalName);
        $baseName = preg_replace('/-+/', '-', $baseName);
        $baseName = trim($baseName, '-');
        if (empty($baseName)) $baseName = 'image';

        $finalName = $baseName;
        $counter   = 1;

        while (Storage::disk('public')->exists("media/{$finalName}.{$extension}")) {
            $finalName = $baseName . '-' . $counter;
            $counter++;
        }

        $fileName = $finalName . '.' . $extension;

        $path = $file->storeAs('media', $fileName, 'public');

        $media = Media::create([
            'name'        => $file->getClientOriginalName(), // оригиналното име за показване
            'path'        => $path,
            'url'         => asset('storage/' . $path),
            'mime_type'   => $file->getMimeType(),
            'size'        => $file->getSize(),
            'uploaded_by' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'url'     => $media->url,
            'id'      => $media->id,
        ]);
    }

    private function storeImageWithOriginalName($file, $folder = 'news')
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension    = $file->getClientOriginalExtension();

        $baseName = preg_replace('/[^a-zA-Z0-9_-]/', '-', $originalName);
        $baseName = preg_replace('/-+/', '-', $baseName);
        $baseName = trim($baseName, '-');
        if (empty($baseName)) $baseName = 'image';

        $finalName = $baseName;
        $counter   = 1;

        while (Storage::disk('public')->exists("{$folder}/{$finalName}.{$extension}")) {
            $finalName = $baseName . '-' . $counter;
            $counter++;
        }

        $fileName = $finalName . '.' . $extension;

        $path = $file->storeAs($folder, $fileName, 'public');

        return asset('storage/' . $path);
    }

    public function destroy(Media $media)
    {

        if ($media->path && Storage::disk('public')->exists($media->path)) {
            Storage::disk('public')->delete($media->path);
        }
        $media->delete();

        return response()->json(['success' => true]);
    }

    public function modal(Request $request)
    {
        $search = $request->get('search', '');
        $media = Media::latest()
            ->when($search, function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->paginate(24); // по 48 на страница – красиво и бързо

        return view('admin.media.modal', compact('media', 'search'));
    }
}
