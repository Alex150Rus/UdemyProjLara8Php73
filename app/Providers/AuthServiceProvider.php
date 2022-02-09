<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update-post', function($user, $blogPost){
            return $user->id === $blogPost->user_id;
        });

        Gate::define('delete-post', function($user, $blogPost){
            return $user->id === $blogPost->user_id;
        });

        //will be called before other Gate checks. And should always return true
        Gate::before(function($user, $ability){
            if($user->is_admin) {
                return true;
            }
        });

//        //Overriding ability
//        Gate::before(function($user, $ability){
//            if($user->is_admin && $ability === 'delete-post') {
//                return true;
//            }
//        });
//
//        //Overriding abilities
//        Gate::before(function($user, $ability){
//            if($user->is_admin && in_array($ability, ['delete-post', 'update-post'])) {
//                return true;
//            }
//        });

//        Gate::after(function($user, $ability, $result){
//            if($user->is_admin) {
//                return true;
//            }
//        });
    }
}
