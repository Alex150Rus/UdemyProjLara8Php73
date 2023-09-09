<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * php artisan db:seed
     * @return void
     */
    public function run()
    {
        if($this->command->confirm('Do you want refresh db?')) {
            $this->command->call('migrate:refresh');
            $this->command->info('db was refreshed');
        }

        Cache::tags(['blog-post'])->flush();

        $this->call([
            UsersTableSeeder::class,
            BlogPostsTableSeeder::class,
            CommentsTableSeeder::class
        ]);
    }
}
