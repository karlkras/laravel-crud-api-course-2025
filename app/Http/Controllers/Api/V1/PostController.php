<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        return PostResource::collection(Post::with("author")->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request) {
        $validated = $request->validated();
        $validated['author_id'] = 1;
        $post = Post::create($validated);
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post) {
        return response()->json(new PostResource($post));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post) {
        $validated = $request->validate([
            'title' => 'required|string|min:2',
            'body' => 'required|string|min:2'
        ]);
        $post->update($validated);
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post) {
        $post->delete();
        return response()->noContent();
    }
}
