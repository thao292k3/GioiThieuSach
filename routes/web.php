<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => ''], function () {
     Route::get('/', [HomeController::class, 'index'])->name('home');
    // Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');
    Route::get('/blog', [HomeController::class, 'blog'])->name('blog');

    Route::get('/blog/{id}', [HomeController::class, 'blogdetail'])->name('blogs.show');

    Route::get('/shopingcart', [HomeController::class, 'shopingcart'])->name('shopingcart');


    // Route GET để hiển thị form liên hệ
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
    Route::post('/contact', [HomeController::class, 'storeContact']);

    // Route POST để xử lý gửi email
    Route::post('/contact', [HomeController::class, 'senMail'])->name('sendMail');

    Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
    Route::get('/shopdetail/{slug?}', [HomeController::class, 'shopdetail'])->name('shopdetail');
    
    Route::get('/blogdetail/{id}', [HomeController::class, 'blogdetail'])->name('blogdetail');
    // Like bài viết
    Route::post('/blog/{blog_id}/like', [HomeController::class, 'likeBlog'])->name('blog.like');

    // Bình luận
    Route::post('/blog/{blog_id}/comment', [HomeController::class, 'post_comment'])->name('blog.comment');

    // Phản hồi bình luận
    Route::post('/comment/{comment_id}/reply', [HomeController::class, 'replyComment'])->name('comment.reply');


    Route::get('/category/{cat}', [HomeController::class, 'category'])->name('category');

    Route::post('/contact', [HomeController::class, 'store'])->name('contact.store');
    Route::get('/books/category/{category_id}', [HomeController::class, 'filterByCategory'])->name('books.filterByCategory');
    Route::post('/comment/{book_id}', [HomeController::class, 'post_comment'])->name('home.comment');
    Route::post('/review/{book_id}', [HomeController::class, 'store'])->name('home.review');
    
    Route::get('/favorite/{book}', [HomeController::class, 'favorite'])->name('home.favorite');

    Route::get('/mail', [HomeController::class, 'mail'])->name('home.mail');
});




Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'post_login'])->name('admin.login.post');

Route::group(['prefix' => 'web', 'middleware'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    // Resource routes for Category
    Route::resource('category', CategoryController::class);

    // Resource routes for Book
    Route::resource('book', BookController::class); // Automatically handles the update route

    // Resource routes for Contact
    Route::resource('contact', ContactController::class);
    // // Route::get('/contacts', [ContactController::class, 'index'])->name('contact.index');
    // // Route::post('/contact/store', [ContactController::class, 'store'])->name('contact.store');
    // // Route::get('/admin/contacts', [ContactController::class, 'index'])->name('contacts.index');
    // // Route::post('/admin/contacts/{id}/reply', [ContactController::class, 'reply'])->name('contact.reply');
    // Route::get('contact/{id}/reply', [ContactController::class, 'showReplyForm'])->name('contact.reply');
    // Route::post('contact/{id}/reply', [ContactController::class, 'sendReply'])->name('contact.sendReply');
    // Route::post('/contact/store', [ContactController::class, 'store'])->name('contact.store');


    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/reply', [ContactController::class, 'reply'])->name('contact.reply');
    Route::post('/edit-response', [ContactController::class, 'editResponse'])->name('contact.editResponse');



    // Resource routes for User
    Route::resource('user', UserController::class);

    // Resource routes for Blog
    Route::resource('blog', BlogController::class);


    Route::resource('comment', CommentController::class);
    Route::post('/approve/{id}', [CommentController::class, 'approve'])->name('comment.approve');

    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
});


Route::group(['prefix' => 'account'], function () {

    Route::get('/', [AccountController::class, 'index'])->name('account.index')->middleware('my_auth');

    Route::get('/login', [AccountController::class, 'login'])->name('account.login');
    Route::get('/logout', [AccountController::class, 'logout'])->name('account.logout');
    Route::get('/register', [AccountController::class, 'register'])->name('account.register');
    Route::post('/register', [AccountController::class, 'post_register'])->name('account.register.post');
    Route::post('/login', [AccountController::class, 'post_login'])->name('account.login.post');
    Route::get('/favorite', [AccountController::class, 'favorite'])->name('account.favorite');
});

Route::post('/upload-image', function (Request $request) {
    $image = $request->file('upload');
    $imageName = time() . '.' . $image->getClientOriginalExtension();
    $image->storeAs('public/images', $imageName);

    return response()->json([
        'uploaded' => 1,
        'fileName' => $imageName
    ]);
});
Route::group(['prefix' => 'cart', 'middleware' => ['auth']], function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::get('/add/{book}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/delete/{book}', [CartController::class, 'delete'])->name('cart.delete');
    Route::get('/update/{book}', [CartController::class, 'update'])->name('cart.update');
    Route::get('/clear', [CartController::class, 'clear'])->name('cart.clear');

    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});

Route::group(['prefix' => 'order', 'middleware' => ['auth']], function () {
    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('order.checkout');
    
    Route::post('/checkout', [CheckoutController::class, 'post_checkout'])->name('checkout.post');
    Route::get('/checkout/verify/{token}', [CheckoutController::class, 'verify'])->name('order.verify');
});

Route::get('/test-email', function () {
    try {
        Mail::raw('Test email', function ($message) {
            $message->to('your_email@example.com')->subject('Test Email');
        });
        return 'Email sent successfully!';
    } catch (\Exception $e) {
        return 'Failed to send email: ' . $e->getMessage();
    }
});

Route::get('/checkout/success', function () {
    return view('site.checkout_success');
})->name('checkout.success');

Route::get('/search', [BookController::class, 'search'])->name('book.search');

Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('order.checkout');
Route::get('/checkout/verify/{token}', [CheckoutController::class, 'verify'])->name('order.verify');
Route::get('/checkout/verify', [CheckoutController::class, 'verify'])->name('order.verify');

Route::post('/checkout', [CheckoutController::class, 'post_checkout'])->name('checkout.post');
Route::get('/checkout/success', function () {
    return view('site.checkout_success');
})->name('checkout.success');


