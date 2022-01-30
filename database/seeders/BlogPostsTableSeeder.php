<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Seeder;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users= User::all();
        //make создаёт инстансы, но не сохраняет
        BlogPost::factory()->count(50)->make()->each(function ($post) use($users){
            $post->user_id = $users->random()->id;
            $post->save();
        });
    }
}
