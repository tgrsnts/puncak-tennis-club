<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\File;

class GalleryVideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->paginate(9);
        return view('admin.gallery-video.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.gallery-video.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'video' => ['required', 'file', 'mimes:mp4,mov,avi,mkv,webm', 'max:204800'], // 200MB
        ]);

        // Store video file in public/videos directory
        if ($request->hasFile('video')) {
            // Ensure the videos directory exists
            File::ensureDirectoryExists(public_path('videos'));
            
            $videoFile = $request->file('video');
            $filename = time() . '_' . $videoFile->getClientOriginalName();
            
            // Move file to public/videos directory
            $videoFile->move(public_path('videos'), $filename);
            
            $data['video_path'] = 'videos/' . $filename;
            $data['type'] = 'local';
        }

        Video::create($data);

        return redirect()->route('admin.gallery-video.index', app()->getLocale())
            ->with('success', 'Video berhasil dibuat.');
    }

    public function edit($locale, Video $video)
    {
        return view('admin.gallery-video.edit', compact('video'));
    }

    public function update(Request $request, $locale, Video $video)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'video' => ['sometimes', 'file', 'mimes:mp4,mov,avi,mkv,webm', 'max:204800'],
        ]);

        // Update video file if provided
        if ($request->hasFile('video')) {
            // Delete old video file
            if ($video->video_path && File::exists(public_path($video->video_path))) {
                File::delete(public_path($video->video_path));
            }
            
            // Ensure the videos directory exists
            File::ensureDirectoryExists(public_path('videos'));
            
            $videoFile = $request->file('video');
            $filename = time() . '_' . $videoFile->getClientOriginalName();
            
            // Move file to public/videos directory
            $videoFile->move(public_path('videos'), $filename);
            
            $data['video_path'] = 'videos/' . $filename;
            $data['type'] = 'local';
        }

        $video->update($data);

        return redirect()->route('admin.gallery-video.index', app()->getLocale())
            ->with('success', 'Video berhasil diperbarui.');
    }

    public function destroy($locale, Video $video)
    {
        // Delete video file from public/videos
        if ($video->video_path && File::exists(public_path($video->video_path))) {
            File::delete(public_path($video->video_path));
        }

        $video->delete();

        if (request()->expectsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Video berhasil dihapus.'
            ]);
        }

        return redirect()->route('admin.gallery-video.index', app()->getLocale())
            ->with('success', 'Video berhasil dihapus.');
    }
}