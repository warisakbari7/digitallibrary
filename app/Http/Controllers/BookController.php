<?php

namespace App\Http\Controllers;

use App\Events\ApprovalEvent;
use App\Events\BookUploadedEvent;
use App\Models\Book;
use App\Models\Article;
use App\Models\Category;
use App\Models\Download;
use App\Models\Contact;
use App\Models\User;
use App\Models\Tag;
use App\Helpers\Number;
use App\Helpers\Helper;
use App\Notifications\ApprovalNotification;
use App\Notifications\UserUploadedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Facades\Jorenvh\Share\Share;
use Illuminate\Support\Facades\Notification;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->type == 'librarian')
        {
            $catagories = Category::where('user_id',Auth::user()->id)->get();
            $id = $catagories->pluck('id')->toArray();
            $tags = Tag::all();
            $abooks = Book::orderBy("id",'desc')->whereIn('category_id',$id)->where("approved","yes")->paginate(30);
            $books = Book::where('approved','no')->whereIn('category_id',$id)->get();
            $articles = Article::where('approved','no')->whereIn('category_id',$id)->get();
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            return view("backend.book.index",compact('uvcontacts','books','catagories','tags','abooks','articles'));
        }
        else if(Auth::user()->type == 'admin')
        {
            $catagories = Category::all();
            $tags = Tag::all();
            $abooks = Book::orderBy("id",'desc')->where("approved","yes")->paginate(30);
            $books = Book::where('approved','no')->get();
            $articles = Article::where('approved','no')->get();
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            return view("backend.book.index",compact('uvcontacts','books','catagories','tags','abooks','articles'));
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
        \abort(404);
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
            $obj = Book::where('title',trim($request->b_name))->where('author',trim($request->b_author))->where('edition',$request->b_edition)->get();
            if(count($obj) > 0)
                return response()->json(['msg' => 'failed']);
            else
                return response()->json(['msg' => 'success']);
        }
        else
        {
            $request->validate([
                'b_author' => 'required|max:255',
                'b_book' => 'required|mimetypes:application/pdf',
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
            $request->file('b_book')->move(\public_path('application/books/pdf'),$pdf);
            $request->file('b_cover')->move(\public_path('application/books/cover'),$cover);
            $book = new Book();
            $book->title = ucwords(trim($request->b_name));
            $book->author = ucwords(trim($request->b_author));
            $book->size = $size;
            $book->path = $pdf;
            $book->views = 0;
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
              <div><img src="'. asset('application/books/cover/'.$book->image) .'" alt="user"
                  class="rounded img-fluid" style="width:40px !important; height:45px !important;"></div>
            </td>
            <td>'. ucfirst($book->title) .'</td>
            <td>'. ucfirst($book->author) .'</td>
            <td>'. $book->edition .'</td>

            <td>'. $book->created_at->diffForhumans() .'</td>
            <td><a href="'. route('book.show',$book->id) .'"> <i class=" btn-sm btn-secondary fa fa-eye "></i>
              </a></td>
            </tr>';
            return response()->json(['msg'=>'success','row'=>$row]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Book $book)
    {
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
                                            <h5 class="mb-0 An_light"> Yes, <small> I recommend this book</small></h5>
                                        </div>';
                                    }
                                    else
                                    {
                                        $rows .= '<div class="text--two d-flex align-items-center ">
                                            <i class="fa fa-times-circle mr-1 mb-1 text-danger"></i>
                                            <h5 class="mb-0 An_light"> No, <small> I don\'t recommend this book</small></h5>
                                        </div>';
                                    }
                                    if(Auth::check())
                                    {
                                        $rows .= '<div class="text--five ml-5 d-flex align-items-center">
                                            <h6 class="mb-0 An_light "><small>Helpful?</small></h6>';
                                                if($review->helpfuls->where('user_id',Auth::user()->id)->where("review_id",$review->id)->where("type","book")->first() != '')
                                                    if($review->helpfuls->where('user_id',Auth::user()->id)->where('review_id',$review->id)->where('type','book')->first()->helpful == 'yes')
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
                                            <a href="'. route("allow.review",$book->id) .'" class=" p-0 m-0 nav-link bg--four small  text--two   px-2 rounded-left ml-2">Yes &nbsp;&nbsp; </a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">'.Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) .'</span>
                                            <a href="'. route("allow.review",$book->id) .'" class="p-0 m-0 nav-link bg--four small  text--two rounded-left px-2   ml-2">No &nbsp;&nbsp;</a> <span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) .'</span>
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
        $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);        
        if(Auth::user()->type =='admin')
        {
            $articles = Article::where('approved','no')->get();
            $books = Book::where("approved",'no')->get();
            return view("backend.book.show",compact("uvcontacts","book","articles","books","reviews","stars","averageRate","total_review"));    
        }
        else if(Auth::user()->type == 'librarian')
        {
            $catagories = Category::where('user_id',Auth::user()->id)->get();
            $id = $catagories->pluck('id')->toArray();
            $articles = Article::where('approved','no')->whereIn('category_id',$id)->get();
            $books = Book::where("approved",'no')->whereIn('category_id',$id)->get();
            return view("backend.book.show",compact("uvcontacts","book","articles","books","reviews","stars","averageRate","total_review"));    
        }
        else
        {
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        \abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        if($request->has('validate'))
        {
            $request->validate([
                'b_author' => 'required|max:255',
                'b_edition' => 'required',
                'b_name' => 'required|max:255',
            ]);
            $obj = Book::where('title',trim($request->b_name))->where('author',trim($request->b_author))->where('edition',$request->b_edition)->get();
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
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        File::delete(\public_path('application/books/cover/'.$book->image));
        File::delete(\public_path('application/books/pdf/'.$book->path));
        $book->delete();
        return \redirect('book');
    }

    public function uploadBook(Request $request)
    {
        if($request->has('validate'))
        {
            $request->validate([
                'b_author' => 'required|max:255',
                'b_edition' => 'required',
                'b_name' => 'required|max:255',
            ]);
            $obj = Book::where('title',trim($request->b_name))->where('author',trim($request->b_author))->where('edition',$request->b_edition)->get();
            if(count($obj) > 0)
                return response()->json(['msg' => 'failed']);
            else
                return response()->json(['msg' => 'success']);
        }
        else
        {
            $request->validate([
                'b_author' => 'required|max:255',
                'b_book' => 'required|mimetypes:application/pdf',
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
            $size = $request->file("b_book")->getSize();
            $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
            $power = $size > 0 ? floor(log($size, 1024)) : 0;
            $size =  number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
            $pdf = time().rand(1,1000).date('dmy').'.'.$request->file('b_book')->getClientOriginalExtension();
            $cover = time().rand(1,1000).date('dmy').'.'.$request->file('b_cover')->getClientOriginalExtension();
            $request->file('b_book')->move(\public_path('application/books/pdf'),$pdf);
            $request->file('b_cover')->move(\public_path('application/books/cover'),$cover);
            $book = new Book();
            $book->title = ucwords(trim($request->b_name));
            $book->author = ucwords(trim($request->b_author));
            $book->size = $size;
            $book->path = $pdf;
            $book->views = 0;
            $book->pages = $request->b_page;
            $book->chapter = $request->b_chapter;
            $book->publish_date = $request->b_publish;
            $book->about_author = trim($request->b_aboutauthor);
            $book->about_book = trim($request->b_aboutbook);
            $book->image = $cover;
            $book->approved = 'no';
            $book->language = $request->b_language;
            $book->edition = $request->b_edition;
            $book->tags = trim($request->tags);
            $book->category_id = $request->b_catagory;
            $book->owner_id = Auth::user()->id;
            $book->save();
            $user = Category::find($book->category_id)->user_id;
            $user = User::where('id',$user)->first();
            Notification::send($user,new UserUploadedNotification('book',route('book.show',$book->id),ucwords(Auth::user()->name).' '.\ucwords(Auth::user()->lastname),ucwords($book->title),Auth::user()->image,$book->created_at->diffForhumans()));
            event(new BookUploadedEvent($user->id,route('book.show',$book->id),ucwords(Auth::user()->name).' '.\ucwords(Auth::user()->lastname),ucwords($book->title),Auth::user()->image,$book->created_at->diffForhumans()));
            return response()->json(['msg'=>'success']);
        }
    }


    public function listUnapproved()
    {
        if(Auth::user()->type == 'admin')
        {
            $articles = Article::where("approved","no")->get();
            $books = Book::orderBy("id","desc")->where('approved','no')->paginate(30);
            return view('backend.book.unapprovedbook',compact('books','articles'));
        }
        else if(Auth::user()->type == 'librarian')
        {
            $catagories = Category::where('user_id',Auth::user()->id)->get();
            $id = $catagories->pluck('id')->toArray();
            $articles = Article::where("approved","no")->whereIn('category_id',$id)->get();
            $books = Book::orderBy("id","desc")->where('approved','no')->whereIn('category_id',$id)->paginate(30);
            return view('backend.book.unapprovedbook',compact('books','articles'));
        }
        else
        {
            return abort(404);
        }
    }


    public function showUnapproved(Book $book)
    {
        if(Auth::user()->type == 'admin')
        {
            $books = Book::where('approved','no')->get();
            $articles = Article::where('approved','no')->get();
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            return \view('backend.book.show-unapproved',compact("uvcontacts",'book','books','articles'));
        }
        else if(Auth::user()->type == 'librarian')
        {
            $catagories = Category::where('user_id',Auth::user()->id)->get();
            $id = $catagories->pluck('id')->toArray();
            $books = Book::where('approved','no')->whereIn('category_id',$id)->get();
            $articles = Article::where('approved','no')->whereIn('category_id',$id)->get();
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            return \view('backend.book.show-unapproved',compact("uvcontacts",'book','books','articles'));
        }
        else
        {
            return abort(404);
        }

    }


    public function approve(Request $request)
    {
        $book = Book::find($request->id);
        $book->approved = 'yes';
        $book->approved_by = Auth::user()->id;
        $book->save();
        $user = User::find($book->owner_id);
        event(new ApprovalEvent($book->owner_id,ucwords($book->title),'book',$book->image,route('show.book',$book->id)));
        Notification::send($user,new ApprovalNotification(ucwords($book->title),'book',$book->image,route('show.book',$book->id)));
        return response()->json(['msg'=>'success']);
    }

    // this function is responsible for searching both approved and unapproved books in dashboard
    public function search(Request $request)
    {
        $books = '';
        $rows = '';
        if(Auth::user()->type == 'admin')
        {
            $books = Book::orderBy('id','desc')
            ->where('approved',$request->approved)        
            ->where('title','like','%'.$request->data.'%')
            ->orWhere('author','like','%'.$request->data.'%')
            ->where('approved',$request->approved)
            ->get();
        }
        elseif(Auth::user()->type == 'librarian')
        {
            $catagories = Category::where('user_id',Auth::user()->id)->get();
            $id = $catagories->pluck('id')->toArray();
            $books = Book::orderBy('id','desc')
            ->whereIn('category_id',$id)
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
              <div><img src="'.asset("application/books/cover/".$book->image).' " alt="user"
                  class="rounded img-fluid" style="width:40px !important; height:45px !important;"></div>
            </td>
            <td> '. \ucwords($book->title) .' </td>
            <td>'. \ucwords($book->author) .'</td>
            <td>'. $book->edition .'</td>
            <td>'. $book->created_at->diffForhumans() .'</td>
            <td><a href="'.(($book->approved == 'yes') ? route("book.show",$book->id): route('show.unapproved.book',$book->id)) .'"> <i class=" btn-sm btn-secondary fa fa-eye "></i>
              </a></td>
          </tr>';
        }
        return response()->json(["rows"=>$rows]);
    }


    // show book in frontend
    public function ShowBook(Request $request,Book $book)
    {
        if($book->approved == 'no')
            return abort(404);
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
                                            <h5 class="mb-0 An_light"> Yes, <small> I recommend this book</small></h5>
                                        </div>';
                                    }
                                    else
                                    {
                                        $rows .= '<div class="text--two d-flex align-items-center ">
                                            <i class="fa fa-times-circle mr-1 mb-1 text-danger"></i>
                                            <h5 class="mb-0 An_light"> No, <small> I don\'t recommend this book</small></h5>
                                        </div>';
                                    }
                                    if(Auth::check())
                                    {
                                        $rows .= '<div class="text--five ml-5 d-flex align-items-center">
                                            <h6 class="mb-0 An_light "><small>Helpful?</small></h6>';
                                                if($review->helpfuls->where('user_id',Auth::user()->id)->where("review_id",$review->id)->where("type","book")->first() != '')
                                                    if($review->helpfuls->where('user_id',Auth::user()->id)->where('review_id',$review->id)->where('type','book')->first()->helpful == 'yes')
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
                                            <a href="'. route("allow.review",$book->id) .'" class=" p-0 m-0 nav-link bg--four small  text--two   px-2 rounded-left ml-2">Yes &nbsp;&nbsp; </a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">'.Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) .'</span>
                                            <a href="'. route("allow.review",$book->id) .'" class="p-0 m-0 nav-link bg--four small  text--two rounded-left px-2   ml-2">No &nbsp;&nbsp;</a> <span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) .'</span>
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
        $relatedBooks = DB::select('select * from  books where category_id = ? AND approved = ? order by rand() limit 15',[$book->category_id,'yes']);
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
        return view("frontend.book-show",compact("book","tags","catagories","relatedBooks","reviews","stars","averageRate","total_review","socialShare"));
    }

    public function download(Request $request,Book $book)
    {
        if(Auth::user()->type == 'client')
        {
            if($request->ajax())
            {
                $obj = Download::where('user_id',Auth::user()->id)->where('downloadable_type','book')->where('downloadable_id',$book->id)->get();
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
                    $downloadable->downloadable_type = 'book';
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
                $obj = Download::where('user_id',Auth::user()->id)->where('downloadable_type','book')->where('downloadable_id',$book->id)->get();
                if(count($obj) > 0)
                {
                    $book->downloads += 1;
                    $book->save();
                    return \redirect(route('show.book',$book->id));
                }
                else
                {
                    $downloadable = new Download();
                    $downloadable->user_id = Auth::user()->id;
                    $downloadable->downloadable_type = 'book';
                    $downloadable->downloadable_id = $book->id;
                    $downloadable->save();
                    $book->downloads += 1;
                    $book->save();
                    return Redirect::to(route('show.book',$book->id));
                }
    
            }
        }
    }

    public function view(Book $book){
        Session::flash('view','true');
        return Redirect::to(route("show.book",$book->id));
    }

    // listing books in frontend
    public function ListBooks(Request $request)
    {
        $books = Book::orderBy('views')->where('approved','yes')->paginate(40)->onEachSide(10);;    
        if($request->ajax())
        {
            return view('ajax-pages.book.list-book',compact('books'))->render();
        }
        else
        {
            $catagories = Category::with('books')->get();
            $collections = Category::where('user_id','<>',null)->get();
            $tags = Tag::all();
            return view('frontend.books',compact('collections','books','tags','catagories'));
        }

    }

    // searching book in frontend
    public function SearchBook(Request $request)
    {
        $request->validate([
            'q'=>'required'
        ]);
        $tags = Tag::all();
        $books = Book::where('approved','yes')->where('title','like',"%$request->q%")->orWhere("author","like","%$request->q%")->orWhere("tags","like","%$request->q%")->paginate(40)->onEachSide(10);
        $collections = Category::with('books')->get();
        $catagories = Category::where('user_id','<>',null)->get();
        $request->flashOnly('q');
        return view('frontend.search-book',\compact('collections','catagories','books','tags'));
    }

    // list books based on category in frontend
    public function listBookCategory($id)
    {
        $tags = Tag::all();
        $catagories = Category::where('user_id','<>',null)->get();
        $collections = Category::with('books')->get();
        $books = Book::orderBy('id','desc')->where('category_id',$id)->where('approved','yes')->paginate(40)->onEachSide(10);
        return view('frontend.books-category',compact('collections','catagories','books','id','tags'));
    }
}
