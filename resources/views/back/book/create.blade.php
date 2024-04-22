@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1>Create Book :  </h1>
                <form action="{{route('book.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="form">
                        <div class="form-group">
                            <label for="title">Titre :</label>
                            <input type="text" name="title" value="" class="form-control" id="title" placeholder="Titre du livre">
                            @if($errors->has('title')) <span class="error">{{$errors->first('title')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="price">Description :</label>
                            <textarea type="text" name="description"class="form-control"></textarea>
                            @if($errors->has('description')) <span class="error">{{$errors->first('description')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-inline mt-2">
                    <label for="genre">Genre :</label>
                    <select id="genre" name="genre_id">
                        <option value="0" {{ is_null(old('genre_id'))? 'selected' : '' }} >No genre</option>
                        @foreach($genres as $id => $name)
                            <option value="{{$id}}">{{$name}}</option>
                        @endforeach
                    </select>
                    </div>
                    <h1>Choisissez un/des auteurs</h1>
                    <div class="form-inline">
                        
                    @forelse($authors as $id => $name)
                        <div class="form-check my-1">
                            <input name="authors[]" value="{{$id}}" type="checkbox" class=" form-check-input" id="author{{$id}}">
                            <label class="form-check-label" for="author{{$id}}">{{$name}}</label>
                        </div>
                    @empty
                    @endforelse
                    </div>
            </div><!-- #end col md 6 -->
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Ajouter un livre</button>
                <div class="input-radio">
            <h2>Status</h2>
            <input type="radio" name="status" value="published" checked> publier<br>
            <input type="radio" name="status" value="unpublished" checked> dépulier<br>
            </div>
            <div class="input-file">
                <h2>File :</h2>
                <input class="file" type="file" name="picture" >
            </div>
            </div><!-- #end col md 6 -->
            </form>
        </div>
@endsection
