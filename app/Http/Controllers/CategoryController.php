<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Book;
use App\Models\Article;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $tags = Tag::orderBy('id','desc')->limit(15)->get();
        $cat = Category::orderBy('id','desc')->limit(15)->get();
        if($request->ajax())
        {
            return \response()->json([ $cat, $tags]);
        }
        else 
        {
            if(Auth::user()->type == 'librarian')
            {
                $categories = Category::where('user_id',Auth::user()->id)->get();
                $id = $categories->pluck('id')->toArray();
                $articles = Article::where("approved","no")->whereIn('category_id',$id)->get();
                $books = Book::where('approved','no')->whereIn('category_id',$id)->get();
                $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
                return view('backend.category.index',compact('uvcontacts','tags','books','articles'))->with('category',$cat);
            }
            elseif(Auth::user()->type == 'admin')
            {

                $articles = Article::where("approved","no")->get();
                $books = Book::where('approved','no')->get();
                $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
                return view('backend.category.index',compact('uvcontacts','tags','books','articles'))->with('category',$cat);
            }
            else
            {
                return abort(404);
            }

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
        $validator = Validator::make($request->all(),[
            'english' => 'required|unique:categories,ename',
            'dari' => 'required|unique:categories,dname',
            'pashto' => 'required|unique:categories,pname',
        ]);

        if($validator->fails()){
            return \response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        }
        else{
            $cat = new Category();
            $cat->ename = trim($request->english);
            $cat->dname = trim($request->dari);
            $cat->pname = trim($request->pashto);
            $cat->save();
            $cat = Category::find(Category::max('id'));
            return \response()->json([ 'cat' => $cat,'status' => 1,'books' => count($cat->books)]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $cat = category::find($request->id);
        return \response()->json($cat);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(),[
            "english" => "required",
            "dari" => "required",
            "pashto" => "required",
        ]);
        if($validator->fails())
        {
            return \response()->json(['status' => 0,'errors' => $validator->errors()]);
        }
        else
        {
            $cat = Category::find($request->id);
            $cat->ename = trim($request->english);
            $cat->dname = trim($request->dari);
            $cat->pname = trim($request->pashto);
            $cat->save();
            return \response()->json(['status' => 1,'cat' => $cat,'books' => count($cat->books)]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return \response()->json(['status' => 1, 'cat' => $category]);
    }
    
    public function loadmore(Request $request)
    {
        $data = '';
        $last_id = '';
        $button = '';
        $category = Category::where('id', '<', $request->id)->orderBy('id','desc')->limit(10)->get();
        if(count($category) > 0 )
        {


            foreach ($category as $cat) {
                $data .= '<tr id="cat'.$cat->id .'">'.
                '<td></td>'.
                '<td>'. $cat->ename .'</td>'.
                '<td>'. count($cat->books) .' </td>'.
                '<td><a href="javascript:void(0)"><i onclick="Show(this)" data-id=" '. $cat->id .'" data-type="catagory" class="fa fa-edit text-dark"></i></a></td> 
                '. '<td><a href="javascript:void(0)" class="text-dark"><i onclick="ShowModal(this)" data-id="'. $cat->id .'" data-type="catagory" class="fa fa-trash"></i></a></td>' .'</tr>';
                $last_id = $cat->id;
            }
            $button = "<button data-type='morecatagory' data-id=' $last_id ' id='btn_loadmore_cat' onclick='loadmore(this)' class='btn btn-primary w-100'>Load More</button>";
            return \response()->json(['button'=>$button,'rows'=>$data, 'type'=>'cat']);


        }
        else
        {
            
            $button = '<button class="btn btn-warning w-100">No Data Found</button>';
            return \response()->json(['button'=>$button,'rows'=>$data,'type' => 'cat']);
        }
    }


    public function search(Request $request)
    {
        $data = '';
        $button = '';
        $category = Category::orderBy('id','desc')->where('ename', 'like', '%'.trim($request->name).'%')->orWhere('dname', 'like', '%'.trim($request->name).'%')->orWhere('pname', 'like', '%'.trim($request->name).'%')->get();
        if(count($category) > 0 )
        {
            foreach ($category as $cat) {
                $data .= '<tr id="cat'.$cat->id .'">'.
                '<td></td>'.
                '<td>'. $cat->ename .'</td>'.
                '<td>'. count($cat->books) .' </td>'.
                '<td><a href="javascript:void(0)"><i onclick="Show(this)" data-id=" '. $cat->id .'" data-type="catagory" class="fa fa-edit text-dark"></i></a></td> 
                '. '<td><a href="javascript:void(0)" class="text-dark"><i onclick="ShowModal(this)" data-id="'. $cat->id .'" data-type="catagory" class="fa fa-trash"></i></a></td>' .'</tr>';
            }
            return \response()->json(['rows'=>$data, 'type'=>'cat']);
        }
        else
        {
            $data = '<tr>
            <td></td>
            <td>No Match</td>
            </tr>';
            return \response()->json(['button'=>$button,'rows'=>$data,'type' => 'cat']);
        }
    }

}
