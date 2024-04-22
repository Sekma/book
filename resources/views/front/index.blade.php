@extends('layouts.master')

@section('content')

    <h1>Tous les livres</h1>

    {{$books->links()}}
    <ul class="list-group bg-white p-2 border">
    @forelse($books as $book)
        <li class="list-group-item">
        <h2><a class="text-decoration-none text-primary-emphasis" href="{{route('book', $book->id)}}">{{$book->title}}</a></h2>
       


        <div class="row">
    
                <div class="col-xs-6 col-md-3">
                @if(!empty($book->picture))
                    <a class="text-decoration-none text-primary-emphasis" href="#" class="thumbnail">
                    <img width="171" src="{{asset('images/'.$book->picture->link)}}" alt="{{$book->picture->title}}">
                    </a>
                @else
                    <p class="text-center my-5 text-danger">"Pas d'image"</p>
                @endif
                </div>
   
        <div class="col-xs-6 col-md-9">
        <h2>Description :</h2>
        {{$book->description}}
        </div>
        </div>



<h3>Auteur(s) :</h3>
    <ul>
        @forelse($book->authors as $author)
        <li ><a class="text-decoration-none text-primary-emphasis" href="{{route('author', $author->id)}}">{{$author->name}}</a></li>
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

