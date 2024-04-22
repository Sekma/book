@extends('layouts.master')

@section('content')
<h1>Tous les livres par genre {{$genre->name?? 'aucun genre'}}</h1>
{{$books->links()}}
<ul class="list-group">
@forelse($books as $book)
<li class="list-group-item">
<h2><a class="text-decoration-none text-primary-emphasis" href="{{url('book', $book->id)}}">{{$book->title}}</a></h2>
<div class="row">

        <div class="col-xs-6 col-md-3">
        @if(!empty($book->picture))
            <a href="#" class="thumbnail">
            <img width="171" src="{{asset('images/'.$book->picture->link)}}" alt="{{$book->picture->title}}">
            </a>
        @else
            <p class="text-center my-5 text-danger">"Pas d'image"</p>
        @endif
        </div>

<div class="col-xs-6 col-md-9">
{{$book->description}}
</div>
</div>
<h3>Liste des autres Auteur(s) :</h3>
    <ul>
        @forelse($book->authors as $author)
        <li ><a class="text-decoration-none text-primary-emphasis" href="{{url('author', $author->id)}}">{{$author->name}}</a></li>
        @empty
        <li>Aucun auteur</li>
        @endforelse
    </ul>
 </li>
@empty
<li>Désolé pour l'instant aucun livre n'est publié sur le site</li>
@endforelse
</ul>
{{$books->links()}}
@endsection 

