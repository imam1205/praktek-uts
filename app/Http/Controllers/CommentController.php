<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Simpan komentar baru dari pengunjung (guest atau user login).
     */
    public function store(Request $request, Post $post)
    {
        if (Auth::check()) {
            // User yang sudah login
            $validated = $request->validate([
                'content' => ['required', 'string', 'max:2000'],
            ]);

            $post->comments()->create([
                'user_id'  => Auth::id(),
                'content'  => $validated['content'],
                'status'   => 'approved',
            ]);
        } else {
            // Guest / tamu
            $validated = $request->validate([
                'guest_name'  => ['required', 'string', 'max:80'],
                'guest_email' => ['nullable', 'email', 'max:120'],
                'content'     => ['required', 'string', 'max:2000'],
            ]);

            $post->comments()->create([
                'guest_name'  => $validated['guest_name'],
                'guest_email' => $validated['guest_email'] ?? null,
                'content'     => $validated['content'],
                'status'      => 'approved',
            ]);
        }

        return back()->with('success', 'Komentar Anda berhasil dikirim!');
    }

    /**
     * Daftar komentar untuk admin.
     */
    public function adminIndex()
    {
        $comments = Comment::with(['post', 'user'])
                           ->latest()
                           ->paginate(20);

        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Hapus komentar (admin).
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Komentar berhasil dihapus.');
    }

    /**
     * Setujui/tolak komentar (admin).
     */
    public function approve(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:approved,rejected'],
        ]);

        $comment->update(['status' => $validated['status']]);
        return back()->with('success', 'Status komentar diperbarui.');
    }
}
