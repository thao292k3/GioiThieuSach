<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::with('book')->orderBy('created_at', 'desc')->get();
        return view('comment.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('comment.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|integer',
            'comment' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        Comment::create([
            'book_id' => $request->book_id,
            'comment' => $request->comment,
            'user_id' => $request->user_id,
            'status' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('comment.index')->with('success', 'Thêm bình luận thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        return view('comment.edit', compact('comment'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $comment = Comment::findOrFail($id);
        $comment->update([
            'comment' => $request->comment,
            'updated_at' => now(),
        ]);

        return redirect()->route('comment.index')->with('success', 'Cập nhật bình luận thành công!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->route('comment.index')->with('success', 'Xóa bình luận thành công!');
    }

    public function approve($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->status = $comment->status == 1 ? 0 : 1;
        $comment->save();

        return redirect()->route('comment.index')->with('success', 'Cập nhật trạng thái bình luận thành công!');
    }
}
