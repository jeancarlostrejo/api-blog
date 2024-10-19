<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $posts = Post::all();

        if($posts->isEmpty()){
            return response()->json(['message' => 'No posts yet', 'data' => $posts], 200);
        }

        return response()->json(['data' => $posts]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $validated["image"] = Storage::put('posts', $validated["image"]);

        $post = auth()->user()->posts()->create($validated);

        return response()->json(['message' => 'Post created successfully', 'data' => $post], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $validated = $request->validated();

        if($request->hasFile('image')) {
            Storage::delete($post->image);

            $validated["image"] = Storage::put('posts', $validated["image"]);
        }

        $validated['image'] ??= $post->image;

        $post->update($validated);

        return response()->json(["message" => "Post updated successfully", "data" => $post], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Storage::delete($post->image);

        $post->delete();

        return response()->noContent();
    }
}
