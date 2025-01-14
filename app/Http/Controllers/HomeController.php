<?php

namespace App\Http\Controllers;

use App\Mail\ContactEmail;
use App\Mail\ContactResponse;
use App\Mail\ContactResponseMail;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Blog;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\Email;
use App\Models\User;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Review;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Mailer\Mailer;

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

        $topCommentedBooks = Book::withCount('comments') // Đếm số lượng bình luận
            ->having('comments_count', '>', 0) // Chỉ lấy sách có ít nhất 1 bình luận
            ->orderBy('comments_count', 'desc') // Sắp xếp theo số lượng bình luận giảm dần
            ->take(5) // Giới hạn 5 sách
            ->get();

        return view('site.index', compact('featuredBooks', 'data', 'limitedCategories', 'latestBooks', 'blogs', 'categories', 'category', 'reviewedBooks', 'topCommentedBooks'));
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
        // $email = 'pp6686336@gmail.com';
        // Mail::to($email)->send(new Mailable());
    }
    public function storeContact(Request $request)
    {
        // Validate dữ liệu nhập vào
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Lưu dữ liệu vào bảng contact
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        // Có thể thêm thông báo thành công
        return redirect()->route('contact')->with('success', 'Your message has been sent successfully!');
    }




    public function shopingcart()
    {
        return view('site.shoping-cart');
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

    public function respond(Request $request, $contact_id)
    {
        $contact = Contact::find($contact_id);

        // Validate the input
        $request->validate([
            'response' => 'required|string',
        ]);

        // Cập nhật phản hồi vào cơ sở dữ liệu
        $contact->response = $request->response;
        $contact->response_date = now();
        $contact->save();

        // Gửi email phản hồi cho khách hàng
        Mail::to($contact->email)->send(new ContactResponseMail($contact));

        return redirect()->route('contact.index')->with('success', 'Response sent successfully.');
    }

    public function store(Request $request)
    {
        // if (!auth()->check()) {
        //     return redirect()->route('account.login')->with('error', 'Vui lòng đăng nhập để bình luận hoặc đánh giá.');
        // }

        // $request->validate([
        //     'name' => 'required|string',
        //     'email' => 'required|email',
        //     'review' => 'required|string',
        //     'rating' => 'required|integer|min:1|max:5',
        // ]);

        // Review::create([
        //     'book_id' => $book_id,
        //     'user_id' => auth()->id(), // Dùng user_id
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'review' => $request->review,
        //     'rating' => $request->rating,
        // ]);

        // return redirect()->back()->with('success', 'Cảm ơn bạn đã đánh giá cuốn sách!');

        if ($request->has('message') && !$request->has('rating')) {
            // Xử lý lưu liên hệ
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'message' => 'required|string',
            ]);

            // Contact::create([
            //     'name' => $request->name,
            //     'email' => $request->email,
            //     'message' => $request->message,
            //     // 'status' => '1', // Gán giá trị mặc định
            // ]);


            // return redirect()->route('contact')->with('success', 'Cảm ơn bạn đã liên hệ!');
        } elseif ($request->has('rating')) {
            // Xử lý lưu đánh giá
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'review' => 'required|string',
                'rating' => 'required|integer|min:1|max:5',
            ]);

            Review::create([
                'book_id' => $request->book_id,
                'user_id' => auth()->id(),
                'name' => $request->name,
                'email' => $request->email,
                'review' => $request->review,
                'rating' => $request->rating,
            ]);

            return redirect()->back()->with('success', 'Cảm ơn bạn đã đánh giá cuốn sách!');
        } else {
            return redirect()->back()->with('error', 'Dữ liệu không hợp lệ.');
        }
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
            ->join('users', 'reviews.user_id', '=', 'users.user_id') // Dùng user_id và tham chiếu đến bảng users
            ->where('reviews.book_id', $book->book_id)
            ->select('users.name as user_name', 'reviews.rating', 'reviews.review', 'reviews.created_at')
            ->get()
            ->map(function ($review) {
                // Chuyển đổi 'created_at' thành đối tượng Carbon
                $review->created_at = Carbon::parse($review->created_at);
                return $review;
            });
        $relatedBooks = Book::where('category_id', $book->category_id)
            ->where('book_id', '!=', $book->book_id) // Sử dụng 'book_id' thay vì 'id'
            ->take(4) // Giới hạn 4 sách liên quan
            ->get();

        // Truyền dữ liệu sang view
        return view('site.shopdetail', compact('book', 'books', 'limitedCategories', 'data', 'reviews', 'comments', 'relatedBooks'));
    }

    function showBookDetail($id)
    {
        $book = Book::findOrFail($id); // Tìm sách theo ID, đảm bảo lỗi 404 nếu không tìm thấy.

        return view('site.shopdetail', compact('book'));
    }

    public function likeBlog($blog_id)
    {
        $blog = Blog::findOrFail($blog_id);

        // Kiểm tra nếu user đã like bài viết trước đó
        if ($blog->likes()->where('user_id', Auth::id())->exists()) {
            return redirect()->back()->with('info', 'You have already liked this post.');
        }

        $blog->likes()->create([
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'You liked the blog!');
    }

    public function replyComment(Request $request, $comment_id)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        $parentComment = Comment::findOrFail($comment_id);

        Comment::create([
            'book_id' => $parentComment->book_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'status' => 1,
            'parent_id' => $parentComment->comment_id,
            'created_up' => now(),
            'updated_up' => now(),
        ]);

        return redirect()->back()->with('success', 'Reply added successfully!');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'comment_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id', 'comment_id');
    }

    public function post_comment(Request $request, $book_id)
    {

        if (!auth()->check()) {
            return redirect()->route('account.login')->with('error', 'Vui lòng đăng nhập để bình luận.');
        }
        // Kiểm tra sách
        $book = Book::find($book_id);
        if (!$book) {
            return redirect()->back()->with('error', 'Không tìm thấy sách!');
        }

        // Lưu bình luận
        Comment::create([
            'book_id' => $book_id,
            'user_id' => auth()->id(),
            'blog_id' => $request->input('blog_id'), // Thêm trường blog_id
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

    public function favorite($book_id)
    {
        // Lấy user hiện tại
        $user = Auth::user();

        // Kiểm tra xem sách có tồn tại không
        $book = Book::find($book_id);
        if (!$book) {
            return redirect()->back()->with('error', 'Sách không tồn tại!');
        }

        // Kiểm tra xem sách đã được yêu thích chưa
        $favorite = Favorite::where('user_id', $user->user_id)
            ->where('book_id', $book_id)
            ->first();

        if ($favorite) {
            // Nếu đã yêu thích, xóa yêu thích
            $favorite->delete();
            return redirect()->back()->with('info', 'Bạn đã bỏ yêu thích sản phẩm!');
        } else {
            // Nếu chưa yêu thích, thêm vào danh sách yêu thích
            Favorite::create([
                'user_id' => $user->user_id,
                'book_id' => $book_id,
            ]);
            return redirect()->back()->with('success', 'Bạn đã yêu thích sản phẩm!');
        }
    }
}
