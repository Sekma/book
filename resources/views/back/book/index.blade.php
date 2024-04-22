@extends('layouts.master')

@section('content')
<p><a href="{{route('book.create')}}"><button type="button" class="btn btn-primary btn-lg">Ajouter un livre</button></a></p>
{{$books->links()}}
{{-- On inclut le fichier des messages retournés par les actions du contrôleurs BookController--}}
@include('back.book.partials.flash')
<table class="table table-striped">
    <thead>
        <tr>
            <th>Title</th>
            <th>Authors</th>
	        <th>Genre</th>
            <th>Date de publication</th>
            <th>Status</th>
            <th>Edition</th>
            <th>Show</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
    @forelse($books as $book)
        <tr class="text-center">
            <td>{{$book->title}}</td>
            <td>
            @forelse($book->authors as $author)
                {{$author->name}}
            @empty
            aucun auteur
            @endforelse
            </td>
	        <td>{{$book->genre->name?? 'aucun genre' }}</td>
            <td>{{$book->created_at}}</td>
            <td @if(($book->status) == "published") class="btn btn-success bg-success text-white" @elseif(($book->status) == "unpublished") class="btn btn-warning bg-warning text-white" @endif>{{$book->status}}</td>
            <td class="text-center">
            <a href="{{route('book.edit', $book->id)}}"><span class="fa fa-edit" aria-hidden="true"></span></a>
            </td>
            <td class="text-center">
                <a href="{{route('book.show', $book->id)}}"><i class="fa fa-eye" aria-hidden="true"></i></a>
            </td>
            <td>
            <form class="delete" method="POST" action="{{route('book.destroy', $book->id)}}">
                 @method('DELETE')
                 @csrf
                <input class="btn btn-danger" type="submit" value="delete" >
            </form>
            </td>
        </tr>
    @empty
        aucun titre ...
    @endforelse
    </tbody>
</table>
{{$books->links()}}
@endsection 

@section('scripts')
    @parent
    <script src="{{asset('js/confirm.js')}}"></script>
@endsection 
