<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book; // importez l'alias de la classe
use App\Models\Author;
use App\Models\Genre;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LengthException;

class BookController extends Controller
{
   // public function __construct(){

        // méthode pour injecter des données à une vue partielle 
     //   view()->composer('partials.menu', function($view){
       //     $genres = Genre::pluck('name', 'id')->all(); // on récupère un tableau associatif ['id' => 1]
         //   $view->with('genres', $genres ); // on passe les données à la vue
       // });
    //} 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genres = Genre::pluck('name', 'id')->all(); 
         /* return Book::all(); */ // retourne tous les livres de l'application
         $books = Book::paginate(5);
         // $books = Book::all(); // pagination 
          return view('back.book.index', ['books' => $books, 'genres' => $genres]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // permet de récupérer une collection type array avec en clé id => name
        $authors = Author::pluck('name', 'id')->all();
        $genres = Genre::pluck('name', 'id')->all();

        return view('back.book.create', ['authors' => $authors, 'genres' => $genres]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required|string',
            'genre_id' => 'integer',
            'authors.*' => 'integer', // pour vérifier un tableau d'entiers il faut mettre authors.*
            'status' => 'in:published,unpublished',
            'title_image' => 'string|nullable', // pour le titre de l'image si il existe
            'picture' => 'image|max:3000'
        ]);
        $book = Book::create($request->all());
        // On utilise le modèle Book et la relation authors ManyToMany pour attacher des/un nouveaux/nouvel auteur(s)
        // à un livre que l'on vient de créer en base de données.
        // Attention $request->authors correspond aux donnes du formulaire alors $book->authors() à la relation ManyToMany
        $book->authors()->attach($request->authors);

         // image
         $im = $request->file('picture');
        
         // si on associe une image à un book 
         if (!empty($im)) {
             
             $link = $request->file('picture')->store('images');
 
             // mettre à jour la table picture pour le lien vers l'image dans la base de données
             $book->picture()->create([
                 'link' => $link,
                 'title' => $request->title_image?? $request->title
             ]);
         }

        return redirect()->route('book.index')->with('message', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::find($id);

        return view('back.book.show', ['book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Book::find($id);

        $authors = Author::pluck('name', 'id')->all();
        $genres = Genre::pluck('name', 'id')->all();
    
        return view('back.book.edit', compact('book', 'authors', 'genres'));
        //return dump(compact('book', 'authors', 'genres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required|string',
            'genre_id' => 'integer',
            'authors.*' => 'integer', // pour vérifier un tableau d'entiers il faut mettre authors.*
            'status' => 'in:published,unpublished'
        ]);

        $book = Book::find($id); // associé les fillables

        $book->update($request->all());
        
        // on utilisera la méthode sync pour mettre à jour les auteurs dans la table de liaison
        $book->authors()->sync($request->authors);

        // image
        $im = $request->file('picture');
        
        // si on associe une image à un book 
        if (!empty($im)) {

            $link = $request->file('picture')->store('images');

            // suppression de l'image si elle existe 
            if(!empty($book->picture)){
                Storage::disk('local')->delete($book->picture->link); // supprimer physiquement l'image
                $book->picture()->delete(); // supprimer l'information en base de données
            }

            // mettre à jour la table picture pour le lien vers l'image dans la base de données
            $book->picture()->create([
                'link' => $link,
                'title' => $request->title_image?? $request->title
            ]);
            
        }

        $bookCount = DB::table('books')->count();
        if($bookCount>$id){
            $result=$id;
        }
        else{
            $result=$bookCount;
        }
        $page= (int) ( ($result - 1) / 5 ) + 1;
        return redirect('admin/book?page='.$page)->with('message', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
            $book = Book::find($id);

        $book->delete();

        return redirect()->route('book.index')->with('message', 'success delete');
    }
}
