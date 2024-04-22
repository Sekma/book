<?php
use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;



//Route::get('/', function () {
  //  return view('admin/book');
//});

Route::get('/dashboard', function () {
    return Redirect::to('/admin/book');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('logout', function ()
{
    auth()->logout();
    Session()->flush();

    return Redirect::to('/');
})->name('logout');
//Route::get('/', ['App\Http\Controllers\FrontController', 'index']);
// routes sécurisées
Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('book/{id}', [FrontController::class, 'show'])->where(['id' => '[0-9]+'])->name('book');
Route::get('author/{id}', [FrontController::class, 'showBookByAuthor'])->where(['id' => '[0-9]+'])->name('author');
Route::get('genre/{id}', [FrontController::class, 'showBookByGenre'])->where(['id' => '[0-9]+'])->name('genre');

//partie admin
Route::resource('admin/book', 'App\Http\Controllers\BookController')->middleware('auth');

require __DIR__.'/auth.php';

/* Route::get('/', [FrontController::class, 'index'])->name('books.index'); */
// OR
//Route::get('/', 'App\Http\Controllers\FrontController@index');

// retourne une ressource en fonction de son id
//Route::get('book/{id}', 'App\Http\Controllers\FrontController@show');

// retourne une ressource en fonction de son id
//Route::get('author/{id}', 'App\Http\Controllers\FrontController@showBookByAuthor');

// retourne une ressource en fonction de son id
//Route::get('genre/{id}', 'App\Http\Controllers\FrontController@showBookByGenre');


/*   
Route::get('/', function () {
  return view('front.index');
});  */
/*  Route::get('test', function(){
  return "Je suis un test";
}); */

// retourne l'ensemble des books
/* Route::get('books', function(){
  return App\Models\Book::all();
}); */

