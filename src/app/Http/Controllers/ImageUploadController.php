<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ImageUploadController extends Controller
{
    public function showUploadForm()
    {
        return view('upload');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/images', $imageName);

        return back()
            ->with('success', 'Image uploaded successfully.')
            ->with('image', $imageName);
    }
}
