<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Naming routes is the best practice


//Route::get('/', function () {
//    return view('home.index', []);
//})->name('home.index');
Route::view('/', 'home.index')->name('home.index');


//Route::get('/contact', function () {
//   return view('home.contact');
//})->name('home.contact');
Route::view('/contact', 'home.contact')->name('home.contact');

/* using route parameters {}, the order is important as they go to function in the same order. /posts is not available
w/o parameter */
Route::get('/posts/{id}', function ($id){
    $posts = [
        1 => [
            'title' => 'Intro to Laravel',
            'content' => 'This is a short intro to Laravel'
        ],
        2 => [
            'title' => 'Intro to PHP',
            'content' => 'This is a short intro to PHP'
        ]
    ];

    abort_if(!isset($posts[$id]), 404);

    return view('posts.show', ['post' => $posts[$id]]);
})
//constraining route params ->where(['id' => '\d+']) or as we did add Route::patter('id', /d+)
// in RouteServiceProvider::class
->name('posts.show');

//using optional parameters {?}. It's better to make default argument in function. /recent-posts is available w/o param
Route::get('/recent-posts/{days_ago?}', function ($daysAgo = 20) {
    return 'Posts from ' . $daysAgo . ' days ago';
})->name('posts.recent.index');
