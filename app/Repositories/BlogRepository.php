<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class BlogRepository
{
    public function getAllBlogs()
    {
        return DB::connection('mysql_second')->table('blogs')->get();
    }
}
