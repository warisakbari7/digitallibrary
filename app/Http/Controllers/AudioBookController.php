<?php

namespace App\Http\Controllers;

use App\Models\AudioBook;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Article;
use App\Models\Category;
use App\Models\Download;
use App\Models\Contact;
use App\Models\Tag;
use App\Helpers\Number;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Facades\Jorenvh\Share\Share;

class AudioBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();
        if(Auth::user()->type == 'librarian')
        {
            $catagories = Category::where('user_id',Auth::user()->id)->get();
            $id = $catagories->pluck('id')->toArray();
            $abooks = AudioBook::orderBy("id",'desc')->whereIn('category_id',$id)->where("approved","yes")->paginate(30);
            $books = Book::whereIn('category_id',$id)->where('approved','no')->get();
            $articles = Article::whereIn('category_id',$id)->where('approved','no')->get();
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            return view("backend.audiobook.index",compact('uvcontacts','books','catagories','tags','abooks','articles'));
        }
        else if(Auth::user()->type == 'admin')
        {
            $catagories = Category::all();
            $abooks = AudioBook::orderBy("id",'desc')->where("approved","yes")->paginate(30);
            $books = Book::where('approved','no')->get();
            $articles = Article::where('approved','no')->get();
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            return view("backend.audiobook.index",compact('uvcontacts','books','catagories','tags','abooks','articles'));
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
        if($request->has('validate'))
        {
            $request->validate([
                'b_author' => 'required|max:255',
                'b_edition' => 'required',
                'b_name' => 'required|max:255',
            ]);
            $obj = AudioBook::where('title',trim($request->b_name))->where('author',trim($request->b_author))->where('edition',$request->b_edition)->get();
            if(count($obj) > 0)
                return response()->json(['msg' => 'failed']);
            else
                return response()->json(['msg' => 'success']);
        }
        else
        {
            $request->validate([
                'b_author' => 'required|max:255',
                'b_book' => 'required|mimes:mp3',
                'b_catagory' => 'required',
                'b_chapter' => 'required',
                'b_cover' => 'required|mimes:jpg,jpeg,png|image',
                'b_edition' => 'required',
                'b_name' => 'required|max:255',
                'b_page' => 'required',
                'b_language' => 'required',
                'tags' => 'required',
                'b_publish' => 'required|date',
            ]);
            $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
            $power = $request->file("b_book")->getSize() > 0 ? floor(log($request->file("b_book")->getSize(), 1024)) : 0;
            $size = number_format($request->file("b_book")->getSize() / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power]; 
            $pdf = time().rand(1,1000).date('dmy').'.'.$request->file('b_book')->getClientOriginalExtension();
            $cover = time().rand(1,1000).date('dmy').'.'.$request->file('b_cover')->getClientOriginalExtension();
            $request->file('b_book')->move(\public_path('application/audiobooks/audio'),$pdf);
            $request->file('b_cover')->move(\public_path('application/audiobooks/cover'),$cover);
            $book = new AudioBook();
            $book->title = ucwords(trim($request->b_name));
            $book->author = ucwords(trim($request->b_author));
            $book->size = $size;
            $book->path = $pdf;
            $book->views = 0;
            $book->rate = 0;
            $book->pages = $request->b_page;
            $book->chapter = $request->b_chapter;
            $book->publish_date = $request->b_publish;
            $book->about_author = trim($request->b_aboutauthor);
            $book->about_book = trim($request->b_aboutbook);
            $book->image = $cover;
            $book->approved = 'yes';
            $book->approved_by = Auth::user()->id;
            $book->language = $request->b_language;
            $book->edition = $request->b_edition;
            $book->tags = trim($request->tags);
            $book->category_id = $request->b_catagory;
            $book->owner_id = Auth::user()->id;
            $book->save();
            $row =' <tr id="'. $book->id .'">
            <td class="text-left">
              <div><img src="'. asset('application/audiobooks/cover/'.$book->image) .'" alt="user"
                  class="rounded img-fluid" style="width:40px !important; height:45px !important;"></div>
            </td>
            <td>'. ucwords($book->title) .'</td>
            <td>'. ucwords($book->author) .'</td>
            <td>'. $book->edition .'</td>

            <td>'. $book->created_at->diffForhumans() .'</td>
            <td><a href="'. route('audiobook.show',$book->id) .'"> <i class=" btn-sm btn-secondary fa fa-eye "></i>
              </a></td>
            </tr>';
            return response()->json(['msg'=>'success','row'=>$row]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AudioBook  $book
     * @return \Illuminate\Http\Response
     */
    public function show(AudioBook $audiobook, Request $request)
    {
        $book = $audiobook;
        if($request->ajax())
        {
            $rows = '';
            $last_id = '';
            $btn_load = '';
            $reviews = $book->reviews()->orderBy('id','desc')->where('id','<',$request->review_id)->limit(7)->get();
            if(count($reviews->toArray()) > 0)
            {
                foreach($reviews as $review)
                {
                        $rows .='<div id="r'. $review->id .'" class="row justify-content-center mx-0 py-1">
                        <div class="col-12">
                            <div class="row mx-1">
                                <div class="media align-items-center">
                                    <img class="mr-3 rounded-circle shadow border" width="10%" height="80%" src="'. asset('application/users/'.$review->user->image) .'" alt="image">
                                    <div class="media-body d-flex align-items-center">
                                        <h5 class="mt-0 mb-0 An_Dm_bold">'. $review->user->name .' '. $review->user->lastname .'</h5>';
                                        if(Auth::check())
                                        {
                                            if(Auth::user()->id == $review->user_id || Auth::user()->type == 'librarian' || Auth::user()->type == 'admin')
                                                $rows .='<h6 class="mt-0 mb-0 ml-3 An_Dm_bold"><small><a href="#ConfirmDelete" data-toggle="modal" class="text--two">Edit</a></small></h6>';
                                        }
                                        $rows .= '</div>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mt-3">
                                    <div class=" d-flex  mr-3  ">';
                                        for ($a = 1; $a <=$review->rate; $a++)
                                            $rows .='<small><i class="fa fa-star text--one pr-1 "></i></small>';
                                        for($a = $review->rate; $a <5; $a++)
                                            $rows .='<small><i class="fa fa-star text--six pr-1 "></i></small>';
                                    $rows .= '</div>
                                    <h6 class="text-muted mb-0"><small><span class="">'. $review->created_at->diffForhumans() .'</span></small></h6>
                                </div>
                            </div>
                            <div id="ConfirmDelete" class="collapse mx-1 bg--four text-center rounded my-2">
                                <h5 class="pt-2">Are you Sure to delete review?</h5>
                                <div class="d-flex justify-content-center px-4 py-3">
                                    <button data-id="{{ $review->id }}" class="yes_delete mx-4 btn btn-danger"  style="margin-right:20px !important; width:120px;">Yes, sure</button>
                                </div>
                            </div>
                            <div class="mx-1 mt-2">
                                <h6 class="An_Dm_bold text-break">'. $review->title .'</h6>
                                <p class="text-muted text-justify text-break">'. $review->body .'</p>
                                <div class="d-flex">';
                                    if($review->recommendation == 'yes')
                                    {
                                        $rows .= '<div class="text--two d-flex align-items-center">
                                            <i class="fa fa-check-circle mr-1"></i>
                                            <h5 class="mb-0 An_light"> Yes, <small> I recommend this audio book</small></h5>
                                        </div>';
                                    }
                                    else
                                    {
                                        $rows .= '<div class="text--two d-flex align-items-center ">
                                            <i class="fa fa-times-circle mr-1 mb-1 text-danger"></i>
                                            <h5 class="mb-0 An_light"> No, <small> I don\'t recommend this audio book</small></h5>
                                        </div>';
                                    }
                                    if(Auth::check())
                                    {
                                        $rows .= '<div class="text--five ml-5 d-flex align-items-center">
                                            <h6 class="mb-0 An_light "><small>Helpful?</small></h6>';
                                                if($review->helpfuls->where('user_id',Auth::user()->id)->where("review_id",$review->id)->where("type","audiobook")->first() != '')
                                                    if($review->helpfuls->where('user_id',Auth::user()->id)->where('review_id',$review->id)->where('type','audiobook')->first()->helpful == 'yes')
                                                    {
                                                        $rows .= '<a href="javascript:void(0)" data-type="yes" id="'. $review->id .'" class=" p-0 m-0 nav-link bg--two small  text-white   px-2 rounded-left ml-2">Yes &nbsp;&nbsp; </a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) .'</span>
                                                        <a href="javascript:void(0)" data-type="no" id="'. $review->id .'" class=" help_no p-0 m-0 nav-link bg--four small  text--two rounded-left px-2   ml-2">No &nbsp;&nbsp;</a> <span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) .'</span>';
                                                    }
                                                    else
                                                    {
                                                        $rows .= '<a href="javascript:void(0)" data-type="yes" id="'. $review->id .'" class=" help_yes p-0 m-0 nav-link bg--four small  text--two   px-2 rounded-left ml-2">Yes &nbsp;&nbsp; </a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) .'</span>
                                                        <a href="javascript:void(0)" data-type="no" id="'. $review->id .'" class="p-0 m-0 nav-link bg--two small  text-white rounded-left px-2 ml-2">No &nbsp;&nbsp;</a> <span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">'.Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) .'</span>';
                                                    }
                                                else
                                                {
                                                    $rows .= '<a href="javascript:void(0)" data-type="yes" id="'. $review->id .'" class=" help_yes p-0 m-0 nav-link bg--four small  text--two   px-2 rounded-left ml-2">Yes &nbsp;&nbsp; </a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) .'</span>
                                                    <a href="javascript:void(0)" data-type="no" id="'. $review->id .'" class=" help_no p-0 m-0 nav-link bg--four small  text--two rounded-left px-2   ml-2">No &nbsp;&nbsp;</a> <span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">'.Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) .'</span>';
                                                }
                                        $rows .= '</div>';
                                    }
                                    else
                                    {
                                        $rows .= '<div class="text--five ml-5 d-flex align-items-center">
                                            <h6 class="mb-0 An_light"><small>Helpful?</small></h6>
                                            <a href="'. route("allow.audiobookreview",$book->id) .'" class=" p-0 m-0 nav-link bg--four small  text--two   px-2 rounded-left ml-2">Yes &nbsp;&nbsp; </a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">'.Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) .'</span>
                                            <a href="'. route("allow.audiobookreview",$book->id) .'" class="p-0 m-0 nav-link bg--four small  text--two rounded-left px-2   ml-2">No &nbsp;&nbsp;</a> <span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) .'</span>
                                        </div>';
                                    }
                                $rows .= '</div>
                            </div>
                            <hr>
                        </div>
                    </div>';
                }
                $last_id = $review->id;
                $btn_load = '<button id="btn-more" data-review="'. $review->id .'" class="row w-100 bg--four px-3 py-2 rounded shadow justify-content-center mx-3  mb-5 An_Dm_bold" style="cursor:pointer; border:none">
                See more reviews
                <i class="fa fa-angle-down  mt-1 ml-2"></i>
                </button>';
                return response()->json(['reviews'=>$rows,'button'=>$btn_load]);
            }
            else
            {
                $rows = '';
                $btn_load = '<div class="row bg--one w-100 px-3 py-2 mx-3 rounded shadow justify-content-center mb-5 mx-0 An_Dm_bold" style="cursor:pointer">
                No more reviews
                </div>';
                return response()->json(['reviews'=>$rows,'button'=>$btn_load]);
            }

        }


        $total_review = count($book->reviews->toArray());
        
        $stars = $book->reviews->groupBy('rate'); 

        $averageRate = Helper::calculateStars($stars,$total_review);
        
        $reviews = $book->reviews()->orderBy('id','desc')->limit(7)->get();
    
        $book->views += 1;
        $book->save();
        $socialShare = Share::page(route(Route::currentRouteName(),$book->id),"{$book->title}")
        ->facebook()
        ->twitter()
        ->linkedin()
        ->whatsapp()
        ->telegram()->getRawLinks();
        if(Auth::user()->type == 'admin')
        {
            $articles = Article::where('approved','no')->get();
            $books = Book::where("approved",'no')->get();
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            return view("backend.audiobook.show",
            compact('uvcontacts',"book","articles","books","reviews","stars","averageRate","total_review","socialShare"));
        }
        else if(Auth::user()->type == 'librarian')
        {
            $catagories = Category::where('user_id',Auth::user()->id)->get();
            $id = $catagories->pluck('id')->toArray();
            $articles = Article::whereIn('category_id',$id)->where('approved','no')->get();
            $books = Book::whereIn('category_id',$id)->where("approved",'no')->get();
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            return view("backend.audiobook.show",compact('uvcontacts',"book","articles","books","reviews","stars","averageRate","total_review","socialShare"));
        }
        else
        {
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AudioBook  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(AudioBook $book)
    {
        \abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AudioBook  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AudioBook $audiobook)
    {
        $book = $audiobook;
        if($request->has('validate'))
        {
            $request->validate([
                'b_author' => 'required|max:255',
                'b_edition' => 'required',
                'b_name' => 'required|max:255',
            ]);
            $obj = AudioBook::where('title',trim($request->b_name))->where('author',trim($request->b_author))->where('edition',$request->b_edition)->get();
            if(count($obj) > 0)
                if($obj[0]->id != $book->id)
                    return response()->json(['msg' => 'failed']);
        }
        else
        {
            $request->validate([
                'b_name' => 'required|max:255',
                'b_author' => 'required|max:255',
                'b_chapter' => 'required',
                'b_edition' => 'required',
                'b_page' => 'required',
                'b_publish' => 'required|date',
            ]);
            $book->title = ucwords(trim($request->b_name));
            $book->author = ucwords(trim($request->b_author));
            $book->pages = $request->b_page;
            $book->chapter = $request->b_chapter;
            $book->publish_date = $request->b_publish;
            $book->about_author = trim($request->b_aboutauthor);
            $book->about_book = trim($request->b_aboutbook);
            $book->edition = $request->b_edition;
            $book->save();
            return response()->json(['msg'=>'success','book'=>$book]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AudioBook  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(AudioBook $audiobook)
    {
        $book = $audiobook;
        File::delete(\public_path('application/audiobooks/cover/'.$book->image));
        File::delete(\public_path('application/audiobooks/audio/'.$book->path));
        $book->delete();
        return \redirect('audiobook');
    }

    // this function is responsible for searching both approved and unapproved books in dashboard
    public function search(Request $request)
    {
        $books = '';
        $rows = '';

        if(Auth::user()->type == 'amdin')      
        {
            $books = AudioBook::orderBy('id','desc')
            ->where('approved',$request->approved)        
            ->where('title','like','%'.$request->data.'%')
            ->orWhere('author','like','%'.$request->data.'%')
            ->where('approved',$request->approved)
            ->get();
        }
        else if (Auth::user()->type == 'librarian')
        {
            $catagories = Category::where('user_id',Auth::user()->id)->get();
            $id = $catagories->pluck('id')->toArray();
            $books = AudioBook::orderBy('id','desc')
            ->whereIn("category_id",$id)
            ->where('approved',$request->approved)        
            ->where('title','like','%'.$request->data.'%')
            ->orWhere('author','like','%'.$request->data.'%')
            ->where('approved',$request->approved)
            ->get();
        }
        else
        {
            return abort(404);
        }
         foreach($books as $book)
        {
            $rows .= '<tr id="'.$book->id .'">
            <td class="text-left">
              <div><img src="'.asset("application/audiobooks/cover/".$book->image).' " alt="user"
                  class="rounded img-fluid" style="width:40px !important; height:45px !important;"></div>
            </td>
            <td> '. ucfirst($book->title) .' </td>
            <td>'. ucfirst($book->author) .'</td>
            <td>'. $book->edition .'</td>
            <td>'. $book->created_at->diffForhumans() .'</td>
            <td><a href="'.(route("audiobook.show",$book->id)) .'"> <i class=" btn-sm btn-secondary fa fa-eye "></i>
              </a></td>
          </tr>';
        }
        return response()->json(["rows"=>$rows]);
    }


    // show audio book in frontend
    public function ShowBook(Request $request,AudioBook $audiobook)
    {
        $book= $audiobook;
        if($request->ajax())
        {
            $rows = '';
            $last_id = '';
            $btn_load = '';
            $reviews = $book->reviews()->orderBy('id','desc')->where('id','<',$request->review_id)->limit(7)->get();
            if(count($reviews->toArray()) > 0)
            {
                foreach($reviews as $review)
                {
                        $rows .='<div id="r'. $review->id .'" class="row justify-content-center mx-0 bg--eight py-1">
                        <div class="col-12">
                            <div class="row mx-1">
                                <div class="media align-items-center">
                                    <img class="mr-3 rounded-circle shadow border" width="10%" height="80%" src="'. asset('application/users/'.$review->user->image) .'" alt="image">
                                    <div class="media-body d-flex align-items-center">
                                        <h5 class="mt-0 mb-0 An_Dm_bold">'. $review->user->name .' '. $review->user->lastname .'</h5>';
                                        if(Auth::check())
                                        {
                                            if(Auth::user()->id == $review->user_id)
                                                $rows .='<h6 class="mt-0 mb-0 ml-3 An_Dm_bold"><small><a href="#editModal" data-toggle="modal" class="text--two">Edit</a></small></h6>';
                                        }
                                        $rows .= '</div>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mt-3">
                                    <div class=" d-flex  mr-3  ">';
                                        for ($a = 1; $a <=$review->rate; $a++)
                                            $rows .='<small><i class="fa fa-star text--one pr-1 "></i></small>';
                                        for($a = $review->rate; $a <5; $a++)
                                            $rows .='<small><i class="fa fa-star text--six pr-1 "></i></small>';
                                    $rows .= '</div>
                                    <h6 class="text-muted mb-0"><small><span class="">'. $review->created_at->diffForhumans() .'</span></small></h6>
                                </div>
                            </div>
                            <div class="mx-1 mt-2">
                                <h6 class="An_Dm_bold text-break">'. $review->title .'</h6>
                                <p class="text-muted text-justify text-break">'. $review->body .'</p>
                                <div class="d-flex">';
                                    if($review->recommendation == 'yes')
                                    {
                                        $rows .= '<div class="text--two d-flex align-items-center">
                                            <i class="fa fa-check-circle mr-1"></i>
                                            <h5 class="mb-0 An_light"> Yes, <small> I recommend this audio book</small></h5>
                                        </div>';
                                    }
                                    else
                                    {
                                        $rows .= '<div class="text--two d-flex align-items-center ">
                                            <i class="fa fa-times-circle mr-1 mb-1 text-danger"></i>
                                            <h5 class="mb-0 An_light"> No, <small> I don\'t recommend this audio book</small></h5>
                                        </div>';
                                    }
                                    if(Auth::check())
                                    {
                                        $rows .= '<div class="text--five ml-5 d-flex align-items-center">
                                            <h6 class="mb-0 An_light "><small>Helpful?</small></h6>';
                                                if($review->helpfuls->where('user_id',Auth::user()->id)->where("review_id",$review->id)->where("type","audiobook")->first() != '')
                                                    if($review->helpfuls->where('user_id',Auth::user()->id)->where('review_id',$review->id)->where('type','audiobook')->first()->helpful == 'yes')
                                                    {
                                                        $rows .= '<a href="javascript:void(0)" data-type="yes" id="'. $review->id .'" class=" p-0 m-0 nav-link bg--two small  text-white   px-2 rounded-left ml-2">Yes &nbsp;&nbsp; </a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) .'</span>
                                                        <a href="javascript:void(0)" data-type="no" id="'. $review->id .'" class=" help_no p-0 m-0 nav-link bg--four small  text--two rounded-left px-2   ml-2">No &nbsp;&nbsp;</a> <span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) .'</span>';
                                                    }
                                                    else
                                                    {
                                                        $rows .= '<a href="javascript:void(0)" data-type="yes" id="'. $review->id .'" class=" help_yes p-0 m-0 nav-link bg--four small  text--two   px-2 rounded-left ml-2">Yes &nbsp;&nbsp; </a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) .'</span>
                                                        <a href="javascript:void(0)" data-type="no" id="'. $review->id .'" class="p-0 m-0 nav-link bg--two small  text-white rounded-left px-2 ml-2">No &nbsp;&nbsp;</a> <span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">'.Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) .'</span>';
                                                    }
                                                else
                                                {
                                                    $rows .= '<a href="javascript:void(0)" data-type="yes" id="'. $review->id .'" class=" help_yes p-0 m-0 nav-link bg--four small  text--two   px-2 rounded-left ml-2">Yes &nbsp;&nbsp; </a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) .'</span>
                                                    <a href="javascript:void(0)" data-type="no" id="'. $review->id .'" class=" help_no p-0 m-0 nav-link bg--four small  text--two rounded-left px-2   ml-2">No &nbsp;&nbsp;</a> <span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) .'</span>';
                                                }
                                        $rows .= '</div>';
                                    }
                                    else
                                    {
                                        $rows .= '<div class="text--five ml-5 d-flex align-items-center">
                                            <h6 class="mb-0 An_light"><small>Helpful?</small></h6>
                                            <a href="'. route("allow.audiobookreview",$book->id) .'" class=" p-0 m-0 nav-link bg--four small  text--two   px-2 rounded-left ml-2">Yes &nbsp;&nbsp; </a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">'.Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) .'</span>
                                            <a href="'. route("allow.audiobookreview",$book->id) .'" class="p-0 m-0 nav-link bg--four small  text--two rounded-left px-2   ml-2">No &nbsp;&nbsp;</a> <span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) .'</span>
                                        </div>';
                                    }
                                $rows .= '</div>
                            </div>
                            <hr>
                        </div>
                    </div>';
                }
                $last_id = $review->id;
                $btn_load = '<button id="btn-more" data-review="'. $review->id .'" class="row w-100 bg--four px-3 py-2 rounded shadow justify-content-center mx-3  mb-5 An_Dm_bold" style="cursor:pointer; border:none">
                See more reviews
                <i class="fa fa-angle-down  mt-1 ml-2"></i>
                </button>';
                return response()->json(['reviews'=>$rows,'button'=>$btn_load]);
            }
            else
            {
                $rows = '';
                $btn_load = '<div class="row bg--one w-100 px-3 py-2 mx-3 rounded shadow justify-content-center mb-5 mx-0 An_Dm_bold" style="cursor:pointer">
                No more reviews
                </div>';
                return response()->json(['reviews'=>$rows,'button'=>$btn_load]);
            }

        }
        $total_review = count($book->reviews->toArray());
        
        $stars = $book->reviews->groupBy('rate'); 

        $averageRate = Helper::calculateStars($stars,$total_review);
        
        $reviews = $book->reviews()->orderBy('id','desc')->limit(7)->get();
        $relatedBooks = DB::select('select * from  audio_books where category_id = ? order by rand() limit 15',[$book->category_id]);
        $tags = Tag::all();
        $catagories = Category::where('user_id','<>',null)->get();
        $book->views += 1;
        $book->save();
 
        $socialShare = Share::page(route(Route::currentRouteName(),$book->id),"{$book->title}")
        ->facebook()
        ->twitter()
        ->linkedin()
        ->whatsapp()
        ->telegram()->getRawLinks();
        return view("frontend.audiobook-show",compact("book","tags","catagories","relatedBooks","reviews","stars","averageRate","total_review","socialShare"));
    }

    public function download(Request $request,AudioBook $audiobook)
    {   
        $book = $audiobook;
        if(Auth::user()->type == 'client')
        {
            if($request->ajax())
            {
                $obj = Download::where('user_id',Auth::user()->id)->where('downloadable_type','audiobook')->where('downloadable_id',$book->id)->get();
                if(count($obj) > 0)
                {
                    $book->downloads += 1;
                    $book->save();
                    return response()->json(['msg'=>'success']);
                }
                else
                {
                    $downloadable = new Download();
                    $downloadable->user_id = Auth::user()->id;
                    $downloadable->downloadable_type = 'audiobook';
                    $downloadable->downloadable_id = $book->id;
                    $downloadable->save();
                    $book->downloads += 1;
                    $book->save();
                    return response()->json(['msg'=>'success']);
                }
            }
            else
            {
                Session::flash('download','true');
                $obj = Download::where('user_id',Auth::user()->id)->where('downloadable_type','audiobook')->where('downloadable_id',$book->id)->get();
                if(count($obj) > 0)
                {
                    $book->downloads += 1;
                    $book->save();
                    return \redirect(route('show.audiobook',$book->id));
                }
                else
                {
                    $downloadable = new Download();
                    $downloadable->user_id = Auth::user()->id;
                    $downloadable->downloadable_type = 'audiobook';
                    $downloadable->downloadable_id = $book->id;
                    $downloadable->save();
                    $book->downloads += 1;
                    $book->save();
                    return Redirect::to(route('show.audiobook',$book->id));
                }
    
            }
        }
    }

    public function view(AudioBook $audiobook){
        $book = $audiobook;
        Session::flash('view','true');
        return Redirect::to(route("show.audiobook",$book->id));
    }

    // listing audio books in frontend
    public function ListAudioBooks(Request $request)
    {
        $books = AudioBook::orderBy('views')->where('approved','yes')->paginate(21)->onEachSide(10);    
        if($request->ajax())
        {
            return view('ajax-pages.audiobook.list-book',compact('books'))->render();
        }
        else
        {
            $collections = Category::with('audiobooks')->get();
            $catagories = Category::where('user_id','<>',null)->get();
            $tags = Tag::all();
            return view('frontend.audiobooks',compact('collections','books','tags','catagories'));
        }

    }

    // searching audio book in frontend
    public function SearchAudioBook(Request $request)
    {
        $request->validate([
            'q'=>'required'
        ]);
        $tags = Tag::all();
        $books = AudioBook::where('title','like',"%$request->q%")->orWhere("author","like","%$request->q%")->orWhere("tags","like","%$request->q%")->paginate(21)->onEachSide(10);
        $collections = Category::with('audiobooks')->get();
        $catagories = Category::where('user_id','<>',null)->get();
        $request->flashOnly('q');
        return view('frontend.search-audiobook',\compact('collections','catagories','books','tags'));
    }

    // list audio books based on category
    public function listAudioBookCategory($id)
    {
        $tags = Tag::all();
        $collections = Category::with('audiobooks')->get();
        $catagories = Category::where("user_id","<>",null)->get();
        $books = AudioBook::orderBy('id','desc')->where('category_id',$id)->paginate(21)->onEachSide(10);
        return view('frontend.audiobooks-category',compact('collections','catagories','books','id','tags'));
    }
}
