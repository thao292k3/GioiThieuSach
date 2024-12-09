<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Models\Category;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Blog::orderBy('blog_id', 'asc')->paginate(6); // Lấy danh sách bài viết
        return view('blog.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all(); // Lấy danh sách danh mục
        return view('blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:100',
            'content' => 'required',
            'image_path' => 'nullable|image|max:2048',
            'status' => 'required|in:pending,approved',
            'category_id' => 'required|exists:categories,category_id',
        ]);

        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->storeAs('uploads', $request->file('image_path')->getClientOriginalName(), 'public');
            $validated['image_path'] = "storage/uploads/" . $request->file('image_path')->getClientOriginalName();
        }



        Blog::create($validated); // Lưu bài viết vào cơ sở dữ liệu

        return redirect()->route('blog.index')->with('success', 'Bài viết đã được tạo.');
    }

    /**
     * Display the specified resource.
     */
    public function show($blog_id)
    {
        $blog = Blog::findOrFail($blog_id); // Tìm bài viết
        return view('blog.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $blog = Blog::findOrFail($id); // Tìm bài viết
        $categories = Category::all(); // Lấy danh sách danh mục
        return view('blog.edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:100',
            'content' => 'required',
            'image_path' => 'nullable|image|max:2048',
            'status' => 'required|in:pending,approved',
            'category_id' => 'required|exists:categories,category_id',
        ]);

        $blog = Blog::findOrFail($id);

        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('images', 'public');
            $validated['image_path'] = $imagePath;
        }

        $blog->update($validated); // Cập nhật bài viết

        return redirect()->route('blog.index')->with('success', 'Cập nhật bài viết thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id); // Tìm bài viết
        $blog->delete(); // Xóa bài viết
        return redirect()->route('blog.index')->with('success', 'Bài viết đã được xóa.');
    }
}
