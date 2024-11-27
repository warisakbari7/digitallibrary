<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $dates = ['created_at'];
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'body',
        'rate',
        'recommendation',
    ];
    public function reviewable()
    {
        return $this->morphTo();
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function book(){
        return $this->belongsTo(Book::class,'reviewable_id','id');
    }

    public function article(){
        return $this->belongsTo(Book::class,'reviewable_id','id');
    }

    public function helpfuls()
    {
        return $this->hasMany(helpful::class);
    }
}
