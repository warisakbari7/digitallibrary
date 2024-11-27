<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'lastname',
        'image',
        'occupation',
        'is_active',
        'live_in',
        'phone',
        'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function catagory()
    {
        return $this->hasMany(Category::class);
    }

    public function UploadedArticles()
    {
        return $this->hasMany(Article::class,'owner_id');
    }

    public function UploadedBooks()
    {
        return $this->hasMany(Book::class,'owner_id');
    }

    public function UploadedAudioBooks()
    {
        return $this->hasMany(AudioBook::class,'owner_id');
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function SavedBooks()
    {
        return $this->morphedByMany(Book::class,'saveable');
    }

    public function SavedAudioBooks()
    {
        return $this->morphedByMany(AudioBook::class,'saveable');
    }
    
    public function SavedArticles()
    {
        return $this->morphedByMany(Article::class,'saveable'); 
    }
  }
