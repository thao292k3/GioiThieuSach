<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Book::orderBy('book_id', 'asc')->paginate(7);
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

    


public function store(Request $request)
{
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|string|unique:books,slug|max:255',
        'author' => 'required|string',
        'publisher' => 'required|string',
        'published_date' => 'required|date',
        'isbn' => 'required|string|unique:books,isbn',
        'price' => 'required|numeric|min:0',
        'description' => 'required|string',
        'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',

        'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
        'status' => 'required|boolean',
        'category_id' => 'required|exists:categories,category_id',
    ]);
    
    // Tạo slug từ title
    $validatedData['slug'] = Str::slug($request->title, '-');
    $validatedData['stock'] = $request->input('stock'); // lấy đúng giá trị 0 hoặc 1


    // Xử lý ảnh bìa
    if ($request->hasFile('cover_image')) {
        $imagePath = $request->file('cover_image')->storeAs(
            'uploads',
            $request->file('cover_image')->getClientOriginalName(),
            'public'
        );
        $validatedData['cover_image'] = "storage/uploads/" . $request->file('cover_image')->getClientOriginalName();
    }
    // Xử lý file PDF
    if ($request->hasFile('pdf_file')) {
        $pdfPath = $request->file('pdf_file')->storeAs(
            'uploads',
            $request->file('pdf_file')->getClientOriginalName(),
            'public'
        );
        $validatedData['pdf_file'] = "storage/uploads/" . $request->file('pdf_file')->getClientOriginalName();
    }

    Book::create($validatedData);


    return redirect()->route('book.index')->with('success', 'Book created successfully!');
}

    /**
     * Display the specified resource.
     */
    public function show($book_id)
    {
        $book = Book::with('cover_images')->findOrFail($book_id);

        return view('book.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $cats = Category::orderBy('name', 'asc')->get();
        return view('book.edit', compact('book', 'cats'));
    }

    
public function update(Request $request, Book $book)
{
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|string|unique:books,slug|max:255',
        'author' => 'required|string',
        'publisher' => 'required|string',
        'published_date' => 'required|date',
        'isbn' => 'required|string|unique:books,isbn,' . $book->book_id . ',book_id',
        'price' => 'required|numeric|min:0',
        'description' => 'required|string',
        'cover_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:5120',
        'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
        'status' => ["required", Rule::in(0, 1)], // Giữ lại trạng thái nổi bật
        'category_id' => 'required|exists:categories,category_id',
        'stock' => 'nullable|boolean',
    ]);

    $messages = [
        'title.required' => 'Title is required.',
        'slug' => 'required|string|unique:books,slug|max:255',
        'author.required' => 'Author is required.',
        'publisher.required' => 'Publisher is required.',
        'isbn.required' => 'ISBN is required.',
        'price.numeric' => 'Price must be a number.',
        'description.required' => 'Description is required.',
        'status.required' => 'Status is required.',
        'category_id.required' => 'Category is required.',
        'cover_image.image' => 'Cover image must be an image file.',
    ];
    $validatedData = $request->validate( $messages);
    // Đánh dấu sách nổi bật
    $validatedData['stock'] = $request->has('stock') ? 1 : 0;

    // Xử lý file ảnh
    if ($request->hasFile('cover_image')) {
        $imagePath = $request->file('cover_image')->storeAs(
            'uploads',
            $request->file('cover_image')->getClientOriginalName(),
            'public'
        );
        $validatedData['cover_image'] = "storage/uploads/" . $request->file('cover_image')->getClientOriginalName();
    } else {
        $validatedData['cover_image'] = $book->cover_image; // Giữ lại ảnh cũ nếu không tải lên ảnh mới
    }

    // Xử lý file PDF
    if ($request->hasFile('pdf_file')) {
        $pdfPath = $request->file('pdf_file')->storeAs(
            'uploads',
            $request->file('pdf_file')->getClientOriginalName(),
            'public'
        );
        $validatedData['pdf_file'] = "storage/uploads/" . $request->file('pdf_file')->getClientOriginalName();
    } else {
        $validatedData['pdf_file'] = $book->pdf_file; // Giữ lại file PDF cũ nếu không tải lên file mới
    }

    // Cập nhật sách
    $book->update($validatedData);

    return redirect()->route('book.index')->with('success', 'Book updated successfully!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete(); // Delete the book record

        return redirect()->route('book.index')->with('success', 'Book deleted successfully!');
    }

    public function search(Request $request)
{
    $keyword = $request->input('keyword');

    // Tìm kiếm sách theo tên, tác giả hoặc thể loại
    $books = Book::query()
        ->where('title', 'LIKE', "%{$keyword}%")
        ->orWhere('author', 'LIKE', "%{$keyword}%")
        ->orWhereHas('category', function ($query) use ($keyword) { // Sửa 'categories' thành 'category'
            $query->where('name', 'LIKE', "%{$keyword}%");
        })
        ->get();

    return view('site.search_results', compact('books', 'keyword'));
}
}
