<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class blog extends Model
{   
    protected $connection = 'mysql_second';
    protected $fillable = [
        'user_id','title', 'body'
    ];

}
