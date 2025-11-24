<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::latest()->paginate(24);
        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request)
    {
        $request->validate(['file' => 'required|image|max:5120']);
        $file = $request->file('file');
        $path = $file->store('media', 'public');

        $media = Media::create([
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'url'  => asset('storage/' . $path),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'uploaded_by' => auth()->id(),
        ]);

        return response()->json(['url' => $media->url]);
    }

   public function destroy(Request $request)
    {
        $request->validate(['id' => 'required|exists:media,id']);
        $media = Media::findOrFail($request->id);

        if (file_exists(public_path($media->path))) {
            @unlink(public_path($media->path));
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
            ->paginate(48); // по 48 на страница – красиво и бързо

        return view('admin.media.modal', compact('media', 'search'));
    }
}
