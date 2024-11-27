<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\AudioBook;
use App\Models\Book;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Contact;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;

class LibrarianController extends Controller
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
            $catagory = Category::where('user_id',null)->get();
            $users = User::where('type','librarian')->orderBy('id','desc')->paginate(30);
            $articles = Article::where('approved','no')->get();
            $books = Book::where('approved','no')->get();
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            return view('backend.librarian.index',compact('uvcontacts','catagory','books','articles'))->with('users',$users);
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
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
            'live' => 'required|string|max:255',
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
            'password' => Hash::make($request->password),
            'lastname' => $request->lastname,
            'image' => $name,
            'occupation' => $request->occupation,
            'live_in' => $request->live,
            'is_active' => true,
            'type' => 'librarian'
        ]);

        $user = User::max('id');
        try {
            //code...
            foreach ($request->catagories as $value) {
                $cat = Category::find($value);
                $cat->user_id =  $user;
                $cat->save();
            }
        } catch (\Throwable $th) {
            User::find($user)->delete();
            return \response()->json(['msg'=> 'WrongId']);
        }

        $user = User::orderBy('id','desc')->limit(1)->get();
       $togglebutton = '';
       if($user[0]->is_active)
       {
            $togglebutton = '<td>
                <label id="'. $user[0]->id .'" class="switch">
                    <input onclick="toggle(this)" type="checkbox" checked>
                    <span class="slider round"></span>
                </label>
            </td>';
       }
        else
        {
            $togglebutton = '<td>
                <label id="'. $user[0]->id .'" class="switch">
                    <input onclick="toggle(this)" type="checkbox" >
                    <span class="slider round"></span>
                </label>
            </td>';
        }
        $row =' <tr id="'.$user[0]->id.'">
        <td><div class=""><img src="'. asset('application/users/'.$user[0]->image) .'"  alt="user" class="rounded img-fluid" width="45"></div></td>
        <td>'. ucfirst($user[0]->name).'</td>
        <td>'. ucfirst($user[0]->lastname) .'</td>
        <td>'. $user[0]->email .'</td>'. $togglebutton .'
        <td><a href="'. route('librarian.show',$user[0]->id) .'"> <i class=" btn-sm btn-secondary fa fa-eye "></i>
        </a></td>
      <td><a href="javascript:void(0)"> <i onclick="Show(this)" class="fa fa-edit text-dark"></i> </a></td>
      </tr>';
        event(new Registered($user));
        return response()->json(['msg'=>'success','row' =>$row]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
    public function show(Request $request, $id)
    {
        if(Auth::user()->type == 'admin')
        {
            if($request->ajax())
            {
                $user = User::where('id',$id)->where('type','librarian')->get()[0];
                return \response()->json($user);
            }
            else
            {
                
                    $user = User::where('id',$id)->where('type','librarian')->get()[0];
                    $catagory = Category::orderBy('ename')->where('user_id',null)->get();
                    $books = Book::where('approved','no')->get();
                    $articles = Article::where('approved','no')->get();
                    $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
                    return \view('backend.librarian.show',compact('articles','uvcontacts','user','books'))->with('catagory',$catagory);

            }
        }
        else
        {
            return abort(401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(404);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->file('image') != '')
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'occupation' => 'required|string|max:255',
                'live' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'email' => 'required|string|email|max:255',
            ]);
            $user = User::find($id);
    
            File::delete(\public_path('application/users/'.$user->image));
            $name = time().rand(1,1000).date('dmy').'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(\public_path('application/users/'),$name);
    
            $user->name = \trim($request->name);
            $user->lastname = \trim($request->lastname);
            $user->email = \trim($request->email);
            $user->occupation = \trim($request->occupation);
            $user->live_in = \trim($request->live);
            $user->image = $name;
            $user->save();
    
        }
        else
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'occupation' => 'required|string|max:255',
                'live' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
            ]);
            $user = User::find($id);
    
            $user->name = \trim($request->name);
            $user->lastname = \trim($request->lastname);
            $user->email = \trim($request->email);
            $user->occupation = \trim($request->occupation);
            $user->live_in = \trim($request->live);
            $user->save();    
        }
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
        $row ='
        <td><div class=""><img src="'. asset('application/users/'.$user->image) .'"  alt="user" class="rounded img-fluid" width="45"></div></td>
        <td>'. ucfirst($user->name).'</td>
        <td>'. ucfirst($user->lastname) .'</td>
        <td>'. $user->email .'</td>'. $togglebutton .'
        <td><a href="'. route('librarian.show',$user->id) .'"> <i class=" btn-sm btn-secondary fa fa-eye "></i></a></td>
        <td><a href="javascript:void(0)"> <i onclick="Show(this)" class="fa fa-edit text-dark"></i> </a></td>';
        return response()->json(['row'=>$row,'id' => $user->id]);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(404);        
        //
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

    public function assign(Request $request)
    {
        foreach ($request->catagory as $value) {
            $obj = Category::find($value);
            $obj->user_id = $request->id;
            $obj->save();
           }
        return response()->json(['msg' => 'success','catagory' => $request->catagory]);
    }

    public function remove(Request $request)
    {
        foreach ($request->data as $key=>$value) {
            $obj = Category::find($value['value']);
            $obj->user_id = null;
            $obj->save();
        }
        return response()->json(['msg' => 'success']);
    }

    public function search(Request $request)
    {
        $users = User::where('type','librarian')->where('name','like','%'.$request->data.'%')->orWhere('lastname','like','%'.$request->data.'%')->where('type','librarian')->get();
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
                    <td><a href="'. route('librarian.show',$user->id) .'"> <i class=" btn-sm btn-secondary fa fa-eye "></i></a></td>
                    <td><a href="javascript:void(0)"> <i onclick="Show(this)" class="fa fa-edit text-dark"></i> </a></td>
                    </tr>';
        }
            return response()->json(['rows'=>$row]);
    }

    public function Books(User $user)
    {
        if(Auth::user()->type == 'admin')
        {
            $articles = Article::where('approved','no')->get();
            $books = Book::where('approved','no')->get();
            $abooks = Book::where('owner_id',$user->id)->where('approved','yes')->paginate(30)->onEachSide(10);
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);        
            return view('backend.librarian.librarian-books',
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
            $aarticles = Article::where('owner_id',$user->id)->where('approved','yes')->paginate(30)->onEachSide(10);
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            $books = Book::where('approved','no')->get();
            $articles = Article::where('approved','no')->get();;            
            return view('backend.librarian.librarian-articles',
            compact('uvcontacts','aarticles','user','articles','books'));
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
        return response()->json(["rows"=>$rows]);
    }
    public function AudioBooks(User $user)
    {
        $aaudios = AudioBook::where('owner_id',$user->id)->paginate(30)->onEachSide(10);
        $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);   
        $books = Book::where('approved','no')->get();
        $articles = Article::where('approved','no')->get();        
        return view('backend.librarian.librarian-audiobooks',
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