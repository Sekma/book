@extends('layouts.master')

@section('content')
<article class="row p-2 border mt-2 bg-white">
    <div class="col-md-12">
    @if($book->count())
    <h1 class="mb-4">{{$book->title}}</h1>
    <div class="row">
       
            <div class="col-12 col-lg-4 bg-light text-center py-2 border">
            @if(!empty($book->picture))
                <a href="#" class="thumbnail">
                <img src="{{asset('images/'.$book->picture->link)}}" alt="{{$book->picture->title}}"  class="img-fluid">
                </a>
            @else
                <p class="text-center my-5 text-danger">"Pas d'image"</p>
            @endif
            </div>
        
        <div class="col">
            <h2>Description :</h2>
            {{$book->description}}  
        </div>
          
    </div>
    <h3 class="mt-2">Auteur(s) :</h3>
    
    <ul>
        @forelse($book->authors as $author)
        <li ><a class="text-decoration-none text-primary-emphasis" href="{{route('author', $author->id)}}">{{$author->name}}</a></li>
        @empty
        <li>Aucun auteur</li>
        @endforelse
    </ul>
    @else 
    <h1>Désolé aucun article</h1>
    @endif 
 </li>
    </div>
</article>

</ul>
@endsection 
