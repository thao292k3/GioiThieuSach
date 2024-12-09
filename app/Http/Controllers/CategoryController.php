<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::orderBy('category_id', 'asc')->paginate(6);

        return view('category.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1', // 0 or 1 for draft or published
            'description' => 'nullable|string|max:255',
        ];

        $messages = [
            'name.required' => 'Tên thể loại là bắt buộc.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'description.max' => 'Mô tả không được vượt quá 255 ký tự.',
        ];

        $request->validate($rules, $messages);

        // Lưu thể loại sách vào cơ sở dữ liệu
        Category::create([
            'name' => $request->name,
            'status' => $request->status,
            'description' => $request->description,
            'parent_id' => $request->parent_id ?? null,
        ]);

        return redirect()->route('category.index')->with('success', 'Thể loại sách đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($category_id)
    {
        $category = Category::findOrFail($category_id);
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
            'description' => 'nullable|string|max:255',
        ];

        $messages = [
            'name.required' => 'Tên thể loại là bắt buộc.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'description.max' => 'Mô tả không được vượt quá 255 ký tự.',
        ];

        $request->validate($rules, $messages);

        $category->update([
            'name' => $request->name,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return redirect()->route('category.index')->with('success', 'Thể loại sách đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($category_id)
    {
        $category = Category::findOrFail($category_id);

        if ($category->books()->count() == 0) {
            $category->delete();
            return redirect()->route('category.index')->with('success', 'Category deleted successfully!');
        }

        return redirect()->route('category.index')->with('error', 'Category cannot be deleted because it has books.');
    }
}
