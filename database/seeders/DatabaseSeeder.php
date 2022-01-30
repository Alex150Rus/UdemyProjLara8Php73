<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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

        $this->call([
            UsersTableSeeder::class,
            BlogPostsTableSeeder::class,
            CommentsTableSeeder::class
        ]);
    }
}
