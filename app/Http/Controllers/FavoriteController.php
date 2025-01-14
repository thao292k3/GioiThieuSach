<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::with('book')->where('user_id', auth()->id())->get();
        return view('favorites.index', compact('favorites'));
    }

    public function destroy($id)
    {
        $favorite = Favorite::where('id', $id)->where('user_id', auth()->id())->first();
        if ($favorite) {
            $favorite->delete();
            return redirect()->route('favorites.index')->with('success', 'Yêu thích đã được xóa.');
        }
        return redirect()->route('favorites.index')->with('error', 'Không thể xóa yêu thích.');
    }
}
