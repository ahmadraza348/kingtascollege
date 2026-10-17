<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GalleryController extends Controller
{
    /** Folder (inside /public) where gallery images are stored. */
    private const FOLDER = 'uploads/gallery';

    public function index(): View
    {
        $images = GalleryImage::latest()->get();

        return view('backend.gallery.index', compact('images'));
    }

    /** Upload one or many images at once. */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'images'   => ['required', 'array', 'max:20'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'], // 5 MB each
            'title'    => ['nullable', 'string', 'max:150'],
        ], [
            'images.required' => 'Please choose at least one image.',
            'images.max'      => 'You can upload up to 20 images at a time.',
            'images.*.image'  => 'Each file must be an image.',
            'images.*.mimes'  => 'Only JPG, PNG or WEBP images are allowed.',
            'images.*.max'    => 'Each image must be smaller than 5 MB.',
        ]);

        $folder = public_path(self::FOLDER);
        File::ensureDirectoryExists($folder);

        $count = 0;
        foreach ($request->file('images') as $file) {
            $name = Str::uuid() . '.' . $file->extension();
            $file->move($folder, $name);

            GalleryImage::create([
                'title'      => $request->input('title') ?: null,
                'image_path' => self::FOLDER . '/' . $name,
            ]);
            $count++;
        }

        toastr()->success($count . ' ' . Str::plural('image', $count) . ' added to the gallery.');

        return redirect()->route('gallery.index');
    }

    public function destroy(GalleryImage $gallery): RedirectResponse
    {
        $file = public_path($gallery->image_path);
        if (is_file($file)) {
            @unlink($file);
        }

        $gallery->delete();

        toastr()->success('Image deleted.');

        return redirect()->route('gallery.index');
    }
}
