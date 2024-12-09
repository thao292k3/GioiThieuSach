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
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    Route::get('/blog', [HomeController::class, 'blog'])->name('blog');

    Route::get('/blog/{id}', [HomeController::class, 'blogdetail'])->name('blogs.show');


    // Route GET để hiển thị form liên hệ
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

    // Route POST để xử lý gửi email
    Route::post('/contact', [HomeController::class, 'senMail'])->name('sendMail');

    Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
    Route::get('/blogdetail/{id}', [HomeController::class, 'blogdetail'])->name('blogdetail');

    Route::get('/category/{cat}', [HomeController::class, 'category'])->name('category');

    Route::post('/contact', [HomeController::class, 'store'])->name('contact.store');
    Route::get('/books/category/{category_id}', [HomeController::class, 'filterByCategory'])->name('books.filterByCategory');
    Route::post('/comment/{book_id}', [HomeController::class, 'post_comment'])->name('home.comment');
    Route::get('/shopdetail/{slug?}', [HomeController::class, 'shopdetail'])->name('shopdetail');
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

    // Resource routes for User
    Route::resource('user', UserController::class);

    // Resource routes for Blog
    Route::resource('blog', BlogController::class);
});


Route::group(['prefix' => 'account'], function () {

    Route::get('/', [AccountController::class, 'index'])->name('account.index')->middleware('my_auth');

    Route::get('/login', [AccountController::class, 'login'])->name('account.login');
    Route::get('/logout', [AccountController::class, 'logout'])->name('account.logout');
    Route::post('/login', [AccountController::class, 'post_login'])->name('account.login.post');

    Route::get('/register', [AccountController::class, 'register'])->name('account.register');
    Route::post('/register', [AccountController::class, 'post_register']);
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
