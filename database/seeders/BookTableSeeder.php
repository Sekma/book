<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Genre;
use App\Models\Author;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // on prendra garde de bien supprimer toutes les images avant de commencer les seeders
        Storage::disk('local')->delete(Storage::allFiles());

        //création des genres
        Genre::create([
            'name' => 'science'
        ]);
        Genre::create([
            'name' => 'maths'
        ]);
        Genre::create([
            'name' => 'cookbook'
        ]);

        // création 30 livres à partir de la factory
        Book::factory()->count(30)->create()->each(function($book){
            // associer un genre à un livre que nous venons de créer
            $genre = Genre::find(rand(1,3));

            // pour chaque $book on lui associe un genre en particulier
            $book->genre()->associate($genre);
            // il faut sauvegarder l'association pour faire persister en base de données
            $book->save();

            // ajout des images
            // On utilise futurama sur lorempicsum pour récupérer des images aléatoirement
            // attention il n'y en a que 9 en tout différentes
            $link = Str::random(12) . '.jpg'; // hash de lien pour la sécurité (injection de scripts protection)
            $file = file_get_contents('https://source.unsplash.com/250x250/'); // flux
            Storage::disk('local')->put($link, $file);

            $book->picture()->create([
                'title' => 'Default', // valeur par défaut
                'link' => $link
            ]);

            // récupération des id des auteurs à partir de la méthode pluck d'Eloquent
            // les méthodes du pluck shuffle et slice permettent de mélanger et récupérer un certain 
            // nombre 3 à partir de l'indice 0, comme ils sont mélangés à chaque fois qu'un livre est créé
            // on aura des id à chaque fois aléatoires.
            // La méthode all permet de faire la requête et de récupérer le résultat sous forme d'un tableau
            $authors = Author::pluck('id')->shuffle()->slice(0,rand(1,3))->all();

            // Il faut se mettre maintenant en relation avec les auteurs (relation ManyToMany) et attacher les id des auteurs
            // dans la table de liaison.
            $book->authors()->attach($authors); // ici on n'a pas besoin de faire persister c'est automatique dans une relation ManyToMany
        });
    }
}
