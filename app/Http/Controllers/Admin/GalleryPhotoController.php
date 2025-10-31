<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GalleryPhotoController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->paginate(9);
        return view('admin.gallery-photo.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.gallery-photo.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'img' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:2048'],
        ]);

        if ($request->hasFile('img')) {
            File::ensureDirectoryExists(public_path('gallery'));
            $file = $request->file('img');
            $filename = now()->format('YmdHis') . '-' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('gallery'), $filename);
            $data['img'] = 'gallery/' . $filename;
        }

        $gallery = Gallery::create($data);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Gallery item berhasil dibuat.',
                'data' => $gallery
            ], 201);
        }

        return redirect()->route('admin.gallery-photo.index', app()->getLocale())
            ->with('success', 'Gallery item berhasil dibuat.');
    }

    public function edit($locale, $gallery)
    {
        $gallery = Gallery::findOrFail($gallery);
        return view('admin.gallery-photo.edit', compact('gallery'));
    }

    public function update(Request $request, $locale, $gallery)
    {
        $gallery = Gallery::findOrFail($gallery);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'img' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:2048'],
        ]);

        if ($request->hasFile('img')) {
            // hapus file lama jika ada
            if ($gallery->img && File::exists(public_path($gallery->img))) {
                File::delete(public_path($gallery->img));
            }

            File::ensureDirectoryExists(public_path('gallery'));
            $file = $request->file('img');
            $filename = now()->format('YmdHis') . '-' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('gallery'), $filename);
            $data['img'] = 'gallery/' . $filename;
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery-photo.index', app()->getLocale())
            ->with('success', 'Gallery item berhasil diperbarui.');
    }

    public function destroy($locale, $gallery)
    {
        \Log::info('DELETE request received', [
            'locale' => $locale,
            'gallery_id' => $gallery
        ]);

        $gallery = Gallery::find($gallery);

        if (!$gallery) {
            \Log::warning('Gallery not found for ID: ' . $gallery);

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Photo tidak ditemukan'
                ], 200);
            }

            return redirect()->route('admin.gallery-photo.index', app()->getLocale())
                ->with('error', 'Gallery item tidak ditemukan.');
        }

        \Log::info('Found gallery:', [
            'id' => $gallery->id,
            'title' => $gallery->title,
            'img' => $gallery->img
        ]);

        // Delete image file if exists
        if ($gallery->img) {
            $imagePath = public_path($gallery->img);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
                \Log::info('Image file deleted: ' . $imagePath);
            }
        }

        // Delete the gallery record
        $gallery->delete();

        if (request()->expectsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Photo berhasil dihapus'
            ]);
        }

        return redirect()->route('admin.gallery-photo.index', app()->getLocale())
            ->with('success', 'Gallery item berhasil dihapus.');
    }
}