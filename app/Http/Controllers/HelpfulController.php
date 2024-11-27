<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\helpful;
use Illuminate\Support\Facades\Auth;

class HelpfulController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::user()->type == 'client')
        {
            $user = Auth::user()->id;
            helpful::updateOrCreate(['user_id'=>$user,'review_id'=>$request->id,'type'=>$request->type],
           ['helpful'=>$request->helpful]);
        }

    }
}
