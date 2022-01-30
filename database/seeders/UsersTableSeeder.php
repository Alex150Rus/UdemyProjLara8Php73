<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //"App\Models\User"
        User::factory()->johnDoe()->create();
        //"Illuminate\Database\Eloquent\Collection"
        User::factory()->count(20)->create();
    }
}
