<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LikeController extends Controller
{
    public function store(Post $post): JsonResponse
    {
        if($post->isLiked(auth()->user())) {
            $post->likes()->where('user_id', auth()->user()->id)->delete();

            return response()->json(["message" => "Unlike post"], Response::HTTP_OK);
        }

        $post->likes()->create([
            'user_id' => auth()->user()->id
        ]);

        return response()->json(["message" => "Like post"], Response::HTTP_CREATED);
    }
}
