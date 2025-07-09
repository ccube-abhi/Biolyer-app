<?php

namespace App\Services;

use App\Repositories\BlogRepository;

class BlogService
{
    protected $blogRepository;

    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    public function getBlogs()
    {
        return $this->blogRepository->getAllBlogs();
    }
}
