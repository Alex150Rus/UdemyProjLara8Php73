<?php

namespace App\Models;

use App\Scopes\DeletedAdminScope;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
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
        return $this->hasMany(Comment::class)->latest();
    }

    public function image() {
        return $this->hasOne(Image::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public function scopeMostCommented(Builder $query)
    {
        //produces comments_count
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }


    public static function boot()
    {
        //static::addGlobalScope(new LatestScope());
        static::addGlobalScope(new DeletedAdminScope);

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
