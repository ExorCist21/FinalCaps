<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    // Display the content management page
    public function index()
    {
        $contents = Content::all(); // Fetch all content
        return view('admin.contentmng', compact('contents'));
    }

    // Store new content
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'required|url',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Handle the image upload (if any)
        $imagePath = $request->file('image_path') ? $request->file('image_path')->store('images', 'public') : null;

        // Create the new content
        Content::create([
            'creatorID' => $request->creatorID,
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.contentmng')->with('success', 'Content created successfully!');
    }

    public function destroy($content_id)
    {
        $content = Content::findOrFail($content_id);
        $content->delete();

        return redirect()->route('admin.contentmng')->with('success', 'Content deleted successfully!');
    }

    public function edit($content_id)
    {
        $content = Content::findOrFail($content_id);
        return view('admin.edit-content', compact('content'));
    }

    public function update(Request $request, $content_id)
    {
        // Validate the incoming request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'required|url',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Fetch the content
        $content = Content::findOrFail($content_id);

        // Handle image upload if a new image is provided
        if ($request->hasFile('image_path')) {
            // Delete the old image if it exists
            if ($content->image_path && Storage::exists($content->image_path)) {
                Storage::delete($content->image_path);
            }
            // Store the new image
            $imagePath = $request->file('image_path')->store('images', 'public');
        } else {
            $imagePath = $content->image_path; // Keep the old image
        }

        // Update the content
        $content->update([
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.contentmng')->with('success', 'Content updated successfully!');
    }

}
