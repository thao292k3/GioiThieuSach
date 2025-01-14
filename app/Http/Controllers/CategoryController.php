<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\UpdateCategoryRequest;
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

    public function create()
    {
        // Kiểm tra xem có danh mục cha nào chưa


        $data = Category::whereNull('parent_id')->get();
        $category = new Category();

        return view('category.create', compact('data', 'category'));
    }



    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
            'description' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:categories,category_id',
        ]);

        // Kiểm tra danh mục đã tồn tại chưa
        if (Category::where('name', $validated['name'])->exists()) {
            return redirect()->back()
                ->with('error', 'Danh mục này đã tồn tại. Vui lòng chọn tên khác.');
        }

        try {
            // Tạo danh mục mới
            Category::create($validated);
            return redirect()->route('category.index')
                ->with('success', 'Thể loại sách đã được thêm thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Đã xảy ra lỗi trong quá trình thêm thể loại.');
        }
    }


    public function edit($category_id)
    {
        $data = Category::all(); // Danh sách các danh mục
        $category = Category::findOrFail($category_id); // Danh mục hiện tại
        return view('category.edit', compact('category', 'data'));
    }


    public function update(UpdateCategoryRequest $request, Category $category)
    {
        // Kiểm tra nếu danh mục cha trùng với chính nó
        if ($request->parent_id == $category->category_id) {
            return redirect()->back()->with('error', 'Danh mục cha không thể trùng với chính nó.');
        }

        // Kiểm tra xem tên danh mục đã tồn tại hay chưa (bỏ qua danh mục hiện tại)
        if (Category::where('name', $request->name)
            ->where('category_id', '!=', $category->category_id) // Bỏ qua danh mục hiện tại
            ->exists()
        ) {
            return redirect()->back()->with('error', 'Danh mục này đã tồn tại. Vui lòng chọn tên khác.');
        }

        // Lấy dữ liệu đã được xác thực
        $validated = $request->validated();

        // Cập nhật danh mục
        $category->update($validated);

        return redirect()->route('category.index')->with('success', 'Thể loại sách đã được cập nhật thành công!');
    }


    public function destroy($category_id)
    {
        $category = Category::findOrFail($category_id);

        if ($category->books()->count() > 0) {
            return redirect()->route('category.index')->with('error', 'Không thể xóa danh mục vì đã có sách liên quan.');
        }

        $category->delete();
        return redirect()->route('category.index')->with('success', 'Danh mục đã được xóa thành công!');
    }
}
