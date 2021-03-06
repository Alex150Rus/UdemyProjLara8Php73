<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Profile;
use Closure;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Author::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }

    public function afterCreating(Closure $callback)
    {
        return parent::afterCreating($callback); // TODO: Change the autogenerated stub
    }
}

$factory = new AuthorFactory();
$factory->afterCreating(function ($author, $faker){
    $profileFactory = new ProfileFactory();
    $author->profile()->save($profileFactory->make());
});
