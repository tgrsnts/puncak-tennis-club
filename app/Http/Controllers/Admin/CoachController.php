<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CoachController extends Controller
{
    public function index()
    {
        $coach = Coach::all();
        return view('admin.coach.index', [
            'data' => $coach
        ]);
    }

    public function create()
    {
        return view('admin.coach.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'nullable|string|max:255',
            'photo_url' => 'nullable|url|max:255',
        ]);


        $path = null;

        if ($request->hasFile('photo_url')) {
            $path = $request->file('photo_url')->store('coach-photos', 'public');
        }

        Coach::create([
            'name' => $validated['name'],
            'specialty' => $validated['specialty'],
            'photo_url' => $path,
        ]);

        return redirect()->route('admin.coach.index', app()->getLocale())
            ->with('success', 'Coach created successfully.');
    }

    public function edit($locale, $id)
    {
        $coach = Coach::findOrFail($id);
        return view('admin.coach.edit', [
            'coach' => $coach
        ]);
    }

    public function update(Request $request, $locale, $id)
    {
        $coach = Coach::findOrFail($id);

        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'specialty' => ['required', 'in:Beginner,Intermediate,Advanced'],
            'photo_url'     => ['nullable', 'image', 'max:2048'],
        ]);

        $coach->name      = $validated['name'];
        $coach->specialty = $validated['specialty'];

        if ($request->hasFile('photo_url')) {
            // hapus foto lama kalau ada
            if ($coach->photo_url && Storage::disk('public')->exists($coach->photo_url)) {
                Storage::disk('public')->delete($coach->photo_url);
            }

            $path = $request->file('photo_url')->store('coach-photos', 'public');
            $coach->photo_url = $path;
        }

        $coach->save();

        return redirect()->route('admin.coach.index', app()->getLocale())
            ->with('success', 'Coach updated successfully.');
    }

    public function destroy($id)
    {
        $coach = Coach::findOrFail($id);
        $coach->delete();

        return redirect()->route('admin.coach.index', app()->getLocale())
            ->with('success', 'Coach deleted successfully.');
    }
}
