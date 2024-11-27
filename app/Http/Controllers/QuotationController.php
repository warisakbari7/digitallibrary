<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Contact;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->type == 'admin')
        {
            $quotations = Quotation::orderBy('id','desc')->paginate(30);
            $books = Book::where('approved','no')->get();
            $articles = Article::where('approved','no')->get();
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            return view('backend.quotation.index',compact('uvcontacts','quotations','books','articles'));
        }
        elseif(Auth::user()->type == 'librarian')
        {
            $categories = Category::where("user_id",Auth::user()->id);
            $id = $categories->pluck('id')->toArray();
            $quotations = Quotation::orderBy('id','desc')->paginate(30);
            $books = Book::where('approved','no')->whereIn("category_id",$id)->get();
            $articles = Article::where('approved','no')->whereIn("category_id",$id)->get();
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            return view('backend.quotation.index',compact('uvcontacts','quotations','books','articles'));
        }
        else
        {
            return abort(404);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['image'=>'required|image|mimes:jpg,jpeg,png']);
        $name = time().rand(1,1000).date('dmy').'.'.$request->file('image')->getClientOriginalExtension();
        $q = new Quotation();
        $q->image = $name;
        $q->user_id = Auth::user()->id;
        $q->save();
        $request->file('image')->move(public_path('application/quotation'),$name);
        $div = '<div class="col-lg-4 mb-4 '. $q->id .'">'.
                    '<div class="gallery-item">'.
                        '<a href="#'. $q->id .'">'.
                        '<img src="'. asset('application/quotation/'.$q->image) .'" alt="" style="height: 200px;" class="img-fluid w-100 shadow rounded"></a>
                    </div>
                </div>';
        $owner = (Auth::user()->id == $q->user_id) ? '<strong> you </strong>' : '<strong> '. $q->user->name .' </strong>';
        $popup = '<div id="'. $q->id .'" class="overlay">'.
        '<div class="popup bg-light rounded p-4  position-relative" style="max-width: 500px; margin: 2em auto;">
            <a class="close mb-3" href="#about">&times;</a>
            <img src="'. asset('application/quotation/'.$q->image) .'" alt="Popup Image" class="img-fluid shadow rounded" />  
            <p class=" text-monospace text-muted small my-3 text-lg">Added By : '.$owner.'
        
            </p>
            <button id="'. $q->id .'" onclick="ShowModal(this)" class="btn btn-danger">Delete</button>
        </div>
        </div>';
        return response()->json(['message'=>'success','row' => $div,'popup'=> $popup]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function show(Quotation $quotation)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function edit(Quotation $quotation)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quotation $quotation)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $q =  Quotation::find($request->id);
        File::delete(\public_path('application/quotation/'.$q->image));
        $q->delete();
        return \response()->json(['message' => 'success','id'=>$request->id]);
    }
}
