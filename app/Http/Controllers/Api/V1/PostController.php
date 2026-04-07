<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Post::published()
            ->with(['categories', 'tags', 'author'])
            ->orderByDesc('published_at');

        if ($request->has('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }

        $perPage = min((int) $request->get('per_page', 12), 50);

        return PostResource::collection($query->paginate($perPage));
    }

    public function show(Post $post): PostResource
    {
        // Vérifier que l'article est publié
        if ($post->status !== \App\Enums\PostStatus::PUBLISHED) {
            abort(404);
        }

        $post->load(['categories', 'tags', 'author']);

        return new PostResource($post);
    }
}