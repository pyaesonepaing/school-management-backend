<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogStoreRequest;
use App\Http\Requests\BlogUpdateRequest;
use App\Models\Blog;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        return Blog::latest()->get();
    }

    public function store(
        BlogStoreRequest $request
    )
    {
        $blog = Blog::create([

            'user_id' => auth()->id(),

            'title' => $request->title,

            'slug' => Str::slug(
                $request->title
            ) . '-' . time(),

            'cover_image' =>
                $request->cover_image,

            'content' =>
                $request->content,

            'is_published' =>
                $request->is_published ?? false,

            'published_at' =>
                $request->is_published
                    ? now()
                    : null

        ]);

        return response()->json(
            $blog,
            201
        );
    }

    public function show(
        Blog $blog
    )
    {
        return $blog;
    }

    public function update(
        BlogUpdateRequest $request,
        Blog $blog
    )
    {
        $blog->update([

            'title' =>
                $request->title,

            'cover_image' =>
                $request->cover_image,

            'content' =>
                $request->content,

            'is_published' =>
                $request->is_published,

            'published_at' =>
                $request->is_published
                    ? now()
                    : null

        ]);

        return $blog;
    }

    public function destroy(
        Blog $blog
    )
    {
        $blog->delete();

        return response()->json([
            'message' =>
                'Blog deleted.'
        ]);
    }
}   