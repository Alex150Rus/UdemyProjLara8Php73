<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int user_id
 * @property Carbon created_at
 */
class BlogPost extends Model
{
    use HasFactory;

    use SoftDeletes;

    //properties, which can be assigned during mass assignment
    protected $fillable = ['title', 'content', 'user_id'];

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public static function boot()
    {
        parent::boot();

        //событие удаления и что присходит во время его срабатывания
        static::deleting(function (BlogPost $blogPost) {
            $blogPost->comments()->delete();
        });

        static::restoring(function (BlogPost $blogPost){
            $blogPost->comments()->restore();
        });

    }
}
