<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostsController;
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
// or
//Route::view('/', 'home.index')->name('home.index');
// or
Route::get('/', [HomeController::class, 'home'])->name('home.index');



//Route::get('/contact', function () {
//   return view('home.contact');
//})->name('home.contact');
// or
//Route::view('/contact', 'home.contact')->name('home.contact');
// or
Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');

Route::get('/single', AboutController::class);

$posts = [
    1 => [
        'title' => 'Intro to Laravel',
        'content' => 'This is a short intro to Laravel',
        'is_new' => true,
        'has_comments' => true,
    ],
    2 => [
        'title' => 'Intro to PHP',
        'content' => 'This is a short intro to PHP',
        'is_new' => false,
    ],
    3 => [
        'title' => 'Intro to Golang',
        'content' => 'This is a short intro to Golang',
        'is_new' => false,
    ]
];

//only - the actions to use, except - the actions not to use
Route::resource('posts', PostsController::class);
    //->only(['index', 'show', 'create', 'store', 'edit', 'update']);

//Route::get('/posts', function () use ($posts) {
//    //dd function for dump data, dump and die
//    //dd(request()->all());
//    //dd((int)request()->input('page', 1)); //for query, json, form params
//    dd((int)request()->query('page', 1)); //for query only
//
//    /* $request->boolean('archieved'); true for 1, "1", true, "true", "on" and "yes"
//     * $request->only(['username', 'password'])
//     * $request->only('username', 'password')
//     * $request->except(['credit_card'])
//     * $request->except('credit_card')
//     * if ($request->has('name') {}
//     * if ($request->has(['name', 'email']) {}
//     * $request->whenHas('name', function($input){})
//     * $request->missing('name', function($input){})
//     * if ($request->hasAny(['name', 'email'])){}
//     * if($request->filled('name')) {}
//     * $request -> whenFilled('name', function($input){})
//     *
//    */
//
//
//    return view('posts.index', ['posts' => $posts]);
//});

/* using route parameters {}, the order is important as they go to function in the same order. /posts is not available
w/o parameter */
//Route::get('/posts/{id}', function ($id) use ($posts) {
//
//    abort_if(!isset($posts[$id]), 404);
//
//    return view('posts.show', ['post' => $posts[$id]]);
//})
////constraining route params ->where(['id' => '\d+']) or as we did add Route::patter('id', /d+)
//// in RouteServiceProvider::class
//    ->name('posts.show');

//using optional parameters {?}. It's better to make default argument in function. /recent-posts is available w/o param
//Route::get('/recent-posts/{days_ago?}', function ($daysAgo = 20) {
//    return 'Posts from ' . $daysAgo . ' days ago';
//})->name('posts.recent.index')
//    //из App\Http\Kernel, 'auth' tells that user needs to be authenticated to visit this route, middleware is also
//    //can accept parameters
//    ->middleware('auth');

Route::prefix('/fun')->name('fun.')->group(function() use ($posts){

    Route::get('responses', function () use ($posts){
        return response($posts, 201)->header('Content-Type', 'application/json')
            ->cookie('MY_COOKIE', 'Alex Medvedev', 3600);
    })->name('responses');

    Route::get('redirect', function (){
        return redirect('/contact');
    })->name('redirect');

    Route::get('back', function (){
        return back();
    })->name('back');

    Route::get('named-route', function (){
        return redirect()->route('posts.show', ['id' => 1]);
    })->name('named-route');

    Route::get('away', function (){
        return redirect()->away('https://google.com');
    })->name('away');

    Route::get('json', function () use ($posts){
        return response()->json($posts);
    })->name('json');

    Route::get('download', function () {
        //face.jpg - a new name of file
        return response()->download(public_path('/daniel.jpg'), 'face.jpg');
    })->name('download');

});

