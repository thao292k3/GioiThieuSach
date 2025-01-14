<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Favorite;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        view()->composer('*', function ($view) {
            $carts = collect(); // Mặc định là collection rỗng
            $user_id = Auth::id(); // Lấy ID người dùng hiện tại

            if ($user_id) {
                // Nếu người dùng đã đăng nhập, lấy giỏ hàng
                $carts = Cart::where('user_id', $user_id)->with('prod')->get();
            }

            // Chia sẻ biến $carts với tất cả view
            $view->with(compact('carts'));

            $favoriteCount = 0;

            if (Auth::check()) { // Kiểm tra người dùng đã đăng nhập chưa
                $favoriteCount = Favorite::where('user_id', Auth::id())->count();
            }

            $view->with('favoriteCount', $favoriteCount);

            $cartCount = 0;
            $cartTotal = 0;

            if (Auth::check()) {
                $userId = Auth::id();

                // Lấy tất cả sản phẩm trong giỏ hàng
                $carts = Cart::where('user_id', $userId)->get();

                // Đếm số lượng sản phẩm
                $cartCount = $carts->count();

                // Tính tổng tiền, sử dụng price_sale nếu có
                $cartTotal = $carts->sum(function ($cart) {
                    // Kiểm tra nếu có price_sale, nếu không lấy price
                    return $cart->price_sale ? $cart->price_sale : $cart->price * $cart->quantity;
                });
            }

            // Chia sẻ dữ liệu với view
            $view->with([
                'cartCount' => $cartCount,
                'cartTotal' => $cartTotal,
            ]);
        });
    }
}
