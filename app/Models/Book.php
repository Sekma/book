<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    use HasFactory;

    protected $fillable = [
        'title', 'description', 'genre_id', 'status'
    ];

    // ici le setter va récupérer la valeur à insérer en base de données
    // nous pourrons alors vérifier sa valeur avant que le modèle n'insère la donnée en base de données
    public function setGenreIdAttribute($value){
       
        if($value == 0){
            $this->attributes['genre_id'] = null;
        }else{

            $this->attributes['genre_id'] = $value;
        }

    }

    
        public function genre(){
        return $this->belongsTo(Genre::class);
        }
        public function authors(){
            return $this->belongsToMany(Author::class);
            }
        public function picture(){
            return $this->hasOne(Picture::class);
            }

        public function scopePublished($query){
            return $query->where('status', 'published');
        }

}
