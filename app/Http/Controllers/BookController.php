<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'author' => 'required|string',
            'publisher' => 'required|string',
            'published_date' => 'required|date',
            'isbn' => 'required|string|unique:books,isbn',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => ["required", Rule::in(0, 1)],
            'category_id' => 'required|exists:categories,category_id',
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

        $validatedData = $request->validate($rules, $messages);

        // Stock as boolean (if checked, it will be 1)
        $validatedData['stock'] = $request->has('stock') ? 1 : 0;

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $imagePath = $request->file('cover_image')->storeAs('uploads', $request->file('cover_image')->getClientOriginalName(), 'public');
            $validatedData['cover_image'] = "storage/uploads/" . $request->file('cover_image')->getClientOriginalName();
        }

        if ($request->hasFile('pdf_file')) {
            $imagePath = $request->file('pdf_file')->storeAs('uploads', $request->file('pdf_file')->getClientOriginalName(), 'public');
            $validatedData['pdf_file'] = "storage/uploads/" . $request->file('pdf_file')->getClientOriginalName();
        }

        // Create the book
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
            'isbn' => 'required|string|max:100|unique:books,isbn,' . $book->book_id . ',book_id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'description' => 'required|string',
            'status' => ["required", Rule::in(0, 1)],
            'category_id' => 'required|exists:categories,category_id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'pdf_file' => 'nullable|file|mimes:pdf|max:5120',
            'stock' => 'nullable|boolean',
        ]);

        // Handle stock as boolean
        $validatedData['stock'] = $request->has('stock') ? 1 : 0;
        // Handle cover image upload if present
        if ($request->hasFile('cover_image')) {
            $request->file('cover_image')->storeAs("uploads", $request->file('cover_image')->getClientOriginalName(), 'public');
            $validatedData["cover_image"] = "storage/uploads/" . $request->file('cover_image')->getClientOriginalName();
        }

        // Handle PDF file upload if present
        if ($request->hasFile('pdf_file')) {
            $pdfPath = $request->file('pdf_file')->storeAs("uploads", $request->file('pdf_file')->getClientOriginalName(), 'public');
            $validatedData["pdf_file"] = "storage/uploads/" . $request->file('pdf_file')->getClientOriginalName();
        }

        // Update the book
        Book::where("book_id", $book->book_id)->update($validatedData);

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
}
