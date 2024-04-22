<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book; // importez l'alias de la classe
use App\Models\Author;
use App\Models\Genre;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function __construct(){

        // méthode pour injecter des données à une vue partielle 
        view()->composer('partials.menu', function($view){
            $genres = Genre::pluck('name', 'id')->all(); // on récupère un tableau associatif ['id' => 1]
            $view->with('genres', $genres ); // on passe les données à la vue
        });
    } 
    
    public function index(){
        $prefix = request()->page?? 'home';
        $path = 'book'.$prefix;

        $books = Cache::remember($path, 60*24, function(){
        /* return Book::all(); */ // retourne tous les livres de l'application
        return Book::published()->with('picture', 'authors')->paginate(5); // pagination
        
       // $books = Book::all(); // pagination 
    });
        return view('front.index', ['books' => $books]);
            }

    public function show(int $id){

        // vous ne récupérez qu'un seul livre 
        $book = Book::find($id);

        // que vous passez à la vue
        return view('front.show', ['book' => $book]);
    }

    public function showBookByAuthor(int $id){

        $author= Author::find($id); // récupérez les informations liés à l'auteur
        $books = $author->books()->published()->paginate(5); // on récupère tous les livres d'un auteur

        // On passe les livres et le nom de l'auteur
        return view('front.author', ['books' => $books, 'author' => $author]);

    }
    public function showBookByGenre(int $id){
        // on récupère le modèle genre.id 
        $genre = Genre::find($id);

        $books = $genre->books()->published()->paginate(5);

        return view('front.genre', ['books' => $books, 'genre' => $genre]);
    }
}
