@extends('layouts.master')

@section('content')
    
                <h1>Edit Book :  </h1>
                <form action="{{route('book.update', $book->id)}}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form">
                                    <div class="form-group">
                                        <label for="title">Titre :</label>
                                            <input type="text" name="title" value="{{$book->title}}" class="form-control" id="title"
                                                placeholder="Titre du livre">
                                            @if($errors->has('title')) <span class="error bg-warning text-warning">{{$errors->first('title')}}</span>@endif
                                    </div>
                                    <div class="form-group">
                                            <label for="price">Description :</label>
                                            <textarea type="text" name="description"class="form-control">{{$book->description}}</textarea>
                                            @if($errors->has('description')) <span class="error bg-warning text-warning">{{$errors->first('description')}}</span> @endif
                                    </div>
                                </div>
                                <div class="form-inline mt-2">
                                    <label for="genre">Genre :</label>
                                    <select id="genre" name="genre_id">
                                            <option value="0" {{is_null($book->genre)? 'selected' : '' }} > No genre </option>
                                        @foreach($genres as $id => $name)
                                            <option value="{{$id}}" {{ (!is_null($book->genre) and $book->genre->id == $id)? 'selected' : '' }} >{{$name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <h1>Choisissez un/des auteurs</h1>
                                <div class="form-inline">
                                @forelse($authors as $id => $name)
                                    <div class="form-check my-1">
                                        <input class=" form-check-input" name="authors[]" value="{{$id}}"
                                                @if( is_null($book->authors) == false and  in_array($id, $book->authors()->pluck('id')->all()))
                                                checked
                                                @endif
                                                type="checkbox" class="form-control"
                                                id="author{{$id}}">
                                        
                                                <label class="form-check-label" for="author{{$id}}">{{$name}}</label>
                                                
                                    </div>
                                @empty
                                @endforelse
                                </div>
                            </div><!-- #end col md 6 -->
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Modifiez un livre</button>
                                <div class="input-radio">
                                    <h2>Status</h2>
                                    <input type="radio" name="status" value="published" @if(old('status', $book->status) == "published") checked @endif> publier<br>
                                    <input type="radio" name="status" value="unpublished" @if(old('status', $book->status) == "unpublished") checked @endif> dépulier<br>
                                </div>
                                <div class="input-file">
                                    <h2>File :</h2>
                                    <input class="file" type="file" name="picture" >
                                    @if($errors->has('picture')) <span class="error bg-warning text-warning">{{$errors->first('picture')}}</span> @endif
                                </div>

                                <h2><strong>Image</strong></h2>
                                <div class="col-xs-6 col-md-3">
                                @if(!empty($book->picture))    
                                    <a href="#" class="thumbnail">
                                    <img src="{{asset('images/'.$book->picture->link)}}" alt="{{$book->picture->title}}" class="img-fluid">
                                    </a>
                                @else
                                    <p class="text-center my-5 text-danger">"Pas d'image"</p>
                                @endif
                                </div>
                            </div><!-- #end col md 6 -->
                        </div>
                    </div>
                </form>
        
        
@endsection