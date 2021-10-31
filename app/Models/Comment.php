<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    //blog_post_id as in migration
    public function blogPost() {
        return $this->belongsTo(BlogPost::class);
    }
}
