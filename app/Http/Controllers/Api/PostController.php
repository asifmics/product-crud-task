<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Resources\PostResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return PostResource::collection(Category::all());
    }

    public function store(CategoryStoreRequest $request): PostResource
    {
        return new PostResource($request);
    }

    public function show(Category $post): PostResource
    {
        return new PostResource($post);
    }

    public function destroy(Category $post)
    {
        return new PostResource($post);
    }
}
