<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        return Blog::where(
            'is_published',
            true
        )
        ->latest()
        ->paginate(10);
    }

    public function show(
        Blog $blog
    )
    {
        abort_if(
            !$blog->is_published,
            404
        );

        return $blog;
    }
}