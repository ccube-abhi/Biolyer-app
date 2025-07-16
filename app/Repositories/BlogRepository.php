<?php

namespace App\Repositories;

use App\Models\Blog;

class BlogRepository
{
    public function getAllBlogs()
    {
        return Blog::all();
    }
}
