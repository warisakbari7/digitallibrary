<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function audiobooks()
    {
        return $this->hasMany(AudioBook::class);
    }
}
