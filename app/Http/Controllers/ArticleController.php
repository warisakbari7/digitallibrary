<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Book;
use App\Models\Download;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Facades\Jorenvh\Share\Share;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use App\Helpers\Helper;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Events\ArticleUploadedEvent;
use App\Notifications\UserUploadedNotification;
use App\Events\ApprovalEvent;
use App\Notifications\ApprovalNotification;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $uvcontacts = '';
        $books = '';
        $catagories = '';
        $aarticles = '';
        $articles = '';

        if(Auth::user()->type == 'client')
            return \abort(404);
        if(Auth::user()->type == 'librarian')
        {
            $catagories = Category::where('user_id',Auth::user()->id)->get();
            $id = $catagories->pluck('id')->toArray();
            $books = Book::whereIn('category_id',$id)->where('approved','no')->get();
            $articles = Article::whereIn('category_id',$id)->where('approved','no')->get();
            
            $aarticles = Article::orderBy("id",'desc')->whereIn('category_id',$id)->where("approved","yes")->paginate(30);
        }
        else if(Auth::user()->type == 'admin')
        {
            $catagories = Category::all();
            $aarticles = Article::orderBy("id",'desc')->where("approved","yes")->paginate(30);
            $books = Book::where('approved','no')->get();
            $articles = Article::where('approved','no')->get();
        }
        else
        {
            return \abort(404);
        }
        $tags = Tag::all();
        $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
        return view("backend.article.index",compact('uvcontacts','books','catagories','tags','aarticles','articles'));
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
                'a_author' => 'required|max:255',
                'a_name' => 'required|max:255',
            ]);
            $obj = Article::where('title',trim($request->a_name))->where('author',trim($request->a_author))->get();
            if(count($obj) > 0)
                return response()->json(['msg' => 'failed']);
            else
                return response()->json(['msg' => 'success']);
        }
        else
        {
            $request->validate([
                'a_author' => 'required|max:255',
                'a_article' => 'required|mimetypes:application/pdf',
                'a_catagory' => 'required',
                'a_chapter' => 'required',
                'a_name' => 'required|max:255',
                'a_page' => 'required',
                'a_language' => 'required',
                'tags' => 'required',
                'a_publish' => 'required|date',
            ]);
            $size = $request->file("a_article")->getSize();
            $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
            $power = $size > 0 ? floor(log($size, 1024)) : 0;
            $size = number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
            $pdf = time().rand(1,1000).date('dmy').'.'.$request->file('a_article')->getClientOriginalExtension();
            $request->file('a_article')->move(\public_path('application/articles/pdf'),$pdf);
            $article = new Article();
            $article->title = ucwords(trim($request->a_name));
            $article->author = ucwords(trim($request->a_author));
            $article->size = $size;
            $article->path = $pdf;
            $article->views = 0;
            $article->rate = 0;
            $article->pages = $request->a_page;
            $article->chapter = $request->a_chapter;
            $article->publish_date = $request->a_publish;
            $article->about_author  = trim($request->a_aboutauthor);
            $article->about_article = trim($request->a_aboutarticle);
            $article->approved = 'yes';
            $article->approved_by = Auth::user()->id;
            $article->language = $request->a_language;
            $article->tags = trim($request->tags);
            $article->category_id = $request->a_catagory;
            $article->owner_id = Auth::user()->id;
            $article->save();
            $row = '<tr id=" '.$article->id .'">
            <td class="text-left"></td>
            <td>'. ucfirst($article->title) .'</td>
            <td>'. ucfirst($article->author) .'</td>

            <td>'. $article->created_at->diffForhumans() .'</td>
            <td><a href="'. route('article.show',$article->id) .'"> <i class=" btn-sm btn-secondary fa fa-eye "></i>
              </a></td>
          </tr>';
            return response()->json(['msg'=>'success','row'=>$row]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request ,Article $article)
    {
        if($request->ajax())
        {
            $rows = '';
            $last_id = '';
            $btn_load = '';
            $reviews = $article->reviews()->orderBy('id','desc')->where('id','<',$request->review_id)->limit(7)->get();
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
                                            <h5 class="mb-0 An_light"> Yes, <small> I recommend this article</small></h5>
                                        </div>';
                                    }
                                    else
                                    {
                                        $rows .= '<div class="text--two d-flex align-items-center ">
                                            <i class="fa fa-times-circle mr-1 mb-1 text-danger"></i>
                                            <h5 class="mb-0 An_light"> No, <small> I don\'t recommend this article</small></h5>
                                        </div>';
                                    }
                                    if(Auth::check())
                                    {
                                        $rows .= '<div class="text--five ml-5 d-flex align-items-center">
                                            <h6 class="mb-0 An_light "><small>Helpful?</small></h6>';
                                                if($review->helpfuls->where('user_id',Auth::user()->id)->where("review_id",$review->id)->where("type","article")->first() != '')
                                                    if($review->helpfuls->where('user_id',Auth::user()->id)->where('review_id',$review->id)->where('type','article')->first()->helpful == 'yes')
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
                                            <a href="'. route("allow.articlereview",$article->id) .'" class=" p-0 m-0 nav-link bg--four small  text--two   px-2 rounded-left ml-2">Yes &nbsp;&nbsp; </a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">'.Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) .'</span>
                                            <a href="'. route("allow.articlereview",$article->id) .'" class="p-0 m-0 nav-link bg--four small  text--two rounded-left px-2   ml-2">No &nbsp;&nbsp;</a> <span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) .'</span>
                                        </div>';
                                    }
                                $rows .= '</div>
                            </div>
                            <hr>
                        </div>
                    </div>';
                }
                $last_id = $review->id;
                $btn_load = '<button id="btn-more" data-review="'. $review->id .'" class="row w-100 bg--four px-3 py-2 rounded shadow justify-content-center mx-3  mb-5 An_Dm_bold" style="cursor:pointer;border:none;">
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
        $total_review = count($article->reviews->toArray());
        
        $stars = $article->reviews->groupBy('rate'); 

        $averageRate = Helper::calculateStars($stars,$total_review);
        
        $reviews = $article->reviews()->orderBy('id','desc')->limit(7)->get();


        $article->views += 1;
        $article->save();
        $book = '';
        if(Auth::user()->type == 'librarian')
        {
            $categories = Category::where('user_id',Auth::user()->id)->get();
            $id = $categories->pluck('id')->toArray();
            $articles = Article::whereIn('category_id',$id)->where('approved','no')->get();
            $books = Book::whereIn('category_id',$id)->where('approved','no')->get();
        }
        else if(Auth::user()->type == 'admin')
        {
            $articles = Article::where('approved','no')->get();
            $books = Book::where("approved",'no')->get();
        }

        $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
        return view("backend.article.show",compact("uvcontacts","article","articles","books","reviews","stars","averageRate","total_review"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    
    public function edit(Article $article)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        if($request->has('validate'))
        {
            $request->validate([
                'a_author' => 'required|max:255',
                'a_name' => 'required|max:255',
            ]);
            $obj = Article::where('title',trim($request->a_name))->where('author',trim($request->a_author))->get();
            if(count($obj) > 0)
                if($obj[0]->id != $article->id)
                    return response()->json(['msg' => 'failed']);
        }
        else
        {
            $request->validate([
                'a_name' => 'required|max:255',
                'a_author' => 'required|max:255',
                'a_chapter' => 'required',
                'a_page' => 'required',
                'a_publish' => 'required|date',
            ]);

            $article->title = ucwords(trim($request->a_name));
            $article->author = ucwords(trim($request->a_author));
            $article->pages = $request->a_page;
            $article->chapter = $request->a_chapter;
            $article->publish_date = $request->a_publish;
            $article->about_author = trim($request->a_aboutauthor);
            $article->about_article = trim($request->a_aboutarticle);
            $article->save();
            return response()->json(['msg'=>'success','article'=>$article]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        File::delete(\public_path('application/articles/pdf/'.$article->path));
        $article->delete();
        return \redirect('article');
    }

    public function uploadArticle(Request $request)
    {
        if($request->has('validate'))
        {
            $request->validate([
                'a_author' => 'required|max:255',
                'a_name' => 'required|max:255',
            ]);
            $obj = Article::where('title',trim($request->a_name))->where('author',trim($request->a_author))->get();
            if(count($obj) > 0)
                return response()->json(['msg' => 'failed']);
            else
                return response()->json(['msg' => 'success']);
        }
        else
        {
            $request->validate([
                'a_author' => 'required|max:255',
                'a_article' => 'required|mimetypes:application/pdf',
                'a_catagory' => 'required',
                'a_chapter' => 'required',
                'a_name' => 'required|max:255',
                'a_page' => 'required',
                'a_language' => 'required',
                'tags' => 'required',
                'a_publish' => 'required|date',
            ]);
            $size = $request->file("a_article")->getSize();
            $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
            $power = $size > 0 ? floor(log($size, 1024)) : 0;
            $size =  number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];            
            $pdf = time().rand(1,1000).date('dmy').'.'.$request->file('a_article')->getClientOriginalExtension();
            $request->file('a_article')->move(\public_path('application/articles/pdf'),$pdf);
            $article = new Article();
            $article->title = ucwords(trim($request->a_name));
            $article->author = ucwords(trim($request->a_author));
            $article->size = $size;
            $article->path = $pdf;
            $article->views = 0;
            $article->rate = 0;
            $article->pages = $request->a_page;
            $article->chapter = $request->a_chapter;
            $article->publish_date = $request->a_publish;
            $article->about_author = trim($request->a_aboutauthor);
            $article->about_article = trim($request->a_aboutarticle);
            $article->approved = 'no';
            $article->language = $request->a_language;
            $article->tags = trim($request->tags);
            $article->category_id = $request->a_catagory;
            $article->owner_id = Auth::user()->id;
            $article->save();
            $user = Category::find($article->category_id)->user_id;
            $user = User::where('id',$user)->first();
            Notification::send($user,new UserUploadedNotification('article',route('article.show',$article->id),ucwords(Auth::user()->name).' '.\ucwords(Auth::user()->lastname),ucwords($article->title),Auth::user()->image,$article->created_at->diffForhumans()));
            event(new ArticleUploadedEvent($user->id,route('article.show',$article->id),ucwords(Auth::user()->name).' '.\ucwords(Auth::user()->lastname),ucwords($article->title),Auth::user()->image,$article->created_at->diffForhumans()));
            return response()->json(['msg'=>'success']);
        }
    }

    public function listUnapproved()
    {
        if(Auth::user()->type == 'admin')
        {
            $books = Book::where('approved','no')->get();
            $articles = Article::orderBy("id","desc")->where('approved','no')->paginate(30);
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            return view('backend.article.unapprovedarticle',compact('uvcontacts','articles','books'));
        }
        else if(Auth::user()->type == 'librarian')
        {
            $books = Book::where('approved','no')->get();
            $articles = Article::orderBy("id","desc")->where('approved','no')->paginate(30);
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            
            
            $catagories = Category::where('user_id',Auth::user()->id)->get();
            $id = $catagories->pluck('id')->toArray();
            $books = Book::whereIn('category_id',$id)->where('approved','no')->get();
            $articles = Article::whereIn('category_id',$id)->where('approved','no')->paginate(30);
            
            return view('backend.article.unapprovedarticle',compact('uvcontacts','articles','books'));
        }
        else
        {
           return abort(404); 
        }
    }


    public function showUnapproved(Article $article)
    {
        if(Auth::user()->type == 'admin')
        {
            $books = Book::where('approved','no')->get();
            $articles = Article::where('approved','no')->get();
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            return \view('backend.article.show-unapproved',compact('uvcontacts','article','articles','books'));
        }
        else if(Auth::user()->type == 'librarian')
        {
            $categories = Category::where('user_id',Auth::user()->id)->get();
            $id = $categories->pluck('id')->toArray();
            $books = Book::whereIn('category_id',$id)->where('approved','no')->get();
            $articles = Article::whereIn('category_id',$id)->where('approved','no')->get();
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            return \view('backend.article.show-unapproved',compact('uvcontacts','article','articles','books'));
        }
        else
        {
            return abort(404);
        }

    }


    public function approve(Request $request)
    {
        $article = Article::find($request->id);
        $article->approved = 'yes';
        $article->approved_by = Auth::user()->id;
        $article->save();
        $user = User::find($article->owner_id);
        event(new ApprovalEvent($article->owner_id,ucwords($article->title),'article',$article->image,route('show.article',$article->id)));
        Notification::send($user,new ApprovalNotification(ucwords($article->title),'article','',route('show.article',$article->id)));
        return response()->json(['msg'=>'success']);
    }



    // this function is responsible for searching both approved and unapproved books in dashboard
    public function search(Request $request)
    {
        $rows = '';
        if(Auth::user()->type == 'librarian')
        {
            $categories = Category::where('user_id',Auth::user()->id)->get();
            $id = $categories->pluck('id')->toArray();
            $articles = Article::orderBy('id','desc')->whereIn('category_id',$id)
            ->where('approved',$request->approved)        
            ->where('title','like','%'.$request->data.'%')
            ->orWhere('author','like','%'.$request->data.'%')
            ->where('approved',$request->approved)
            ->get();
            $x = 1;
             foreach($articles as $article)
            {
                $rows .= '<tr id="'. $article->id .'">
                <td class="text-left">
                '.$x.'
                </td>
                <td> '. ucfirst($article->title) .' </td>
                <td>'. ucfirst($article->author) .'</td>
                <td>'. $article->created_at->diffForhumans() .'</td>
                <td><a href="'.(($article->approved == 'yes') ? route("article.show",$article->id): route('show.unapproved.article',$article->id)) .'"> <i class=" btn-sm btn-secondary fa fa-eye "></i>
                  </a></td>
              </tr>';
              $x++;
            }
        }
        else if (Auth::user()->type == 'admin')
        {
            $articles = Article::orderBy('id','desc')
            ->where('approved',$request->approved)        
            ->where('title','like','%'.$request->data.'%')
            ->orWhere('author','like','%'.$request->data.'%')
            ->where('approved',$request->approved)
            ->get();
            $x = 1;
             foreach($articles as $article)
            {
                $rows .= '<tr id="'. $article->id .'">
                <td class="text-left">
                '.$x.'
                </td>
                <td> '. ucfirst($article->title) .' </td>
                <td>'. ucfirst($article->author) .'</td>
                <td>'. $article->created_at->diffForhumans() .'</td>
                <td><a href="'.(($article->approved == 'yes') ? route("article.show",$article->id): route('show.unapproved.article',$article->id)) .'"> <i class=" btn-sm btn-secondary fa fa-eye "></i>
                  </a></td>
              </tr>';
              $x++;
            }
        }
        else
        {
            return abort(404);
        }

        return response()->json(["rows"=>$rows]);
    }

     // show article in frontend
    public function ShowArticle(Request $request,Article $article)
    {
        if($article->approved == 'no')
            return abort(404);
          if($request->ajax())
          {
              $rows = '';
              $last_id = '';
              $btn_load = '';
              $reviews = $article->reviews()->orderBy('id','desc')->where('id','<',$request->review_id)->limit(7)->get();
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
                                              <h5 class="mb-0 An_light"> Yes, <small> I recommend this article</small></h5>
                                          </div>';
                                      }
                                      else
                                      {
                                          $rows .= '<div class="text--two d-flex align-items-center ">
                                              <i class="fa fa-times-circle mr-1 mb-1 text-danger"></i>
                                              <h5 class="mb-0 An_light"> No, <small> I don\'t recommend this article</small></h5>
                                          </div>';
                                      }
                                      if(Auth::check())
                                      {
                                          $rows .= '<div class="text--five ml-5 d-flex align-items-center">
                                              <h6 class="mb-0 An_light "><small>Helpful?</small></h6>';
                                                  if($review->helpfuls->where('user_id',Auth::user()->id)->where("review_id",$review->id)->where("type","article")->first() != '')
                                                      if($review->helpfuls->where('user_id',Auth::user()->id)->where('review_id',$review->id)->where('type','article')->first()->helpful == 'yes')
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
                                              <a href="'. route("allow.review",$article->id) .'" class=" p-0 m-0 nav-link bg--four small  text--two   px-2 rounded-left ml-2">Yes &nbsp;&nbsp; </a><span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="yesNum">'.Number::ToShortForm(count($review->helpfuls->where('helpful','yes'))) .'</span>
                                              <a href="'. route("allow.review",$article->id) .'" class="p-0 m-0 nav-link bg--four small  text--two rounded-left px-2   ml-2">No &nbsp;&nbsp;</a> <span class="p-0 m-0 nav-link bg--four small  text--two rounded-right px-2" id="noNum">'. Number::ToShortForm(count($review->helpfuls->where('helpful','no'))) .'</span>
                                          </div>';
                                      }
                                  $rows .= '</div>
                              </div>
                              <hr>
                          </div>
                      </div>';
                  }
                  $last_id = $review->id;
                  $btn_load = '<button id="btn-more" data-review="'. $review->id .'" class="row w-100 bg--four px-3 py-2 rounded shadow justify-content-center mx-3  mb-5 An_Dm_bold" style="cursor:pointer; border:none;">
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
          $total_review = count($article->reviews->toArray());
          
          $stars = $article->reviews->groupBy('rate'); 
  
          $averageRate = Helper::calculateStars($stars,$total_review);
          
          $reviews = $article->reviews()->orderBy('id','desc')->limit(7)->get();
          $relatedArticles = DB::select('select * from  articles where category_id = ? and approved = ? order by rand() limit 15',[$article->category_id,'yes']);
          $tags = Tag::all();
          $catagories = Category::where('user_id','<>',null)->get();
          $article->views += 1;
          $article->save();
  
          $socialShare = Share::page(route(Route::currentRouteName(),$article->id),"{$article->title}")
          ->facebook()
          ->twitter()
          ->linkedin()
          ->whatsapp()
          ->telegram()->getRawLinks();
          return view("frontend.article-show",compact("article","tags","catagories","relatedArticles","reviews","stars","averageRate","total_review","socialShare"));
    }
    
    public function download(Request $request,Article $article)
    {
          if(Auth::user()->type == 'client')
          {
              if($request->ajax())
              {
                  $obj = Download::where('user_id',Auth::user()->id)->where('downloadable_type','article')->where('downloadable_id',$article->id)->get();
                  if(count($obj) > 0)
                  {
                      $article->downloads += 1;
                      $article->save();
                      return response()->json(['msg'=>'success']);
                  }
                  else
                  {
                      $downloadable = new Download();
                      $downloadable->user_id = Auth::user()->id;
                      $downloadable->downloadable_type = 'article';
                      $downloadable->downloadable_id = $article->id;
                      $downloadable->save();
                      $article->downloads += 1;
                      $article->save();
                      return response()->json(['msg'=>'success']);
                  }
              }
              else
              {
                  Session::flash('download','true');
                  $obj = Download::where('user_id',Auth::user()->id)->where('downloadable_type','article')->where('downloadable_id',$article->id)->get();
                  if(count($obj) > 0)
                  {
                      $article->downloads += 1;
                      $article->save();
                      return \redirect(route('show.article',$article->id));
                  }
                  else
                  {
                      $downloadable = new Download();
                      $downloadable->user_id = Auth::user()->id;
                      $downloadable->downloadable_type = 'article';
                      $downloadable->downloadable_id = $article->id;
                      $downloadable->save();
                      $article->downloads += 1;
                      $article->save();
                      return Redirect::to(route('show.article',$article->id));
                  }
              }
          }
    }

    public function view(Article $article)
    {
        Session::flash('view','true');
        return Redirect::to(route("show.article",$article->id));
    }

    // listing articles in frontend
    public function ListArticles(Request $request)
    {
        $articles = Article::orderBy('views')->where('approved','yes')->paginate(10)->onEachSide(10);    
        if($request->ajax())
        {
            return view('ajax-pages.article.list-article',compact('articles'))->render();
        }
        else
        {
            $extraArticles = Article::inRandomOrder()->where('approved','yes')->limit(20)->get();
            $tags = Tag::all();
            $collections = Category::with('articles')->get();
            $catagories = Category::where('user_id','<>',null)->get();
            return view('frontend.articles',compact('collections','articles','tags','extraArticles','catagories'));
        }

    }

    // searching article in frontend
    public function SearchArticle(Request $request)
    {
        $request->validate([
            'q'=>'required'
        ]);
        $tags = Tag::all();
        $extraArticles = Article::inRandomOrder()->where('approved','yes')->limit(20)->get();
        $articles = Article::where('approved','yes')->where('title','like',"%$request->q%")->orWhere("author","like","%$request->q%")->orWhere("tags","like","%$request->q%")->paginate(10)->onEachSide(10);
        $request->flashOnly('q');
        $catagories = Category::where('user_id','<>',null)->get();
        return view('frontend.search-article',\compact('extraArticles','articles','tags','catagories'));
    }

    // list article based on category
    public function listArticleCategory($id)
    {
        $tags = Tag::all();
        $collections = Category::with(['articles'])->get();
        $catagories = Category::where('user_id','<>',null)->get();
        $articles = Article::orderBy('id','desc')->where('category_id',$id)->where('approved','yes')->paginate(40)->onEachSide(10);
        return view('frontend.articles-category',compact('collections','catagories','articles','id','tags'));
    }
}
