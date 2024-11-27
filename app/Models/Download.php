<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;
    public function Books()
    {
        return $this->belongsTo(Book::class,'downloadable_id');
    }

    public function articles()
    {
        return $this->belongsTo(Article::class,'downloadable_id');
    }
    
    public function audios()
    {
        return $this->belongsTo(AudioBook::class,'downloadable_id');
    }
}
