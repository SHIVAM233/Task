<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    public function index()
    {
        $randomKey = Str::random(20);
        $data = Banner::all();
        return view('view', compact('randomKey', 'data'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_url' => 'nullable|url',
            'image_text' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            try {
                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads'), $imageName);
                
                Banner::create([
                    'image_path' => $imageName,
                    'key' => $request->key,
                    'image_url' => $request->image_url,
                    'image_text' => $request->image_text,
                ]);

                return back()->with('success', 'Image uploaded successfully!')->with('image', $imageName);
            } catch (\Exception $e) {
                \Log::error('Error uploading image: ' . $e->getMessage());
                return back()->with('error', 'There was an error uploading the image: ' . $e->getMessage());
            }
        }

        return back()->with('error', 'No image selected');
    }

    public function destroy($id)
    {
        $image = Banner::findOrFail($id);
    
        $imagePath = public_path('uploads/' . $image->image_name);
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }
        $image->delete();
    
        return back()->with('success', 'Image deleted successfully!');
    }

    public function getBanner(Request $request)
    {
        $key = $request->key ?? '';

        $banner = Banner::where('key', '=', $key)->first();
        
        if (!$banner) {
            return response()->json(['error' => 'UnAuthorization'], 401);
        }
        $fullImageUrl = url('uploads/' . $banner->image_path);

        return response()->json([
            'imageUrl' => $fullImageUrl,
            'link' => $banner->image_url,
            'altText' => $banner->image_text,
        ]);
    }
}
