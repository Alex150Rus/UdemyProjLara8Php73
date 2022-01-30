<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //"App\Models\User"
        $doe = User::factory()->johnDoe()->create();
        //"Illuminate\Database\Eloquent\Collection"
        $else = User::factory()->count(20)->create();

        $users = $else->concat([$doe]);

        //make создаёт инстансы, но не сохраняет
        $posts = BlogPost::factory()->count(50)->make()->each(function ($post) use($users){
            $post->user_id = $users->random()->id;
            $post->save();
        });

        $comments = Comment::factory()->count(150)->make()->each(function ($comment) use ($posts){
            $comment->blog_post_id = $posts->random()->id;
            $comment->save();
        });
    }
}
