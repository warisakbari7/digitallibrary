<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Book;
use App\Models\Article;

class UserNotificationController extends Controller
{
    public function index()
    {
        $catagories = Category::where('user_id','<>',null)->get();
        $tags = Tag::all();
        if(Auth::user()->type == 'client')
            return view("frontend.notifications",\compact('catagories','tags'));
        else
        {
            if(Auth::user()->type == 'admin')
            {
                $books = Book::where('approved','no')->get();
                $articles = Article::where('approved','no')->get();
                return view('backend.notification.index',compact('books','articles'));
            }
            elseif(Auth::user()->type == 'librarian')
            {
                $categories = Category::where('user_id',Auth::user()->id)->get();
                $id = $categories->pluck('id')->toArray();
                $books = Book::where('approved','no')->whereIn('category_id',$id)->get();
                $articles = Article::where('approved','no')->whereIn('category_id',$id)->get();
                return view('backend.notification.index',compact('books','articles'));
            }
            else
            {
                return abort(404);
            }

        }

    }
    public function MarkAsRead()
    {
        Auth::user()->notifications->MarkAsRead();
    }

    public function LoadMore(Request $request)
    {
        $notifications = Auth::user()->notifications()->where('inc','<',$request->id)->limit(10)->get();
        $row = '';
        $btn = '';
        $counter = $notifications->count();
        if($notifications->count() > 0)
        {
            
            if(Auth::user()->type != 'client')
            {
                foreach ($notifications as $notification)
                {
                        if($notification->data['type'] == 'message')
                        {
                            $row .= '
                            <div class="row p-3 shadow" id="'. $notification->inc .'">
                            <div class="col-11">
                            <a href="'. $notification->data['url'] .'" class="dropdown-item">
                                <div class="media">
                                <div class="media-body">
                                    <h4 class="dropdown-item-title text-break text-wrap">'. $notification->data['email'] .'</h4>
                                    <p class="text-sm">A new message from <strong>'. $notification->data['name'] .'</strong></p>
                                    <p class="text-sm text-wrap text-break">'. $notification->data['message'] .'</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>'. $notification->created_at->diffForhumans() .'</p>
                                </div>
                                </div>
                            </a>
                            </div>
                                <div class="col-1 d-flex justify-content-center align-items-center">
                                        <a id="no_delete" data-id="'. $notification->inc .'" href="javascript:void(0)" class="bg-danger rounded  text-center" style="width:25px; ">&times;</a>
                                </div>
                            </div>';
                        }
                        else
                        {
                            $row .='
                            <div class="row p-3 shadow" id="'. $notification->inc .'">
                                <div class="col-11">
                                        <a href="'. $notification->data['url'] .'" class="dropdown-item">
                                                <div class="media">
                                                    <img src="'. asset('application/users/'.$notification->data['image']) .'" alt="User Avatar" class="img-size-50 img-circle mr-3 mt-3">
                                                    <div class="media-body">
                                                        <h4 class="dropdown-item-title text-break text-wrap">'. $notification->data['title'] .'</h4>
                                                        <p class="text-sm">A new '. $notification->data['type'] .' was uploaded by <strong>'. $notification->data['owner'] .'</strong></p>
                                                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>'. $notification->created_at->diffForhumans() .'</p>
                                                    </div>
                                            </div>
                                            </a>
                                </div>
                                <div class="col-1 d-flex justify-content-center align-items-center">
                                        <a id="no_delete" data-id="'. $notification->inc .'" href="javascript:void(0)" class="bg-danger rounded  text-center" style="width:25px; ">&times;</a>
                                </div>
                            </div>';
                        }
    
                }
                $btn = '
                <div class="row" id="btn_more_container">
                <div class="col-12 text-center pt-4">
                    <div id="btn_more" data-id="'. $notification->inc.'" class="btn btn-secondary w-25" style="border-radius:20px;" >More</div>
                </div>
                </div>';
            }
            else
            {
                
                foreach ($notifications as $notification)
                {
                    if($notification->data['type'] == 'book')
                    {
                        $row .= '
                        <div class="row p-3 shadow" style=" border-radius:90px;" id="'. $notification->inc .'">
                        <div class="col-11">
                        <a href="'. $notification->data['url'] .'" class="dropdown-item">
                        <div class="row">
                            <div class="col-2 p-3">
                                <img src="'. asset('application/books/cover/'.$notification->data['image']) .'" alt="User Avatar" class="w-50 h-100 rounded mr-3">
                            </div>
                            <div class="col-9 col-sm-6">
                                <h4>'. $notification->data['title'] .'</h4>
                                <p class="text-sm text-wrap text-break">your '. $notification->data['type'] .' was approved successfully</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>'. $notification->created_at->diffForhumans() .'</p>
                            </div>
                        </div>
                        </a>
                        </div>
                        <div class="col-1 d-flex justify-content-center align-items-center">
                        <a id="no_delete" data-id="'. $notification->inc .'" href="javascript:void(0)" class="bg-danger rounded  text-center text-white text-decoration-none" style="width:25px; ">&times;</a>
                        </div>';
                    }
                    else
                    {
                        $row .= '<div class="row p-3 shadow" style=" border-radius:90px;" id="'. $notification->inc .'">
                        <div class="col-11">
                            <a href="'. $notification->data['url'] .'" class="dropdown-item rounded">
                                <div class="row">
                                  <div class="col">
                                    <p class="text-sm">  <strong>'. $notification->data['title'] .'</strong></p>
                                    <p class="text-sm text-wrap text-break"> you '. $notification->data['type'] .' was approved successfully</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>'. $notification->created_at->diffForhumans() .'</p>
                                  </div>
                                </div>
                            </a>
                            </div>
                            <div class="col-1 d-flex justify-content-center align-items-center">
                            <a id="no_delete" data-id="'. $notification->inc .'" href="javascript:void(0)" class="bg-danger rounded  text-center text-white text-decoration-none" style="width:25px; ">&times;</a>
                        </div>';
                        }
                            
                }
                $btn = '
                <div class="row" id="btn_more_container">
                <div class="col-12 text-center pt-4">
                    <div id="btn_more" data-id="'. $notification->inc.'" class="btn btn-secondary bg--two w-25" style="border-radius:20px;" >More</div>
                </div>
                </div>';
            }
        }
        else
        {
            $btn = '
            <div class="row" id="btn_more_container">
            <div class="col-12 text-center pt-4">
                <div class="btn bg--one text-white w-25" style="border-radius:20px;" >Finished</div>
            </div>
            </div>';
        }
        return response()->json(['rows'=>$row,'btn'=>$btn,'counter' => $counter]);
    }

    public function destroy(Request $request)
    {
        Auth::user()->notifications()->where("inc",$request->id)->delete();
        return response()->json(['notification'=>$request->id]);
    }
}
