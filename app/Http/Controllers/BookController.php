<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Book::orderBy('id', 'asc')->paginate(7);
        return view('book.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cats = Category::orderBy('name', 'asc')->get();
        return view('book.create', compact('cats'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'author' => 'required|string',
            'publisher' => 'required|string',
            'isbn' => 'required|string|unique:books',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'status' => 'required|in:published,draft', // Giả sử trạng thái chỉ có 2 giá trị
        ];

        $messages = [
            'title.required' => 'Title is required.',
            'author.required' => 'Author is required.',
            'publisher.required' => 'Publisher is required.',
            'isbn.required' => 'ISBN is required.',
            'price.numeric' => 'Price must be a number.',
            'description.required' => 'Description is required.',
            'status.required' => 'Status is required.',
            'category_id.required' => 'Category is required.',
            'cover_image.image' => 'Cover image must be an image file.',
        ];

        $request->validate($rules, $messages);

        // Collect validated data
        $data = $request->only([
            'title',
            'author',
            'publisher',
            'published_date',
            'isbn',
            'price',
            'description',
            'status',
            'category_id',
            'cover_image'
        ]);

        // Chuyển đổi 'status' thành số (1 = published, 0 = draft)
        $data['status'] = $request->input('status') == 'published' ? 1 : 0;

        // Xử lý tải lên hình ảnh nếu có
        if ($request->hasFile('cover_image')) {
            $imagePath = $request->file('cover_image')->store('cover_images', 'public');
            $data['cover_image'] = $imagePath;

            if (Book::create($data)) {
                return redirect()->route('book.index');
            }
            return redirect()->route('book.index');
        }

        // Lưu sản phẩm vào cơ sở dữ liệu
        Book::create($data);

        return redirect()->route('book.index')->with('success', 'Book created successfully!');
    }



    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $cats = Category::orderBy('name', 'asc')->get();
        return view('book.edit', compact('book', 'cats'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'published_date' => 'nullable|date',
            'isbn' => 'required|string|unique:books,isbn,' . $book->id,
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'status' => 'required|in:1,0',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Xử lý ảnh bìa (nếu có)
        if ($request->hasFile('cover_image')) {
            $imagePath = $request->file('cover_image')->store('cover_images', 'public');
            $validatedData['cover_image'] = $imagePath;
        }

        // Cập nhật sách
        $book->update($validatedData);
        //session()->flash('success', 'Sửa sách thành công');

        return redirect()->route('book.index')->with('success', 'Sách đã được cập nhật thành công.');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete(); // Xóa bản ghi

        return redirect()->route('book.index')->with('success', 'Book deleted successfully!');
    }
}
