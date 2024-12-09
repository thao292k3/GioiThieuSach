<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{


    public function uploadImage(Request $request)
    {
        // Kiểm tra xem có file hay không
        if ($request->hasFile('upload')) {
            // Validate ảnh
            $request->validate([
                'upload' => 'required|image|mimes:jpg,jpeg,png,gif|max:10240',  // 10MB
            ]);


            // Lưu ảnh vào thư mục public/images
            $image = $request->file('upload');
            $path = $image->store('public/images');

            // Trả về URL của ảnh đã tải lên
            return response()->json([
                'url' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        //
    }
}
