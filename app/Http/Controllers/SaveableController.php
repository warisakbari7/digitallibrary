<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AudioBook;
use App\Models\Book;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SaveableController extends Controller
{
    public function book(Book $book)
    {
        $result = $book->SavedBy()->toggle(Auth::user()->id);
        return response()->json($result->toArray());
    }



    public function isLoginBook(Book $book)
    {

        return Redirect::to(route("show.book",$book->id));        
    }

    public function audiobook(AudioBook $audiobook)
    {
        $result = $audiobook->SavedBy()->toggle(Auth::user()->id);
        return response()->json($result);
    }

    public function isLoginAudioBook(AudioBook $book)
    {

        return Redirect::to(route("show.audiobook",$book->id));        
    }

    public function article(Article $article)
    {
        $result = $article->SavedBy()->toggle(Auth::user()->id);
        return response()->json($result);
    }

    public function isLoginArticle(Article $article)
    {

        return Redirect::to(route("show.article",$article->id));        
    }

}
