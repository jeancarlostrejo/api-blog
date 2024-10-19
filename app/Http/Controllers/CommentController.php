<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    public function store(Request $request, Post $post): JsonResponse
    {
        $validated = $request->validate([
            'body' => 'required'
        ]);

        auth()->user()->comments()->create([
            'body' => $validated['body'],
            'post_id' => $post->id
        ]);

        return response()->json(['message' => 'comment created successfully'], Response::HTTP_CREATED);
    }

    public function destroy(Comment $comment, Post $post): Response
    {
        $comment->delete();

        return response()->noContent();
    }
}
