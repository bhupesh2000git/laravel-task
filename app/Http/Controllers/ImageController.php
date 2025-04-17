<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;


class ImageController extends Controller
{
    public function index()
    {
        $images = DB::table('images')->get();

        return view('images.index', compact('images'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'orientation' => 'required|in:portrait,landscape',
        ]);

        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $path = $img->store('image', 'public');

            DB::table('images')->insert([
                'filename' => $path,
                'orientation' => $request->orientation,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return redirect()->route('indeximage')->with('success', 'Image uploaded successfully!');
    }

    public function clear(Request $request)
    {
        DB::table('images')->truncate();

        Storage::disk('public')->deleteDirectory('image');

        return redirect()->route('indeximage')
            ->with('success', 'All images have been cleared.');
    }
}
