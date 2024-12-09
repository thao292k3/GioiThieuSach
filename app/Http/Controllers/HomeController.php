<?php

namespace App\Http\Controllers;

use App\Mail\ContactEmail;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Blog;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\Email;

use App\Models\Comment;
use Illuminate\Mail\Mailable;

class HomeController extends Controller
{
    public function index()
    {
        $featuredBooks = Book::where('stock', 1)->get();
        $data = Category::all();
        $limitedCategories = $data->take(11);
        // Lấy 5 sách mới nhất
        $latestBooks = Book::orderBy('created_at', 'desc')->take(5)->get();

        $blogs = Blog::orderBy('date', 'desc')->get();

        $categories = Category::all();
        $category = $featuredBooks->pluck('cat.name')->unique(); // Lấy các thể loại duy nhất

        $reviewedBooks = Book::whereHas('reviews', function ($query) {
            $query->whereNotNull('review'); // Lọc chỉ sách có review không rỗng
        })->with(['reviews' => function ($query) {
            $query->orderBy('created_at', 'desc'); // Sắp xếp review mới nhất
        }])->get();

        $topRatedBooks = DB::table('books')
            ->join('reviews', 'books.book_id', '=', 'reviews.book_id')
            ->select('books.book_id', 'books.title', 'books.cover_image', 'books.price', DB::raw('AVG(reviews.rating) as avg_rating'))
            ->groupBy('books.book_id', 'books.title', 'books.cover_image', 'books.price')
            ->orderByDesc('avg_rating')
            ->limit(1) // Lấy một sách duy nhất
            ->get();

        return view('site.index', compact('featuredBooks', 'data', 'limitedCategories', 'latestBooks', 'blogs', 'categories', 'category', 'reviewedBooks', 'topRatedBooks'));
    }


    public function cate(Category $cat)
    {
        $categories = Category::all();
        $data = Category::all();
        $limitedCategories = $data->take(11);
        $books = $cat->books()->paginate(9);
        // Hiển thị form liên hệ
        return view('site.category', compact('cat', 'books', 'data', 'limitedCategories'));
    }


    public function featuredBooks(Category $cat)
    {
        $featuredBooks = Book::where('stock', 1)->get();
        $categories = Category::all();
        $data = Category::all();
        $limitedCategories = $data->take(11);
        $books = $cat->books()->paginate(9);
        // Hiển thị form liên hệ
        return view('site.category', compact('cat', 'books', 'data', 'limitedCategories', 'featuredBook'));
    }


    public function getFeaturedBooks()
    {
        // Lọc sách có stock = 1
        $featuredBooks = Book::where('stock', 1)->get();

        // Lấy danh sách các thể loại duy nhất của sách nổi bật
        $categories = $featuredBooks->map(function ($item) {
            return $item->category->name; // Lấy tên thể loại của mỗi sản phẩm
        })->unique(); // Lọc các thể loại duy nhất

        return view('site.index', compact('categories', 'featuredBooks'));
    }

    public function filterByCategory($category_id)
    {
        // Lấy danh sách sách theo thể loại
        $featuredBooks = Book::where('category_id', $category_id)->get();

        // Lấy danh sách thể loại sách để hiển thị trên giao diện
        $categories = Category::all();

        return view('site.index', compact('featuredBooks', 'categories'));
    }


    public function blog()
    {
        $blogs = Blog::paginate(6);
        $data = Category::all();
        $limitedCategories = $data->take(7);

        // Lấy 5 bài viết mới nhất, bạn có thể thay đổi số lượng tùy ý
        $recentBlogs = Blog::where('status', 'approved')
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();

        return view('site.blog', compact('blogs', 'data', 'limitedCategories', 'recentBlogs'));
    }

    public function blogdetail($blog_id)
    {
        // Lấy bài viết chi tiết theo blog_id
        $blog = Blog::findOrFail($blog_id); // Tự động trả về lỗi 404 nếu không tìm thấy bài viết

        // Lấy 5 bài viết mới nhất (đã được phê duyệt) để hiển thị ở sidebar
        $recentBlogs = Blog::where('status', 'approved')
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();

        return view('site.blogdetail', compact('blog', 'recentBlogs'));
    }

    public function show($id)
    {
        $blog = Blog::findOrFail($id); // Lấy bài viết theo ID, nếu không tồn tại sẽ trả về lỗi 404.
        $recentBlogs = Blog::latest()->take(5)->get(); // Lấy danh sách bài viết gần đây để hiển thị ở sidebar.

        return view('site.blogdetail', compact('blog', 'recentBlogs'));
    }


    public function contact()
    {
        // Hiển thị form liên hệ
        return view('site.contact');
    }

    public function senMail(Request $request)
    {
        // Lấy dữ liệu từ form
        $name = $request->input('name');
        $email = $request->input('email');
        $message = $request->input('message');

        // Gửi email
        Mail::to('pp6686336@gmail.com')->send(new ContactEmail($name, $email, $message));

        // Redirect về form liên hệ với thông báo
        return redirect()->route('contact')->with('success', 'Đã gửi liên hệ thành công.');
    }


    public function store(Request $request)
    {
        // Code xử lý lưu dữ liệu
    }



    public function shop()
    {
        $saleBooks = Book::whereNotNull('sale_price')->where('sale_price', '>', 0)->get();
        $data = Category::all();
        $books = Book::paginate(6);
        $limitedCategories = $data->take(11);
        $latestBooks = Book::orderBy('created_at', 'desc')->take(5)->get();



        // Truyền dữ liệu sang view
        return view('site.shop', compact('saleBooks', 'limitedCategories', 'data', 'books', 'latestBooks'));
    }



    public function shopdetail($slug = null)
    {
        if (!$slug) {
            // Xử lý khi không có slug (ví dụ: chuyển hướng về trang chủ hoặc hiển thị lỗi)
            return redirect()->route('home')->with('error', 'Không tìm thấy sản phẩm.');
        }

        $book = Book::where('slug', $slug)->firstOrFail();
        $books = Book::paginate(6);
        $data = Category::all();
        $limitedCategories = $data->take(11);

        // Lấy danh sách bình luận liên quan đến sách
        $comments = Comment::where('book_id', $book->book_id)->orderBy('created_at', 'desc')->get();

        $reviews = DB::table('reviews')
            ->join('customers', 'reviews.customer_id', '=', 'customers.customer_id')
            ->where('reviews.book_id', $book->book_id)
            ->select('customers.name as customer_name', 'reviews.rating', 'reviews.review', 'reviews.created_at')
            ->get()
            ->map(function ($review) {
                // Chuyển đổi 'created_at' thành đối tượng Carbon
                $review->created_at = Carbon::parse($review->created_at);
                return $review;
            });

        // Truyền dữ liệu sang view
        return view('site.shopdetail', compact('book', 'books', 'limitedCategories', 'data', 'reviews', 'comments'));
    }

    function showBookDetail($id)
    {
        $book = Book::findOrFail($id); // Tìm sách theo ID, đảm bảo lỗi 404 nếu không tìm thấy.

        return view('site.shopdetail', compact('book'));
    }

    public function post_comment(Request $request, $book_id)
    {
        // Kiểm tra sách
        $book = Book::find($book_id);
        if (!$book) {
            return redirect()->back()->with('error', 'Không tìm thấy sách!');
        }

        // Lưu bình luận
        Comment::create([
            'book_id' => $book_id,
            'user_id' => auth()->id(),
            'comment' => $request->input('comment'), // Trường comment trong form
            'status' => 1, // Trạng thái mặc định
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Bình luận đã được gửi.');
    }

    public function category(Category $cat)
    {
        $data = Category::all();
        $limitedCategories = $data->take(11);
        $books = $cat->books()->paginate(9);
        // Hiển thị form liên hệ
        return view('site.category', compact('cat', 'books', 'data', 'limitedCategories'));
    }



    public function master()
    {
        $data = Category::all();
        $limitedCategories = $data->take(11);
        return view('site.master', compact('data', 'limitedCategories'));
    }
}
