<?php

namespace App\Http\Controllers;

use App\Events\NewPostCreated;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Notifications\NewPostNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $posts = Post::with('comments')->get();

        if($posts->isEmpty()){
            return response()->json(['message' => 'No posts yet', 'data' => $posts], 200);
        }

        return response()->json(['data' => $posts], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $validated["image"] = Storage::put('posts', $validated["image"]);

        $post = auth()->user()->posts()->create($validated);

        event(new NewPostCreated(auth()->user(), $post));

        return response()->json(['message' => 'Post created successfully', 'data' => $post], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): JsonResponse
    {
        $post->load(['comments.user'])->loadCount(['comments', 'likes']);

        return response()->json($post, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        $this->authorize('update', $post);

        $validated = $request->validated();

        if($request->hasFile('image')) {
            Storage::delete($post->image);

            $validated["image"] = Storage::put('posts', $validated["image"]);
        }

        $validated['image'] ??= $post->image;

        $post->update($validated);

        return response()->json(["message" => "Post updated successfully", "data" => $post], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): Response
    {
        $this->authorize('delete', $post);

        Storage::delete($post->image);

        $post->delete();

        return response()->noContent();
    }
}
