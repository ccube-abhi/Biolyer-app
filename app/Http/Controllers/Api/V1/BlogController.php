<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\BlogService;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class BlogController extends Controller
{
    protected $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    /**
     * Blog Listing
     */
    public function getData()
    {
        try {
            $blogs = $this->blogService->getBlogs();

            return $this->successResponse('Blog list fetched successfully.', $blogs);
        } catch (Throwable $e) {
            Log::error('Blog fetch error: '.$e->getMessage(), ['exception' => $e]);

            return $this->errorResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
