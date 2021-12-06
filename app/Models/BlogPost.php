<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property Carbon created_at
 */
class BlogPost extends Model
{
    use HasFactory;

    //properties, which can be assigned during mass assignment
    protected $fillable = ['title', 'content'];

    public function comments() {
        return $this->hasMany(Comment::class);
    }
}
