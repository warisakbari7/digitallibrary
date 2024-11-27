<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Download;
use App\Models\User;
use App\Models\Contact;
use App\Models\Article;
use App\Models\AudioBook;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if(Auth::user()->type == 'admin')
        {
            $users = User::where('type','client')->orderBy('id','desc')->paginate(30)->onEachSide(10);
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            $books = Book::where('approved','no')->get();
            $articles = Article::where('approved','no')->get();
            return view('backend.user.index',compact('uvcontacts','users','articles','books'));
        }
        elseif(Auth::user()->type == 'librarian')
        {
            $users = User::where('type','client')->orderBy('id','desc')->paginate(30)->onEachSide(10);
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            $categories = Category::where("user_id",Auth::user()->id)->get();
            $id = $categories->pluck('id')->toArray();
            $books = Book::where('approved','no')->whereIn('category_id',$id)->get();
            $articles = Article::where('approved','no')->whereIn('category_id',$id)->get();
            return view('backend.user.index',compact('uvcontacts','users','articles','books'));
        }
        else
        {
            return abort(404);
        }

    }

    public function show(Request $request, $id)
    {
        if($request->ajax())
        {
            $user = User::where('id',$id)->where('type','librarian')->get()[0];
            return \response()->json($user);
        }
        else
        {

            $user = User::where('id',$id)->where('type','client')->get()[0];
            $savedbooks = $user->SavedBooks()->get();
            $downloadedbooks = Download::with('books')->where('downloadable_type','book')->where('user_id',$user->id)->get();
            $uploadedbooks = $user->UploadedBooks;
            $savedarticles = $user->SavedArticles()->get();
            $downloadedarticles = Download::with('articles')->where('downloadable_type','article')->where('user_id',$user->id)->get();
            $uploadedarticles = $user->UploadedArticles;

            $savedaudios = $user->SavedAudioBooks()->get();
            $downloadedaudios = Download::with('audios')->where('downloadable_type','audiobook')->where('user_id',$user->id)->get();
            $catagory = Category::orderBy('ename')->where('user_id',null)->get();
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            $books = '';
            $articles = '';
            if(Auth::user()->type == 'admin')
            {
                $books = Book::where('approved','no')->get();
                $articles = Article::where('approved','no')->get();
                return \view('backend.user.show',compact('articles','books','uvcontacts','user','downloadedaudios','savedaudios','uploadedarticles','downloadedarticles','savedbooks','downloadedbooks','uploadedbooks','savedarticles'))->with('catagory',$catagory);

            }
            elseif(Auth::user()->type == 'librarian')
            {
                $categories = Category::where('user_id',Auth::user()->id)->get();
                $id = $categories->pluck('id')->toArray();
                $books = Book::where('approved','no')->whereIn('category_id',$id)->get();
                $articles = Article::where('approved','no')->whereIn('category_id',$id)->get();
                return \view('backend.user.show',compact('articles','books','uvcontacts','user','downloadedaudios','savedaudios','uploadedarticles','downloadedarticles','savedbooks','downloadedbooks','uploadedbooks','savedarticles'))->with('catagory',$catagory);
            }
            else
            {
                return abort(404);
            }
        }
    }

    public function search(Request $request)
    {
        $users = User::where('type','client')->where('name','like','%'.$request->data.'%')->orWhere('lastname','like','%'.$request->data.'%')->get();
        $row = '';
        foreach ($users as $user) 
        {
                $togglebutton = '';
                if($user->is_active)
                {
                    $togglebutton = '<td>
                    <label id="'. $user->id .'" class="switch">
                        <input onclick="toggle(this)" type="checkbox" checked>
                        <span class="slider round"></span>
                    </label>
                    </td>';
                }
                else
                {
                    $togglebutton = '<td>
                    <label id="'. $user->id .'" class="switch">
                        <input onclick="toggle(this)" type="checkbox" >
                        <span class="slider round"></span>
                    </label>
                    </td>';
                }
                $row .='<tr id="'.$user->id.'">
                    <td><div class=""><img src="'. asset('application/users/'.$user->image) .'"  alt="user" class="rounded img-fluid" width="45"></div></td>
                    <td>'. ucfirst($user->name).'</td>
                    <td>'. ucfirst($user->lastname) .'</td>
                    <td>'. $user->email .'</td>'. $togglebutton .'
                    <td><a href="'. route('user.show',$user->id) .'"> <i class=" btn-sm btn-secondary fa fa-eye "></i></a></td>
                    </tr>';
        }
            return response()->json(['rows'=>$row]);
    }

    public function Profile($name)
    {
        $uvcontacts = Contact::where('viewed',false)->get();
        if(Auth::user()->type == 'amdin')
        {
            $books = Book::where('approved','no')->get();
            $articles = Article::where('approved','no')->get();
            return view('backend.profile',compact('uvcontacts','articles','books'));
        }
        elseif(Auth::user()->type == 'librarian')
        {
            $categories = Category::where('user_id',Auth::user()->id)->get();
            $id = $categories->pluck('id')->toArray();
            $books = Book::where('approved','no')->whereIn('category_id',$id)->get();
            $articles = Article::where('approved','no')->whereIn('category_id',$id)->get();
            return view('backend.profile',compact('uvcontacts','articles','books'));
        }
        else
        {              
            return abort(404);
        }     

    }

    public function profilepic(Request $request)
    {
        if(Auth::user()->id == $request->id)
        {
            $user = User::find($request->id);
            File::delete(public_path('application/users/'.$user->image));
            $name = time().rand(1,1000).date('dmy').'.'.$request->file('image')->getClientOriginalExtension();
            $user->image = $name;
            $user->save();
            $request->file('image')->move(\public_path('application/users'),$name);
            return response()->json($name);
        }
    }

    public function ListAdmin()
    {
        if(Auth::user()->type == 'admin')
        {
            $catagory = Category::where('user_id',null)->get();
            $users = User::where('type','admin')->where('id','<>',Auth::user()->id)->orderBy('id','desc')->paginate(30);
            $articles = Article::where('approved','no')->get();
            $books = Book::where('approved','no')->get();
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            return view('backend.admin.index',compact('uvcontacts','catagory','books','articles'))->with('users',$users);
        }
        else
        {
            return abort(404);
        }
    }

    public function StoreAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
            'live' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        
        $name = time().rand(1,1000).date('dmy').'.'.$request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(\public_path('application/users/'),$name);
        $user = User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'lastname' => $request->lastname,
            'image' => $name,
            'occupation' => $request->occupation,
            'live_in' => $request->live,
            'is_active' => true,
            'type' => 'admin'
        ]);


       $togglebutton = '';
       if($user->is_active)
       {
            $togglebutton = '<td>
                <label id="'. $user->id .'" class="switch">
                    <input onclick="toggle(this)" type="checkbox" checked>
                    <span class="slider round"></span>
                </label>
            </td>';
       }
        else
        {
            $togglebutton = '<td>
                <label id="'. $user->id .'" class="switch">
                    <input onclick="toggle(this)" type="checkbox" >
                    <span class="slider round"></span>
                </label>
            </td>';
        }
        $row =' <tr id="'.$user->id.'">
        <td><div class=""><img src="'. asset('application/users/'.$user->image) .'"  alt="user" class="rounded img-fluid" width="45"></div></td>
        <td>'. ucfirst($user->name).'</td>
        <td>'. ucfirst($user->lastname) .'</td>
        <td>'. $user->phone .'</td>
        <td>'. $user->email .'</td>'. $togglebutton .'
        <td><a href="'. route('librarian.show',$user->id) .'"> <i class=" btn-sm btn-secondary fa fa-eye "></i>
        </a></td>
      </tr>';
        return response()->json(['msg'=>'success','row' =>$row]);
    }

    public function AdminShow(Request $request, $id)
    {
        if(Auth::user()->type == 'admin')
        {
            if($request->ajax())
            {
                $user = User::where('id',$id)->where('type','admin')->get()[0];
                return \response()->json($user);
            }
            else
            {
                
                    $user = User::where('id',$id)->where('type','admin')->get()[0];
                    $catagory = Category::orderBy('ename')->where('user_id',null)->get();
                    $books = Book::where('approved','no')->get();
                    $articles = Article::where('approved','no')->get();
                    $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
                    return \view('backend.admin.show',compact('articles','uvcontacts','user','books'))->with('catagory',$catagory);

            }
        }
        else
        {
            return abort(401);
        }
    }

    public function AdminSearch(Request $request)
    {
        $users = User::where('id','<>',Auth::user()->id)->where('type','admin')->where('name','like','%'.$request->data.'%')->orWhere('lastname','like','%'.$request->data.'%')->where('type','admin')->where('id','<>',Auth::user()->id)->get();
        $row = '';
        foreach ($users as $user) 
        {
                $togglebutton = '';
                if($user->is_active)
                {
                    $togglebutton = '<td>
                    <label id="'. $user->id .'" class="switch">
                        <input onclick="toggle(this)" type="checkbox" checked>
                        <span class="slider round"></span>
                    </label>
                    </td>';
                }
                else
                {
                    $togglebutton = '<td>
                    <label id="'. $user->id .'" class="switch">
                        <input onclick="toggle(this)" type="checkbox" >
                        <span class="slider round"></span>
                    </label>
                    </td>';
                }
                $row .='<tr id="'.$user->id.'">
                    <td><div class=""><img src="'. asset('application/users/'.$user->image) .'"  alt="user" class="rounded img-fluid" width="45"></div></td>
                    <td>'. ucfirst($user->name).'</td>
                    <td>'. ucfirst($user->lastname) .'</td>
                    <td>'. $user->email .'</td>'.
                    '<td>'. $user->phone .'</td>'.
                     $togglebutton .'
                    <td><a href="'. route('librarian.show',$user->id) .'"> <i class=" btn-sm btn-secondary fa fa-eye "></i></a></td>
                    </tr>';
        }
            return response()->json(['rows'=>$row]);
    }

    public function toggleUser(Request $request)
    {
        if(Auth::user()->type == 'admin')
        {
            User::find($request->id)->update([
                'is_active'=>(boolean)$request->status
                ]); 
            return response()->json(['msg' =>'success']);
        }
    }


    public function Books(User $user)
    {
        if(Auth::user()->type == 'admin')
        {
            $articles = Article::where('approved','no')->get();
            $books = Book::where('approved','no')->get();
            $abooks = Book::where('owner_id',$user->id)->where('approved','yes')->paginate(30)->onEachSide(10);
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);        
            return view('backend.admin.admin-books',
            compact('uvcontacts','abooks','user','articles','books'));   
        }
        else
        {
            return abort(404);
        }
    }

            // this function is responsible for searching both approved and unapproved books in dashboard
    public function SearchBook(Request $request)
    {
        $books = Book::orderBy('id','desc')
        ->where('owner_id',$request->id)
        ->where('approved',$request->approved)        
        ->where('title','like','%'.$request->data.'%')
        ->orWhere('author','like','%'.$request->data.'%')
        ->where('owner_id',$request->id)
        ->get();
        $rows = '';
            if($books->count()>0)
            {
                foreach($books as $book)
                {
                    $rows .= '<tr id="'.$book->id .'">
                    <td class="text-left">
                      <div><img src="'.asset("application/books/cover/".$book->image).' " alt="user"
                          class="rounded img-fluid" style="width:40px !important; height:45px !important;"></div>
                    </td>
                    <td> '. ucwords($book->title) .' </td>
                    <td>'. ucwords($book->author) .'</td>
                    <td>'. $book->edition .'</td>
                    <td>'. $book->created_at->diffForhumans() .'</td>
                    <td><a href="'.(($book->approved == 'yes') ? route("book.show",$book->id): route('show.unapproved.book',$book->id)) .'"> <i class=" btn-sm btn-secondary fa fa-eye "></i>
                      </a></td>
                  </tr>';
                }
            }
            else
            {
                $rows = '<tr><td colspan="5">Not Found</td></tr>';
                return response()->json(["rows"=>$rows]);
            }
    }

    public function Articles(User $user)
    {
        if(Auth::user()->type == 'admin')
        {
            $aarticles = Article::where('owner_id',$user->id)->where('approved','yes')->paginate(30)->onEachSide(10);
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            $books = Book::where('approved','no')->get();
            $articles = Article::where('approved','no')->get();;            
            return view('backend.admin.admin-articles',
            compact('uvcontacts','aarticles','user','articles','books'));
        }
        else
        {
            return abort(404);
        }
    }

    public function SearchArticle(Request $request)
    {
        $articles = Article::orderBy('id','desc')
        ->where('owner_id',$request->id)
        ->where('approved',$request->approved)        
        ->where('title','like','%'.$request->data.'%')
        ->orWhere('author','like','%'.$request->data.'%')
        ->where('owner_id',$request->id)
        ->get();
        $rows = '';
        $x = 1;
        if($articles->count() > 0)
        {
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
            $rows = '<tr><td colspan="5">Not Found</td></tr>';
        }
        return response()->json(["rows"=>$rows]);
    }

    public function AudioBooks(User $user)
    {
        if(Auth::user()->type != 'admin')
            return abort(404);
        $aaudios = AudioBook::where('owner_id',$user->id)->paginate(30)->onEachSide(10);
        $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);   
        $books = Book::where('approved','no')->get();
        $articles = Article::where('approved','no')->get();        
        return view('backend.admin.admin-audiobooks',
        compact('uvcontacts','aaudios','user','articles','books'));
    }


    public function SearchAudioBook(Request $request)
    {
        $books = AudioBook::orderBy('id','desc')
        ->where('owner_id',$request->id)        
        ->where('title','like','%'.$request->data.'%')
        ->orWhere('author','like','%'.$request->data.'%')
        ->where('owner_id',$request->id)
        ->get();
        $rows = '';
        if($books->count() > 0)
        {
            foreach($books as $book)
            {
                $rows .= '<tr id="'.$book->id .'">
                <td class="text-left">
                  <div><img src="'.asset("application/audiobooks/cover/".$book->image).' " alt="user"
                      class="rounded img-fluid" style="width:40px !important; height:45px !important;"></div>
                </td>
                <td> '. ucwords($book->title) .' </td>
                <td>'. ucwords($book->author) .'</td>
                <td>'. $book->edition .'</td>
                <td>'. $book->created_at->diffForhumans() .'</td>
                <td><a href="'. route("audiobook.show",$book->id).'"> <i class=" btn-sm btn-secondary fa fa-eye "></i>
                  </a></td>
              </tr>';
            }
        }
        else
        {
            $rows = '<tr><td colspan="5">Not Found</td></tr>';            
        }
        return response()->json(["rows"=>$rows]);
    }
}
