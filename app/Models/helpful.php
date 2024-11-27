<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class helpful extends Model
{
    use HasFactory;
    protected $fillable = ['review_id','user_id','type','helpful'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
