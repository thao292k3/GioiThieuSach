<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaravelController extends Controller
{
    public function getRecommendations($userId)
{
    $response = Http::get("http://localhost:8000/recommend/$userId");
    $bookIds = $response->json()['recommended_books'];

    $books = Book::whereIn('id', $bookIds)->get();
    return view('recommendations', compact('books'));
}

    public function getBookDetails($bookId)
    {
        $response = Http::get("http://localhost:8000/book/$bookId");
        $book = $response->json();
        return view('book_details', compact('book'));
    }

    public function getUserProfile($userId)
    {
        $response = Http::get("http://localhost:8000/user/$userId");
        $user = $response->json();
        return view('user_profile', compact('user'));
    }
    public function getUserBooks($userId)
    {
        $response = Http::get("http://localhost:8000/user/$userId/books");
        $books = $response->json();
        return view('user_books', compact('books'));
    }
}
