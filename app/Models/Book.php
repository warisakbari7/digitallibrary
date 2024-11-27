<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'author',
        'size',
        'path',
        'views',
        'pages',
        'chapter',
        'about_author',
        'about_book',
        'image',
        'approved',
        'tags',
        'category_id',
        'owner_id',
        'approved_by',
        'language',
        'publish_date',
    ];
  
    protected $dates = ['created_at'];

    public function owner()
    {
        return $this->belongsto(User::class,'owner_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class,'approved_by');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews(){
        return $this->morphMany(Review::class,'reviewable');
    }

    public function SavedBy()
    {
        return $this->morphToMany(User::class,'saveable');
    }
} 

